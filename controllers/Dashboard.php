<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';
		
		$this->load->model('model_products');
		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_stores');
	}

	/* 
	* It only redirects to the manage category page
	* It passes the total product, total paid orders, total users, and total stores information
	into the frontend.
	*/
	public function index()
	{
		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 11) ? true :false;

		$this->data['is_admin'] = $is_admin;

		if($is_admin)
		{
			#set data
			$this->data['total_products'] = $this->model_products->countTotalProducts();
			$this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders($user_id);
			$this->data['total_users'] = $this->model_users->countTotalUsers($user_id);
			$this->data['total_stores'] = $this->model_orders->countTotalUnpaidOrders($user_id);
			#render template
			$this->render_template('dashboard', $this->data);
		}
		if($is_admin==false)
		{	
			#set permission
			$this->data['is_admin'] = true;

			#set data
			$this->data['total_products'] = $this->model_products->countTotalProducts();
			$this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders($user_id);
			$this->data['total_stores'] = $this->model_orders->countTotalUnpaidOrders($user_id);
			$this->data['total_users'] = $this->model_users->countTotalUsers($user_id);

			#render template
			$this->render_template('dashboard', $this->data);
		}
	}
}