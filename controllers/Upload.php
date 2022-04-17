<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends Admin_Controller {

        public function __construct()
        {
                parent::__construct();

                $this->not_logged_in();
                $this->load->helper(array('form', 'url'));
        }

        public function do_upload()
        {
                $this->data['page_title'] = 'Upload';
                
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'txt';
                $config['max_size']             = 100;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('userfile'))
                {
                        $this->data['upload_data'] = $this->upload->data();
                        $this->render_template('/user_clients/upload_success', $this->data);
                }
        }
}
