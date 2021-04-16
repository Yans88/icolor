<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_kerusakan extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {	
		if(!$this->session->userdata('login') || !$this->session->userdata('master_kerusakan')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Price Check';
		$this->data['judul_utama'] = 'Price Check';
		$this->data['judul_sub'] = 'List';
		$selects = array('master_kerusakan.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$this->data['m_kerusakan'] = $this->access->readtable('master_kerusakan',$selects,array('master_kerusakan.deleted_at'=>null),array('kategori' => 'kategori.id_kategori = master_kerusakan.device_cat','sub_kategori' => 'sub_kategori.id_sub = master_kerusakan.device_type'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('kerusakan/kerusakan_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function add($id =''){
		if(!$this->session->userdata('login') || !$this->session->userdata('master_kerusakan')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Price Check';
		$this->data['judul_utama'] = 'Price Check';
		$this->data['judul_sub'] = 'Add';
		$this->data['master_kerusakan'] = '';
		$this->data['category'] = $this->access->readtable('kategori','', array('deleted_at'=>null,'tipe'=>1))->result_array();
		if($id > 0) $this->data['master_kerusakan'] = $this->access->readtable('master_kerusakan','',array('id'=>$id))->row();		
		$this->data['isi'] = $this->load->view('kerusakan/kerusakan_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_by'	=> $this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('master_kerusakan', $data, $where);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
		$device_cat = isset($_POST['device_cat']) ? (int)$_POST['device_cat'] : 0;
		$device_type = isset($_POST['device_type']) ? (int)$_POST['device_type'] : 0;
		$name_sp = isset($_POST['nama_sp']) ? $_POST['nama_sp'] : '';
		$harga = isset($_POST['harga']) ? str_replace('.','',$_POST['harga']) : 0;
		$varian = isset($_POST['varian']) ? $_POST['varian'] : '';
		$harga = str_replace(',','',$harga);		
		$simpan = array();			
		$simpan = array(			
			'device_cat'	=> $device_cat,
			'device_type'	=> $device_type,
			'nama_sp'		=> $name_sp,
			'varian'		=> $varian,
			'harga'			=> $harga
		);
		$where = array();		
		if($id > 0){
			$where = array('id'=>$id);
			$simpan += array('updated_by' => $this->session->userdata('operator_id'));
			$this->access->updatetable('master_kerusakan', $simpan, $where); 			
			$save = $id;
		}else{
			$simpan += array('created_at' => $tgl,'created_by' => $this->session->userdata('operator_id'));
			$save = $this->access->inserttable('master_kerusakan', $simpan);			
		}		
		echo $save;	 
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
