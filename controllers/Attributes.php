<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attributes extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Reports';

		$this->load->model('model_attributes');
	}

	/* 
	* redirect to the index page 
	*/
	public function index()
	{
		if(!in_array('viewAttribute', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('attributes/index', $this->data);	
	}

	/* 
	* gets the attribute data from data and returns the attribute 
	*/
	public function fetchAttributeData()
	{

		$result = array('data' => array());
		$data = $this->model_attributes->getAttributeData();

		foreach ($data as $key => $value) {

			#$count_attribute_value = $this->model_attributes->countAttributeValue($value['id']);

			// button
			#$buttons = '<a href="'.base_url('attributes/addvalue/'.$value['id']).'" class="btn btn-default"><i class="fa fa-plus"></i> Add Value</a> 
			#<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>
			#<button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>
			#';

			#$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['customer_name'],
				$value['username'],
				$value['product'],
				$value['qty'],
				$value['date']
			);
		} // /foreach

		echo json_encode($result);
	}

	public function fetchAttributeData2()
	{

		$result = array('data' => array());
		$data = $this->model_attributes->getAttributeData2();

		foreach ($data as $key => $value) {

			#$count_attribute_value = $this->model_attributes->countAttributeValue($value['id']);

			// button
			#$buttons = '<a href="'.base_url('attributes/addvalue/'.$value['id']).'" class="btn btn-default"><i class="fa fa-plus"></i> Add Value</a> 
			#<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>
			#<button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>
			#';

			#$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['customer_name'],
				$value['product'],
				$value['qty']
			);
		} // /foreach

		echo json_encode($result);
	}

	public function getQtyData()
	{

		$result = array('data' => array());
		$data = $this->model_attributes->getQtyData();

		foreach ($data as $key => $value) {

			#$count_attribute_value = $this->model_attributes->countAttributeValue($value['id']);

			// button
			#$buttons = '<a href="'.base_url('attributes/addvalue/'.$value['id']).'" class="btn btn-default"><i class="fa fa-plus"></i> Add Value</a> 
			#<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>
			#<button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>
			#';

			#$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['product'],
				$value['qty']
			);
		} // /foreach

		echo json_encode($result);
	}

}
?>