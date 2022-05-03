<?php 

class Model_attributes extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getAttributeData()
	{

		$sql = "select orders.customer_name, users.username, products.name as 'product', orders_item.qty, from_unixtime(orders.date_time,'%m/%d/%Y') as 'date' from orders, products, orders_item, users where orders.id = orders_item.order_id and products.id = orders_item.product_id and orders_item.product_id > 14 and orders.user_id = users.id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getQtyData(){

		$sql = "select DISTINCT products.name as 'product', sum(products.qty) - sum(orders_item.qty) as 'qty' from orders, products, orders_item, users where orders.id = orders_item.order_id and products.id = orders_item.product_id and orders_item.product_id > 14 and orders.user_id = users.id GROUP BY orders.customer_name, products.name;";
		$query = $this->db->query($sql);
		return $query->result_array();

	}

	public function getAttributeData2()
	{

		$sql = "select DISTINCT orders.customer_name, products.name as 'product', sum(orders_item.qty) as 'qty' from orders, products, orders_item, users where orders.id = orders_item.order_id and products.id = orders_item.product_id and orders_item.product_id > 14 and orders.user_id = users.id GROUP BY orders.customer_name, products.name;";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getActiveAttributeData()
	{
		$sql = "SELECT * FROM attributes WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

}
?>