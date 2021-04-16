<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_sp extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }
	
    function index(){	
		$tgl = date('Y-m-d H:i:s');
		$tgl_noorder = date('ymd');
		$dt = array();
		$param = $this->input->post();
		$id_ta = array();
		$dt_insert = array();
		$sp = '';
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;		
		$id_store = isset($param['id_store']) ? (int)$param['id_store'] : 0;
		$device_cat = isset($param['device_cat']) ? (int)$param['device_cat'] : 0;
		$device_type = isset($param['device_type']) ? (int)$param['device_type'] : 0;
		$spare_parts = isset($param['spare_parts']) ? json_decode($param['spare_parts']) : '';
		$pembayaran = isset($param['pembayaran']) ? (int)$param['pembayaran'] : 0;
		$dp = isset($param['dp']) ? (int)$param['dp'] : 0;
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';			
		$ig = isset($param['ig']) ? $param['ig'] : '';
		$wa = isset($param['wa']) ? $param['wa'] : '';	
		$this->db->trans_begin();
		$store = $this->access->readtable('store','',array('id_op'=>$id_store))->row();
		$nama_store = $store->nama;
		$kategori = $this->access->readtable('kategori','',array('id_kategori'=>$device_cat))->row();
		$nama_cat = $kategori->nama_kategori;
		$type = $this->access->readtable('sub_kategori','',array('id_sub'=>$device_type))->row();
		$nama_type = $type->nama_sub;	
		$nmr_order = 0;
		$status = 1;
		$status_transfer = '';
		$nama_rek = '';
		$date_transfer = null;
		$bank_name = null;
		$member = $this->access->readtable('customer','',array('id_customer'=>$id_member,'deleted_at'=>null))->row();
		if($pembayaran == 1) {
			$status =2;
			$status_transfer =1;
			$date_transfer =$tgl;
			$bank_name = 'Kasir';
			$nama_rek = $member->nama.' '.$member->last_name;;
		}
		// if($dp == 0) $status = 2;
		$dt_simpan = array();
		$dt_simpan = array(
			'id_member'		=> $id_member,					
			'status'		=> $status,
			'id_store'		=> $id_store,
			'nama_store'	=> $nama_store,
			'alamat'		=> $alamat,			
			'ig'			=> $ig,
			'wa'			=> $wa,
			'nama_cat'		=> $nama_cat,
			'device_cat'	=> $device_cat,
			'device_type'	=> $device_type,
			'nama_type'		=> $nama_type,			
			'pembayaran'	=> $pembayaran,
			'dp'			=> $dp,		
			'status_transfer'	=> $status_transfer,
			'date_transfer'	=> $date_transfer,
			'nama_rek'	=> $nama_rek,
			'bank_name'		=> $bank_name,
			'created_at'	=> $tgl
		);
		$save = $this->access->inserttable('order_sp', $dt_simpan);	
		$varian = array();
		if($save > 0 && !empty($spare_parts)){
			for($i=0;$i<count($spare_parts);$i++){
				$id_ta[] = $spare_parts[$i]->id;
				$varian[$spare_parts[$i]->id] = !empty($spare_parts[$i]->varian) ? $spare_parts[$i]->varian : '';	
				$sp = implode(',',$id_ta);	
			}
			$sql = 'SELECT * FROM master_kerusakan WHERE id IN ('.$sp.')';
			$_dt = $this->db->query($sql)->result_array();
			$ttl_hrg_sp = 0;
			if(!empty($_dt)){
				foreach($_dt as $dt){
					$ttl_hrg_sp += $dt['harga'];
					$dt_insert[] = array(
						'id_order'	=> $save,						
						'id_sp'			=> $dt['id'],
						'nama_sp'		=> $dt['nama_sp'],
						'harga_sp'		=> $dt['harga'],
						'device_cat'	=> $dt['device_cat'],
						'device_type'	=> $dt['device_type'],
						'varian'		=> $varian[$dt['id']],
						'created_at'	=> $tgl,
					);
				}
				$this->db->insert_batch('osp_detail', $dt_insert);
			}
			$ttl_dp = 0;
			if($dp > 0)	$ttl_dp = $ttl_hrg_sp * 0.5;
			$sisa = $ttl_hrg_sp - $ttl_dp;
			$_save = $save;
			if($save < 10) $_save = '0'.$save;
			$nmr_order = $tgl_noorder.'05'.$_save;
			$dt_upd = array('ttl_order'=>$ttl_hrg_sp,'ttl_dp'=>$ttl_dp,'sisa'=>$sisa,'order_no'=>$nmr_order);
			if($pembayaran == 1) $dt_upd += array('jml_transfer'=>$sisa);
			$this->access->updatetable('order_sp', $dt_upd, array('id_order'=>$save));
			$dt_simpan += $dt_upd;
			
		}
		if($save > 0){
			$dt_simpan += array('id_order'=>$save);
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}
			
			$this->load->library('send_notif');
			$ids = array();
			$data_fcm = array();
			$notif_fcm = array();
			$dt_inserts = array();
			if(!empty($member->fcm_token) && $member->order_part > 0){
				$ids = array($member->fcm_token);
				$data_fcm = array(
					'id'			=> $save,			
					'title'			=> 'iColor',
					'type'			=> 5,
					'message'		=> "Order part ".$nmr_order
				);
				$notif_fcm = array(
					'title'		=> 'iColor',
					'body'		=> "Order part ".$nmr_order,
					'badge'		=> 1,
					'sound'		=> 'Default'
				);
				$dt_inserts[] = array(
					'id_member'		=> $id_member,
					'type'			=> 5,
					'id_data'		=> $save,
					'pesan'			=> "Order part ".$nmr_order,
					'created_at'	=> $tgl,
				);
				$notif = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);
				if(!empty($dt_inserts)) $this->db->insert_batch('history_notif', $dt_inserts);
			}		
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $member->email;
			$nama = $member->nama.' '.$member->last_name;
			$nama_type = $nama_cat.' - '.$nama_type;
			$subject = 'Order Parts';
			if($pembayaran == 1) $payment_type = 'Cash';
			if($pembayaran == 2) $payment_type = 'Manual Transfer';			
			$content_member = '';
			$content_member = $out['email_orderpart'];
			$content = str_replace('[#name#]', $nama, $content_member);	
			$content = str_replace('[#device#]', $nama_type, $content);
			$content = str_replace('[#payment_type#]', $payment_type, $content);
			$content = str_replace('[#tgl_order#]', date('d-m-Y'), $content);
			$content = str_replace('[#nohp_customer#]', $wa, $content);
			$content = str_replace('[#no_order#]', $nmr_order, $content);
			$_tbl = '';
			if(!empty($dt_insert)){
				$_tbl ='<table border="1" cellpadding="1" cellspacing="1" style="width: 450px;">
				<tbody>
				<tr>
					<td>No</td>
					<td>Spare parts</td>
					<td>Variant</td>
					<td>Harga</td>				
				</tr>';
				for($i=0;$i<count($dt_insert);$i++){
					$n = $i + 1;
					$my_varian = '';
					$my_varian = !empty($dt_insert[$i]['varian']) ? $dt_insert[$i]['varian'] : '-';
					$_tbl .='<tr>
						<td>'.$n.'</td>
						<td>'.$dt_insert[$i]['nama_sp'].'</td>
						<td>'.$my_varian.'</td>
						<td>'.number_format($dt_insert[$i]['harga_sp'],0,'',',').'</td> 
						</tr>';
				}
				$_tbl .= '</table>';
			}
			$content = str_replace('[#list_sp#]', $_tbl, $content);
			$this->send_notif->send_email($from,$pass, $to,$subject, $content);
			$this->db->trans_commit();
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'Terima kasih telah melakukan pembelian spare part di iColor',
				'data' 		=> $dt_simpan	
			);
		}else{
			$this->db->trans_rollback();
			$result = array(
				'err_code' 	=> '05',
				'err_msg' 	=> 'insert has problem',
				'data' 		=> ''	
			);
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function history_order(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$selects = array('order_sp.*','customer.nama','customer.last_name');
		$booking_service = $this->access->readtable('order_sp',$selects,array('order_sp.id_member'=>$id_member),array('customer' => 'customer.id_customer = order_sp.id_member'),'','','LEFT')->result_array();
		$dt = array();		
		if(!empty($booking_service)){
			foreach($booking_service as $bs){
				$dt[] = array(
					'id_order'	=> $bs['id_order'],
					'order_no'	=> $bs['order_no'],					
					'id_member'		=> $bs['id_member'],
					'nama_member'	=> $bs['nama'],
					'alamat'		=> $bs['alamat'],					
					'ig'			=> $bs['ig'],
					'wa'			=> $bs['wa'],					
					'status'		=> $bs['status'],
					'status_transfer'		=> $bs['status_transfer'],
					'id_store'		=> $bs['id_store'],
					'nama_store'	=> $bs['nama_store'],
					'device_cat'	=> $bs['device_cat'],
					'nama_cat'		=> $bs['nama_cat'],
					'device_type'	=> $bs['device_type'],
					'nama_type'		=> $bs['nama_type'],					
					'pembayaran'	=> $bs['pembayaran'],
					'dp'			=> $bs['dp'],
					'ttl_order'		=> $bs['ttl_order'],
					'ttl_dp'		=> $bs['ttl_dp'],
					'sisa'			=> $bs['sisa'],
					'created_at'	=> $bs['created_at'],
					
				);
			}
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
		}else{
			$result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> null
			);
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function order_detail(){
		$tgl = date('Y-m-d');
		$param = $this->input->post();
		$id_order = isset($param['id_order']) ? (int)$param['id_order'] : 0;		
		$selects = array('order_sp.*','customer.nama','customer.last_name');
		$booking_service = $this->access->readtable('order_sp',$selects,array('order_sp.id_order'=>$id_order),array('customer' => 'customer.id_customer = order_sp.id_member'),'','','LEFT')->row();
		$id_store = (int)$booking_service->id_store;
		$shop_order_detail = $this->access->readtable('osp_detail','',array('id_order'=>$id_order))->result_array();	
		$list_sp = array();		
		if(!empty($shop_order_detail)){
			foreach($shop_order_detail as $key=>$bd){
				unset($bd['updated_at']);
				unset($bd['created_at']);
				unset($bd['deleted_by']);
				unset($bd['deleted_at']);
				$list_sp[] = $bd;			
			}			
		}
		$dt = array();
		if(!empty($booking_service)){
			$dt = array(
				'id_order'		=> $booking_service->id_order,
				'order_no'		=> $booking_service->order_no,				
				'id_member'		=> $booking_service->id_member,
				'nama_member'	=> $booking_service->nama,
				'alamat'		=> $booking_service->alamat,				
				'ig'			=> $booking_service->ig,
				'wa'			=> $booking_service->wa,				
				'status'		=> $booking_service->status,
				'status_transfer'		=> $booking_service->status_transfer,
				'id_store'		=> $booking_service->id_store,
				'nama_store'	=> $booking_service->nama_store,
				'device_cat'	=> $booking_service->device_cat,
				'nama_cat'		=> $booking_service->nama_cat,
				'device_type'	=> $booking_service->device_type,
				'nama_type'		=> $booking_service->nama_type,				
				'pembayaran'	=> $booking_service->pembayaran,
				'dp'			=> $booking_service->dp,
				'ttl_order'		=> $booking_service->ttl_order,
				'ttl_dp'		=> $booking_service->ttl_dp,
				'sisa'			=> $booking_service->sisa,				
				'created_at'	=> $booking_service->created_at,
				'list_sp'		=> $list_sp
				
			);
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
		}else{
			$result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> null
			);
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	
	
	function confirm_payment(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();		
		$id_order = isset($param['id_order']) ? (int)$param['id_order'] : 0;
		$bank = isset($param['bank_name']) ? $param['bank_name'] : '';
		$sender_name = isset($param['sender_name']) ? $param['sender_name'] : '';
		$no_rek = isset($param['no_rek']) ? $param['no_rek'] : '';
		$jml_transfer = isset($param['jml_transfer']) ? $param['jml_transfer'] : '';
		$jml_transfer = str_replace('.','',$jml_transfer);
		$jml_transfer = str_replace(',','',$jml_transfer);
		$config = array();
		$config['upload_path'] = "./uploads/payment/";
		$config['allowed_types'] = "jpg|png|jpeg|";
		$config['max_size']	= '4096';		
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload',$config);
		$simpan = array();
		$simpan = array(
			'date_transfer'		=> $tgl,
			'bank_name'			=> $bank,
			'nama_rek'			=> $sender_name,
			'no_rek'			=> $no_rek,
			'jml_transfer'		=> $jml_transfer,
			'status'			=> 2,
			'status_transfer'	=> 1
		);
		if(!empty($_FILES['img'])){
			$upl = '';
			if($this->upload->do_upload('img')){
				$upl = $this->upload->data();
				$simpan += array("img_transfer" => $upl['file_name']);			
			}
		}
		$this->access->updatetable('order_sp', $simpan, array('id_order'=>$id_order,'pembayaran'=>2));
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'Terima kasih sudah melakukan pembayaran',
				'data'		=> $simpan
			];
		http_response_code(200);
		echo json_encode($result);	
	}
	
	
	function test(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_ta = array();
		$dt_insert = array();
		$sp = '';
		$spare_parts = isset($param['spare_parts']) ? $param['spare_parts'] : 0;
		for($i=0;$i<count($spare_parts);$i++){
			$id_ta[] = $spare_parts[$i];
			$sp = implode(',',$id_ta);	
		}
		$sql = 'SELECT * FROM master_kerusakan WHERE id IN ('.$sp.')';
		$_dt = $this->db->query($sql)->result_array();
		$ttl_hrg_sp = 0;
		if(!empty($_dt)){
			foreach($_dt as $dt){
				$ttl_hrg_sp += $dt['harga'];
				$dt_insert[] = array(
					'id_booking'	=> 1,
					'add_adm'		=> 0,
					'id_sp'			=> $dt['id'],
					'nama_sp'		=> $dt['nama_sp'],
					'harga_sp'		=> $dt['harga'],
					'device_cat'	=> $dt['device_cat'],
					'device_type'	=> $dt['device_type'],
					'created_at'	=> $tgl,
				);
			}
			$this->db->insert_batch('bs_detail', $dt_insert);
		}
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt_insert
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
}
