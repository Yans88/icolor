<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Forum extends CI_Controller {

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
		$sort = array('abs(forum.id)','DESC');
		if($_sort == 2) $sort = array('abs(forum.id)','ASC');
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			$_like = array('forum.title'=> $keyword);
		}
		$where = array();
		$where = array('forum.deleted_at'=>null);
		if($type > 0)$where += array('forum.device_type'=>$type);
		$select = array('forum.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$tutorial = $this->access->readtable('forum','',$where,array('kategori'=>'kategori.id_kategori = forum.device_cat','sub_kategori'=>'sub_kategori.id_sub = forum.device_type'),'',$sort,'LEFT','',$_like)->result_array();
		
		if(!empty($tutorial)){
			foreach($tutorial as $t){
				$dt[] = array(
					'id_forum'		=> $t['id'],
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
					
					'img'				=> !empty($t['img']) ? base_url('uploads/forum/'.$t['img']) : null,
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
		$id_forum = isset($param['id_forum']) ? (int)$param['id_forum'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$select = array('forum.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$tutorial = $this->access->readtable('forum','',array('forum.deleted_at'=>null,'forum.id'=>$id_forum),array('kategori'=>'kategori.id_kategori = forum.device_cat','sub_kategori'=>'sub_kategori.id_sub = forum.device_type'),'','','LEFT')->row();
		
		$dt_like = $this->access->readtable('forum_like','',array('id_forum'=>$id_forum,'id_forum'=>$id_member))->row();
		$dt_jmllike = $this->access->readtable('forum_like','',array('id_forum'=>$id_forum))->result_array();
		$dt_jmlshare = $this->access->readtable('forum_share','',array('id_forum'=>$id_forum))->result_array();
		
		$is_like = !empty($dt_like) ? 1 : 0;
		$jml_like = !empty($dt_jmllike) ? count($dt_jmllike) : 0;
		$jml_share = !empty($dt_jmlshare) ? count($dt_jmlshare) : 0;
		
		if(!empty($tutorial)){
			$dt = array(
				'id_forum'		=> $tutorial->id,
				'title'				=> $tutorial->title,
				'deskripsi'			=> $tutorial->deskripsi,				
				'device_cat'		=> $tutorial->device_cat,
				'device_type'		=> $tutorial->device_type,
				'nama_kategori'		=> $tutorial->nama_kategori,
				'type'				=> $tutorial->nama_sub,				
				'is_like'			=> (int)$is_like,
				'jml_like'			=> (int)$jml_like,
				'jml_share'			=> (int)$jml_share,
				'img'				=> !empty($tutorial->img) ? base_url('uploads/forum/'.$tutorial->img) : null,
				
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
		$id_forum = isset($param['id_forum']) ? (int)$param['id_forum'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$first_komen_forum = isset($param['first_komen_forum']) ? (int)$param['first_komen_forum'] : 0;
		$comment = isset($param['comment']) ? $param['comment'] : '';
		
		$dt_simpan = array(
			'id_member'		=> $id_member,
			'id_forum'	=> $id_forum,
			'comment'	=> $comment
		);
		
		$save = $this->access->inserttable('forum_comment', $dt_simpan);	
		$reward_point = 0;
		if($first_komen_forum <= 0){
			$this->load->model('Setting_point_m');
			$setting_point = $this->Setting_point_m->get_key_val();
			$reward_point = str_replace('.','',$setting_point['first_komen_forum']);
			$reward_point = str_replace(',','',$reward_point);
			$reward_point = (int)$reward_point;
			$login = $this->access->readtable('customer','',array('id_customer'=>$id_member))->row();
			$_first_komen_forum = (int)$login->first_komen_forum;
			$simpan_history = array();
			$upd = array();
			if($_first_komen_forum <= 0){
				$point = (int)$login->point + $reward_point;				
				$simpan_history = array(
					"id_member"			=> $id_member,
					"tgl"				=> date('Y-m-d H:i:s'),
					"id_tr"				=> $save,
					"type"				=> 4,
					"description"		=> "Add Points First comment forum",
					"nilai"				=> $reward_point
				);
				$upd = array('point'=>$point,'first_komen_forum'=>$save);
				$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
				$this->access->inserttable("point_history",$simpan_history);
			}
			
		}
		$login = $this->access->readtable('customer','',array('id_customer'=>$id_member))->row();
		$photo = !empty($login->photo) ? base_url('uploads/members/'.$login->photo) : null;
		$dt_simpan +=array('photo' => $photo);
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=>  $dt_simpan,
				'get_point'	=> $reward_point,
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function reply_comment(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_comment = isset($param['id_comment']) ? (int)$param['id_comment'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$comment = isset($param['comment']) ? $param['comment'] : '';
		$first_komen_forum = isset($param['first_komen_forum']) ? (int)$param['first_komen_forum'] : 0;
		$dt_comment = $this->access->readtable('forum_comment','',array('id'=>$id_comment))->row();
		$id_forum = !empty($dt_comment) ? $dt_comment->id_forum : 0;
		$dt_simpan = array(
			'id_member'		=> $id_member,
			'id_comment'	=> $id_comment,
			'id_forum'		=> (int)$id_forum,
			'comment'		=> $comment
		);
		$save = $this->access->inserttable('forum_reply_comment', $dt_simpan);	
		$reward_point = 0;
		if($first_komen_forum <= 0){
			$this->load->model('Setting_point_m');
			$setting_point = $this->Setting_point_m->get_key_val();
			$reward_point = str_replace('.','',$setting_point['first_komen_forum']);
			$reward_point = str_replace(',','',$reward_point);
			$reward_point = (int)$reward_point;
			$login = $this->access->readtable('customer','',array('id_customer'=>$id_member))->row();
			$_first_komen_forum = (int)$login->first_komen_forum;
			$simpan_history = array();
			$upd = array();
			if($_first_komen_forum <= 0){
				$point = (int)$login->point + $reward_point;				
				$simpan_history = array(
					"id_member"			=> $id_member,
					"tgl"				=> date('Y-m-d H:i:s'),
					"id_tr"				=> $save,
					"type"				=> 4,
					"description"		=> "Add Points First comment forum",
					"nilai"				=> $reward_point
				);
				$upd = array('point'=>$point,'first_komen_forum'=>$save);
				$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
				$this->access->inserttable("point_history",$simpan_history);
			}
			
		}
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=>  $dt_simpan,
				'get_point'	=> $reward_point,
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_comment(){		
		$param = $this->input->post();
		$id_forum = isset($param['id_forum']) ? (int)$param['id_forum'] : 0;
		$dt_c = array();
		$sort = array('ABS(forum_comment.id)','DESC');
		$select = array('customer.*','forum_comment.comment','forum_comment.id','forum_comment.updated_at as tgl');
		$comment = $this->access->readtable('forum_comment',$select,array('id_forum'=>$id_forum,'forum_comment.deleted_at'=>null),array('customer'=>'customer.id_customer = forum_comment.id_member'),'',$sort,'LEFT')->result_array();		
		$sort = array();
		$select = array();
		$sort = array('ABS(forum_reply_comment.id)','ASC');
		$select = array('customer.*','forum_reply_comment.comment','forum_reply_comment.id','forum_reply_comment.updated_at as tgl','forum_reply_comment.id_comment');
		$comment_reply = $this->access->readtable('forum_reply_comment',$select,array('id_forum'=>$id_forum,'forum_reply_comment.deleted_at'=>null),array('customer'=>'customer.id_customer = forum_reply_comment.id_member'),'',$sort,'LEFT')->result_array();
		$dt_reply = array();
		$dt_c = array();
		if(!empty($comment_reply)){
			foreach($comment_reply as $cr){
				$_photo = '';
				$_photo = !empty($cr['photo']) ? base_url('uploads/members/'.$cr['photo']) : null;
				$dt_reply[$cr['id_comment']][] = array(
					'id'		=> $cr['id'],
					'comment'	=> $cr['comment'],
					'nama'		=> $cr['nama'],
					'last_name'	=> $cr['last_name'],
					'tgl'		=> $cr['tgl'],
					'photo'		=> $_photo,
				);
			}
		}
		if(!empty($comment)){
			foreach($comment as $c){
				$photo = !empty($c['photo']) ? base_url('uploads/members/'.$c['photo']) : null;
				$dt_c[] = array(
					'id'		=> $c['id'],
					'comment'	=> $c['comment'],
					'nama'		=> $c['nama'],
					'last_name'	=> $c['last_name'],
					'tgl'		=> $cr['tgl'],
					'photo'		=> $photo,
					'reply'		=> $dt_reply[$c['id']]
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
		$id_forum = isset($param['id_forum']) ? (int)$param['id_forum'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$val  = isset($param['like']) ? (int)$param['like'] : 1;
		$dt_simpan = array();
		$dt_simpan = array(
			'id_member'		=> $id_member,
			'id_forum'	=> $id_forum
		);
		if($val > 0){			
			$save = $this->access->inserttable('forum_like', $dt_simpan);	
		}else{
			$save = $this->access->deletetable('forum_like',$dt_simpan);
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
		$id_forum = isset($param['id_forum']) ? (int)$param['id_forum'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$val  = isset($param['like']) ? (int)$param['like'] : 1;
		$dt_simpan = array();
		$dt_simpan = array(
			'id_member'		=> $id_member,
			'id_forum'	=> $id_forum
		);
		$save = $this->access->inserttable('forum_share', $dt_simpan);
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
		$id_forum = isset($param['id_forum']) ? (int)$param['id_forum'] : 0;
		$dt_c = array();
		$sort = array('ABS(forum_like.id)','DESC');
		$select = array('customer.*','forum_like.id','forum_like.updated_at as tgl');
		$comment = $this->access->readtable('forum_like',$select,array('id_forum'=>$id_forum),array('customer'=>'customer.id_customer = forum_like.id_member'),'',$sort,'LEFT')->result_array();
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
	
	function get_member_share(){
		$param = $this->input->post();
		$id_forum = isset($param['id_forum']) ? (int)$param['id_forum'] : 0;
		$dt_c = array();
		$sort = array('ABS(forum_share.id)','DESC');
		$select = array('customer.*','forum_share.id','forum_share.updated_at as tgl');
		$comment = $this->access->readtable('forum_share',$select,array('id_forum'=>$id_forum),array('customer'=>'customer.id_customer = forum_share.id_member'),'',$sort,'LEFT')->result_array();
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
