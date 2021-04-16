<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public $data = array();

	public function __construct() {

		parent::__construct();
		
		
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
		} else {
			// $level = '';
			$this->data['u_name'] = $this->session->userdata('u_name');
			$this->data['_operator_id'] = $this->session->userdata('operator_id');
			
			$this->data['l_evel'] = $this->session->userdata('level_name');
			$this->data['_MEMBERS'] = $this->session->userdata('members');
			$this->data['_TOOLS'] = $this->session->userdata('tools');
			$this->data['_SPPARTS'] = $this->session->userdata('spare_parts');
			$this->data['_MKERUSAKAN'] = $this->session->userdata('master_kerusakan');			
			$this->data['_TUTOR'] = $this->session->userdata('tutorial');
			$this->data['_FORUM'] = $this->session->userdata('forum');
			$this->data['_NEWS'] = $this->session->userdata('news');
			$this->data['_HOMES'] = $this->session->userdata('home_service');
			$this->data['_PICKUPS'] = $this->session->userdata('pickup_service');
			$this->data['_KIRIMDEVICE'] = $this->session->userdata('kirim_device');
			$this->data['_INSTORE'] = $this->session->userdata('instore');
			$this->data['_ORDER_PARTS'] = $this->session->userdata('order_part_s');
			$this->data['_ORDER_SHOP'] = $this->session->userdata('order_shop');
			$this->data['_PREDEEM'] = $this->session->userdata('product_redeem');
			$this->data['_DREDEEM'] = $this->session->userdata('daftar_redeem');
			$this->data['_CATEGORY'] = $this->session->userdata('category');
			$this->data['_PRODUCT'] = $this->session->userdata('product');
			$this->data['_BANNER'] = $this->session->userdata('banner');
			$this->data['_STORE'] = $this->session->userdata('store');
			$this->data['_KURIR'] = $this->session->userdata('kurir');
			$this->data['_TEKNISI'] = $this->session->userdata('teknisi');
			$this->data['_AREA'] = $this->session->userdata('area');
			$this->data['_PROVINCE'] = $this->session->userdata('province');
			$this->data['_FAQ'] = $this->session->userdata('faq');
			$this->data['_BANKICOLOR'] = $this->session->userdata('bank_icolor');
			$this->data['_LEVELROLE'] = $this->session->userdata('level_role');
			$this->data['_USERS'] = $this->session->userdata('users');
			$this->data['_SPOINT'] = $this->session->userdata('setting_point');
			$this->data['_SETTING'] = $this->session->userdata('setting');
			$this->data['isi'] = '';
			$this->data['judul_browser'] = '';
			$this->data['judul_utama'] = '';
			$this->data['judul_sub'] = '';
			$this->data['link_aktif'] = '';
			$this->data['css_files'] = array();
			$this->data['js_files'] = array();
			$this->data['js_files2'] = array();

		}
	}
}


