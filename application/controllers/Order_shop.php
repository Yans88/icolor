<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_shop extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function new_order() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_shop')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Shop Product';
		$this->data['judul_utama'] = 'New Order';
		$this->data['judul_sub'] = 'List';
		$sort = array('shop_order.id_order', 'DESC');
		$where = array();
		$where = array('shop_order.status <='=>6);
		$this->data['status'] = 1;
		$selects = array('shop_order.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('shop_order',$selects,$where,array('customer' => 'customer.id_customer = shop_order.id_member'),'',$sort,'LEFT')->result_array();		
		
		$this->data['isi'] = $this->load->view('shop_order/shop_order_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function onprocess() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_shop')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Shop Product';
		$this->data['judul_utama'] = 'Dikirim';
		$this->data['judul_sub'] = 'List';
		$sort = array('shop_order.id_order', 'DESC');
		$where = array();
		$where = array('shop_order.status'=>7);
		$this->data['status'] = 7;
		$selects = array('shop_order.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('shop_order',$selects,$where,array('customer' => 'customer.id_customer = shop_order.id_member'),'',$sort,'LEFT')->result_array();		
		
		$this->data['isi'] = $this->load->view('shop_order/shop_order_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function completed() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_shop')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Shop Product';
		$this->data['judul_utama'] = 'Completed';
		$this->data['judul_sub'] = 'List';
		$sort = array('shop_order.id_order', 'DESC');
		$where = array();
		$where = array('shop_order.status'=>8);
		$this->data['status'] = 8;
		$selects = array('shop_order.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('shop_order',$selects,$where,array('customer' => 'customer.id_customer = shop_order.id_member'),'',$sort,'LEFT')->result_array();		
		
		$this->data['isi'] = $this->load->view('shop_order/shop_order_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function cancel() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_shop')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Shop Product';
		$this->data['judul_utama'] = 'Cancel';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$where = array('shop_order.status'=>9);
		$this->data['status'] = 9;
		$selects = array('shop_order.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('shop_order',$selects,$where,array('customer' => 'customer.id_customer = shop_order.id_member'),'','','LEFT')->result_array();		
		
		$this->data['isi'] = $this->load->view('shop_order/shop_order_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function set_payment(){
		$id_order = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;		
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$os = $this->access->readtable('shop_order','',array('shop_order.id_order'=>$id_order))->row();
		$_status = (int)$os->status;
		$dt_upd = array();
		if($_status != 6){
			$dt_upd += array('status' => $status,);
		}
		$dt_upd += array(
			'status_transfer'		=> $status,			
			'catatan_adm_payment'	=> $catatan,
			'status_transfer_date'	=> date('Y-m-d H:i:s'),
			'status_transfer_by'	=> $this->session->userdata('operator_id')
		);
		$this->access->updatetable('shop_order', $dt_upd, array('id_order'=>$id_order));
		
		echo $id_order;
	}
	
	function set_req_cancel(){
		$id_order = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;		
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		
		if($status == 4){
			$bs = $this->access->readtable('shop_order','',array('id_order'=>$id_order))->row();
			$status = (int)$bs->proses_by > 0 ? 5 : (int)$bs->status_transfer;			
		}
		$dt_upd = array();
		$dt_upd = array(			
			'status'					=> $status,
			'req_cancel'				=> $status,
			'appr_rej_req_cancel_note'	=> $catatan,
			'appr_rej_req_cancel_date'	=> date('Y-m-d H:i:s'),
			'appr_rej_req_cancel_by'	=> $this->session->userdata('operator_id')
		);
		$this->access->updatetable('shop_order', $dt_upd, array('id_order'=>$id_order));
		echo $id_order;
	}
	
	function appr_reject(){
		$id_order = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;		
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$dt_upd = array();
		$dt_upd = array(			
			'status'				=> $status,
			'catatan_adm_proses'	=> $catatan,
			'proses_date'			=> date('Y-m-d H:i:s'),
			'proses_by'				=> $this->session->userdata('operator_id')
		);
		$this->access->updatetable('shop_order', $dt_upd, array('id_order'=>$id_order));
		echo $id_order;
	}
	
	function set_kirim(){
		$id_order = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$dt_upd = array();
		$dt_upd = array(			
			'status'				=> 7,
			'catatan_kirim'	=> $catatan,
			'tgl_kirim'			=> date('Y-m-d H:i:s'),
			'dikirim_oleh'				=> $this->session->userdata('operator_id')
		);
		$this->access->updatetable('shop_order', $dt_upd, array('id_order'=>$id_order));
		echo $id_order;
	}	
	
	function bs_detail($id_booking=0){
		$this->data['judul_browser'] = 'Shop Product';
		$this->data['judul_utama'] = 'Shop Product';
		$this->data['judul_sub'] = 'Detail';
		
		$selects = array('shop_order.*','customer.nama','customer.last_name');
		$bs = $this->access->readtable('shop_order',$selects,array('shop_order.id_order'=>$id_booking),array('customer' => 'customer.id_customer = shop_order.id_member'),'','','LEFT')->row();
		
		$this->data['bs'] = $bs;
		$selects = array('history_status.*','admin.name');
		$history = '';
		$this->data['bs_detail'] = $this->access->readtable('shop_order_detail','',array('id_order'=>$id_booking))->result_array();
		$this->data['history'] = $history;
		$this->data['isi'] = $this->load->view('shop_order/bs_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function get_mykerusakan(){
		$id_booking = isset($_POST['id_booking']) ? $_POST['id_booking'] : 0;
		$bs_detail = $this->access->readtable('shop_order_detail','',array('id_order'=>$id_booking))->result_array();
		$booking_service = $this->access->readtable('shop_order','',array('id_order'=>$id_booking))->row();
		
		$res = '';
		$ttl_hrg_sp = 0;
		if(!empty($bs_detail)){
			$res .='<ul class="list-group list-group-unbordered">';
			foreach($bs_detail as $bd){
				$ttl_hrg_sp += $bd['hrg_final'];
				$variant = '';
				$variant = !empty($bd['varian']) ? ' - '.$bd['varian']: '';
				$res .='<li class="list-group-item">
						  <b>'.number_format($bd['jml'],0,'',',').' pcs '.$bd['nama_product'].''.$variant.'</b><a class="pull-right">'.number_format($bd['hrg_final'],0,'',',').'</a>
						</li>';
				
			}
			$res .='</ul></div></div>';
			$res .='<div class="row"><div class="col-sm-4 col-sm-offset-8">			  
				<table class="table">
				  <tbody><tr>
					<th style="width:50%">Total:</th>
					<td align="right">'.number_format($ttl_hrg_sp,0,'',',').'</td>
				  </tr>
				 
				 
				  
				</tbody></table>
			 
			</div></div>';
		}else{
			$res ='<ul class="list-group list-group-unbordered"><li class="list-group-item" style="color:#dd4b39 !important">
						  <b>Data not found</b>
						</li></ul>';
		}
		echo $res;
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
