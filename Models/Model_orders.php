<?php

class Model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the orders data */
	public function getOrdersData($id = null)
	{
		$user_id = $this->session->userdata('id');
		if ($id) {
			$sql = "SELECT * FROM orders WHERE id = ? AND user_id = $user_id";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// get the orders item data
	public function getOrdersItemData($order_id = null)
	{
		if (!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM orders_item WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	public function create()
	{
		$user_id = $this->session->userdata('id');
		$bill_no = 'BILPR-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
		$data = array(
			'bill_no' => $bill_no,
			'customer_name' => $this->input->post('customer_name'),
			'customer_address' => $this->input->post('customer_address'),
			'customer_phone' => $this->input->post('customer_phone'),
			'date_time' => strtotime(date('Y-m-d h:i:s a')),
			'gross_amount' => $this->input->post('gross_amount_value'),
			'service_charge_rate' => $this->input->post('service_charge_rate'),
			'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
			'vat_charge_rate' => $this->input->post('vat_charge_rate'),
			'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
			'net_amount' => $this->input->post('net_amount_value'),
			'discount' => $this->input->post('discount'),
			'paid_status' => $this->input->post('paid_status'),
			'user_id' => $user_id,
			'comments' => $this->input->post('comments')
		);

		//insert order data
		$insert = $this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();

		$this->load->model('model_products');

		$count_product = count($this->input->post('product'));
		for ($x = 0; $x < $count_product; $x++) {
			$items = array(
				'order_id' => $order_id,
				'product_id' => $this->input->post('product')[$x],
				'qty' => $this->input->post('qty')[$x],
				'rate' => $this->input->post('rate_value')[$x],
				'amount' => $this->input->post('amount_value')[$x],
			);
			//insert order items
			$this->db->insert('orders_item', $items);

			// decrease the stock from the product
			$product_data = $this->model_products->getProductData($this->input->post('product')[$x], $user_id);

			//check if product data object is not empty
			if (!empty($product_data)) {

				$qty = (int)$product_data['product_qty'] - (int)$this->input->post('qty')[$x];

				if ($qty < 0) {
					//set session flashdata to error message
					$this->session->set_flashdata('error', 'Product is not available in the inventory');
					$qty = 0;

					//remove the order from the database
					$this->db->delete('orders', array('id' => $order_id));
					//remove the order items from the database
					$this->db->delete('orders_item', array('order_id' => $order_id));

					return false;
				}

				$update_product = array('product_qty' => $qty);
				$this->model_products->update($update_product, $this->input->post('product')[$x], $user_id);
			} else {
				//set session flashdata to error message
				$this->session->set_flashdata('error', 'Product is not available in the inventory');

				//remove the order from the database
				$this->db->delete('orders', array('id' => $order_id));
				//remove the order items from the database
				$this->db->delete('orders_item', array('order_id' => $order_id));

				return false;
			}
		}
		return ($order_id) ? $order_id : false;
	}

	public function countOrderItem($order_id)
	{
		if ($order_id) {
			$sql = "SELECT * FROM orders_item WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

	public function update($id)
	{
		if ($id) {

			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
				'customer_name' => $this->input->post('customer_name'),
				'customer_address' => $this->input->post('customer_address'),
				'customer_phone' => $this->input->post('customer_phone'),
				'gross_amount' => $this->input->post('gross_amount_value'),
				'service_charge_rate' => $this->input->post('service_charge_rate'),
				'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
				'vat_charge_rate' => $this->input->post('vat_charge_rate'),
				'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
				'net_amount' => $this->input->post('net_amount_value'),
				'discount' => $this->input->post('discount'),
				'paid_status' => $this->input->post('paid_status'),
				'user_id' => $user_id
			);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now the order item 
			// first we will replace the product qty to original and subtract the qty again
			$this->load->model('model_products');
			$get_order_item = $this->getOrdersItemData($id);
			foreach ($get_order_item as $k => $v) {
				$product_id = $v['product_id'];
				$qty = $v['qty'];
				// get the product 
				$product_data = $this->model_products->getProductData($product_id, $user_id);
				$update_qty = $qty + $product_data['product_qty'];
				$update_product_data = array('product_qty' => $update_qty);

				// update the product qty
				$this->model_products->update($update_product_data, $product_id, $user_id);
			}

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('orders_item');

			// now decrease the product qty
			$count_product = count($this->input->post('product'));
			for ($x = 0; $x < $count_product; $x++) {
				$items = array(
					'order_id' => $id,
					'product_id' => $this->input->post('product')[$x],
					'qty' => $this->input->post('qty')[$x],
					'rate' => $this->input->post('rate_value')[$x],
					'amount' => $this->input->post('amount_value')[$x],
				);
				$this->db->insert('orders_item', $items);

				// now decrease the stock from the product
				$product_data = $this->model_products->getProductData($this->input->post('product')[$x], $user_id);
				//check if product data object is not empty
				if (!empty($product_data)) {

					$qty = (int) $product_data['product_qty'] - (int) $this->input->post('qty')[$x];

					//check if the qty is less than zero
					if ($qty < 0) {
						//set session flashdata to error message
						$this->session->set_flashdata('error', 'Product is not available in the inventory');
						$qty = 0;

						//remove the order from the database
						$this->db->delete('orders', array('id' => $id));
						//remove the order items from the database
						$this->db->delete('orders_item', array('order_id' => $id));

						return false;
					}

					$update_product = array('product_qty' => $qty);
					$this->model_products->update($update_product, $this->input->post('product')[$x], $user_id);
				}
			}

			return true;
		}
	}



	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('orders');

			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('orders_item');
			return ($delete == true && $delete_item) ? true : false;
		}
	}

	public function countTotalPaidOrders($user_id)
	{
		$sql = "SELECT orders.id FROM orders, users WHERE paid_status = 1 AND users.id = $user_id AND orders.user_id = $user_id";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

	public function countTotalUnpaidOrders($user_id)
	{
		$sql = "SELECT orders.id FROM orders, users WHERE paid_status = 2 AND users.id = $user_id AND orders.user_id = $user_id";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
}
