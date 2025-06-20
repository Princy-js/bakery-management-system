<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adminmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    // Admin login
    function authenticate($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('admin');

        if ($query->num_rows() === 1) {
            $row = $query->row();

            // Verify password
            if (password_verify($password, $row->password)) {
                return true;
            }
        }

        return false;
    }

    //count total customers
    function count_customers() {
        return $this->db->count_all('users');
    }

    //count total products
    function count_products() {
        return $this->db->count_all('products');
    }

    //categories
    function get_categories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        $res=$this->db->get()->result_array();
        return $res;
    }
    //save category
    function save_category($data){
        return $this->db->insert('categories',$data);
    }
    // update category
    function update_category($data,$id){
        $this->db->where('id',$id);
        return $this->db->update('categories',$data);
    }
    //delete category
    function delete_category($id){
        $this->db->where('id',$id);
        return $this->db->delete('categories');
    }

    //products
    function get_products_with_category(){
        $this->db->select('products.*, categories.category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    //get category name
    function get_category_names() {
        $query = $this->db->get('categories');
        return $query->result_array();
    }
    //save product
    function save_product($data) {
        return $this->db->insert('products', $data);
    }
    //get product by id
    function get_product_by_id($id) {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }

    // update product
    function update_product($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    // view product by id
    function view_product_by_id($id) {
    return $this->db->select('products.*, categories.category_name')
                    ->from('products')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->where('products.id', $id)
                    ->get()
                    ->row_array();
    }
    // delete product details
    function delete_product_info($id){
        $this->db->where('id',$id);
        return $this->db->delete('products');
    }

    // get all users
    function get_users()
    {
        $this->db->select('*');
        $this->db->from('users');
        $res=$this->db->get()->result_array();
        return $res;
    }

    function get_user_by_id($id)
    {
        return $this->db->select('id, name, email, phone, address, created_at, status')
                    ->where('id', $id)
                    ->get('users')
                    ->row_array();
    }

    function deactivate_user($id) {
        $this->db->where('id', $id);
        return $this->db->update('users', ['status' => 0]);
    }

    //get offers
    function get_offers()
    {
        $this->db->select('offers.*, categories.category_name, categories.id as category_id');
        $this->db->from('offers');
        $this->db->join('categories', 'categories.id = offers.category_id', 'left');
        $res = $this->db->get()->result_array();
        return $res;
    }

    // Insert offer into the 'offers' table
    function insert_offer($data)
    {
        $this->db->insert('offers', $data);
        return $this->db->insert_id();
    }
    
    // apply offer to products
    function apply_offer_to_products($offer_id, $category_id, $offer_percent) {
        $this->db->where('category_id', $category_id);
        $products = $this->db->get('products')->result_array();

        log_message('info', "Found " . count($products) . " products in category $category_id");

        foreach ($products as $product) {
            $original_price = $product['original_price'];
            $discount = ($offer_percent / 100) * $original_price;
            $offer_price = $original_price - $discount;

            $this->db->where('id', $product['id']);
            $this->db->update('products', [
                'offer_price' => $offer_price,
                'offer_id' => $offer_id
            ]);

            log_message('info', "Updated product ID " . $product['id'] . " with offer price $offer_price and offer ID $offer_id");
        }
    }

    // remove expired offers
    function remove_expired_offers_from_products(){
        $today = date('Y-m-d');
        // Get all expired offers
        $this->db->where('end_date <', $today);
        $this->db->where('status', 1); // Only those still active
        $expired_offers = $this->db->get('offers')->result_array();

        foreach ($expired_offers as $offer) {
            $offer_id = $offer['id'];

            // Update products using this offer
            $this->db->where('offer_id', $offer_id);
            $products = $this->db->get('products')->result_array();

            foreach ($products as $product) {
                $this->db->where('id', $product['id']);
                $this->db->update('products', [
                    'offer_price' => $product['original_price'],
                    'offer_id' => null
                ]);
            }

            // Set offer status = 0 (expired)
            $this->db->where('id', $offer_id);
            $this->db->update('offers', ['status' => 0]);
        }

        return true;
    }

    // to get offer by id
    function get_offer_by_id($id) {
        return $this->db->get_where('offers', ['id' => $id])->row_array();
    }
    // update offer
    function update_offer($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('offers', $data);  // 'offers' is the table name
    }
    // delete offer
    function delete_offer($id){
        $this->db->where('id', $id);
        return $this->db->delete('offers');
    }
    // delete offer from products table
    function delete_offer_from_products($offer_id){
        $this->db->where('offer_id', $offer_id);
        $this->db->update('products', [
            'offer_price' => null,
            'offer_id' => null
        ]);
    }
    // view offer by id
    function view_offer_by_id($id) {
    return $this->db->select('offers.*, categories.category_name')
                    ->from('offers')
                    ->join('categories', 'categories.id = offers.category_id', 'left')
                    ->where('offers.id', $id)
                    ->get()
                    ->row_array();
    }

    function get_orders() {
        $this->db->select('orders.id as order_id, users.name as customer_name, 
                        products.name as product_name, order_items.quantity, 
                        order_items.total_price, orders.order_status');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('order_items', 'order_items.order_id = orders.id');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('order_items.status', 1); 
        $this->db->order_by('orders.order_date', 'DESC');

        $res = $this->db->get()->result_array(); 
        return $res;
    }

    function get_order_by_id($order_id) {
        $this->db->select('orders.*, users.name as customer_name, products.product_name');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('order_items', 'order_items.order_id = orders.id');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('orders.id', $order_id);
        return $this->db->get()->row_array();
    }

    function get_reviews()
    {
    
        $this->db->select('reviews.id, users.name as customer_name, products.name as product_name, reviews.ratings, reviews.review, reviews.status');
        $this->db->from('reviews');
        $this->db->join('users', 'reviews.user_id = users.id');
        $this->db->join('products', 'reviews.product_id = products.id');
        $this->db->where('reviews.status', 1); 
        $query = $this->db->get();

        return $query->result_array(); 
    }

    function get_review_by_id($review_id) {
        $this->db->select('reviews.*, users.name as customer_name, products.name as product_name');
        $this->db->from('reviews');
        $this->db->join('users', 'reviews.user_id = users.id');
        $this->db->join('products', 'reviews.product_id = products.id');
        $this->db->where('reviews.id', $review_id);
        $query = $this->db->get();

        return $query->row_array(); 
    }

    function get_payments() {
        $this->db->select('payments.id as payment_id, users.name as customer_name, orders.id as order_id, payments.amount_paid, payments.payment_mode, payments.status');
        $this->db->from('payments');
        $this->db->join('orders', 'orders.id = payments.order_id');
        $this->db->join('users', 'users.id = orders.user_id');
   
        $res = $this->db->get()->result_array();
        return $res;
    }


    function get_payment_by_id($payment_id) {
        $this->db->select('payments.*,  users.name as customer_name, 
                       orders.id as order_id, ');
        $this->db->from('payments');
        $this->db->join('orders', 'orders.id = orders.id');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->where('payments.id', $payment_id); 
    
        $query = $this->db->get();
        return $query->row_array();  
    }


    // functions for fetching data for reports
    // user data fetching
    function get_users_data($startDate = null, $endDate = null, $status = null) {
        $this->db->select('id, name, email, phone, address, status, created_at');
        $this->db->from('users');

        if ($startDate && $endDate) {
            $this->db->where('created_at >=', $startDate);
            $this->db->where('created_at <=', $endDate);
        }
        if ($status) {
            $this->db->where('status', $status); 
        }

        return $this->db->get()->result_array();
    }

// Sales data fetching
    function get_sales($startDate = null, $endDate = null, $paymentStatus = null) {
        $this->db->select('orders.id as order_id, users.name as customer_name, 
                        products.name as product_name, order_items.quantity, 
                        order_items.total_price, orders.order_status, payments.amount_paid, 
                        payments.payment_mode, payments.status as payment_status');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('order_items', 'order_items.order_id = orders.id');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->join('payments', 'payments.order_id = orders.id');
    
        if ($startDate && $endDate) {
            $this->db->where('orders.order_date >=', $startDate);
            $this->db->where('orders.order_date <=', $endDate);
        }

        if ($paymentStatus) {
            $this->db->where('payments.status', $paymentStatus); 
        }

        return $this->db->get()->result_array();
    }

    // Get Users Report Data
    function get_users_report() {
        $this->db->select('id, name, email, phone, address, created_at, status');
        $this->db->from('users');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get Sales Report Data
        function get_sales_report() {
        $this->db->select('orders.id as order_id, users.name as customer_name, 
                           products.name as product_name, order_items.quantity, 
                           order_items.total_price, payments.status as payment_status');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('order_items', 'order_items.order_id = orders.id');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->join('payments', 'payments.order_id = orders.id');
       
        $query = $this->db->get();
        return $query->result_array();
    }

    // 1. Total Orders Count
public function getTotalOrdersCount() {
    return $this->db->count_all_results('orders');
}

// 2. Pending Orders Count
public function getPendingOrdersCount() {
    $this->db->where('order_status', 'pending');
    return $this->db->count_all_results('orders');
}

// 3. Delivered Orders Count
public function getDeliveredOrdersCount() {
    $this->db->where('order_status', 'success');
    return $this->db->count_all_results('orders');
}

// 4. Bulk Orders Count (assuming 'bulk_orders' table)
public function getBulkOrdersCount() {
    return $this->db->count_all_results('bulk_orders');
}

// 5. Total Revenue from Successful Orders
public function getTotalRevenue() {
    $this->db->select_sum('total_price');
    $this->db->where('order_status', 'success');
    $query = $this->db->get('orders');
    return $query->row()->total_price ?? 0;
}




}
?>
