<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Raporte Hedhje';
		$this->load->model('model_reports');
	}

	public function index()
	{
		$users = $this->model_reports->getAllUsers();
		$this->data['users'] = $users;

		$this->render_template('reports/index', $this->data);
	}

	public function userReport($id)
	{
		$this->model_reports->getUserReport($id);

		redirect('reports/index');
	}
}
