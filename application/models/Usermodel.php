<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    // fetch all products with category
    function get_products_with_category(){
        $this->db->select('products.*, categories.category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    // fetch category name
    function get_category_names() {
        $query = $this->db->get('categories');
        return $query->result_array();
    }
    
    // get products by id
    function get_product_by_id($id)
    {
        $this->db->select('products.*, categories.category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id');
        $this->db->where('products.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // add item to cart
    function insert_cart_item($data)
    {
        return $this->db->insert('cart', $data);
    }

    // get user's cart
    function get_user_cart($user_id){
        $this->db->select('cart.*, products.name, products.image, products.original_price, products.offer_price, products.offer_id');
        $this->db->from('cart');
        $this->db->join('products', 'products.id = cart.product_id');
        $this->db->where('cart.user_id', $user_id);
        $this->db->where('cart.status', 1);
        return $this->db->get()->result();
    }

    // get cart items 
    function get_cart_item_by_id($cart_id){
        return $this->db->get_where('cart', ['id' => $cart_id])->row();
    }

    // update cart quantity
    function update_cart_quantity($cart_id, $quantity){
        $this->db->where('id', $cart_id);
        return $this->db->update('cart', ['quantity' => $quantity]);
    }

    // delete cart items from table
    function delete_cart_item($cart_id){
        $this->db->where('id', $cart_id);
        return $this->db->delete('cart');
    }

    // get products with offer
    function get_all_products_with_offer()
    {
        return $this->db->select('products.*, offers.offer_percent')
                    ->from('products')
                    ->join('offers', 'offers.id = products.offer_id', 'left')
                    ->get()
                    ->result_array();
    }

    // get cart item in profile page 
    function get_cart_items($user_id) {
        $this->db->select('cart.*, products.name, products.image'); // Removed products.price
        $this->db->from('cart');
        $this->db->join('products', 'products.id = cart.product_id');
        $this->db->where('cart.user_id', $user_id);
        return $this->db->get()->result();
    }

    // clear cart after placing orders
    function clear_cart($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->delete('cart');
    }

    // get cart of the user
    function get_user_orders($user_id) {
        $this->db->select('
        oi.id,
        o.id as order_id, 
        oi.product_id, 
        p.name, 
        p.image, 
        oi.quantity, 
        oi.total_price,
        oi.status, 
        CASE 
            WHEN pay.status = 1 THEN "Paid" 
            ELSE "Pending" 
        END as payment_status, 
        CASE 
            WHEN o.order_status = "success" THEN "Delivered"
            WHEN o.order_status = "pending" THEN "Pending"
            WHEN o.order_status = "cancel" THEN "Canceled"
        END as order_status', false);

        $this->db->from('orders o');
        $this->db->join('order_items oi', 'o.id = oi.order_id');
        $this->db->join('products p', 'oi.product_id = p.id');
        $this->db->join('payments pay', 'pay.order_id = o.id', 'left');
        $this->db->where('o.user_id', $user_id);
        $this->db->where('o.status', 1);
        $this->db->order_by('o.order_date', 'DESC');
        return $this->db->get()->result();
    }


    //fetch all products
    function get_all_products() {
       return $this->db->get('products')->result_array();
    }
    
    // register the user
    function register($data) {
        return $this->db->insert('users', $data);
    }

    // get user by email
    function get_user_by_email($email) {
        return $this->db->get_where('users', ['email' => $email, 'status' => 1])->row_array();
    }

    // get user by id
    function get_user_by_id($id) {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }









}
?>