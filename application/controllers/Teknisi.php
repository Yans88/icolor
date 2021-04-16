<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teknisi extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {	
		if(!$this->session->userdata('login') || !$this->session->userdata('teknisi')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Teknisi';
		$this->data['judul_utama'] = 'Teknisi';
		$this->data['judul_sub'] = 'List';
		$select = array('teknisi.*','store.nama as nama_store');
		$this->data['kurir'] = $this->access->readtable('teknisi',$select,array('teknisi.deleted_at'=>null),array('store' => 'store.id_op = teknisi.id_store'),'','','LEFT')->result_array();
		$this->data['store'] = $this->access->readtable('store','',array('deleted_at'=>null))->result_array();	
		$this->data['isi'] = $this->load->view('kurir/teknisi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function del(){
		if(!$this->session->userdata('login') || !$this->session->userdata('teknisi')){
			$this->no_akses();
			return false;
		}	
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_by'	=> $this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('teknisi', $data, $where);
	}
	
	public function save(){
		if(!$this->session->userdata('login') || !$this->session->userdata('teknisi')){
			$this->no_akses();
			return false;
		}	
		$tgl = date('Y-m-d H:i:s');
		$id = isset($_POST['id_user']) ? (int)$_POST['id_user'] : 0;
		$id_store = isset($_POST['store']) ? (int)$_POST['store'] : 0;
		$email = isset($_POST['email']) ? strtolower($_POST['email']) : '';		
		$nama = isset($_POST['nama']) ? $_POST['nama'] : '';		
		$phone = isset($_POST['phone']) ? $_POST['phone'] : '';		
		$simpan = array();		
		$simpan = array(			
			'nama'		=> $nama,
			'id_store'	=> $id_store,
			'phone'		=> $phone,
			'email'		=> $email
		);
		$where = array();
		$save = 0;		
		if($id > 0){
			$where = array('id'=>$id);
			$simpan += array('updated_by' => $this->session->userdata('operator_id'));
			$this->access->updatetable('teknisi', $simpan, $where);			
			$save = $id;
		}else{
			$simpan += array('created_at' => $tgl,'created_by' => $this->session->userdata('operator_id'));
			$save = $this->access->inserttable('teknisi', $simpan);   
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
