<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	// public $data = array ('pesan' => '');
	
	public function __construct () {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Login_m','login', TRUE);
	}
	
	public function index() {
		// status user login = BENAR, pindah ke halaman home
		$this->data = '';
		if ($this->session->userdata('login') == TRUE) {
			// redirect('product');
			redirect(base_url('user'));
		} else {
			// status login salah, tampilkan form login
			// validasi sukses
			if($this->login->validasi()) {
				// cek di database sukses
				if($this->login->cek_user()) {
					if($this->session->userdata('members') > 0) redirect('members');
					if($this->session->userdata('home_service') > 0) redirect('booking_service/home_service');
					if($this->session->userdata('pickup_service') > 0) redirect('booking_service/pickup_device');
					if($this->session->userdata('kirim_device') > 0) redirect('booking_service/kirim_ketoko');
					if($this->session->userdata('instore') > 0) redirect('booking_service/instore');
					if($this->session->userdata('order_shop') > 0) redirect('order_shop/new_order');
					if($this->session->userdata('order_part_s') > 0) redirect('order_part_s/new_order');
					if($this->session->userdata('daftar_redeem') > 0) redirect('redeem');
					if($this->session->userdata('product_redeem') > 0) redirect('redeem/product');
					if($this->session->userdata('news') > 0) redirect('berita');
					if($this->session->userdata('category') > 0) redirect('category');
					if($this->session->userdata('forum') > 0) redirect('forum');
					redirect('banner');
				} else {
					// cek database gagal
					$this->data['pesan'] = 'Username atau Password salah.';
				}
			} else {
				// validasi gagal
         }
        
         $this->load->view('themes/login_form_v', $this->data);
		}
	}
	
	// function test(){
		// redirect('home');
	// }

	public function logout() {
		// $this->login->logout();
		$this->session->sess_destroy();
		$this->session->unset_userdata(array('u_name' => '', 'login' => FALSE));
		
		redirect('/');
	}
}