<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking_service extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function home_service() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('home_service')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Booking Service';
		$this->data['judul_utama'] = 'Home Service';
		$this->data['judul_sub'] = 'List';
		
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'booking_service.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}		
		$sort = array('booking_service.id_booking', 'DESC');
		$where = array();
		$where = array('booking_service.layanan'=>1);
		$this->data['layanan'] = 1;		
		$selects = array('booking_service.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('booking_service',$selects,$where,array('customer' => 'customer.id_customer = booking_service.id_member'),'',$sort,'LEFT','','','',$field_in, $_id_ta)->result_array();	
		$bs_detail = $this->access->readtable('bs_detail',array('id_booking','nama_sp','varian'),array('deleted_at'=>null))->result_array();	
		$sp = array();
		foreach($bs_detail as $bs){
			$nama_sp = '';
			$nama_sp = $bs['nama_sp'];
			if(!empty($bs['varian'])) $nama_sp .='('.$bs['varian'].')';
			$sp[$bs['id_booking']][] = $nama_sp;
		}
		$this->data['sp'] = $sp;
		$this->data['isi'] = $this->load->view('booking_service/hs_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function pickup_device() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('pickup_service')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Booking Service';
		$this->data['judul_utama'] = 'Pickup Device';
		$this->data['judul_sub'] = 'List';
		
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'booking_service.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}
		$sort = array('booking_service.id_booking', 'DESC');
		$where = array();
		$where = array('booking_service.layanan'=>2);
		$this->data['layanan'] = 2;
		$selects = array('booking_service.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('booking_service',$selects,$where,array('customer' => 'customer.id_customer = booking_service.id_member'),'',$sort,'LEFT','','','', $field_in, $_id_ta)->result_array();	
		$this->data['teknisi'] = $this->access->readtable('kurir','',array('deleted_at'=>null))->result_array();
		$bs_detail = $this->access->readtable('bs_detail',array('id_booking','nama_sp','varian'),array('deleted_at'=>null))->result_array();	
		$sp = array();
		foreach($bs_detail as $bs){
			$nama_sp = '';
			$nama_sp = $bs['nama_sp'];
			if(!empty($bs['varian'])) $nama_sp .='('.$bs['varian'].')';
			$sp[$bs['id_booking']][] = $nama_sp;
		}
		$this->data['sp'] = $sp;
		$this->data['isi'] = $this->load->view('booking_service/pd_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function kirim_ketoko() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('kirim_device')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Booking Service';
		$this->data['judul_utama'] = 'Kirim Device ke Toko';
		$this->data['judul_sub'] = 'List';
		
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'booking_service.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}
		$sort = array('booking_service.id_booking', 'DESC');
		$where = array();
		$where = array('booking_service.layanan'=>3);
		$this->data['layanan'] = 3;		
		$selects = array('booking_service.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('booking_service',$selects,$where,array('customer' => 'customer.id_customer = booking_service.id_member'),'',$sort,'LEFT','','','', $field_in, $_id_ta)->result_array();
		$this->data['teknisi'] = $this->access->readtable('kurir','',array('deleted_at'=>null))->result_array();
		$bs_detail = $this->access->readtable('bs_detail',array('id_booking','nama_sp','varian'),array('deleted_at'=>null))->result_array();	
		$sp = array();
		foreach($bs_detail as $bs){
			$nama_sp = '';
			$nama_sp = $bs['nama_sp'];
			if(!empty($bs['varian'])) $nama_sp .='('.$bs['varian'].')';
			$sp[$bs['id_booking']][] = $nama_sp;
		}
		$this->data['sp'] = $sp;
		$this->data['isi'] = $this->load->view('booking_service/stt_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function instore() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('instore')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d');
		$this->data['judul_browser'] = 'Booking Service';
		$this->data['judul_utama'] = 'In Store';
		$this->data['judul_sub'] = 'List';
		
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'booking_service.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}
		$_sort = array('booking_service.id_booking', 'DESC');
		$where = array();
		$where = array('booking_service.layanan'=>4);
		$this->data['layanan'] = 4;
		$id_store = 1;
		$sort = array('ABS(id_booking)','ASC');
		$this->data['antrian'] = $this->access->readtable('booking_service','',array('id_store'=>$id_store,'layanan'=>4,'date_format(tgl_service, "%Y-%m-%d") ='=>$tgl,'ABS(status_antrian)'=>0),'','',$sort)->row();
		$selects = array('booking_service.*','customer.nama','customer.last_name');
		$this->data['booking_service'] = $this->access->readtable('booking_service',$selects,$where,array('customer' => 'customer.id_customer = booking_service.id_member'),'',$_sort,'LEFT','','','', $field_in, $_id_ta)->result_array();	
		// error_log($this->db->last_query());
		//$this->data['teknisi'] = $this->access->readtable('kurir','',array('deleted_at'=>null))->result_array();
		$bs_detail = $this->access->readtable('bs_detail',array('id_booking','nama_sp','varian'),array('deleted_at'=>null))->result_array();	
		$sp = array();
		foreach($bs_detail as $bs){
			$nama_sp = '';
			$nama_sp = $bs['nama_sp'];
			if(!empty($bs['varian'])) $nama_sp .='('.$bs['varian'].')';
			$sp[$bs['id_booking']][] = $nama_sp;
		}
		$this->data['sp'] = $sp;
		$this->data['isi'] = $this->load->view('booking_service/instore_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function get_antrian(){
		if(!$this->session->userdata('login') || !$this->session->userdata('instore')){
			$this->no_akses();
			return false;
		}
		$this->db->trans_begin();
		$tgl = date('Y-m-d');
		$id_store = 1;
		$sort = array('ABS(id_booking)','ASC');
		$selects = array('MIN(nmr_antrian) as nmr_antrian','id_booking');
		$antrian = $this->access->readtable('booking_service','',array('id_store'=>$id_store,'layanan'=>4,'date_format(tgl_service, "%Y-%m-%d") ='=>$tgl,'ABS(status_antrian)'=>0),'','',$sort)->row();
		$antrian_next = (int)$antrian->nmr_antrian ? (int)$antrian->nmr_antrian : 0;
		$id_booking_next = (int)$antrian->id_booking ? (int)$antrian->id_booking : 0;
		if($id_booking_next > 0){
			$this->access->updatetable('booking_service', array('status_antrian'=>1,'cs_by'=>1), array('id_booking'=>$id_booking_next,'ABS(status_antrian)'=>0));
		}		
		$this->db->trans_commit();
		echo $antrian_next;
	}
	
	function set_teknisi(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;
		$teknisi = isset($_POST['teknisi']) ? (int)$_POST['teknisi'] : 0;
		$tgl = isset($_POST['tgl']) ? date('Y-m-d', strtotime($_POST['tgl'])) : null;
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$dt_teknisi = $this->access->readtable('teknisi','',array('teknisi.id'=>$teknisi))->row();
		$nama_tk = $dt_teknisi->nama;
		$phone_tk = $dt_teknisi->phone;
		$email_tk = $dt_teknisi->email;
		$this->access->updatetable('booking_service', array('catatan_tk'=>$catatan,'status'=>2,'id_tk'=>$teknisi,'nama_tk'=>$nama_tk,'jadwal_tk'=>$tgl,'phone_tk'=>$phone_tk,'email_tk'=>$email_tk), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> 2,
			'catatan'		=> $catatan,
			'ket'			=> 'on schedule',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function set_kurir(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;
		$teknisi = isset($_POST['teknisi']) ? (int)$_POST['teknisi'] : 0;
		$tgl = isset($_POST['tgl']) ? date('Y-m-d', strtotime($_POST['tgl'])) : null;
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$dt_teknisi = $this->access->readtable('kurir','',array('kurir.id'=>$teknisi))->row();
		$nama_tk = $dt_teknisi->nama;
		$phone_tk = $dt_teknisi->phone;
		$email_tk = $dt_teknisi->email;
		$this->access->updatetable('booking_service', array('catatan_tk'=>$catatan,'status'=>2,'id_tk'=>$teknisi,'nama_tk'=>$nama_tk,'jadwal_tk'=>$tgl,'phone_tk'=>$phone_tk,'email_tk'=>$email_tk), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> 2,
			'catatan'		=> $catatan,
			'ket'			=> 'on schedule',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function set_terima(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;		
		$this->access->updatetable('booking_service', array('status'=>3,'tgl_diterima'=>date('Y-m-d H:i:s')), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> 3,
			'catatan'		=> $catatan,
			'ket'			=> 'diterima',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function set_waiting_diagnostic(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$status = 4;
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$this->access->updatetable('booking_service', array('status'=>$status), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> $status,
			'catatan'		=> $catatan,
			'ket'			=> 'waiting diagnostic',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function set_diagnostic(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;
		$status = 5;
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$this->access->updatetable('booking_service', array('status'=>$status), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> $status,
			'catatan'		=> $catatan,
			'ket'			=> 'diagnostic',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function need_approval(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;
		$status = 6;
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$this->access->updatetable('booking_service', array('status'=>$status), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> $status,
			'catatan'		=> $catatan,
			'ket'			=> 'need approval customer',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function set_onprogress(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;
		$status = 7;
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$this->access->updatetable('booking_service', array('status'=>$status), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> $status,
			'catatan'		=> $catatan,
			'ket'			=> 'On Progress',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function set_pickup_by_cust(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;
		$status = 8;
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$this->access->updatetable('booking_service', array('status'=>$status,'tgl_diterima'=>null), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> $status,
			'catatan'		=> $catatan,
			'ket'			=> 'waiting pickup by customer',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		
		echo $id_booking;
	}
	
	function set_complete(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;
		$status = 9;
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$this->access->updatetable('booking_service', array('status'=>$status,'tgl_diterima'=>null), array('id_booking'=>$id_booking));
		$bs = $this->access->readtable('booking_service','',array('id_booking'=>$id_booking))->row();
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> $status,
			'catatan'		=> $catatan,
			'ket'			=> 'complete-approve',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->load->model('Setting_point_m');
		$setting_point = $this->Setting_point_m->get_key_val();
		$reward_point = str_replace('.','',$setting_point['order_bs']);
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
				"type"				=> 7,
				"description"		=> "Add Points Booking Service #".$id_booking,
				"nilai"				=> $reward_point
		);	
		$this->access->inserttable('history_status', $dt_history);	
		
		$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
		
		$this->access->inserttable("point_history",$simpan_history);
		
		echo $id_booking;
	}
	
	function set_cancel(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;
		$status = 10;
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$this->access->updatetable('booking_service', array('status'=>$status,'tgl_diterima'=>null), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> $status,
			'catatan'		=> $catatan,
			'ket'			=> 'complete-cancel',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function set_payment(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;		//2 => approve, 3=> reject
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$this->access->updatetable('booking_service', array('status_transfer'=>$status,'catatan_adm_payment'=>$catatan), array('id_booking'=>$id_booking));
		$_status = $status == 2 ? 11 : 12;
		$ket = $status == 2 ? 'payment approve' : 'payment reject';
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> $_status,
			'catatan'		=> $catatan,
			'ket'			=> $ket,
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function set_diterima_cust(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;		
		$this->access->updatetable('booking_service', array('status'=>13,'tgl_diterima'=>date('Y-m-d H:i:s')), array('id_booking'=>$id_booking));
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> 13,
			'catatan'		=> $catatan,
			'ket'			=> 'diterima customer',
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		echo $id_booking;
	}
	
	function appr_reject(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;		//9 => approve, 10=> reject
		$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : null;
		$dt_upd = array('status' => $status);
		if($status == 8){
			$booking_service = $this->access->readtable('booking_service','',array('booking_service.id_booking'=>$id_booking))->row();
			$biaya_layanan = !empty($booking_service->biaya_layanan) ? $booking_service->biaya_layanan : 0;
			$dt_upd += array('hrg_final' => $biaya_layanan);
		}
		$this->access->updatetable('booking_service', $dt_upd, array('id_booking'=>$id_booking));
		if($status == 9) $ket = 'complete-approve';
		if($status == 8) $ket = 'complete-reject';
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> $status,
			'catatan'		=> $catatan,
			'ket'			=> $ket,
			'created_at'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->session->userdata('operator_id'),
		);
		$this->access->inserttable('history_status', $dt_history);
		error_log($this->db->last_query());	
		echo $id_booking;
	}
	
	function add_instore(){
		$this->data['judul_browser'] = 'Booking Service';
		$this->data['judul_utama'] = 'Instore';
		$this->data['judul_sub'] = 'Form';
		//$where = array('customer.deleted_at'=>null);
		//$this->data['member'] = $this->access->readtable('customer','',$where)->result_array();
		$this->data['category'] = $this->access->readtable('kategori','', array('deleted_at'=>null,'tipe'=>1))->result_array();
		$this->data['isi'] = $this->load->view('booking_service/instore_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function simpan_instore(){
		$tgl = date('Y-m-d H:i:s');
		$_tgl = date('Y-m-d');
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$layanan = 4;
		$id_store = 1;
		$device_cat = isset($param['device_cat']) ? (int)$param['device_cat'] : 0;
		$device_type = isset($param['device_type']) ? (int)$param['device_type'] : 0;
		$spare_parts = isset($param['spare_parts']) ? $param['spare_parts'] : 0;
		$pembayaran = isset($param['pembayaran']) ? (int)$param['pembayaran'] : 0;
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';		
		$tgl_service = isset($param['tgl_service']) ? date('Y-m-d', strtotime($param['tgl_service'])) : '';
		$ig = isset($param['ig']) ? $param['ig'] : '';
		$wa = isset($param['wa']) ? $param['wa'] : '';
		$serial_number = isset($param['serial_number']) ? $param['serial_number'] : '';
		$kerusakan = isset($param['kerusakan']) ? $param['kerusakan'] : '';
		$catatan = isset($param['catatan']) ? $param['catatan'] : '';
		$passcode = isset($param['passcode']) ? $param['passcode'] : '';
		$imei = isset($param['imei']) ? $param['imei'] : '';
		
		$store = $this->access->readtable('store','',array('id_op'=>$id_store))->row();
		$nama_store = $store->nama;
		$kategori = $this->access->readtable('kategori','',array('id_kategori'=>$device_cat))->row();
		$nama_cat = $kategori->nama_kategori;
		$type = $this->access->readtable('sub_kategori','',array('id_sub'=>$device_type))->row();
		$nama_type = $type->nama_sub;
		$biaya_layanan = 0;
		$sort = array('ABS(id_booking)','DESC');
		$selects = array('MAX(nmr_antrian) as nmr_antrian');
		$get_antrian = $this->access->readtable('booking_service',$selects,array('id_store'=>$id_store,'layanan'=>4,'date_format(tgl_service, "%Y-%m-%d") ='=>$tgl_service),'','',$sort)->row();
		$nmr_antrian = (int)$get_antrian->nmr_antrian + 1;
		$dt_simpan = array();
		$dt_simpan = array(
			'id_member'		=> $id_member,
			'nmr_booking'	=> $nmr_booking,
			'nmr_antrian'	=> $nmr_antrian,
			'layanan'		=> $layanan,
			'biaya_layanan'	=> $biaya_layanan,
			'status'		=> 3,
			'id_store'		=> $id_store,
			'nama_store'	=> $nama_store,
			'alamat'		=> $alamat,
			'tgl_service'	=> $tgl_service,
			'ig'			=> $ig,
			'wa'			=> $wa,
			'nama_cat'		=> $nama_cat,
			'device_cat'	=> $device_cat,
			'device_type'	=> $device_type,
			'nama_type'		=> $nama_type,
			'serial_number'	=> $serial_number,
			'passcode'		=> $passcode,
			'imei'			=> $imei,
			'kerusakan'		=> $kerusakan,
			'catatan'		=> $catatan,
			'pembayaran'	=> $pembayaran,
			'harga_sp'		=> 0,
			'hrg_final'		=> $biaya_layanan,			
			'created_at'	=> $tgl
		);
		if($tgl_service == $_tgl){
			$dt_simpan += array(
				'status_antrian' => 1,
				'cs_by'			 => $this->session->userdata('operator_id'),
			);
		}
		$save = 0;
		$save = $this->access->inserttable('booking_service', $dt_simpan);
		$tgl_noorder = '';
		$nmr_order = '';
		if($save > 0){			
			$tgl_noorder = date('ymd');
			$nmr_order = $tgl_noorder.'01'.$save;
			$this->access->updatetable('booking_service', array('nmr_booking'=>$nmr_order), array('id_booking'=>$save));
			//$dt_simpan += array('id_booking'=>$save);
			$dt_history = array();
			$dt_history = array(
				'id_bs'			=> $save,
				'status'		=> 3,
				'catatan'		=> null,
				'ket'			=> 'booking from admin',
				'created_at'	=> $tgl,
				'status_by'		=> $this->session->userdata('operator_id'),
			);
			$this->access->inserttable('history_status', $dt_history);			
		}
		echo $save;
	}
	
	function bs_detail($id_booking=0){
		if(!$this->session->userdata('login') || !$this->session->userdata('home_service') || !$this->session->userdata('pickup_service') || !$this->session->userdata('kirim_device') || !$this->session->userdata('instore')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Booking Service';
		$this->data['judul_utama'] = 'Booking Service';
		$this->data['judul_sub'] = 'Detail';
		$sort = array('history_status.created_at', 'DESC');
		$selects = array('booking_service.*','customer.nama','customer.last_name');
		$this->data['bs'] = $this->access->readtable('booking_service','',array('booking_service.id_booking'=>$id_booking),array('customer' => 'customer.id_customer = booking_service.id_member'),'','','LEFT')->row();
		$selects = array('history_status.*','admin.name');
		$history = $this->access->readtable('history_status',$selects,array('id_bs'=>$id_booking),array('admin' => 'admin.operator_id = history_status.status_by'),'',$sort,'LEFT')->result_array();
		
		$this->data['history'] = $history;
		$this->data['isi'] = $this->load->view('booking_service/bs_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function get_kerusakan(){
		$id_booking = isset($_POST['id_booking']) ? (int)$_POST['id_booking'] : 0;		
		$mytools = $this->access->readtable('bs_detail','',array('id_booking'=>$id_booking,'deleted_at'=>null))->result_array();
		$booking_service = $this->access->readtable('booking_service','',array('booking_service.id_booking'=>$id_booking))->row();
		$device_type = $booking_service->device_type;
		$_mt = array();
		if(!empty($mytools)){			
			foreach($mytools as $mt) {		
				array_push($_mt, $mt['id_sp']);
			}
		}
		
		$spare_parts = $this->access->readtable('master_kerusakan','',array('deleted_at'=>null,'device_type'=>$device_type))->result_array();
		$html = '';
		if(!empty($spare_parts)){
			$html .='<option value="">- Pilih Spare Part-</option>';
			foreach($spare_parts as $t){
				if(!in_array($t['id'], $_mt)) $html .='<option value="'.$t['id'].'">'.$t['nama_sp'].'</option>';
			}
		}
		if(empty($html)) $html .='<option value="">Data not found</option>';
		echo $html;
	}
	
	function get_variant(){
		$id_sp = isset($_POST['id_sp']) ? (int)$_POST['id_sp'] : 0;
			
		$spare_parts = $this->access->readtable('master_kerusakan','',array('deleted_at'=>null,'id'=>$id_sp))->row();
		$varian = $spare_parts->varian;		
		$html = '';
		if(!empty($varian)){
			$_v = explode(',',$varian);
			$html .='<option value="">- Pilih Variant -</option>';
			for($i=0;$i<count($_v);$i++){
				$html .='<option value="'.$_v[$i].'">'.$_v[$i].'</option>';
			}
		}
		// if(empty($html)) $html .='<option value="-">Data not found</option>';
		echo $html;
	}
	
	function simpan_sp(){
		$tgl = date('Y-m-d H:i:s');
		$id_booking = isset($_POST['id_booking']) ? $_POST['id_booking'] : 0;
		$spare_parts = isset($_POST['dt_tools']) ? $_POST['dt_tools'] : 0;
		$variant = isset($_POST['variant']) ? $_POST['variant'] : '-';
		$variant = $variant == '-' ? ''  : $variant;
		$dt_save = array();
		$id_ta = array();
		$booking_service = $this->access->readtable('booking_service','',array('booking_service.id_booking'=>$id_booking))->row();
		$biaya_layanan = (int)$booking_service->biaya_layanan > 0 ? $booking_service->biaya_layanan : 0;
		$_dt = array();
		$sql = 'SELECT * FROM master_kerusakan WHERE id ='.$spare_parts;			
		$_dt = $this->db->query($sql)->result_array();
		$ttl_hrg_sp = 0;
		if(!empty($_dt)){
			foreach($_dt as $dt){					
				$dt_insert[] = array(
					'id_booking'	=> $id_booking,
					'add_adm'		=> $this->session->userdata('operator_id'),
					'id_sp'			=> $dt['id'],
					'nama_sp'		=> $dt['nama_sp'],
					'varian'		=> $variant,
					'harga_sp'		=> $dt['harga'],
					'device_cat'	=> $dt['device_cat'],
					'device_type'	=> $dt['device_type'],
					'created_at'	=> $tgl,
				);
			}
			$this->db->insert_batch('bs_detail', $dt_insert);
			$_sql = 'select sum(harga_sp) as ttl_hrg_sp from bs_detail where id_booking='.$id_booking.' and deleted_at is null';
			$_dt_booking = $this->db->query($_sql)->row();
			$ttl_hrg_sp = $_dt_booking->ttl_hrg_sp;
			$hrg_final = $ttl_hrg_sp + $biaya_layanan;
			$this->access->updatetable('booking_service', array('harga_sp'=>$ttl_hrg_sp,'hrg_final'=>$hrg_final), array('id_booking'=>$id_booking));				
		}
		echo $id_booking;
	}
	
	function get_mykerusakan(){
		$id_booking = isset($_POST['id_booking']) ? $_POST['id_booking'] : 0;
		$bs_detail = $this->access->readtable('bs_detail','',array('id_booking'=>$id_booking,'deleted_at'=>null))->result_array();
		$booking_service = $this->access->readtable('booking_service','',array('booking_service.id_booking'=>$id_booking))->row();
		$biaya_layanan = (int)$booking_service->biaya_layanan > 0 ? $booking_service->biaya_layanan : 0;
		$hrg_final = (int)$booking_service->hrg_final > 0 ? $booking_service->hrg_final : 0;
		$layanan = (int)$booking_service->layanan > 0 ? $booking_service->layanan : 0;
		$res = '';
		$ttl_hrg_sp = 0;
		if(!empty($bs_detail)){
			$res .='<ul class="list-group list-group-unbordered">';
			foreach($bs_detail as $bd){
				$ttl_hrg_sp += $bd['harga_sp'];
				$variant = '';
				$variant = !empty($bd['varian']) ? ' - '.$bd['varian']: '';
				if($layanan == 1){
					$res .='<li class="list-group-item">
						  <b>'.$bd['nama_sp'].''.$variant.'</b> <a class="pull-right">'.number_format($bd['harga_sp'],0,'',',').'</a>
						</li>';
				}else{
					$res .='<li class="list-group-item">
						  <b>'.$bd['nama_sp'].''.$variant.'</b> <button style="margin-left:10px;" title="Delete" onclick="return del_sp('.$bd['id'].');" class="btn btn-xs btn-danger del_news pull-right"><i class="fa fa-trash-o"></i></button><a class="pull-right">'.number_format($bd['harga_sp'],0,'',',').'</a>
						</li>';
				}
				
			}
			$res .='</ul></div></div>';
			$res .='<div class="row"><div class="col-sm-4 col-sm-offset-8">
			 

			  
				<table class="table">
				  <tbody><tr>
					<th style="width:50%">Subtotal:</th>
					<td align="right">'.number_format($ttl_hrg_sp,0,'',',').'</td>
				  </tr>
				  <tr>
					<th>Biaya Layanan :</th>
					<td align="right">'.number_format($biaya_layanan,0,'',',').'</td>
				  </tr>
				  <tr>
					<th>Total:</th>
					<td align="right"><strong>'.number_format($hrg_final,0,'',',').'</strong></td>
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
	
	function del_sp(){
		$tgl = date('Y-m-d H:i:s');
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$_bs_detail = $this->access->readtable('bs_detail','',array('id'=>$id,'deleted_at'=>null))->row();
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_by'	=> $this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		$this->access->updatetable('bs_detail', $data, $where);
		$id_booking = (int)$_bs_detail->id_booking;
		$bs_detail = $this->access->readtable('bs_detail','',array('id_booking'=>$id_booking,'deleted_at'=>null))->result_array();
		$booking_service = $this->access->readtable('booking_service','',array('booking_service.id_booking'=>$id_booking))->row();
		$biaya_layanan = (int)$booking_service->biaya_layanan > 0 ? $booking_service->biaya_layanan : 0;
		$_sql = 'select sum(harga_sp) as ttl_hrg_sp from bs_detail where id_booking='.$id_booking.' and deleted_at is null';
		$_dt_booking = $this->db->query($_sql)->row();
		$ttl_hrg_sp = $_dt_booking->ttl_hrg_sp;
		$hrg_final = $ttl_hrg_sp + $biaya_layanan;
		$this->access->updatetable('booking_service', array('harga_sp'=>$ttl_hrg_sp,'hrg_final'=>$hrg_final), array('id_booking'=>$id_booking));	
		echo $id;
	}
	
	function get_teknisi(){
		$id_store = isset($_POST['id']) ? (int)$_POST['id'] : 0;
		$where = array('deleted_at'=>null,'id_store'=>$id_store);		
		$type = $this->access->readtable('teknisi','',$where)->result_array();	
		$html = '';
		if(!empty($type)){
			foreach($type as $t){
				$html .='<option value="'.$t['id'].'">'.$t['nama'].'</option>';
			}
		}else{
			$html .='<option value="">Data not found</option>';
		}
		echo $html;
	}
	
	function get_kurir(){
		$id_store = isset($_POST['id']) ? (int)$_POST['id'] : 0;
		$where = array('deleted_at'=>null,'id_store'=>$id_store);		
		$type = $this->access->readtable('kurir','',$where)->result_array();	
		error_log($this->db->last_query());
		$html = '';
		if(!empty($type)){
			foreach($type as $t){
				$html .='<option value="'.$t['id'].'">'.$t['nama'].'</option>';
			}
		}else{
			$html .='<option value="">Data not found</option>';
		}
		echo $html;
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
