<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Tutorial extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		$this->load->library('converter');
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }
	
    function index(){	
		$tgl = date('Y-m-d H:i:s');
		$dt = array();
		$param = $this->input->post();
		$keyword = isset($param['keyword']) ? $param['keyword'] :'';
		$_sort = isset($param['sort']) ? (int)$param['sort'] : 1;
		$type = isset($param['device_type']) ? (int)$param['device_type'] : 0;
		$_like = array();
		$sort = array('abs(tutorial.id)','DESC');
		if($_sort == 2) $sort = array('abs(tutorial.id)','ASC');
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			$_like = array('tutorial.title'=> $keyword);
		}
		$where = array();
		$where = array('tutorial.deleted_at'=>null);
		if($type > 0)$where += array('tutorial.device_type'=>$type);
		$select = array('tutorial.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$tutorial = $this->access->readtable('tutorial',$select,$where,array('kategori'=>'kategori.id_kategori = tutorial.device_cat','sub_kategori'=>'sub_kategori.id_sub = tutorial.device_type'),'',$sort,'LEFT','',$_like)->result_array();
		
		if(!empty($tutorial)){
			foreach($tutorial as $t){
				$dt[] = array(
					'id_tutorial'		=> $t['id'],
					'title'				=> $t['title'],
					'introduction'		=> $t['introduction'],
					'deskripsi'			=> $t['deskripsi'],
					'difficulty'		=> $t['difficulty'],
					'time_required'		=> $t['time_required'],
					'video_overview'	=> $t['video_overview'],
					'device_cat'		=> $t['device_cat'],
					'device_type'		=> $t['device_type'],
					'nama_kategori'		=> $t['nama_kategori'],
					'type'				=> $t['nama_sub'],					
					'img'				=> !empty($t['img']) ? base_url('uploads/tutorials/'.$t['img']) : null,
				);
			}
		}
		if(!empty($dt)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Data not found',
				'data'		=>  null
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function detail(){
		$param = $this->input->post();
		$id_tutorial = isset($param['id_tutorial']) ? (int)$param['id_tutorial'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$select = array('tutorial.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$tutorial = $this->access->readtable('tutorial',$select,array('tutorial.deleted_at'=>null,'tutorial.id'=>$id_tutorial),array('kategori'=>'kategori.id_kategori = tutorial.device_cat','sub_kategori'=>'sub_kategori.id_sub = tutorial.device_type'),'','','LEFT')->row();
		
		$section = $this->access->readtable('tutorial_section','', array('id_tutor'=>$id_tutorial, 'deleted_at'=>null))->result_array();
		$step = $this->access->readtable('tutorial_step','', array('id_tutor'=>$id_tutorial, 'deleted_at'=>null))->result_array();
		$step_gbr = $this->access->readtable('tutorial_step_gbr',array('id_step','id_step_img','gbr'),array('id_tutor'=>$id_tutorial,'deleted_at'=>null))->result_array();
		$selects = array('shop_product.*','tutorial_tools.id');
		$tools = $this->access->readtable('tutorial_tools',$selects,array('tutorial_tools.id_tutorial'=>$id_tutorial,'tutorial_tools.deleted_at'=>null,'shop_product.deleted_at'=>null),array('shop_product'=>'shop_product.id_product = tutorial_tools.id_tools'),'','','LEFT')->result_array();
		
		$selects = array('shop_product.*','tutorial_sp.id');		
		$spare_parts = $this->access->readtable('tutorial_sp',$selects,array('tutorial_sp.id_tutorial'=>$id_tutorial,'tutorial_sp.deleted_at'=>null,'shop_product.deleted_at'=>null),array('shop_product'=>'shop_product.id_product = tutorial_sp.id_sp'),'','','LEFT')->result_array();
		
		$dt_like = $this->access->readtable('tutorial_like','',array('id_tutorial'=>$id_tutorial,'id_tutorial'=>$id_member))->row();
		$dt_jmllike = $this->access->readtable('tutorial_like','',array('id_tutorial'=>$id_tutorial))->result_array();
		$dt_jmlshare = $this->access->readtable('tutorial_share','',array('id_tutorial'=>$id_tutorial))->result_array();
		$dt_step = array();
		$dt_sg = array();
		$dt_tools = array();
		$dt_sp = array();
		$is_like = !empty($dt_like) ? 1 : 0;
		$jml_like = !empty($dt_jmllike) ? count($dt_jmllike) : 0;
		$jml_share = !empty($dt_jmlshare) ? count($dt_jmlshare) : 0;
		if(!empty($tools)){
			foreach($tools as $t){
				$dt_tools[] = array(
					'id_tools'		=> $t['id'],
					'nama_tools'	=> $t['nama_product'],
					'harga'			=> $t['harga_final']
				);
			}
		}
		if(!empty($spare_parts)){
			foreach($spare_parts as $sp){
				$dt_sp[] = array(
					'id_sp'		=> $sp['id'],
					'nama_sp'	=> $sp['nama_product'],
					'harga'		=> $sp['harga_final']
				);
			}
		}
		if(!empty($step_gbr)){
			foreach($step_gbr as $sg){
				$dt_sg[$sg['id_step']][] = array(
					'id_step_img'	=> $sg['id_step_img'],
					'img'			=> !empty($sg['gbr']) ? base_url('uploads/step/'.$sg['gbr']) : null
				);
			}
		}
		if(!empty($step)){
			foreach($step as $st){
				$dt_step[$st['id_section']][] = array(
					'id_step'	=> $st['id_step'],
					'step'		=> $st['step'],
					'ket'		=> $st['ket'],
					'list_gbr'	=> $dt_sg[$st['id_step']]
				);
			}
		}
		$dt_section = null;
		if(!empty($section)){
			foreach($section as $_s){
				$dt_section[] = array(
					'id_section'	=> $_s['id_section'],
					'section'		=> $_s['section'],
					'list_step'		=> $dt_step[$_s['id_section']]
				);
			}
		}
		if(!empty($tutorial)){
			$dt = array(
				'id_tutorial'		=> $tutorial->id,
				'title'				=> $tutorial->title,
				'introduction'		=> $tutorial->introduction,
				'deskripsi'			=> $tutorial->deskripsi,
				'difficulty'		=> $tutorial->difficulty,
				'time_required'		=> $tutorial->time_required,
				'video_overview'	=> $tutorial->video_overview,
				'device_cat'		=> $tutorial->device_cat,
				'device_type'		=> $tutorial->device_type,
				'nama_kategori'		=> $tutorial->nama_kategori,
				'type'				=> $tutorial->nama_sub,
				'section'			=> (int)count($section),
				'is_like'			=> (int)$is_like,
				'jml_like'			=> (int)$jml_like,
				'jml_share'			=> (int)$jml_share,
				'img'				=> !empty($tutorial->img) ? base_url('uploads/tutorials/'.$tutorial->img) : null,
				'list_spare_sparts'	=> $dt_sp,
				'list_tools'		=> $dt_tools,
				'list_section'		=> $dt_section,
			);
		}
		if(!empty($dt)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Data not found',
				'data'		=>  null
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function comment(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_tutorial = isset($param['id_tutorial']) ? (int)$param['id_tutorial'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$comment = isset($param['comment']) ? $param['comment'] : '';
		$first_komen_tutor = isset($param['first_komen_tutor']) ? (int)$param['first_komen_tutor'] : 0;
		$dt_simpan = array(
			'id_member'		=> $id_member,
			'id_tutorial'	=> $id_tutorial,
			'comment'	=> $comment
		);
		$save = $this->access->inserttable('tutorial_comment', $dt_simpan);	
		$reward_point = 0;
		if($first_komen_tutor <= 0){
			$this->load->model('Setting_point_m');
			$setting_point = $this->Setting_point_m->get_key_val();
			$reward_point = str_replace('.','',$setting_point['first_komen_tutor']);
			$reward_point = str_replace(',','',$reward_point);
			$reward_point = (int)$reward_point;
			$login = $this->access->readtable('customer','',array('id_customer'=>$id_member))->row();
			$_first_komen_tutor = (int)$login->first_komen_tutor;
			$simpan_history = array();
			$upd = array();
			if($_first_komen_forum <= 0){
				$point = (int)$login->point + $reward_point;				
				$simpan_history = array(
					"id_member"			=> $id_member,
					"tgl"				=> date('Y-m-d H:i:s'),
					"id_tr"				=> $save,
					"type"				=> 3,
					"description"		=> "Add Points First comment tutorial",
					"nilai"				=> $reward_point
				);
				$upd = array('point'=>$point,'first_komen_tutor'=>$save);
				$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
				$this->access->inserttable("point_history",$simpan_history);
			}
			
		}
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=>  $dt_simpan
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_comment(){		
		$param = $this->input->post();
		$id_tutorial = isset($param['id_tutorial']) ? (int)$param['id_tutorial'] : 0;
		$dt_c = array();
		$sort = array('ABS(tutorial_comment.id)','DESC');
		$select = array('customer.*','tutorial_comment.comment','tutorial_comment.id','tutorial_comment.updated_at as comment_tgl');
		$comment = $this->access->readtable('tutorial_comment',$select,array('id_tutorial'=>$id_tutorial,'tutorial_comment.deleted_at'=>null),array('customer'=>'customer.id_customer = tutorial_comment.id_member'),'',$sort,'LEFT')->result_array();
		if(!empty($comment)){
			foreach($comment as $c){
				$photo = !empty($c['photo']) ? base_url('uploads/members/'.$c['photo']) : null;
				$dt_c[] = array(
					'id'		=> $c['id'],
					'comment'	=> $c['comment'],
					'nama'		=> $c['nama'],
					'last_name'	=> $c['last_name'],
					'tgl'		=> $c['comment_tgl'],
					'photo'		=> $photo
				);
			}
		}
		$result = array();
		if(!empty($dt_c)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=>  $dt_c
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'not found',
				'data'		=>  null
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function proses_like(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_tutorial = isset($param['id_tutorial']) ? (int)$param['id_tutorial'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$val  = isset($param['like']) ? (int)$param['like'] : 1;
		$dt_simpan = array();
		$dt_simpan = array(
			'id_member'		=> $id_member,
			'id_tutorial'	=> $id_tutorial
		);
		if($val > 0){			
			$save = $this->access->inserttable('tutorial_like', $dt_simpan);	
		}else{
			$save = $this->access->deletetable('tutorial_like',$dt_simpan);
		}
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=>  $dt_simpan
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function proses_share(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_tutorial = isset($param['id_tutorial']) ? (int)$param['id_tutorial'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$val  = isset($param['like']) ? (int)$param['like'] : 1;
		$dt_simpan = array();
		$dt_simpan = array(
			'id_member'		=> $id_member,
			'id_tutorial'	=> $id_tutorial
		);
		$save = $this->access->inserttable('tutorial_share', $dt_simpan);
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=>  $dt_simpan
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_member_like(){
		$param = $this->input->post();
		$id_tutorial = isset($param['id_tutorial']) ? (int)$param['id_tutorial'] : 0;
		$dt_c = array();
		$sort = array('ABS(tutorial_like.id)','DESC');
		$select = array('customer.*','tutorial_like.id','tutorial_like.updated_at');
		$comment = $this->access->readtable('tutorial_like',$select,array('id_tutorial'=>$id_tutorial),array('customer'=>'customer.id_customer = tutorial_like.id_member'),'',$sort,'LEFT')->result_array();
		if(!empty($comment)){
			foreach($comment as $c){
				$photo = !empty($c['photo']) ? base_url('uploads/members/'.$c['photo']) : null;
				$dt_c[] = array(
					'id'		=> $c['id'],					
					'nama'		=> $c['nama'],
					'last_name'	=> $c['last_name'],
					'tgl'		=> $c['updated_at'],
					'photo'		=> $photo
				);
			}
		}
		$result = array();
		if(!empty($dt_c)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=>  $dt_c
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'not found',
				'data'		=>  null
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_member_share(){
		$param = $this->input->post();
		$id_tutorial = isset($param['id_tutorial']) ? (int)$param['id_tutorial'] : 0;
		$dt_c = array();
		$sort = array('ABS(tutorial_share.id)','DESC');
		$select = array('customer.*','tutorial_share.id','tutorial_share.updated_at as tgl');
		$comment = $this->access->readtable('tutorial_share',$select,array('id_tutorial'=>$id_tutorial),array('customer'=>'customer.id_customer = tutorial_share.id_member'),'',$sort,'LEFT')->result_array();
		if(!empty($comment)){
			foreach($comment as $c){
				$photo = !empty($c['photo']) ? base_url('uploads/members/'.$c['photo']) : null;
				$dt_c[] = array(
					'id'		=> $c['id'],					
					'nama'		=> $c['nama'],
					'last_name'	=> $c['last_name'],
					'tgl'		=> $c['tgl'],
					'photo'		=> $photo
				);
			}
		}
		$result = array();
		if(!empty($dt_c)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=>  $dt_c
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'not found',
				'data'		=>  null
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	
}
