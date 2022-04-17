<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UserInventory extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->load->model('model_userinventory');
    }

    public function index()
    {

        $this->data['page_title'] = 'Inventar';
        $inventory_data = $this->model_userinventory->getAllUserData();
        $this->data['inventory_data'] = $inventory_data;

        $this->render_template('user_inventory/index', $this->data);
    }

    public function edit($id)
    {
        $this->data['page_title'] = 'Hyrje Magazine';
        $update_data = $this->model_userinventory->getUserData($id);
        $this->data['update_data'] = $update_data;

        $this->render_template('user_inventory/edit', $this->data);
    }

    public function insert($id)
    {
        $this->model_userinventory->insert($id);
        redirect('/userinventory/edit/'.$id);
    }

    public function insert_index($id)
    {
        $this->data['page_title'] = 'Hyrje Magazine';
        $user = $this->model_userinventory->getUserData($id);
        $this->data['user_data'] = $user;

        $this->render_template('user_inventory/insert', $this->data);
    }
}
