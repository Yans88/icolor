<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);					
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Level-Role';
		$this->data['judul_utama'] = 'Level-Role';
		$this->data['judul_sub'] = 'List';
		$this->data['title_box'] = 'List of Level';
		$this->data['level'] = $this->access->readtable('level','',array('level.deleted_at'=>null))->result_array();			
		$this->data['isi'] = $this->load->view('level_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function add($id_level=null) {
		if(!$this->session->userdata('login') || !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}
		$this->data['level'] = '';	
		$this->data['judul_browser'] = 'Level-Role';
		$this->data['judul_utama'] = 'Level-Role';
		$this->data['judul_sub'] = 'List';
		$this->data['title_box'] = 'List of Level';
		if(!empty($id_level)){
			$this->data['level'] = $this->access->readtable('level','',array('deleted_at'=>null,'id'=>$id_level))->row();
		}
		
		$this->data['isi'] = $this->load->view('level_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function save(){		
		if(!$this->session->userdata('login') || !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}
		
		$save =0;
		$id_level = isset($_POST['id_level']) ? (int)$_POST['id_level'] : '0';		
		$level_name = isset($_POST['level_name']) ? $_POST['level_name'] : '';				
		$members = isset($_POST['members']) ? (int)$_POST['members'] : '0';
		$tools = isset($_POST['tools']) ? (int)$_POST['tools'] : '0';
		$spare_parts = isset($_POST['spare_parts']) ? (int) $_POST['spare_parts'] : '0';
		$master_kerusakan = isset($_POST['master_kerusakan']) ? (int)$_POST['master_kerusakan'] : '0';
		$tutorial = isset($_POST['tutorial']) ? (int)$_POST['tutorial'] : '0';
		$forum = isset($_POST['forum']) ? (int)$_POST['forum'] : '0';
		$news = isset($_POST['news']) ? (int)$_POST['news'] : '0';
		$home_service = isset($_POST['home_service']) ? (int)$_POST['home_service'] : '0';
		$pickup_service = isset($_POST['pickup_service']) ? (int)$_POST['pickup_service'] : '0';
		$kirim_device = isset($_POST['kirim_device']) ? (int)$_POST['kirim_device'] : '0';
		$instore = isset($_POST['instore']) ? (int)$_POST['instore'] : '0';
		$order_part_s = isset($_POST['order_part_s']) ? (int)$_POST['order_part_s'] : '0';
		$order_shop = isset($_POST['order_shop']) ? (int)$_POST['order_shop'] : '0';
		$product_redeem = isset($_POST['product_redeem']) ? (int)$_POST['product_redeem'] : '0';
		$daftar_redeem = isset($_POST['daftar_redeem']) ? (int)$_POST['daftar_redeem'] : '0';
		$category = isset($_POST['category']) ? (int)$_POST['category'] : '0';
		$product = isset($_POST['product']) ? (int)$_POST['product'] : '0';
		$banner = isset($_POST['banner']) ? (int)$_POST['banner'] : '0';
		$store = isset($_POST['store']) ? (int)$_POST['store'] : '0';
		$kurir = isset($_POST['kurir']) ? (int)$_POST['kurir'] : '0';
		$teknisi = isset($_POST['teknisi']) ? (int)$_POST['teknisi'] : '0';
		$area = isset($_POST['area']) ? (int)$_POST['area'] : '0';
		$province = isset($_POST['province']) ? (int)$_POST['province'] : '0';
		$faq = isset($_POST['faq']) ? (int)$_POST['faq'] : '0';
		$bank_icolor = isset($_POST['bank_icolor']) ? (int)$_POST['bank_icolor'] : '0';
		$level_role = isset($_POST['level_role']) ? (int)$_POST['level_role'] : '0';
		$users = isset($_POST['users']) ? (int)$_POST['users'] : '0';
		$setting_point = isset($_POST['setting_point']) ? (int)$_POST['setting_point'] : '0';
		$setting = isset($_POST['setting']) ? (int)$_POST['setting'] : '0';
		$data = array(
			'level_name'		=> $level_name,
			'members'			=> $members,
			'tools'				=> $tools,
			'spare_parts'		=> $spare_parts,
			'master_kerusakan'	=> $master_kerusakan,
			'tutorial'			=> $tutorial,
			'forum'				=> $forum,
			'news'				=> $news,
			'home_service'		=> $home_service,
			'pickup_service'	=> $pickup_service,
			'kirim_device'		=> $kirim_device,
			'instore'			=> $instore,
			'order_part_s'		=> $order_part_s,
			'order_shop'		=> $order_shop,
			'product_redeem'	=> $product_redeem,
			'daftar_redeem'		=> $daftar_redeem,
			'category'			=> $category,
			'product'			=> $product,
			'banner'			=> $banner,
			'store'				=> $store,
			'kurir'				=> $kurir,
			'teknisi'			=> $teknisi,
			'area'				=> $area,
			'province'			=> $province,
			'faq'				=> $faq,
			'bank_icolor'		=> $bank_icolor,
			'level_role'		=> $level_role,
			'users'				=> $users,
			'setting_point'		=> $setting_point,
			'setting'			=> $setting,
			
		);
		$where = array();
		$tgl = date('Y-m-d H:i:s');
		$operator_id = $this->session->userdata('operator_id');
		if($id_level > 0){			
			$where = array('id'=>$id_level);
			$data += array('updated_by' => $operator_id);
			$this->access->updatetable('level',$data, $where);
			$save = $id_level;
		}else{			
			$data += array('created_by' => $operator_id, 'created_at' => $tgl);
			$save = $this->access->inserttable('level', $data);
		}
		
		echo $save;
	}
	
	public function del(){	
		if(!$this->session->userdata('login') || !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}	
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);		
		echo $this->access->updatetable('level', $data, $where);
	}
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div><div class="error-page">
        <h3 class="text-red"><i class="fa fa-warning text-yellow"></i> Oops! No Akses.</h3></div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}


}
