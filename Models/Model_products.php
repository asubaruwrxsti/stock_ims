<?php 

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getProductData($id = null, $user_id = null)
	{
		if($id) {
			$sql = "SELECT * FROM user_inventory where product_id = $id and user_id = $user_id";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}

	public function getActiveProductData()
	{
		$sql = "SELECT * FROM products WHERE availability = ? ORDER BY id DESC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('products', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id, $u_id)
	{
		if($data && $id) {
			//$this->db->where('id', $id);
			//$update = $this->db->update('products', $data);
			$this->db->where('product_id', $id);
			$this->db->where('user_id', $u_id);
			$update = $this->db->update('user_inventory', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}