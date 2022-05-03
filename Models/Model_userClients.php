<?php

class Model_userClients extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllUsers()
    {
        $sql = "SELECT users.id, users.firstname, users.lastname FROM users";
        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function getUserCustomers($id)
    {
        $sql = "SELECT users.firstname, users.lastname, users.id, users.username, customers.id AS c_id, customers.name, customers.date_added FROM customers, users WHERE customers.parent_id = users.id AND users.id = " . $id;
        $result = $this->db->query($sql);

        if ($result->num_rows() == 0) {
            $sql = "INSERT INTO customers (id, parent_id, name) VALUES ('IDX_" . $id . "'," . $id . ", 'base_idx_" . $id . "')";
            $result = $this->db->query($sql);
        } else {
            return $result->result_array();
        }
    }

    public function insertCustomer($id)
    {

        $customer_id = $this->input->post('customer_id');
        $customer_name = $this->input->post('customer_name');

        for ($a = 0; $a < count($customer_id); $a++) {
            $sql = "INSERT INTO customers (id, parent_id, name) VALUES ('" . $customer_id[$a] . "', " . $id . ", '" . $customer_name[$a] . "');";
            $this->db->query($sql);
        }
    }

    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM customers WHERE customers.id ='" . $id . "'";
        $result = $this->db->query($sql);
        return ($result) ? True : False;
    }
}
