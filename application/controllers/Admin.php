<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','html'));
		$this->load->library(array('session', 'form_validation'));
	    $this->load->model('adminmodel');

	    if (!$this->session->userdata('admin_logged_in') && !in_array($this->router->fetch_method(), ['login', 'index'])) {
            redirect('admin/index');
        }


    }

    // Admin view
	function index() {
        $this->load->view('admin/login');
    }

    // Admin login
    function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $authenticated = $this->adminmodel->authenticate($username, $password);

        if ($authenticated) {
            // Set session data
            $admin_data = array(
                'username' => $username,
                'admin_logged_in' => true
            );
            $this->session->set_userdata($admin_data);

            $response['status'] = 'success';
            $response['message'] = 'Login successful';
            echo json_encode($response);
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Incorrect username or password';
            echo json_encode($response);
        }
    }

    // dashboard
    function dashboard() {
        // Check if admin is logged in
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }

        $data['num_users'] = $this->adminmodel->count_customers();
        $data['num_products'] = $this->adminmodel->count_products();
        $data['total_orders'] = $this->adminmodel->getTotalOrdersCount();
        $data['pending_orders'] = $this->adminmodel->getPendingOrdersCount();
        $data['delivered_orders'] = $this->adminmodel->getDeliveredOrdersCount();
        $data['bulk_orders'] = $this->adminmodel->getBulkOrdersCount();
        $data['total_revenue'] = $this->adminmodel->getTotalRevenue();

        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar',$data);
        $this->load->view('admin/dashboard',$data);
        $this->load->view('admin/footer');
    }
    // logout
    function logout() {
        $this->session->unset_userdata('admin_logged_in');
        $this->session->unset_userdata('admin_username');
        redirect('admin');
    }

    //functions for products
    function products(){
        $data['products'] = $this->adminmodel->get_products_with_category();
        $data['categories'] = $this->adminmodel->get_category_names();
        $data['num_products'] = $this->adminmodel->count_products();
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/product_list', $data);
        $this->load->view('admin/footer');    
    }

    // to save product
    function save_product() {
    $price = $this->input->post('price');

    $data = array(
        'name' => $this->input->post('productname'),
        'category_id' => $this->input->post('categoryname'),
        'description' => $this->input->post('description'),
        'original_price' => $price,      // Real price
        'offer_price' => $price,         // Same initially
        'availability' => $this->input->post('availability'),
        'added_at' => date('Y-m-d H:i:s'),
        'status' => '1'
    );

    // Image upload code (unchanged)
    if (!empty($_FILES['image']['name'])) {
        $config['upload_path'] = './assets/images/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();
            $data['image'] = $upload_data['file_name'];
        } else {
            echo $this->upload->display_errors();
            return;
        }
    }

    $this->adminmodel->save_product($data);
    redirect('admin/products');
    }


    //to update product
    function edit_product($id) {
        $data['products'] = $this->adminmodel->get_product_by_id($id);
        $data['categories'] = $this->adminmodel->get_category_names();
        echo json_encode($data);
    }

    function update_product($id) {
    $data = array(
        'name' => $this->input->post('productname'),
        'category_id' => $this->input->post('categoryname'),
        'description' => $this->input->post('description'),
        'original_price' => $this->input->post('price'),
        'availability' => $this->input->post('availability')
    );

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $config['upload_path'] = './assets/images/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();
            $data['image'] = $upload_data['file_name'];
        } else {
            // Optional: log upload error
            echo json_encode([
                'status' => 'error',
                'message' => $this->upload->display_errors()
            ]);
        return;
        }
    }

    $this->load->model('adminmodel');
    $result = $this->adminmodel->update_product($id, $data);

        if ($result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database update failed']);
        }
    }

    // view product details
    function view_product($id) {
    $product = $this->adminmodel->view_product_by_id($id);

        if ($product) {
            echo json_encode(['product' => $product]);
        } else {
            echo json_encode(['error' => 'Product not found']);
        }
    }

    // to delete product
    function delete_product(){
        $id=$_POST['id'];
        return $this->adminmodel->delete_product_info($id);
    }


    // functions for category
    function category(){
        $data=array();
        $data['categories']=$this->adminmodel->get_categories();
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/category_list',$data);
        $this->load->view('admin/footer');    
    }
    // to save category
    function save_category(){
        $data = [
            'category_name' => $this->input->post('categoryname'),
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 1
        ];
        $this->adminmodel->save_category($data);
        $this->category();
    }
    // to update category
    function update_category($id){
    $data = [
        'category_name' => $this->input->post('categoryname'),
        'status' => 1 
    ];

        if ($this->adminmodel->update_category($data, $id)) {
            echo json_encode(['status' => 'success', 'message' => 'Category updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update category']);
        }
    }
    // to delete category
    function delete_category(){
        $id=$_POST['id'];
        return $this->adminmodel->delete_category($id);
    }


    // functions for offer
    function offers(){
        $data=array();
        $data['offers']=$this->adminmodel->get_offers();
        $data['categories'] = $this->adminmodel->get_category_names();
        $this->adminmodel->remove_expired_offers_from_products();
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/offers_list', $data);
        $this->load->view('admin/footer');    
    }

    // to save offer
    function save_offer()
    {
    
        $this->load->library('form_validation');
        $this->form_validation->set_rules('offer_name', 'Offer Name', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');
        $this->form_validation->set_rules('offer_percent', 'Offer Percent', 'required|numeric');
        $this->form_validation->set_rules('categoryname', 'Category', 'required|integer');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[0,1]');

        if ($this->form_validation->run() == FALSE) {
        
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/offers');
        } else {
       
            $data = array(
                'offer_name' => $this->input->post('offer_name'),
                'description' => $this->input->post('description'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'offer_percent' => $this->input->post('offer_percent'),
                'category_id' => $this->input->post('categoryname'),
                'status' => $this->input->post('status')
            );

            $this->load->model('adminmodel');
            $offer_id = $this->adminmodel->insert_offer($data);
            $this->adminmodel->apply_offer_to_products($offer_id, $data['category_id'], $data['offer_percent']);
            $this->session->set_flashdata('success', 'Offer added successfully.');
            redirect('admin/offers');
        }
    }

    // to activate function
    function activate_offer($offer_id)
    {
        $offer = $this->Offer_model->get_offer_by_id($offer_id);

        if ($offer && $offer['status'] == 1) {
        $this->Offer_model->apply_offer_to_products($offer['id'], $offer['category_id'], $offer['offer_percent']);
        }
    }

    // remove expired offers
    function remove_expired_offers() {
        $this->load->model('adminmodel');
        $result = $this->adminmodel->remove_expired_offers_from_products();

        if ($result) {
            echo "Expired offers removed successfully.";
        } else {
            echo "No expired offers found.";
        }
    }

    // view offers
    function view_offer($id) {
        $offer = $this->adminmodel->view_offer_by_id($id);

        if ($offer) {
            echo json_encode(['offer' => $offer]);
        } else {
            echo json_encode(['error' => 'Offer not found']);
        }
    }

    // edit offer
    function edit_offer($id) {
        $data['offers'] = $this->adminmodel->get_offer_by_id($id);
        $data['categories'] = $this->adminmodel->get_category_names();
        echo json_encode($data);
    }

    // update offer
    function update_offer()
    {
        $offer_id = $this->input->post('id');
        $category_id = $this->input->post('categoryname');
        $offer_percent = $this->input->post('offer_percent');

        $data = array(
            'offer_name' => $this->input->post('offer_name'),
            'category_id' => $category_id,
            'offer_percent' => $offer_percent,
            'description' => $this->input->post('description'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date')
        );

        // Check if the offer is still valid
        $today = date('Y-m-d');
        if ($data['end_date'] >= $today) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        $this->load->model('adminmodel');
        $result = $this->adminmodel->update_offer($offer_id, $data);

        if ($result) {
            $this->adminmodel->apply_offer_to_products($offer_id, $category_id, $offer_percent);

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }


    function delete_offer($id)
    {
        $this->load->model('adminmodel');

        // Check if offer exists (optional safety)
        $offer = $this->db->get_where('offers', ['id' => $id])->row();
        if (!$offer) {
            show_error('Offer not found');
            return;
        }

        // Remove from products
        $this->adminmodel->delete_offer_from_products($id);

        // Delete offer
        if ($this->adminmodel->delete_offer($id)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    // function for review
    function reviews(){
        $data['reviews'] = $this->adminmodel->get_reviews();
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/reviews_list',$data);
        $this->load->view('admin/footer');    
    }
    
    function get_review_details() {
        $review_id = $this->input->post('review_id');

        if ($review_id) {
        
            $review = $this->adminmodel->get_review_by_id($review_id);

            if ($review) {
                echo json_encode(['status' => 'success', 'data' => $review]);
            } else {
                echo json_encode(['status' => 'failed', 'message' => 'Review not found']);
            }
        } else {
            echo json_encode(['status' => 'failed', 'message' => 'Invalid review ID']);
        }
   }

    function delete_review() {
        $review_id = $this->input->post('review_id');

        if ($review_id) {
            $this->db->where('id', $review_id);
            $deleted = $this->db->delete('reviews');

            if ($deleted) {
                echo 'deleted';
            } else {
                echo 'failed';
            }
        } else {
            echo 'invalid';
        }
    }


    // function for payments
    function payments(){
        $data['payments'] = $this->adminmodel->get_payments();
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/payments_list',$data);
        $this->load->view('admin/footer');    
    }
   
    function view_payment_details() {
        $payment_id = $this->input->post('payment_id');  

        if (!$payment_id) {
            echo json_encode(['status' => 'error', 'message' => 'Payment ID is required']);
            return;
        }
        $this->load->model('adminmodel');
        $payment = $this->adminmodel->get_payment_by_id($payment_id);  // Retrieve payment by ID

        if ($payment) {
            echo json_encode(['status' => 'success', 'data' => $payment]);  // Return payment data
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Payment not found']);
        }
    }

    function toggle_payment_status() {
        $payment_id = $this->input->post('payment_id');
        $status = $this->input->post('status');

        if (!$payment_id || !isset($status)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        // Toggle the payment status
        $new_status = ($status == 1) ? 0 : 1; 

        $this->db->where('id', $payment_id);
        $updated = $this->db->update('payments', ['status' => $new_status]);

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Payment status updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update payment status']);
        }
    }

     //functions for orders
    function orders(){
        $data=array();    
        $data['orders'] = $this->adminmodel->get_orders();
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/orders_list',$data);
        $this->load->view('admin/footer');    
    }

    function toggle_order_status() {
        $order_id = $this->input->post('order_id');
        $status = $this->input->post('status');

        if ($order_id && $status) {
            $this->db->where('id', $order_id);
            $updated = $this->db->update('orders', ['order_status' => $status]);

            if ($updated) {
                echo 'updated';
            } else {
                echo 'failed';
            }
        } else {
            echo 'invalid';
        }
    }

    function cancel_order() {
        $order_id = $this->input->post('order_id');

        if ($order_id) {
            $this->db->where('id', $order_id);
            $updated = $this->db->update('orders', ['order_status' => 'canceled']);

            if ($updated) {
                $this->db->where('order_id', $order_id);
                $this->db->update('order_items', ['status' => 'canceled']);
                echo 'cancelled';  
            } else {
                echo 'failed';  
            }
        } else {
            echo 'invalid';  
        }
    }

    function get_orders_by_status($status) {
        $this->db->select('orders.id as order_id, users.name as customer_name, 
                       products.name as product_name, order_items.quantity, 
                       order_items.total_price, orders.order_status');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('order_items', 'order_items.order_id = orders.id');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('orders.order_status', $status);  // Use where condition based on the status (pending or success)
        $this->db->order_by('orders.order_date', 'DESC');
        $res = $this->db->get()->result_array();
        return $res;
    }

    function get_order_details() {
        $order_id = $this->input->post('order_id');

        if (!$order_id) {
            echo 'error';
            return;
        }

        $this->load->model('Ordermodel');
        $order = $this->Ordermodel->get_order_by_id($order_id);

        if ($order) {
            echo json_encode($order);
        } else {
            echo 'error';
        }
    }


    function confirmed_orders() {
        $data['delivered_orders'] = $this->get_orders_by_status('success'); // Fetch delivered orders
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/confirmed_orders', $data);
        $this->load->view('admin/footer');
    }

    function pending_orders() {
        $data['pending_orders'] = $this->get_orders_by_status('pending'); // Fetch pending orders
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/pending_orders', $data);
        $this->load->view('admin/footer');
    }

    function bulk_orders(){
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/bulk_orders_list');
        $this->load->view('admin/footer');    
    }

    function reports(){
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/reports_page');
        $this->load->view('admin/footer');    
    }
   
    // functions for users
    function users(){
        $data=array();
        $data['users']=$this->adminmodel->get_users();
        $data['num_users'] = $this->adminmodel->count_customers();
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/users_list', $data);
        $this->load->view('admin/footer');    
    }

    function get_user_by_id()
    {
        $id = $this->input->post('id');
        $user = $this->adminmodel->get_user_by_id($id);

        if ($user) {
            echo json_encode(['status' => 'success', 'data' => $user]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
    }

    function delete_user() {
        $id = $this->input->post('id');

        if (!$id) {
            echo 'Invalid request';
            return;
        }
        $this->db->where('id', $id);
        $this->db->update('users', ['status' => 0]);

        if ($this->db->affected_rows() > 0) {
            echo 'User deleted successfully';
        } else {
            echo 'User deletion failed or user already inactive';
        }
    }


    // Users Report
   function user_reports() {
        $data['users'] = $this->adminmodel->get_users_report();
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/users_report', $data);
        $this->load->view('admin/footer');
    }

    function generate_users_report() {
        $startDate = $this->input->get('start_date');
        $endDate = $this->input->get('end_date');
        $status = $this->input->get('status');

        $data['users'] = $this->adminmodel->get_users_data($startDate, $endDate, $status);
        $this->load->view('admin/users_report', $data);
    
    }

// Sales Report
    function sales_reports() {
        $data['sales'] = $this->adminmodel->get_sales_report();
        $this->load->view('admin/headers');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/sales_reports', $data);
        $this->load->view('admin/footer');
    }
    function generate_sales_report() {
        $startDate = $this->input->get('start_date');
        $endDate = $this->input->get('end_date');
        $paymentStatus = $this->input->get('payment_status');
    
        $data['sales'] = $this->adminmodel->get_sales($startDate, $endDate, $paymentStatus);
        $this->load->view('admin/sales_reports', $data);
    }


















}
?>




