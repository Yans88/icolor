<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class News extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }

    public function index(){
		$param = $this->input->post();
		$keyword = isset($param['keyword']) ? $param['keyword'] :'';
		$_sort = isset($param['sort']) ? (int)$param['sort'] : 1;
		$sort = array('abs(news.id_news)','DESC');
		if($_sort == 2) $sort = array('abs(news.id_news)','ASC');
		$_like = array();
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			$_like = array('news.title'=> $keyword);
		}
		$news = $this->access->readtable('news','',array('deleted_at'=>null),'','',$sort,'','',$_like)->result_array();
		$dt = array();
		$img = '';
		$thumbnail = '';
		if(!empty($news)){
			foreach($news as $n){			
				$img = !empty($n['img']) ? base_url('uploads/news/'.$n['img']) : null;
				$thumbnail = !empty($n['thumbnail']) ? base_url('uploads/news/'.$n['thumbnail']) : null;
				$dt[] = array(
					"id_news"			=> $n['id_news'],
					"title"				=> $n['title'],
					"deskripsi_title"	=> $n['deskripsi_title'],
					"subtitle"			=> $n['subtitle'],
					"deskripsi_sub"		=> $n['deskripsi_sub'],
					"img"				=> $img,
					"thumbnail"			=> $thumbnail,
					"tgl"				=> $n['created_at']
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
    
	
	public function detail(){
		$param = $this->input->post();
		$id_news = isset($param['id_news']) ? (int)$param['id_news'] : 0;
		$news = $this->access->readtable('news','',array('deleted_at'=>null,'id_news'=>$id_news))->row();
		$dt = array();
		$img = '';
		$thumbnail = '';
		if(!empty($news)){
			$img = !empty($news->img) ? base_url('uploads/news/'.$news->img) : null;
			$thumbnail = !empty($news->thumbnail) ? base_url('uploads/news/'.$news->thumbnail) : null;
			$dt = array(
				"id_news"			=> $news->id_news,
				"title"				=> $news->title,
				"deskripsi_title"	=> $news->deskripsi_title,
				"subtitle"			=> $news->subtitle,
				"deskripsi_sub"		=> $news->deskripsi_sub,
				"img"				=> $img,
				"thumbnail"			=> $thumbnail,
				"tgl"				=> $news->created_at
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
	

}
