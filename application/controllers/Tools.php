<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('tools')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Tools';
		$this->data['judul_utama'] = 'Tools';
		$this->data['judul_sub'] = 'List';
		$this->data['tipe'] = 1;
		$this->data['tools'] = $this->access->readtable('tools','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('tools_sp/tools_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
		
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_tools' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('tools', $data, $where);
	}
	
	
	public function simpan_cat(){
		$tgl = date('Y-m-d H:i:s');
		$id_tools = isset($_POST['id_tools']) ? (int)$_POST['id_tools'] : 0;
		$tools = isset($_POST['tools']) ? $_POST['tools'] : '';
		$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
		$harga = isset($_POST['harga']) ? str_replace('.','',$_POST['harga']) : 0;
		$harga = str_replace(',','',$harga);
		$config['upload_path']   = FCPATH.'/uploads/tools/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array();
		$simpan = array(
				'nama'		=>	$tools,
				'harga'		=>	$harga,
				'deskripsi'	=>	$deskripsi
			);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$where = array();
		$save = 0;	
		if($id_tools > 0){
			$where = array('id_tools'=>$id_tools);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->updatetable('tools', $simpan, $where);   
		}else{
			$simpan += array('created_at' => $tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('tools', $simpan);   
		} 
		redirect(site_url('tools'));
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
