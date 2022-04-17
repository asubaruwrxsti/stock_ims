<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UserClients extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->load->model('model_userclients');
    }

    public function index(){
        $this->data['page_title'] = 'Kliente';
        $userclient_data = $this->model_userclients->getAllUsers();
        $this->data['userclient_data'] = $userclient_data;

        $this->render_template('user_clients/index', $this->data);
    }

    public function insert_view($id){
        $this->data['page_title'] = 'Shto Klient';
        $userclient_data = $this->model_userclients->getUserCustomers($id);
        $this->data['userclient_data'] = $userclient_data;

        $this->render_template('user_clients/addClient', $this->data);
    }

    public function insert($id){
        $this->model_userclients->insertCustomer($id);
        redirect('userclients/user/'.$id);
    }

    public function delete($id, $parent_id){
        $this->model_userclients->deleteCustomer($id);
        redirect('userclients/user/'.$parent_id);
    }

    public function userCustomers($id){
        $this->data['page_title'] = 'Kliente Perdoruesi';
        $user_customerData = $this->model_userclients->getUserCustomers($id);
        $this->data['user_customerdata'] = $user_customerData;

        $this->render_template('user_clients/userCustomers', $this->data);
    }

}