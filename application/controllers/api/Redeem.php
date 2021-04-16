<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Redeem extends CI_Controller {

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
		$where = array('product_redeem.deleted_at'=>null);
		$device_cat = isset($param['device_cat']) ? (int)$param['device_cat'] : 0;
		$device_type = isset($param['device_type']) ? (int)$param['device_type'] : 0;
		$keyword = isset($param['keyword']) ? $param['keyword'] :'';
		$_like = array();
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			$_like = array('product_redeem.nama_barang'=> $keyword);
		}
		if($device_cat > 0) $where += array('device_cat'=>$device_cat);		
		if($device_type > 0) $where += array('device_type'=>$device_type);	
		// $selects = array('shop_product.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$product = $this->access->readtable('product_redeem','',$where,'','','','','',$_like)->result_array();
		$result = array();
		$dt = array();
		if(!empty($product)){
			foreach($product as $p){
				$dt[] = array(
					"id_product"		=> $p['id_product'],
					"nama_produk"		=> $p['nama_barang'],
					"img"				=> !empty($p['img']) ? base_url('uploads/products/'.$p['img']): null,
					"point"				=> $p['point']
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
		$where = array('product_redeem.deleted_at'=>null,'product_redeem.id_product'=>$id_product);
		// $selects = array('shop_product.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$sp = $this->access->readtable('product_redeem','',$where)->row();
		
		$result = array();
		$dt = array();
		
		if(!empty($sp)){
			$varian = '';
			$varian = $sp->varian;
			$_v = explode(',',$varian);
			$dt = array(
				'id_product'	=> $sp->id_product,
				'nama_produk'	=> $sp->nama_barang,
				'point'			=> $sp->point,
				'img'			=> !empty($sp->img) ? base_url('uploads/products/'.$sp->img): null,
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
		$dt = array();
		$param = $this->input->post();
		$id_ta = array();
		$dt_insert = array();
		$sp = '';
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;		
		$id_product = isset($param['id_product']) ? (int)$param['id_product'] : 0;			
		$wa = isset($param['wa']) ? $param['wa'] : '';
		
		$member = $this->access->readtable('customer','',array('id_customer'=>$id_member,'deleted_at'=>null))->row();
		$point_member = $member->point > 0 ? $member->point : 0;
		$update_member = array();
		$this->db->trans_begin();
		if($point_member == 0){
			$result = array(
				'err_code' 	=> '06',
				'err_msg' 	=> 'Point anda 0',					
			);
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$product_redeem = $this->access->readtable('product_redeem','',array('id_product'=>$id_product))->row();
		$nama_barang = !empty($product_redeem->nama_barang) ? $product_redeem->nama_barang : '-';
		$point_product = $product_redeem->point > 0 ? $product_redeem->point : 0;
		if($point_member < $point_product){
			$this->db->trans_rollback();
			$result = array(
				'err_code' 	=> '06',
				'err_msg' 	=> 'Point tidak cukup',					
				'point' 	=> $point_member,					
			);
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$sisa_point = $point_member - $point_product;
		$update_member = array(
			"point" => $sisa_point
		);
		$simpan_redeem = array(
			"id_member"		=> $id_member,
			"id_product"	=> $id_product,
			"point"			=> $point_product,
			"redeem_point"	=> $point_member,
			"tgl"			=> date('Y-m-d H:i:s'),
			"status"		=> 1,
			"sisa_point"	=> $sisa_point,
			"hp_redeem"		=> $wa
		);
		$save = $this->access->inserttable("redeem",$simpan_redeem);	
		$result = array();		
		if($save > 0){
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}
			$this->load->library('send_notif');
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $member->email;
			$nama = $member->nama.' '.$member->last_name;
			$subject = 'Redeem Point';
			$content_member = '';
			$content_member = $out['email_redeempoint']; 
			$content = str_replace('[#name#]', $nama, $content_member);
			$content = str_replace('[#product_redeem#]', $nama_barang, $content);
			$content = str_replace('[#point_redeem#]', number_format($point_product,0,'',','), $content);
			$simpan_history = array();
			$simpan_history = array(
				"id_member"			=> $id_member,
				"tgl"				=> $tgl,
				"id_tr"				=> $save,
				"type"				=> 10,
				"description"		=> "Redeem Points",
				"nilai"				=> '-'.$point
			);
			$this->access->inserttable("point_history",$simpan_history);
			$this->access->updatetable('customer',$update_member, array("id_customer"=>$id_member));
			$this->send_notif->send_email($from,$pass, $to,$subject, $content);
			$this->db->trans_commit();
			$result = array(
				'err_code' 		=> '00',
				'err_msg' 		=> 'Terima Kasih, Redeem Anda Akan Kami Proses',
				'data'			=> $simpan_redeem,
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
	
	
	
}
