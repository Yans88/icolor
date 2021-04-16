<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Area';
		$this->data['judul_utama'] = 'Area';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$where = array('store.deleted_at'=>null);
		
		$this->data['area'] = $this->access->readtable('area_layanan','',array('area_layanan.deleted_at'=>null),array('store' => 'store.id_op = area_layanan.id_store'),'','','LEFT')->result_array();		
		$this->data['store'] = $this->access->readtable('store','',$where)->result_array();		
		$this->data['isi'] = $this->load->view('area/area_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function del(){
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_area' => $_POST['id']
		);
		$data = array(
			'deleted_by'	=> $this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('area_layanan', $data, $where);
	}

	
	public function simpan_cat(){
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$id_category = isset($_POST['id_category']) ? (int)$_POST['id_category'] : 0;		
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$id_store = isset($_POST['list_store']) ? (int)$_POST['list_store'] : '';
			
		$simpan = array(			
			'nama_area'		=> $category,		
			'id_store'		=> $id_store				
		);
		
		$where = array();
		$save = 0;	
		if($id_category > 0){
			$where = array('id_area'=>$id_category);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->updatetable('area_layanan', $simpan, $where);   
		}else{
			$simpan += array('created_at' => $tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('area_layanan', $simpan);   
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
