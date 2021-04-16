<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Outlet extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {	
		if(!$this->session->userdata('login') || !$this->session->userdata('store')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Outlet';
		$this->data['judul_utama'] = 'Outlet';
		$this->data['judul_sub'] = 'List';
		
		$this->data['faq'] = $this->access->readtable('store','',array('store.deleted_at'=>null),array('city' => 'city.id_city = store.id_city','provinsi' => 'provinsi.id_provinsi = store.id_provinsi'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('outlets/outlet_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function add($id_store =''){
		if(!$this->session->userdata('login') || !$this->session->userdata('store')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Store';
		$this->data['judul_utama'] = 'Store';
		$this->data['judul_sub'] = 'Add';
		$this->data['store'] = '';
		$this->data['provinsi'] = $this->access->readtable('provinsi','',array('deleted_at'=>null))->result_array();
		if($id_store > 0) $this->data['store'] = $this->access->readtable('store','',array('id_op'=>$id_store))->row();		
		$this->data['isi'] = $this->load->view('outlets/outlet_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function get_city(){
		$id_provinsi = isset($_POST['id']) ? (int)$_POST['id'] : 0;
		$where = array('deleted_at'=>null,'id_provinsi'=>$id_provinsi);		
		$type = $this->access->readtable('city','',$where)->result_array();		
		$html = '';
		if(!empty($type)){
			foreach($type as $t){
				$html .='<option value="'.$t['id_city'].'">'.$t['nama_city'].'</option>';
			}
		}else{
			$html .='<option value="">Data not found</option>';
		}
		echo $html;
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_op' => $_POST['id']
		);
		$data = array(
			'deleted_by'	=> $this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('store', $data, $where);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id_outlet = isset($_POST['id_store']) ? (int)$_POST['id_store'] : 0;
		$id_provinsi = isset($_POST['provinsi']) ? (int)$_POST['provinsi'] : 0;
		$id_city = isset($_POST['kota']) ? (int)$_POST['kota'] : 0;
		$name_store = isset($_POST['name_store']) ? $_POST['name_store'] : '';
		$username = md5(strtolower($_POST['username']));
		$password = isset($_POST['password']) ? md5($_POST['password']) : '';
		$deskripsi = isset($_POST['alamat']) ? $_POST['alamat'] : '';
		$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';		
		$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';		
		$_user = $this->converter->encode(strtolower($_POST['username']));
		$_pass = isset($_POST['password']) ? $this->converter->encode($_POST['password']) : '';		
		$simpan = array(			
			'nama'		=> $name_store,
			'username'	=> $username,
			'password'	=> $password,
			'deskripsi'	=> $deskripsi,
			'longitude'	=> $longitude,
			'latitude'	=> $latitude,
			'id_provinsi'	=> $id_provinsi,
			'id_city'	=> $id_city,
			'_user'		=> $_user,
			'_pass'		=> $_pass
		);
		$where = array();
		$save = 0;
		// $data = array(			
			// 'id_store'		=> $save,
			// 'name'			=> $name_store,
			// 'username'		=> $username,	
			// 'password'		=> $password,	
			// 'tipe'			=> 2,	
			// '_user'			=> $_user,
			// '_pass'			=> $_pass	
		// );
		if($id_outlet > 0){
			$where = array('id_op'=>$id_outlet);
			$simpan += array('created_by' => $this->session->userdata('operator_id'));
			$this->access->updatetable('store', $simpan, $where); 
			$_where = array('id_store' => $id_outlet,'status'=>1,'tipe'=>2);
			$this->access->updatetable('admin', $data, $_where);   	
			$save = $id_outlet;
		}else{
			$simpan += array('created_at' => $tgl,'updated_by' => $this->session->userdata('operator_id'));
			$save = $this->access->inserttable('store', $simpan); 
			// $data += array('id_store' => $save,'status'=>1,'tipe'=>2);
			// $this->access->inserttable('admin', $data);   
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
