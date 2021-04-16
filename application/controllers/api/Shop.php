<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }
	
	function get_product(){
		$param = $this->input->post();
		$where = array();
		$where = array('shop_product.deleted_at'=>null,'qty >'=>0);
		$device_cat = isset($param['device_cat']) ? (int)$param['device_cat'] : 0;
		$device_type = isset($param['device_type']) ? (int)$param['device_type'] : 0;
		$keyword = isset($param['keyword']) ? $param['keyword'] :'';
		$_like = array();
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			$_like = array('shop_product.nama_product'=> $keyword);
		}
		if($device_cat > 0) $where += array('device_cat'=>$device_cat);		
		if($device_type > 0) $where += array('device_type'=>$device_type);	
		$selects = array('shop_product.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$shop_product = $this->access->readtable('shop_product',$selects,$where,array('kategori' => 'kategori.id_kategori = shop_product.device_cat','sub_kategori' => 'sub_kategori.id_kategori = shop_product.device_type'),'','','LEFT','',$_like)->result_array();
		$result = array();
		$dt = array();
		$sort = array('ABS(id)', 'ASC');
		if(!empty($shop_product)){
			foreach($shop_product as $sp){
				$varian = '';
				$_v = null;
				if(!empty($sp['varian'])){
					$varian = $sp['varian'];
					$_v = explode(',',$varian);
				}				
				$_gbr = '';	
				$_gbr = $this->access->readtable('shop_product_img','',array('id_product'=>$sp['id_product'],'deleted_at'=>null),'','',$sort)->row();
				
				$gbr = !empty($_gbr) ? base_url('uploads/products/'.$_gbr->gbr) : null;
				$dt[] = array(
					'id_product'	=> $sp['id_product'],
					'nama_product'	=> $sp['nama_product'],
					'device_cat'	=> $sp['device_cat'],
					'nama_kategori'	=> $sp['nama_kategori'],
					'nama_type'	=> $sp['nama_sub'],
					'device_type'	=> $sp['device_type'],
					'tipe'			=> $sp['kategori'],
					'qty'			=> $sp['qty'],
					'harga'			=> $sp['harga'],
					'diskon'		=> $sp['diskon'],
					'hrg_final'		=> $sp['hrg_final'],
					'rincian_produk'		=> $sp['rincian_produk'],
					'deskripsi'		=> $sp['deskripsi'],
					'preorder'		=> $sp['preorder'],
					'waktu_po'		=> $sp['waktu_po'],
					'video'			=> $sp['video'],
					'gbr'			=> $gbr,
					'varian'		=> $_v
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
				'err_msg' 	=> 'Data not found',
				'data' 		=> $dt	
			);
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function product_detail(){
		$param = $this->input->post();
		$where = array();		
		$id_product = isset($param['id_product']) ? (int)$param['id_product'] : 0;
		$where = array('shop_product.deleted_at'=>null,'shop_product.id_product'=>$id_product);
		$selects = array('shop_product.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$sp = $this->access->readtable('shop_product',$selects,$where,array('kategori' => 'kategori.id_kategori = shop_product.device_cat','sub_kategori' => 'sub_kategori.id_kategori = shop_product.device_type'),'','','LEFT')->row();
		$_gbr = $this->access->readtable('shop_product_img','',array('id_product'=>$id_product,'deleted_at'=>null))->result_array();
		$result = array();
		$dt = array();
		$dt_gbr = null;
		if(!empty($_gbr)){
			foreach($_gbr as $g){
				$dt_gbr[] = array(
					'id_gbr'	=> $g['id'],
					'gbr'	=> base_url('uploads/products/'.$g['gbr']),
				);
			}
		}
		if(!empty($sp)){
			$varian = '';
			$varian = $sp->varian;
			$_v = explode(',',$varian);
			$dt = array(
				'id_product'	=> $sp->id_product,
				'nama_product'	=> $sp->nama_product,
				'device_cat'	=> $sp->device_cat,
				'nama_kategori'	=> $sp->nama_kategori,
				'nama_type'		=> $sp->nama_sub,
				'device_type'	=> $sp->device_type,
				'tipe'			=> $sp->kategori,
				'qty'			=> $sp->qty,
				'harga'			=> $sp->harga,
				'diskon'		=> $sp->diskon,
				'hrg_final'		=> $sp->hrg_final,
				'rincian_produk'		=> $sp->rincian_produk,
				'deskripsi'		=> $sp->deskripsi,
				'preorder'		=> $sp->preorder,
				'waktu_po'		=> $sp->waktu_po,
				'video'			=> $sp->video,
				'varian'		=> $_v,
				'img'			=> $dt_gbr
			);
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            
		}else{
			$result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not found',
				'data' 		=> $dt	
			);
		}
		http_response_code(200);
		echo json_encode($result);
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
		$pembayaran = isset($param['pembayaran']) ? (int)$param['pembayaran'] : 0;		
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';		
		$catatan = isset($param['catatan']) ? $param['catatan'] : '';
		$list_item = isset($param['list_item']) ? json_decode($param['list_item']) : '';
		$dt_simpan = array();
		$dt_stock = array();
		$akun_bank = $this->access->readtable('master_akun_bank','',array('deleted_at'=>null,'id_bank'=>$pembayaran))->row();	
		$this->db->trans_begin();
		$dt_simpan = array(
			'id_member'		=> $id_member,
			'status'		=> 1,
			'alamat'		=> $alamat,			
			'catatan'		=> $catatan,
			'id_bank_icolor'	=> $pembayaran,
			'nama_bank_icolor'	=> $akun_bank->nama_bank,
			'no_rek_icolor'		=> $akun_bank->no_rek,
			'holder_name_icolor'=> $akun_bank->holder_name,			
			'created_at'	=> $tgl
		);
		$save = 0;
		$nmr_order = 0;
		$save = $this->access->inserttable('shop_order', $dt_simpan);	
		
		$ttl_order = 0;
		for($i = 0; $i < count($list_item); $i++){
			$id_product = 0;	
			$jml = 0 ;	
			$id_product = (int)$list_item[$i]->id_product;	
			$varian = !empty($list_item[$i]->varian) ? $list_item[$i]->varian : '';	
			$jml = (int)$list_item[$i]->jml;
			
			$where = array();
			$sp = '';
			$name_stok = array();
			if((int)$id_product > 0 && (int)$jml > 0){
				$where = array('shop_product.deleted_at'=>null,'shop_product.id_product'=>$id_product);
				$selects = array('shop_product.*','kategori.nama_kategori','sub_kategori.nama_sub');
				$sp = $this->access->readtable('shop_product',$selects,$where,array('kategori' => 'kategori.id_kategori = shop_product.device_cat','sub_kategori' => 'sub_kategori.id_kategori = shop_product.device_type'),'','','LEFT')->row();
				$qty = 0;
				if(!empty($sp)){
					$qty = (int)$sp->qty;
					$ttl_hrg = $jml * $sp->hrg_final;
					$ttl_order += $ttl_hrg;
					$dt[] = array(							
						'id_order'		=> $save,
						'id_product'	=> $sp->id_product,
						'nama_product'	=> $sp->nama_product,
						'device_cat'	=> $sp->device_cat,
						'nama_cat'		=> $sp->nama_kategori,
						'nama_type'		=> $sp->nama_sub,
						'device_type'	=> $sp->device_type,
						'kategori'		=> $sp->kategori,
						'jml'			=> $jml,
						'harga'			=> $sp->harga,
						'diskon'		=> $sp->diskon,
						'hrg_final'		=> $sp->hrg_final,
						'ttl_hrg'		=> $ttl_hrg,
						'rincian_produk'		=> $sp->rincian_produk,
						'deskripsi'		=> $sp->deskripsi,
						'preorder'		=> (int)$sp->preorder,
						'waktu_po'		=> $sp->waktu_po,
						'varian'		=> $varian,
						'created_at'	=> $tgl
					);
					// $this->access->inserttable('shop_order_detail', $dt);	
					// error_log($this->db->last_query());
					$dt_upd[] = array(
						'id_product'	=> $sp->id_product,						
						'qty'			=> (int)$qty - (int)$jml
					);
					if((int)$jml > (int)$qty){
						array_push($name_stok, $sp->nama_product);
						$dt_stock[] = array(							
							'id_product'	=> $sp->id_product,
							'nama_product'	=> $sp->nama_product,
							'device_cat'	=> $sp->device_cat,
							'nama_kategori'	=> $sp->nama_kategori,
							'nama_type'		=> $sp->nama_sub,
							'device_type'	=> $sp->device_type,
							'tipe'			=> $sp->kategori,
							'qty'			=> $sp->qty,
							'harga'			=> $sp->harga,
							'diskon'		=> $sp->diskon,
							'hrg_final'		=> $sp->hrg_final,
							'rincian_produk'		=> $sp->rincian_produk,
							'deskripsi'		=> $sp->deskripsi,
							'preorder'		=> $sp->preorder,
							'waktu_po'		=> $sp->waktu_po,
							'varian'		=> $varian
						);
					}
				}
			}
		}
		$result = array();
		if(count($dt_stock) > 0){
			$this->db->trans_rollback();
			$result = array(
				'err_code' 	=> '06',
				'err_msg' 	=> 'Stok habis untuk produk '.implode(", ",$name_stok),
				'err_stok' 	=> $dt_stock,
				'data'		=> $dt_simpan	
			);
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		if(count($dt_stock) == 0 && $save > 0){
			$_save = $save;
			if($save < 10) $_save = '0'.$save;
			$nmr_order = $tgl_noorder.'06'.$_save;
			$this->access->updatetable('shop_order', array('order_no'=>$nmr_order,'ttl_order'=>$ttl_order,'ttl_cart'=>count($dt)), array('id_order' => $save));
			$this->db->update_batch('shop_product', $dt_upd, 'id_product');
			$this->db->insert_batch('shop_order_detail', $dt);			
		}
		if($save > 0){
			$dt_simpan += array('id_order'=>$save);
			$dt_history = array();
			$dt_history = array(
				'id_order'		=> $save,
				'status'		=> 1,
				'catatan'		=> null,
				'ket'			=> 'order',
				'created_at'	=> $tgl,
			);
			$this->access->inserttable('history_status_order', $dt_history);
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}
			$member = $this->access->readtable('customer','',array('id_customer'=>$id_member,'deleted_at'=>null))->row();
			$this->load->library('send_notif');
			$ids = array();
			$data_fcm = array();
			$notif_fcm = array();
			$dt_insert = array();
			if(!empty($member->fcm_token) && $member->order_shop > 0){
				$ids = array($member->fcm_token);
				$data_fcm = array(
					'id'			=> $save,			
					'title'			=> 'iColor',
					'type'			=> 4,
					'message'		=> "Order iColor Shop - ".$nmr_order
				);
				$notif_fcm = array(
					'title'		=> 'iColor',
					'body'		=> "Order iColor Shop - ".$nmr_order,
					'badge'		=> 1,
					'sound'		=> 'Default'
				);
				$dt_insert[] = array(
					'id_member'		=> $id_member,
					'type'			=> 4,
					'id_data'		=> $save,
					'pesan'			=> "Order iColor Shop - ".$nmr_order,
					'created_at'	=> $tgl,
				);
				$notif = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);
				if(!empty($dt_insert)) $this->db->insert_batch('history_notif', $dt_insert);
			}			
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $member->email;
			$nama = $member->nama.' '.$member->last_name;
			$subject = 'iColor Shop';
			$payment_type = $akun_bank->nama_bank.' : '.$akun_bank->no_rek.' a.n '.$akun_bank->holder_name;	
			$content_member = '';
			$content_member = $out['email_icolorshop'];
			$content = str_replace('[#name#]', $nama, $content_member);			
			$content = str_replace('[#bank_icolor#]', $payment_type, $content);
			$content = str_replace('[#alamat_pengiriman#]', $alamat, $content);
			$content = str_replace('[#tgl_order#]', date('d-m-Y'), $content);
			$content = str_replace('[#no_order#]', $nmr_order, $content);
			$content = str_replace('[#total_harga#]', number_format($ttl_order,0,'',','), $content);
			$_tbl = '';
			if(!empty($dt)){
				$_tbl ='<table border="1" cellpadding="1" cellspacing="1" style="width: 500px;">
				<tbody>
				<tr>
					<td>No</td>
					<td>Product</td>
					<td>Variant</td>
					<td>Harga</td>				
					<td>Qty</td>				
					<td>Sub total</td>				
				</tr>';
				for($i=0;$i<count($dt);$i++){
					$n = $i + 1;
					$my_varian = '';
					$my_varian = !empty($dt[$i]['varian']) ? $dt[$i]['varian'] : '-';
					$_tbl .='<tr>
						<td>'.$n.'</td>
						<td>'.$dt[$i]['nama_product'].'</td>
						<td>'.$my_varian.'</td>
						<td>'.number_format($dt[$i]['hrg_final'],0,'',',').'</td> 
						<td>'.number_format($dt[$i]['jml'],0,'',',').'</td> 
						<td>'.number_format($dt[$i]['ttl_hrg'],0,'',',').'</td> 
						</tr>';
				}
				$_tbl .= '</table>';
			}
			$content = str_replace('[#list_cart#]', $_tbl, $content);
			$this->send_notif->send_email($from,$pass, $to,$subject, $content);
			$this->db->trans_commit();
			$result = array(
				'err_code' 		=> '00',
				'err_msg' 		=> 'Terima Kasih, Pesanan Anda Akan Kami Proses',
				'data'			=> $dt_simpan,
			);
		}else{
			$this->db->trans_rollback();
			$result = array(
				'err_code' 	=> '05',
				'err_msg' 	=> 'insert has problem',
				'data' 		=> null	
			);
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function history_order(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$selects = array('shop_order.*','customer.nama','customer.last_name');
		$booking_service = $this->access->readtable('shop_order',$selects,array('shop_order.id_member'=>$id_member),array('customer' => 'customer.id_customer = shop_order.id_member'),'','','LEFT')->result_array();
		$dt = array();		
		if(!empty($booking_service)){
			foreach($booking_service as $bs){
				$dt[] = array(
					'id_order'	=> $bs['id_order'],					
					'order_no'	=> $bs['order_no'],					
					'id_member'		=> $bs['id_member'],
					'nama_member'	=> $bs['nama'],
					'alamat'		=> $bs['alamat'],					
					'status'		=> $bs['status'],					
					'status_transfer'		=> $bs['status_transfer'],					
					'catatan'		=> $bs['catatan'],
					'ttl_order'		=> $bs['ttl_order'],
					'id_bank_icolor'		=> $bs['id_bank_icolor'],
					'nama_bank_icolor'		=> $bs['nama_bank_icolor'],
					'no_rek_icolor'		=> $bs['no_rek_icolor'],
					'holder_name_icolor'		=> $bs['holder_name_icolor'],
					'created_at'	=> $bs['created_at'],
					'req_cancel'	=> (int)$bs['req_cancel'],
					
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
		$selects = array('shop_order.*','customer.nama','customer.last_name');
		$booking_service = $this->access->readtable('shop_order',$selects,array('shop_order.id_order'=>$id_order),array('customer' => 'customer.id_customer = shop_order.id_member'),'','','LEFT')->row();		
		$shop_order_detail = $this->access->readtable('shop_order_detail','',array('id_order'=>$id_order))->result_array();	
		$list_sp = array();		
		if(!empty($shop_order_detail)){
			foreach($shop_order_detail as $key=>$bd){
				unset($bd['updated_at']);
				unset($bd['created_at']);
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
				'status'		=> $booking_service->status,	
				'status_transfer'		=> $booking_service->status_transfer,	
				'ttl_order'		=> $booking_service->ttl_order,	
				'id_bank_icolor'		=> $booking_service->id_bank_icolor,	
				'nama_bank_icolor'		=> $booking_service->nama_bank_icolor,	
				'no_rek_icolor'		=> $booking_service->no_rek_icolor,	
				'holder_name_icolor'		=> $booking_service->holder_name_icolor,					
				'created_at'	=> $booking_service->created_at,
				'req_cancel'	=> (int)$booking_service->req_cancel,
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
		$this->access->updatetable('shop_order', $simpan, array('id_order'=>$id_order));
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'Terima kasih sudah melakukan pembayaran',
				'data'		=> $simpan
			];
		http_response_code(200);
		echo json_encode($result);	
	}
	
	function req_cancel(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_order = isset($param['id_order']) ? (int)$param['id_order'] : 0;
		$simpan = array();
		$simpan = array(
			'req_cancel_date'	=> $tgl,			
			'req_cancel'		=> 1,
			'status'			=> 6,
			
		);
		$this->access->updatetable('shop_order', $simpan, array('id_order'=>$id_order,'ABS(req_cancel)'=>0));
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> 'on process'
			];
		http_response_code(200);
		echo json_encode($result);	
	} 
	
	function completed(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_order = isset($param['id_order']) ? (int)$param['id_order'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$simpan = array();
		$simpan = array(
			'completed_at'	=> $tgl,			
			'status'			=> 8,
			
		);
		$this->access->updatetable('shop_order', $simpan, array('id_order'=>$id_order));
		$this->load->model('Setting_point_m');
		$setting_point = $this->Setting_point_m->get_key_val();
		$reward_point = str_replace('.','',$setting_point['order_shop']);
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
				"id_tr"				=> $id_order,
				"type"				=> 8,
				"description"		=> "Add Points Order Shop #".$id_order,
				"nilai"				=> $reward_point
		);
		$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
		$this->access->inserttable("point_history",$simpan_history);
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> 'completed'
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
