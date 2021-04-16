<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Province extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('province')){
			$this->no_akses();
			return false;
		}		
		$this->data['judul_browser'] = 'Province';
		$this->data['judul_utama'] = 'Province';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$this->data['provinsi'] = $this->access->readtable('provinsi','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('provinsi/province_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function city($id_provinsi=0) {
		if(!$this->session->userdata('login') || !$this->session->userdata('province')){
			$this->no_akses();
			return false;
		}			
		$this->data['judul_browser'] = 'City';
		$this->data['judul_utama'] = 'All';
		$this->data['judul_sub'] = 'City';
		
		$where = array('deleted_at'=>null);
		if($id_provinsi > 0){
			$where += array('id_provinsi' => $id_provinsi);
			$prov = $this->access->readtable('provinsi','',$where)->row();
			$this->data['judul_utama'] = $prov->nama_provinsi;
		}
		
		$this->data['id_provinsi'] = $id_provinsi;
		$this->data['city'] = $this->access->readtable('city','',$where)->result_array();
		$this->data['isi'] = $this->load->view('provinsi/city_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function kecamatan($id_city=0) {
		if(!$this->session->userdata('login') || !$this->session->userdata('province')){
			$this->no_akses();
			return false;
		}			
		$this->data['judul_browser'] = 'Kecamatan';
		$this->data['judul_utama'] = 'All';
		$this->data['judul_sub'] = 'Kecamatan';
		
		$where = array('deleted_at'=>null);
		if($id_city > 0){
			$where += array('id_city' => $id_city);
			$city = $this->access->readtable('city','',$where)->row();			
			$this->data['judul_utama'] = $city->nama_city;
		}
		$id_provinsi = $city->id_provinsi;
		$this->data['provinsi'] = $this->access->readtable('provinsi','',array('deleted_at'=>null,'id_provinsi'=>$id_provinsi))->row();
		$this->data['id_city'] = $id_city;
		$this->data['id_provinsi'] = $id_provinsi;
		$this->data['kecamatan'] = $this->access->readtable('kecamatan','',$where)->result_array();
		$this->data['isi'] = $this->load->view('provinsi/kecamatan_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function kelurahan($id_kec=0) {
		if(!$this->session->userdata('login') || !$this->session->userdata('province')){
			$this->no_akses();
			return false;
		}			
		$this->data['judul_browser'] = 'Kelurahan';
		$this->data['judul_utama'] = 'All';
		$this->data['judul_sub'] = 'Kelurahan';
		
		$where = array('deleted_at'=>null);
		if($id_kec > 0){
			$where += array('id_kec' => $id_kec);
			$kecamatan = $this->access->readtable('kecamatan','',$where)->row();			
			$this->data['judul_utama'] = $kecamatan->nama_kec;
		}
		$id_city = $kecamatan->id_city;
		$city = $this->access->readtable('city','',array('id_city'=>$id_city))->row();	
		$id_provinsi = $city->id_provinsi;
		$this->data['provinsi'] = $this->access->readtable('provinsi','',array('deleted_at'=>null,'id_provinsi'=>$id_provinsi))->row();
		$this->data['city'] = $city;	
		$this->data['id_city'] = $id_city;
		$this->data['id_kec'] = $id_kec;
		$this->data['id_provinsi'] = $id_provinsi;
		$this->data['kelurahan'] = $this->access->readtable('kelurahan','',$where)->result_array();
		$this->data['isi'] = $this->load->view('provinsi/kelurahan_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_provinsi' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('provinsi', $data, $where);
	}

	public function del_city(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_city' => $_POST['id']
		);
		$data = array(			
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('city', $data, $where);
	}
	
	public function del_kec(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_kec' => $_POST['id']
		);
		$data = array(
			'deleted_by'	=>$this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('kecamatan', $data, $where);
	}
	
	public function del_kel(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_kelurahan' => $_POST['id']
		);
		$data = array(
			'deleted_by'	=>$this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('kelurahan', $data, $where);
	}
	
	public function simpan_prov(){
		$tgl = date('Y-m-d H:i:s');
		$id_provinsi = isset($_POST['id_provinsi']) ? (int)$_POST['id_provinsi'] : 0;		
		$nama_provinsi = isset($_POST['provinsi']) ? $_POST['provinsi'] : '';
		$ocrcode_p = isset($_POST['ocrcode_p']) ? $_POST['ocrcode_p'] : '';
			
		$simpan = array(			
			'nama_provinsi'		=> $nama_provinsi,			
			'ocrcode_p'			=> $ocrcode_p			
		);
		
		$where = array();
		$save = 0;	
		if($id_provinsi > 0){
			$where = array('id_provinsi'=>$id_provinsi);
			$save = $this->access->updatetable('provinsi', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('provinsi', $simpan);   
		}  
		redirect(site_url('province'));
	}
	
	public function simpan_city(){
		$tgl = date('Y-m-d H:i:s');
		$id_provinsi = isset($_POST['id_provinsi']) ? (int)$_POST['id_provinsi'] : 0;		
		$id_city = isset($_POST['id_city']) ? (int)$_POST['id_city'] : 0;		
		$nama_city = isset($_POST['city']) ? $_POST['city'] : '';
		$ocrcode_c = isset($_POST['ocrcode_c']) ? $_POST['ocrcode_c'] : '';
				
		$simpan = array(			
			'id_provinsi'	=> $id_provinsi,			
			'nama_city'		=> $nama_city,			
			'ocrcode_c'		=> $ocrcode_c			
		);
		
		$where = array();
		$save = 0;	
		if($id_city > 0){
			$where = array('id_city'=>$id_city);
			$save = $this->access->updatetable('city', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('city', $simpan);   
		}  
		redirect(site_url('province/city/'.$id_provinsi));
	}
	
	public function simpan_kec(){
		$tgl = date('Y-m-d H:i:s');
		$id_kec = isset($_POST['id_kec']) ? (int)$_POST['id_kec'] : 0;		
		$id_city = isset($_POST['id_city']) ? (int)$_POST['id_city'] : 0;		
		$nama_kec = isset($_POST['kecamatan']) ? $_POST['kecamatan'] : '';
		$simpan = array(						
			'nama_kec'	=> $nama_kec,					
		);
		
		$where = array();
		$save = 0;	
		if($id_kec > 0){
			$where = array('id_kec'=>$id_kec);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->updatetable('kecamatan', $simpan, $where);   
		}else{
			$simpan += array('created_at' => $tgl,'id_city' => $id_city,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('kecamatan', $simpan);   
		}  
		redirect(site_url('province/kecamatan/'.$id_city));
	}
	
	public function simpan_kel(){
		$tgl = date('Y-m-d H:i:s');
		$id_kec = isset($_POST['id_kec']) ? (int)$_POST['id_kec'] : 0;		
		$id_kel = isset($_POST['id_kel']) ? (int)$_POST['id_kel'] : 0;		
		$kelurahan = isset($_POST['kelurahan']) ? $_POST['kelurahan'] : '';
		$kode_pos = isset($_POST['kode_pos']) ? $_POST['kode_pos'] : '';
		$simpan = array(						
			'nama_kel'	=> $kelurahan,					
			'kode_pos'	=> $kode_pos,					
		);
		
		$where = array();
		$save = 0;	
		if($id_kel > 0){
			$where = array('id_kelurahan'=>$id_kel);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->updatetable('kelurahan', $simpan, $where);   
		}else{
			$simpan += array('created_at' => $tgl,'id_kec' => $id_kec,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('kelurahan', $simpan);   
		}  
		redirect(site_url('province/kelurahan/'.$id_kec));
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
