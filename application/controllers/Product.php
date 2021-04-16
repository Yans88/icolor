<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$where = array('deleted_at'=>null,'kategori'=>1);
		$this->data['kategori'] = 1;
		$this->data['shop_product'] = $this->access->readtable('shop_product','',$where)->result_array();
		
		$this->data['isi'] = $this->load->view('product/product_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function spare_parts() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$where = array('deleted_at'=>null,'kategori'=>2);
		$this->data['kategori'] = 2;
		$this->data['shop_product'] = $this->access->readtable('shop_product','',$where)->result_array();
		
		$this->data['isi'] = $this->load->view('product/product_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function tools() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$where = array('deleted_at'=>null,'kategori'=>3);
		$this->data['kategori'] = 3;
		$this->data['shop_product'] = $this->access->readtable('shop_product','',$where)->result_array();
		
		$this->data['isi'] = $this->load->view('product/product_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function acc() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$where = array('deleted_at'=>null,'kategori'=>4);
		$this->data['kategori'] = 4;
		$this->data['shop_product'] = $this->access->readtable('shop_product','',$where)->result_array();
		
		$this->data['isi'] = $this->load->view('product/product_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function del(){
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_product' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('shop_product', $data, $where);
	}
	
	function add_product($kategori=0){
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'Form';
		$this->data['product'] = '';
		$this->data['kategori'] = $kategori;
		$this->data['category'] = $this->access->readtable('kategori','', array('deleted_at'=>null,'tipe'=>$kategori))->result_array();
		$this->data['isi'] = $this->load->view('product/product_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function edit_product($id_product=0){
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'Form';
		$product = $this->access->readtable('shop_product','', array('deleted_at'=>null,'id_product'=>$id_product))->row();
		$this->data['category'] = $this->access->readtable('kategori','', array('deleted_at'=>null,'tipe'=>$product->kategori))->result_array();
		$this->data['product'] = $product;
		$this->data['isi'] = $this->load->view('product/product_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function save_produk(){
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;	
		$device_cat = isset($_POST['device_cat']) ? (int)$_POST['device_cat'] : 0;	
		$device_type = isset($_POST['device_type']) ? (int)$_POST['device_type'] : 0;	
		$kategori = isset($_POST['kategori']) ? (int)$_POST['kategori'] : 0;	
		$po = isset($_POST['po']) ? (int)$_POST['po'] : 0;	
		$stok = isset($_POST['stok']) ?  str_replace(',','',$_POST['stok']) : 0;	
		$harga = isset($_POST['harga']) ?  str_replace(',','',$_POST['harga']) : 0;	
		$diskon = isset($_POST['diskon']) ?  str_replace(',','',$_POST['diskon']) : 0;	
		$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
		$rincian_produk = isset($_POST['rincian_produk']) ? $_POST['rincian_produk'] : '';
		$waktu_po = isset($_POST['waktu_po']) ? $_POST['waktu_po'] : '';
		$nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
		$video = isset($_POST['video']) ? $_POST['video'] : '';
		$varian = isset($_POST['varian']) ? $_POST['varian'] : '';
		$diskon = str_replace('.','',$diskon);
		$harga = str_replace('.','',$harga);
		$stok = str_replace('.','',$stok);
		$_diskon = $diskon/100;
		$hrg_final = $harga - ($harga * $_diskon);
		$save = 0;
		$simpan = array();
		$simpan = array(
			'nama_product'	=> $nama_produk,
			'device_cat'	=> $device_cat,
			'device_type'	=> $device_type,
			'qty'			=> $stok,
			'harga'			=> $harga,
			'diskon'		=> $diskon,
			'rincian_produk'		=> $rincian_produk,
			'deskripsi'		=> $deskripsi,
			'preorder'		=> $po,
			'waktu_po'		=> $waktu_po,
			'varian'		=> $varian,
			'video'			=> $video,
			'hrg_final'		=> $hrg_final
		);
		if($id_product > 0){
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$this->access->updatetable('shop_product', $simpan, array('id_product'=>$id_product));
			$save  = $id_product;
		}else{
			$simpan += array('kategori'=>$kategori,'created_by'=>$this->session->userdata('operator_id'),'created_at'=>$tgl);
			$save = $this->access->inserttable('shop_product', $simpan);
		}		
		
		echo $save;
	}
	
	public function simpan_dt(){
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$id_product = isset($_POST['id']) ? (int)$_POST['id'] : 0;				
		$_param = isset($_POST['param']) ? $_POST['param'] : '';
		$val = isset($_POST['val']) ? str_replace(',','',$_POST['val']) : '';
		$val = str_replace('.','',$val);
		$simpan = array();
		$simpan = array(
			$_param => $val
		);
		if($_param == 'diskon'){
			$hrg_final = 0;
			$sp = $this->access->readtable('shop_product','',array('deleted_at'=>null,'id_product'=>$id_product))->row();
			$harga = $sp->harga;
			$_diskon = $val/100;
			$hrg_final = $harga - ($harga * $_diskon);
			$simpan += array(
				'hrg_final' => $hrg_final
			);
		}
		if($_param == 'harga'){
			$hrg_final = 0;
			$sp = $this->access->readtable('shop_product','',array('deleted_at'=>null,'id_product'=>$id_product))->row();
			$harga = $val;
			$_diskon = $sp->diskon/100;
			$hrg_final = $harga - ($harga * $_diskon);
			$simpan += array(
				'hrg_final' => $hrg_final
			);
		}
		$where = array('deleted_at'=>null,'id_product'=>$id_product);
		$this->access->updatetable('shop_product', $simpan, $where);
	}
	
	function get_mygbr(){
		$id_product = isset($_POST['id_product']) ? $_POST['id_product'] : '';		
		$step_gbr = $this->access->readtable('shop_product_img','',array('id_product'=>$id_product,'deleted_at'=>null))->result_array();
		$html = '';
		if(!empty($step_gbr)){
			foreach($step_gbr as $sg){
				$html .='<div class="col-sm-2 first" style="padding-left:0; padding-right:0;">
						
						<div class="thumbnail"><img height="180" width="220" src="'.base_url('uploads/products/'.$sg['gbr']).'" alt="..." class="margin"><button onclick="return del_img('.$sg['id'].');" class="btn btn-block btn-xs btn-danger" style="margin-top:3px; bottom:12px;">Delete</button>
						</div>						
					</div>';
			}
		}else{
			$html = '<h3>Data not found</h3>';
		}
		
		
		echo $html;
	}
	
	function del_img(){
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
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
		echo $this->access->updatetable('shop_product_img', $data, $where);
	}
	
	function proses_upload(){
        $config['upload_path']   = FCPATH.'/uploads/products/';
        $config['allowed_types'] = 'jpeg|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$tgl = date('Y-m-d H:i:s');
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;
		
		$dataa = array();
        if($this->upload->do_upload('userfile_step')){
        	$token=$this->input->post('token_foto');
        	$nama=$this->upload->data('file_name');			
			$dataa = array(
				'gbr'		=> $nama,
				'id_product'	=> $id_product,				
				'created_at' => $tgl,
				'created_by'=>$this->session->userdata('operator_id'),
				'token'		=> $token
			);
        	$this->access->inserttable('shop_product_img', $dataa); 
        }
		echo $id_product;
	}
	
	function remove_foto(){
		//Ambil token foto
		$del =0;
		$id_product =0;
		$token=$this->input->post('token');		
		$foto=$this->db->get_where('shop_product_img',array('token'=>$token));
		if($foto->num_rows()>0){			
			$hasil=$foto->row();
			$nama_foto=$hasil->gbr;
			$id_product=$hasil->id_product;
			if(file_exists($file=FCPATH.'/uploads/products/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('shop_product_img',array('token'=>$token));

		}
		echo $id_product;
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
