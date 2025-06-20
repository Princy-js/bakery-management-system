<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','html'));
		$this->load->library(array('session', 'form_validation'));
	    $this->load->model('usermodel');


    }

    // Home page
	function index() {        
        $data['products'] = $this->usermodel->get_products_with_category();
        $data['products'] = $this->usermodel->get_all_products_with_offer();
        $data['categories'] = $this->usermodel->get_category_names();
		$this->load->view('users/header');
        $this->load->view('users/home', $data);
        $this->load->view('users/footer');
    }

    //About Us page
    function about_us() {
		$this->load->view('users/header');
        $this->load->view('users/about_us');
        $this->load->view('users/footer');
    }

    // Contact us page
    function contact_us() {
        $this->load->view('users/header');
        $this->load->view('users/contact_us');
        $this->load->view('users/footer');
    }

    // products page
    function products() {
        $data['products'] = $this->usermodel->get_products_with_category();
        $data['products'] = $this->usermodel->get_all_products_with_offer();
        $data['categories'] = $this->usermodel->get_category_names();
        $this->load->view('users/header');
        $this->load->view('users/products', $data);
        $this->load->view('users/footer');
    }
    
    //to get product details
    function get_product_details()
    {
        $product_id = $this->input->post('id');
        $this->load->model('usermodel');
        $product = $this->usermodel->get_product_by_id($product_id); 

        echo json_encode($product);
    }

    //add to cart
    function add_to_cart()
    {
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => 'login_required']);
            return;
         }

        $product_id = $this->input->post('product_id');
        $user_id = $this->session->userdata('user_id');

        $this->load->model('usermodel');
        $product = $this->usermodel->get_product_by_id($product_id);

        if (!$product) {
            echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
            return;
        }

        if (isset($product['availability']) && strtolower($product['availability']) === 'not available') {
            echo json_encode(['status' => 'error', 'message' => 'Product is not available.']);
            return;
        }

        $price = !empty($product['offer_price']) ? $product['offer_price'] : $product['original_price'];

        $data = [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => 1,
            'total_price' => $price,
            'status' => 1 
        ];
        $this->db->insert('cart', $data);
        echo json_encode(['status' => 'success']);
    }

    // to load cart modal
    function load_cart(){
        if (!$this->session->userdata('user_id')) {
            echo '<p class="text-center text-danger">Please login to view your cart.</p>';
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $data['cart'] = $this->usermodel->get_user_cart($user_id);
        $this->load->view('users/cart_view', $data); // create this view
    }

    //to update product quantity
    function update_quantity()
    {
        $cart_id = $this->input->post('id');
        $action = $this->input->post('action');

        $cart = $this->usermodel->get_cart_item_by_id($cart_id);
        if ($cart) {
            $qty = $cart->quantity;
            if ($action == 'increase') {
                $qty += 1;
            } elseif ($action == 'decrease' && $qty > 1) {
                $qty -= 1;
            }

            $this->usermodel->update_cart_quantity($cart_id, $qty);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cart item not found']);
        }
    }

    //remove cart items
    function remove_item()
    {
        $cart_id = $this->input->post('id');
        $this->usermodel->delete_cart_item($cart_id);
        echo json_encode(['status' => 'success']);
    }

    // user registration
    function register() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('users/header');
            $this->load->view('users/user_registration');
            $this->load->view('users/footer');
        } else {
            $data = [
                'name'     => $this->input->post('name'),
                'email'    => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'status'   => 1
            ];
            $this->usermodel->register($data);
            $this->session->set_flashdata('success', 'Registered successfully! Please log in.');
            redirect('user/login');
        }
    }

    // User login
    function login() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('users/header');
            $this->load->view('users/user_login');
            $this->load->view('users/footer');
        } else {
            $user = $this->usermodel->get_user_by_email($this->input->post('email'));
            if ($user && password_verify($this->input->post('password'), $user['password'])) {
                $this->session->set_userdata('user_id', $user['id']);
                redirect('user/index');
            } else {
                $this->session->set_flashdata('error', 'Invalid email or password.');
                redirect('user/login');
            }
        }
    }

    // User logout
    function logout() {
        $this->session->unset_userdata('user_id');
        redirect('user/index');
    }

    // user profile
    function profile() {
        if (!$this->session->userdata('user_id')) {
            redirect('users/user_login');
        }

        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->usermodel->get_user_by_id($user_id);
        $data['orders'] = $this->usermodel->get_user_orders($user_id);
        $this->load->view('users/header');
        $this->load->view('users/user_profile', $data); 
        $this->load->view('users/footer');
    }

    // update profile
    function update_profile() {
        $user_id = $this->session->userdata('user_id');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $this->db->where('id', $user_id);
        $this->db->update('users', [
            'phone' => $phone,
            'address' => $address
        ]);

        $this->session->set_flashdata('success', 'Profile updated successfully.');
        redirect('user/profile');
    }

    // checkout page
    function checkout() {
        $user_id = $this->session->userdata('user_id');
        $data['cart'] = $this->usermodel->get_cart_items($user_id);
        $this->load->view('users/header');
        $this->load->view('users/checkout', $data);
        $this->load->view('users/footer');
    }

    // order confirmation
    function confirm_order() {
        $user_id = $this->session->userdata('user_id');
        $product_ids = $this->input->post('product_ids');
        $quantities = $this->input->post('quantities');
        $total_prices = $this->input->post('total_prices');
        $payment_mode = $this->input->post('payment_mode');
        $user_note = $this->input->post('user_note');
        $subtotal = $this->input->post('subtotal');

        $order_data = [
            'user_id' => $user_id,
            'total_price' => $subtotal,
            'payment_mode' => $payment_mode,
            'order_status' => 'pending',
            'user_note' => $user_note,
            'status' => 1
        ];
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();

    
        for ($i = 0; $i < count($product_ids); $i++) {
        $quantity = $quantities[$i];
        $unit_price = $total_prices[$i]; 
        $total_price = $unit_price * $quantity; 

        $this->db->insert('order_items', [
            'order_id' => $order_id,
            'product_id' => $product_ids[$i],
            'quantity' => $quantity,
            'unit_price' =>$unit_price,
            'total_price' => $total_price,
            'status' => 1
        ]);
        }
        $payment_status = ($payment_mode === 'cod') ? 0 : 1;

        $this->db->insert('payments', [
            'order_id' => $order_id,
            'amount_paid' => $subtotal,
            'payment_mode' => $payment_mode,
            'status' => $payment_status
        ]);
        $this->usermodel->clear_cart($user_id);
        $this->session->set_flashdata('message', 'Order placed successfully!');
        redirect('user/profile');
    }

    // cancel orders
    function cancel_order_item()
    {
        $item_id = $this->input->post('item_id');

        if (!$item_id) {
            echo json_encode(['status' => 'failed', 'message' => 'Invalid item']);
            return;
        }
        $item = $this->db->get_where('order_items', ['id' => $item_id])->row();

        if (!$item || $item->status != 1) {
            echo json_encode(['status' => 'failed', 'message' => 'Invalid or already canceled item']);
            return;
        }

        $this->db->where('id', $item_id)->update('order_items', ['status' => 0]);

   
        $this->db->select_sum('total_price');
        $this->db->where('order_id', $item->order_id);
        $this->db->where('status', 1); 
        $remaining_total = $this->db->get('order_items')->row()->total_price ?? 0;

  
        $this->db->where('id', $item->order_id);
        $this->db->update('orders', ['total_price' => $remaining_total]);

   
        $this->db->where('order_id', $item->order_id);
        $this->db->update('payments', ['amount_paid' => $remaining_total]);

        echo json_encode(['status' => 'success', 'message' => 'Item canceled and prices updated']);
    }


    // invoice
    function invoice($order_id)
    {

        $order = $this->db->get_where('orders', ['id' => $order_id])->row();
        if (!$order) {
            show_404();
        }

        $user = $this->db->get_where('users', ['id' => $order->user_id])->row();

        $this->db->select('oi.*, p.name as product_name, p.image');
        $this->db->from('order_items oi');
        $this->db->join('products p', 'p.id = oi.product_id');
        $this->db->where('oi.order_id', $order_id);
        $order_items = $this->db->get()->result();

        // Payment info
        $payment = $this->db->get_where('payments', ['order_id' => $order_id])->row();

        $data = [
            'order' => $order,
            'user' => $user,
            'order_items' => $order_items,
            'payment' => $payment,
        ];
        $this->load->view('users/invoice_view', $data);
    }

    //review
    function submit_review() {
        $product_id = $this->input->post('product_id');
        $rating = $this->input->post('rating');
        $comment = $this->input->post('comment');
        $user_id = $this->session->userdata('user_id'); 

       
        if (empty($product_id) || empty($rating) || empty($comment) || empty($user_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing input data.']);
            return;
        }

        $data = [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'ratings' => $rating,
            'review' => $comment,
            'posted_at' => date('Y-m-d H:i:s'),
            'status' => 1 
        ];
    

        $insert = $this->db->insert('reviews', $data);

        if ($insert) {
            echo json_encode(['status' => 'success', 'message' => 'Review submitted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to submit review.']);
        }
    }
}
?>

