<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_part_s extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function new_order() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_part_s')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Order Part Service';
		$this->data['judul_utama'] = 'New Order';
		$this->data['judul_sub'] = 'List';
		
		$my_store = $this->session->userdata('store');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'order_sp.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}		
		$sort = array('order_sp.id_order', 'DESC');
		$where = array();
		$where = array('order_sp.status <='=>4);
		$this->data['status'] = 1;
		$selects = array('order_sp.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('order_sp',$selects,$where,array('customer' => 'customer.id_customer = order_sp.id_member'),'',$sort,'LEFT','','','', $field_in, $_id_ta)->result_array();		
		$bs_detail = $this->access->readtable('osp_detail',array('id_order','nama_sp','varian'),array('deleted_at'=>null))->result_array();	
		$sp = array();
		foreach($bs_detail as $bs){
			$nama_sp = '';
			$nama_sp = $bs['nama_sp'];
			if(!empty($bs['varian'])) $nama_sp .='('.$bs['varian'].')';
			$sp[$bs['id_order']][] = $nama_sp;
		}
		$this->data['sp'] = $sp;
		$this->data['isi'] = $this->load->view('order_parts/order_parts_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function onprocess() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_part_s')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Order Part Service';
		$this->data['judul_utama'] = 'On Progress';
		$this->data['judul_sub'] = 'List';
		
		$my_store = $this->session->userdata('store');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'order_sp.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}		
		$sort = array('order_sp.id_order', 'DESC');
		$where = array();
		$where = array('order_sp.status'=>5);
		$this->data['status'] = 5;
		$selects = array('order_sp.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('order_sp',$selects,$where,array('customer' => 'customer.id_customer = order_sp.id_member'),'',$sort,'LEFT','','','', $field_in, $_id_ta)->result_array();		
		$bs_detail = $this->access->readtable('osp_detail',array('id_order','nama_sp','varian'),array('deleted_at'=>null))->result_array();	
		$sp = array();
		foreach($bs_detail as $bs){
			$nama_sp = '';
			$nama_sp = $bs['nama_sp'];
			if(!empty($bs['varian'])) $nama_sp .='('.$bs['varian'].')';
			$sp[$bs['id_order']][] = $nama_sp;
		}
		$this->data['sp'] = $sp;
		$this->data['isi'] = $this->load->view('order_parts/order_parts_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function completed() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_part_s')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Order Part Service';
		$this->data['judul_utama'] = 'Completed';
		$this->data['judul_sub'] = 'List';
		
		$my_store = $this->session->userdata('store');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'order_sp.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}		
		$sort = array('order_sp.id_order', 'DESC');
		$where = array();
		$where = array('order_sp.status'=>6);
		$this->data['status'] = 6;
		$selects = array('order_sp.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('order_sp',$selects,$where,array('customer' => 'customer.id_customer = order_sp.id_member'),'',$sort,'LEFT','','',$sort, $field_in, $_id_ta)->result_array();		
		$bs_detail = $this->access->readtable('osp_detail',array('id_order','nama_sp','varian'),array('deleted_at'=>null))->result_array();	
		$sp = array();
		foreach($bs_detail as $bs){
			$nama_sp = '';
			$nama_sp = $bs['nama_sp'];
			if(!empty($bs['varian'])) $nama_sp .='('.$bs['varian'].')';
			$sp[$bs['id_order']][] = $nama_sp;
		}
		$this->data['sp'] = $sp;
		$this->data['isi'] = $this->load->view('order_parts/order_parts_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function set_payment(){
		$id_order = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;		//4 => approve, 3=> reject
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$confirm_bank = isset($_POST['confirm_bank']) ? $_POST['confirm_bank'] : '';
		$dt_upd = array();
		$dt_upd = array(
			'status_transfer'		=> $status,
			'status'				=> $status,
			'catatan_adm_payment'	=> $catatan,
			'status_transfer_date'	=> date('Y-m-d H:i:s'),
			'status_transfer_by'	=> $this->session->userdata('operator_id')
		);
		if(!empty($confirm_bank)) $dt_upd += array('bank_name'=>$confirm_bank);
		$this->access->updatetable('order_sp', $dt_upd, array('id_order'=>$id_order));
		
		echo $id_order;
	}
	
	function appr_reject(){
		$id_order = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;		//9 => approve, 10=> reject
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$dt_upd = array();
		$dt_upd = array(			
			'status'				=> $status,
			'catatan_adm_proses'	=> $catatan,
			'proses_date'			=> date('Y-m-d H:i:s'),
			'proses_by'				=> $this->session->userdata('operator_id')
		);
		$this->access->updatetable('order_sp', $dt_upd, array('id_order'=>$id_order));
		echo $id_order;
	}
	
	function set_completed(){
		$id_order = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;		//9 => approve, 10=> reject
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$dt_upd = array();
		$dt_upd = array(			
			'status'				=> $status,
			'catatan_adm_completed'	=> $catatan,
			'completed_date'		=> date('Y-m-d H:i:s'),
			'completed_by'			=> $this->session->userdata('operator_id')
		);
		$bs = $this->access->readtable('order_sp','',array('id_order'=>$id_order))->row();
		$this->access->updatetable('order_sp', $dt_upd, array('id_order'=>$id_order));
		$this->load->model('Setting_point_m');
		$setting_point = $this->Setting_point_m->get_key_val();
		$reward_point = str_replace('.','',$setting_point['order_part']);
		$reward_point = str_replace(',','',$reward_point);
		$reward_point = (int)$reward_point;
		$id_member = (int)$bs->id_member;
		$login = $this->access->readtable('customer','',array('id_customer'=>$id_member))->row();
		$point = (int)$login->point + $reward_point;
		$simpan_history = array();
		$upd = array();
		$upd = array('point'=>$point);
		$simpan_history = array(
				"id_member"			=> $id_member,
				"tgl"				=> date('Y-m-d H:i:s'),
				"id_tr"				=> $id_booking,
				"type"				=> 9,
				"description"		=> "Add Points Order Part Service #".$id_order,
				"nilai"				=> $reward_point
		);	
		$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
		$this->access->inserttable("point_history",$simpan_history);
		echo $id_order;
	}
	
	function bs_detail($id_booking=0){
		$this->data['judul_browser'] = 'Order Part Service';
		$this->data['judul_utama'] = 'Order Part Service';
		$this->data['judul_sub'] = 'Detail';
		$bs = '';
		$selects = array('order_sp.*','customer.nama','customer.last_name');
		$bs = $this->access->readtable('order_sp','',array('order_sp.id_order'=>$id_booking),array('customer' => 'customer.id_customer = order_sp.id_member'),'','','LEFT')->row();
		
		$pic = array();
		$dt_adm = array();
		if((int)$bs->status_transfer_by > 0) $pic[] = (int)$bs->status_transfer_by;
		if((int)$bs->proses_by > 0) $pic[] = (int)$bs->proses_by;
		if((int)$bs->pic > 0) $pic[] = (int)$bs->pic;
		$_id_ta = '';
		$_id_ta = !empty($pic) ? implode(',',$pic) : '';
		if(!empty($_id_ta)){
			$sql_member = 'SELECT * FROM admin WHERE operator_id IN ('.$_id_ta.')';
			$_dt_member = $this->db->query($sql_member)->result_array();
			if(!empty($_dt_member)){
				foreach($_dt_member as $dm){
					$dt_adm[$dm['operator_id']] = $dm['name'];
				}
			}
		}
		
		$this->data['dt_adm'] = $dt_adm;
		$this->data['bs'] = $bs;
		$this->data['isi'] = $this->load->view('order_parts/bs_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function get_mykerusakan(){
		$id_booking = isset($_POST['id_booking']) ? $_POST['id_booking'] : 0;
		$bs_detail = $this->access->readtable('osp_detail','',array('id_order'=>$id_booking,'deleted_at'=>null))->result_array();
		$booking_service = $this->access->readtable('order_sp','',array('id_order'=>$id_booking))->row();
		$ttl_dp = (int)$booking_service->dp > 0 ? number_format($booking_service->ttl_dp,0,'',',') : 0;		
		$sisa = (int)$booking_service->sisa > 0 ? number_format($booking_service->sisa,0,'',',') : 0;
		$res = '';
		$ttl_hrg_sp = 0;
		if(!empty($bs_detail)){
			$res .='<ul class="list-group list-group-unbordered">';
			$i = 1;
			foreach($bs_detail as $bd){
				$ttl_hrg_sp += $bd['harga_sp'];
				$variant = '';
				$variant = !empty($bd['varian']) ? ' - '.$bs['varian']: '';
				$res .='<li class="list-group-item">
						  <b>'.$i++.'. '.$bd['nama_sp'].''.$variant.'</b> <a class="pull-right">'.number_format($bd['harga_sp'],0,'',',').'</a>
						</li>';
				
			}
			$res .='</ul></div></div>';
			$res .='<div class="row"><div class="col-sm-4 col-sm-offset-8">			  
				<table class="table">
				  <tbody><tr>
					<th style="width:50%">Total:</th>
					<td align="right">'.number_format($ttl_hrg_sp,0,'',',').'</td>
				  </tr>
				  <tr>
					<th>DP :</th>
					<td align="right">'.$ttl_dp.'</td>
				  </tr>
				  <tr>
					<th>Sisa:</th>
					<td align="right"><strong>'.$sisa.'</strong></td>
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
