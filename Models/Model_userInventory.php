<?php

class Model_userInventory extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function edit($id = NULL)
    {
        $qty = $this->input->post('product_qty');
        $product_id = $this->input->post('product_id');

        $data = array(
            'user_id' => $id,
            'product_qty' => $qty,
            'product_id' => $product_id
        );

        $result = $this->db->update('user_inventory', $data);
        return ($result) ? True : False;
    }

    public function delete($entry_id)
    {
        $sql = "DELETE FROM user_inventory WHERE entry_id = $entry_id";
        $result = $this->db->delete($sql);

        if ($result) {
            redirect($_SERVER['REQUEST_URI'], 'refresh');
        }
    }

    public function getUserData($id)
    {
        $sql = "SELECT DISTINCT users.id, users.firstname, users.lastname, users.username, products.name, user_inventory.product_qty, user_inventory.entry_date FROM users, products, user_inventory WHERE users.id = user_inventory.user_id AND users.id =" . $id . " AND products.id = user_inventory.product_id GROUP BY user_inventory.product_qty";
        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function getAllUserData()
    {
        $sql = "SELECT DISTINCT users.id, users.firstname, users.lastname FROM users;";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function insert($id)
    {
        $product_id = $this->input->post('product_id');
        $product_qty = $this->input->post('product_qty');

        for ($a = 0; $a < count($product_id); $a++) {
            $sql = "INSERT INTO user_inventory (product_id, product_qty, user_id) VALUES (" . $product_id[$a] . ", " . $product_qty[$a] . ", " . $id . ")";
            $this->db->query($sql);
        }
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM products";
        $result = $this->db->query($sql);

        return $result->result_array();
    }
}
