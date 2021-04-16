<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_service extends CI_Controller {

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
		$kode_layanan = array(
			1	=> '02',
			2	=> '03',
			3	=> '04',
			4	=> '01'
		);
		$nama_layanan = array(
			1	=> 'Home Service',
			2	=> 'Pickup Device',
			3	=> 'Kirim Device ke Toko',
			4	=> 'Instore'
		);
		$dt = array();
		$param = $this->input->post();
		$id_ta = array();
		$dt_insert = array();
		$sp = '';
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$layanan = isset($param['jenis_layanan']) ? (int)$param['jenis_layanan'] : 0;
		$id_store = isset($param['id_store']) ? (int)$param['id_store'] : 0;
		$id_area = isset($param['id_area']) ? (int)$param['id_area'] : 0;
		$device_cat = isset($param['device_cat']) ? (int)$param['device_cat'] : 0;
		$device_type = isset($param['device_type']) ? (int)$param['device_type'] : 0;
		$spare_parts = isset($param['spare_parts']) ? json_decode($param['spare_parts']) : '';
		$pembayaran = isset($param['pembayaran']) ? (int)$param['pembayaran'] : 0;
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';		
		$passcode = isset($param['passcode']) ? $param['passcode'] : '';		
		$imei = isset($param['imei']) ? $param['imei'] : '';		
		$tgl_service = isset($param['tgl_service']) ? date('Y-m-d', strtotime($param['tgl_service'])) : '';
		$ig = isset($param['ig']) ? $param['ig'] : '';
		$wa = isset($param['wa']) ? $param['wa'] : '';
		$serial_number = isset($param['serial_number']) ? $param['serial_number'] : '';
		$kerusakan = isset($param['kerusakan']) ? $param['kerusakan'] : '';
		$catatan = isset($param['catatan']) ? $param['catatan'] : '';
		
		$area_layanan = $this->access->readtable('area_layanan','',array('id_area'=>$id_area))->row();
		$store = $this->access->readtable('store','',array('id_op'=>$id_store))->row();
		$nama_area = !empty($area_layanan->nama_area) ? $area_layanan->nama_area : '';
		$nama_store = $store->nama;
		$kategori = $this->access->readtable('kategori','',array('id_kategori'=>$device_cat))->row();
		$nama_cat = $kategori->nama_kategori;
		$type = $this->access->readtable('sub_kategori','',array('id_sub'=>$device_type))->row();
		$nama_type = $type->nama_sub;
		$this->db->trans_begin();
		$biaya_layanan = 0;
		$opsi_val_arr = $this->sm->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}
		if($layanan == 1) $biaya_layanan = str_replace('.','',$out['biaya_home_service']);			
		if($layanan == 2) $biaya_layanan = str_replace('.','',$out['biaya_pickup_device']);
		$biaya_layanan = str_replace(',','',$biaya_layanan);
		$nmr_order = 0;
		$nmr_antrian = 0;
		$status = 1;
		$status_name = 'booking';
		if($layanan == 4){
			$status = 3;
			$status_name = 'diterima';
			$sort = array('ABS(id_booking)','DESC');
			$selects = array('MAX(nmr_antrian) as nmr_antrian');
			$get_antrian = $this->access->readtable('booking_service',$selects,array('id_store'=>$id_store,'layanan'=>4,'date_format(tgl_service, "%Y-%m-%d") ='=>$tgl_service),'','',$sort)->row();
			$nmr_antrian = (int)$get_antrian->nmr_antrian + 1;
		}
		
		$dt_simpan = array();
		$dt_simpan = array(
			'id_member'		=> $id_member,			
			'nmr_antrian'	=> $nmr_antrian,
			'layanan'		=> $layanan,
			'biaya_layanan'	=> $biaya_layanan,
			'status'		=> $status,
			'id_area'		=> $id_area,
			'id_store'		=> $id_store,
			'nama_area'		=> $nama_area,
			'nama_store'	=> $nama_store,
			'alamat'		=> $alamat,
			'tgl_service'	=> $tgl_service,
			'ig'			=> $ig,
			'wa'			=> $wa,
			'imei'			=> $imei,
			'nama_cat'		=> $nama_cat,
			'device_cat'	=> $device_cat,
			'device_type'	=> $device_type,
			'nama_type'		=> $nama_type,
			'serial_number'	=> $serial_number,
			'passcode'		=> $passcode,
			'kerusakan'		=> $kerusakan,
			'catatan'		=> $catatan,
			'pembayaran'	=> $pembayaran,
			'harga_sp'		=> 0,
			'hrg_final'		=> $biaya_layanan,
			'created_at'	=> $tgl
		);
		$save = $this->access->inserttable('booking_service', $dt_simpan);	
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
						'id_booking'	=> $save,
						'add_adm'		=> 0,
						'id_sp'			=> $dt['id'],
						'nama_sp'		=> $dt['nama_sp'],
						'harga_sp'		=> $dt['harga'],
						'device_cat'	=> $dt['device_cat'],
						'device_type'	=> $dt['device_type'],
						'varian'		=> $varian[$dt['id']],
						'created_at'	=> $tgl,
					);
				}
				$this->db->insert_batch('bs_detail', $dt_insert);
			}
			$hrg_final = $ttl_hrg_sp + $biaya_layanan;
			$_save = $save;
			if($save < 10) $_save = '0'.$save;
			$nmr_order = $tgl_noorder.''.$kode_layanan[$layanan].''.$_save;
			$this->access->updatetable('booking_service', array('harga_sp'=>$ttl_hrg_sp,'hrg_final'=>$hrg_final,'nmr_booking'=>$nmr_order,), array('id_booking'=>$save));
			$dt_simpan += array('harga_sp'=>$ttl_hrg_sp);
			
		}
		if($save > 0){
			$dt_simpan += array('id_booking'=>$save);
			$dt_history = array();
			$dt_history = array(
				'id_bs'			=> $save,
				'status'		=> $status,
				'catatan'		=> null,
				'ket'			=> $status_name,
				'created_at'	=> $tgl,
			);
			$this->access->inserttable('history_status', $dt_history);
			$member = $this->access->readtable('customer','',array('id_customer'=>$id_member,'deleted_at'=>null))->row();
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
					'type'			=> 6,
					'message'		=> "Order book service ".$nmr_order." - ".$nama_layanan[$layanan]
				);
				$notif_fcm = array(
					'title'		=> 'iColor',
					'body'		=> "Order book service ".$nmr_order." - ".$nama_layanan[$layanan],
					'badge'		=> 1,
					'sound'		=> 'Default'
				);
				$dt_inserts[] = array(
					'id_member'		=> $id_member,
					'type'			=> 6,
					'id_data'		=> $save,
					'pesan'			=> "Order book service ".$nmr_order." - ".$nama_layanan[$layanan],
					'created_at'	=> $tgl,
				);
				$notif = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);
				if(!empty($dt_inserts)) $this->db->insert_batch('history_notif', $dt_inserts);
			}		
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $member->email;
			$nama = $member->nama.' '.$member->last_name;
			$subject = 'Booking Service';
			if($pembayaran == 1) $payment_type = 'Cash';
			if($pembayaran == 2) $payment_type = 'Manual Transfer';
			$nama_type = $nama_cat.' - '.$nama_type;
			$content_member = '';
			$content_member = $out['email_bs'];
			$content = str_replace('[#name#]', $nama, $content_member);
			$content = str_replace('[#device#]', $nama_type, $content);
			$content = str_replace('[#payment_type#]', $payment_type, $content);
			$content = str_replace('[#tgl_order#]', date('d-m-Y'), $content);
			$content = str_replace('[#no_order#]', $nmr_order, $content);
			$content = str_replace('[#nohp_customer#]', $wa, $content);
			$content = str_replace('[#catatan#]', $catatan, $content);
			$content = str_replace('[#kerusakan#]', $kerusakan, $content);
			$content = str_replace('[#tgl_service#]', date('d-m-Y',strtotime($tgl_service)), $content);
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
				'err_msg' 	=> 'Terima kasih telah melakukan booking service di iColor',
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
	
	function history_booking(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$selects = array('booking_service.*','customer.nama','customer.last_name');
		$booking_service = $this->access->readtable('booking_service',$selects,array('booking_service.id_member'=>$id_member),array('customer' => 'customer.id_customer = booking_service.id_member'),'','','LEFT')->result_array();
		$dt = array();	
		
		if(!empty($booking_service)){
			foreach($booking_service as $bs){
				$dt[] = array(
					'id_booking'	=> $bs['id_booking'],
					'order_no'	=> $bs['nmr_booking'],
					'nmr_antrian'	=> $bs['nmr_antrian'],
					'id_member'		=> $bs['id_member'],
					'nama_member'	=> $bs['nama'],
					'alamat'		=> $bs['alamat'],
					'tgl_service'	=> $bs['tgl_service'],
					'ig'			=> $bs['ig'],
					'wa'			=> $bs['wa'],
					'layanan'		=> $bs['layanan'],
					'biaya_layanan'	=> $bs['biaya_layanan'],
					'status'		=> $bs['status'],
					'status_transfer'		=> $bs['status_transfer'],
					'id_area'		=> $bs['id_area'],
					'id_store'		=> $bs['id_store'],
					'nama_store'	=> $bs['nama_store'],
					'nama_area'		=> $bs['nama_area'],
					'imei'			=> $bs['imei'],
					'device_cat'	=> $bs['device_cat'],
					'nama_cat'		=> $bs['nama_cat'],
					'device_type'	=> $bs['device_type'],
					'nama_type'		=> $bs['nama_type'],
					'serial_number'	=> $bs['serial_number'],
					'passcode'		=> $bs['passcode'],
					'harga_sp'		=> $bs['harga_sp'],
					'kerusakan'		=> $bs['kerusakan'],
					'catatan'		=> $bs['catatan'],
					'pembayaran'	=> $bs['pembayaran'],
					'created_at'	=> $bs['created_at'],
					'id_tk'			=> $bs['id_tk'],
					'nama_tk'		=> $bs['nama_tk'],
					'phone_tk'		=> $bs['phone_tk'],
					'email_tk'		=> $bs['email_tk'],
					'jadwal_tk'		=> $bs['jadwal_tk'],
					'kurir'			=> $bs['kurir'],
					'no_awb'		=> $bs['no_awb'],
					'catatan_pengiriman'		=> $bs['catatan_pengiriman'],
					'img_kurir'		=> !empty($bs['img_kurir']) ? base_url('uploads/pengiriman/'.$bs['img_kurir']) : null
					
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
	
	function booking_detail(){
		$tgl = date('Y-m-d');
		$param = $this->input->post();
		$id_booking = isset($param['id_booking']) ? (int)$param['id_booking'] : 0;		
		$selects = array('booking_service.*','customer.nama','customer.last_name');
		$booking_service = $this->access->readtable('booking_service',$selects,array('booking_service.id_booking'=>$id_booking),array('customer' => 'customer.id_customer = booking_service.id_member'),'','','LEFT')->row();
		$id_store = (int)$booking_service->id_store;
		$layanan = (int)$booking_service->layanan;
		$antrian_berjalan = null;
		if($layanan == 4){
			$sort = array('ABS(id_booking)','ASC');
			$selects = array('MAX(nmr_antrian) as nmr_antrian');
			$antrian = $this->access->readtable('booking_service',$selects,array('id_store'=>$id_store,'layanan'=>4,'date_format(tgl_service, "%Y-%m-%d") ='=>$tgl,'ABS(status_antrian)'=>1),'','',$sort)->row();			
			$antrian_berjalan = (int)$antrian->nmr_antrian > 0 ?(int)$antrian->nmr_antrian : 0;
		}
		$dt = array();
		if(!empty($booking_service)){
			$bs_detail = '';
			$bs_detail = $this->access->readtable('bs_detail',array('id_booking','nama_sp','varian','harga_sp'),array('id_booking'=>$id_booking,'deleted_at'=>null))->result_array();
			$list_sp = array();
			if(!empty($bs_detail)){
				foreach($bs_detail as $bd){
					$list_sp[] = array(
						'nama_sp' 	=> $bd['nama_sp'],
						'varian' 	=> $bd['varian'],
						'harga_sp' 	=> $bd['harga_sp'],
					);
				}
			}
			$dt = array(
				'id_booking'	=> $booking_service->id_booking,
				'order_no'	=> $booking_service->nmr_booking,
				'nmr_antrian'	=> $booking_service->nmr_antrian,
				'antrian_berjalan'	=> $antrian_berjalan,
				'id_member'		=> $booking_service->id_member,
				'nama_member'	=> $booking_service->nama,
				'alamat'		=> $booking_service->alamat,
				'tgl_service'	=> $booking_service->tgl_service,
				'ig'			=> $booking_service->ig,
				'wa'			=> $booking_service->wa,
				'layanan'		=> $booking_service->layanan,
				'biaya_layanan'	=> $booking_service->biaya_layanan,
				'status'		=> $booking_service->status,
				'status_transfer'		=> $booking_service->status_transfer,
				'id_area'		=> $booking_service->id_area,
				'id_store'		=> $booking_service->id_store,
				'nama_store'	=> $booking_service->nama_store,
				'nama_area'		=> $booking_service->nama_area,
				'imei'			=> $booking_service->imei,
				'device_cat'	=> $booking_service->device_cat,
				'nama_cat'		=> $booking_service->nama_cat,
				'device_type'	=> $booking_service->device_type,
				'nama_type'		=> $booking_service->nama_type,
				'serial_number'	=> $booking_service->serial_number,							
				'passcode'		=> $booking_service->passcode,							
				'harga_sp'		=> $booking_service->harga_sp,
				'kerusakan'		=> $booking_service->kerusakan,
				'catatan'		=> $booking_service->catatan,
				'pembayaran'	=> $booking_service->pembayaran,
				'created_at'	=> $booking_service->created_at,
				'id_tk'			=> $booking_service->id_tk,
				'nama_tk'		=> $booking_service->nama_tk,
				'phone_tk'		=> $booking_service->phone_tk,
				'email_tk'		=> $booking_service->email_tk,
				'jadwal_tk'		=> $booking_service->jadwal_tk,
				'kurir'			=> $booking_service->kurir,
				'no_awb'		=> $booking_service->no_awb,
				'catatan_pengiriman'		=> $booking_service->catatan_pengiriman,
				'img_kurir'		=> !empty($booking_service->img_kurir) ? base_url('uploads/pengiriman/'.$booking_service->img_kurir) : null,
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
	
	function set_pengiriman(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_booking = isset($param['id_booking']) ? (int)$param['id_booking'] : 0;
		$kurir = isset($param['kurir']) ? $param['kurir'] : '';
		$awb = isset($param['awb']) ? $param['awb'] : '';
		$catatan = isset($param['awb']) ? $param['catatan'] : '';
		$config = array();
		$config['upload_path'] = "./uploads/pengiriman/";
		$config['allowed_types'] = "jpg|png|jpeg|";
		$config['max_size']	= '4096';		
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload',$config);
		$simpan = array();
		$simpan = array(
			'status'				=> 2,
			'kurir'					=> $kurir,
			'no_awb'				=> $awb,
			'catatan_pengiriman'	=> $catatan,
			'tgl_kirim'				=> $tgl
		);
		if(!empty($_FILES['img'])){
			$upl = '';
			if($this->upload->do_upload('img')){
				$upl = $this->upload->data();
				$simpan += array("img_kurir" => $upl['file_name']);			
			}
		}
		$this->access->updatetable('booking_service', $simpan, array('id_booking'=>$id_booking,'layanan'=>3));
		
		$dt_history = array();
		$dt_history = array(
			'id_bs'			=> $id_booking,
			'status'		=> 2,
			'catatan'		=> $catatan,
			'ket'			=> 'kirim oleh customer',
			'created_at'	=> $tgl,
		);
		$this->access->inserttable('history_status', $dt_history);
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'Saved',
				'data'		=> $simpan
			];
		http_response_code(200);
		echo json_encode($result);	
	}
	
	function confirm_payment(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();		
		$id_booking = isset($param['id_booking']) ? (int)$param['id_booking'] : 0;
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
			'status_transfer'	=> 1
		);
		if(!empty($_FILES['img'])){
			$upl = '';
			if($this->upload->do_upload('img')){
				$upl = $this->upload->data();
				$simpan += array("img_transfer" => $upl['file_name']);			
			}
		}
		$this->access->updatetable('booking_service', $simpan, array('id_booking'=>$id_booking,'pembayaran'=>2));
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'Terima kasih sudah melakukan pembayaran',
				'data'		=> $simpan
			];
		http_response_code(200);
		echo json_encode($result);	
	}
	
	function tests(){
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
