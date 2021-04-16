<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redeem extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {		
		if(!$this->session->userdata('login') || !$this->session->userdata('daftar_redeem')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Redeem';
		$this->data['judul_utama'] = 'Redeem';
		$this->data['judul_sub'] = 'List';
		$sort = array('redeem.id_redeem','DESC');
		$selects = array('redeem.*','admin.name','customer.nama','customer.phone','product_redeem.*');
		$this->data['redeem'] = $this->access->readtable('redeem',$selects,'',array('customer'=>'customer.id_customer = redeem.id_member','product_redeem'=>'product_redeem.id_product=redeem.id_product','admin'=>'admin.operator_id = redeem.status_by'), '',$sort,'LEFT')->result_array();
		
		$this->data['isi'] = $this->load->view('products_redeem/redeem_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function product(){
		if(!$this->session->userdata('login') || !$this->session->userdata('product_redeem')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Product Redeem';
		$this->data['judul_utama'] = 'Product Redeem';
		$this->data['judul_sub'] = 'List';
		$this->data['product'] = $this->access->readtable('product_redeem','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('products_redeem/product_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_product' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('product', $data, $where);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;		
		$nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
		$point = isset($_POST['point']) ? $_POST['point'] : '';
		$config['upload_path']   = FCPATH.'/uploads/products/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array(			
			'nama_barang'		=> $nama_produk,
			'point'				=> $point,	
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$where = array();
		$save = 0;		
		if($id_product > 0){
			$where = array('id_product'=>$id_product);
			$save = $this->access->updatetable('product_redeem', $simpan, $where);   
		}else{
			$simpan += array('create_at'	=> $tgl);
			$save = $this->access->inserttable('product_redeem', $simpan);   
		}  
		if($save > 0){
			redirect(site_url('redeem/product'));
		}	 
	}
	
	public function upd_status(){
		$tgl = date('Y-m-d');
		$val = isset($_POST['id']) ? $_POST['id'] : '';	
		//error_log($val);	
		$_val = explode('_',$val);
		//error_log(serialize($_val));
		$status = $_val[0];
		$id = $_val[1];
		$dt_redeem = '';
		$dt_member = '';
		$id_member = 0;
		$point = 0;		
		$upd = array();
		if($status == 3){
			$dt_redeem = $this->access->readtable('redeem','',array('id_redeem'=>$id))->row();
			$id_member = $dt_redeem->id_member;
			$dt_member = $this->access->readtable('customer','',array('id_customer'=>$id_member))->row();
			$point = $dt_member->point + $dt_redeem->point;			
			$upd = array('point'=>$point);
			$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
			$simpan_history = array();
			$simpan_history = array(
				"id_member"			=> $id_member,
				"tgl"				=> date('Y-m-d H:i:s'),
				"id_tr"				=> $id,
				"type"				=> 11,
				"description"		=> "Refund Points",
				"nilai"				=> '+'.$point
			);
			$this->access->inserttable("point_history",$simpan_history);
		}
		$simpan = array(			
			'status'		=> $status,
			'status_by'		=> $this->session->userdata('operator_id'),
			'status_date'	=> date('Y-m-d H:i:s')		
		);
		
		$where = array('id_redeem'=>$id);
		$this->access->updatetable('redeem', $simpan, $where); 
		echo $id;
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
