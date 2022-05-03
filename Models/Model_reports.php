<?php

//include the file that loads the PhpSpreadsheet classes
require 'spreadsheet/vendor/autoload.php';

//include the classes needed to create and write .xlsx file
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Model_reports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllUsers()
	{
		$sql = "SELECT users.id, users.firstname, users.lastname, users.username FROM users";
		$result = $this->db->query($sql);

		return $result->result_array();
	}

	public function getUserReport($id)
	{
		error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & E_ERROR & E_WARNING);
		$sql = "SELECT DISTINCT from_unixtime(orders.date_time, '%Y') AS date FROM users, orders where users.id = orders.user_id and users.id = '" . $id . "' ORDER BY date ASC; ";
		$year = $this->db->query($sql);

		//object of the Spreadsheet class to create the excel data
		$spreadsheet = new Spreadsheet();
		$template = new Spreadsheet();

		$fxls = './Viti Raport.xlsx';
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
		$spreadsheet = $reader->load($fxls);
		$template = $reader->load($fxls);

		$letters = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');

		$a = 0;
		foreach ($year->result_array() as $k => $v) :

			// create sheets depending on the year
			$spreadsheet->setActiveSheetIndex($a)->setTitle($v['date']);
			$timestamp = strtotime("1 January" . $v['date']);

			$sql = "SELECT DISTINCT users.username, orders.date_time AS date_o FROM users, orders where users.id = orders.user_id and users.id = '" . $id . "' and orders.date_time >" . $timestamp . " and orders.date_time <" . ($timestamp + 31536000);
			$result = $this->db->query($sql);

			// write excel
			foreach ($result->result_array() as $a => $b) :
				$spreadsheet->setActiveSheetIndex($v['date'] - 2021)
					->setCellValue(sprintf('%s%d', $letters[intval(date('m', $b['date_o'])) - 1], intval(date('d',  $b['date_o'])) + 1), "*");
			endforeach;

			$clone = clone $template->getSheetByName("main");
			$clone->setTitle("clone");
			$spreadsheet->addSheet($clone);

			$a++;

		endforeach;
		$spreadsheet->removeSheetByIndex($spreadsheet->getSheetCount() - 1);

		$writer = new Xlsx($spreadsheet);
		$writer->save("./raporte/Viti_raport_" . $id . ".xlsx");
	}
}
