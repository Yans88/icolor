<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Master extends CI_Controller {

    function __construct(){        
        parent::__construct();	
		
		$this->load->model('Api_m');	
		$this->load->model('Access','access',true);	
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }	
	
	function tc(){		
		$term_condition = $this->Api_m->get_key_val();
		$tc = isset($term_condition['term_condition']) ? $term_condition['term_condition'] : '';
		$tcku = array();
		$dataku = array();
		if(!empty($tc)){
			$tc = preg_replace("/<p[^>]*?>/", "", $tc);
			$tc = str_replace("</p>", "", $tc);
			//$tc = str_replace("\r\n","<br />",$tc);
			// $tcku = [
					// 'term_condition' 	=> $tc		
			// ];
			$dataku = array(				
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $tc	
			);
			
		}else{
			$dataku = array(				
                'err_code' => '04',
                'err_msg' => 'Data not be found',
				'data' 	=> $tcku
			);
			
		}
		http_response_code(200);
		echo json_encode($dataku);
	}
	
	function tc_hs(){		
		$term_condition = $this->Api_m->get_key_val();
		$tc = isset($term_condition['tc_home_s']) ? $term_condition['tc_home_s'] : '';
		$tcku = array();
		$dataku = array();
		if(!empty($tc)){
			$tc = preg_replace("/<p[^>]*?>/", "", $tc);
			$tc = str_replace("</p>", "", $tc);
			//$tc = str_replace("\r\n","<br />",$tc);
			// $tcku = [
					// 'term_condition' 	=> $tc		
			// ];
			$dataku = array(				
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $tc	
			);
			
		}else{
			$dataku = array(				
                'err_code' => '04',
                'err_msg' => 'Data not be found',
				'data' 	=> $tcku
			);
			
		}
		http_response_code(200);
		echo json_encode($dataku);
	}
	
	function tc_pd(){		
		$term_condition = $this->Api_m->get_key_val();
		$tc = isset($term_condition['tc_pickup_d']) ? $term_condition['tc_pickup_d'] : '';
		$tcku = array();
		$dataku = array();
		if(!empty($tc)){
			$tc = preg_replace("/<p[^>]*?>/", "", $tc);
			$tc = str_replace("</p>", "", $tc);
			//$tc = str_replace("\r\n","<br />",$tc);
			// $tcku = [
					// 'term_condition' 	=> $tc		
			// ];
			$dataku = array(				
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $tc	
			);
			
		}else{
			$dataku = array(				
                'err_code' => '04',
                'err_msg' => 'Data not be found',
				'data' 	=> $tcku
			);
			
		}
		http_response_code(200);
		echo json_encode($dataku);
	}
	
	function tc_kd(){		
		$term_condition = $this->Api_m->get_key_val();
		$tc = isset($term_condition['tc_kirim_d']) ? $term_condition['tc_kirim_d'] : '';
		$tcku = array();
		$dataku = array();
		if(!empty($tc)){
			$tc = preg_replace("/<p[^>]*?>/", "", $tc);
			$tc = str_replace("</p>", "", $tc);
			//$tc = str_replace("\r\n","<br />",$tc);
			// $tcku = [
					// 'term_condition' 	=> $tc		
			// ];
			$dataku = array(				
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $tc	
			);
			
		}else{
			$dataku = array(				
                'err_code' => '04',
                'err_msg' => 'Data not be found',
				'data' 	=> $tcku
			);
			
		}
		http_response_code(200);
		echo json_encode($dataku);
	}
	
	function tc_instore(){		
		$term_condition = $this->Api_m->get_key_val();
		$tc = isset($term_condition['tc_instore']) ? $term_condition['tc_instore'] : '';
		$tcku = array();
		$dataku = array();
		if(!empty($tc)){
			$tc = preg_replace("/<p[^>]*?>/", "", $tc);
			$tc = str_replace("</p>", "", $tc);
			//$tc = str_replace("\r\n","<br />",$tc);
			// $tcku = [
					// 'term_condition' 	=> $tc		
			// ];
			$dataku = array(				
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $tc	
			);
			
		}else{
			$dataku = array(				
                'err_code' => '04',
                'err_msg' => 'Data not be found',
				'data' 	=> $tcku
			);
			
		}
		http_response_code(200);
		echo json_encode($dataku);
	}
	
	function policy(){		
		$policy = $this->Api_m->get_key_val();
		$p = isset($policy['policy']) ? $policy['policy'] : '';
		$tc = array();
		$dataku = array();
		if(!empty($p)){
			$p = preg_replace("/<p[^>]*?>/", "", $p);
			$p = str_replace("</p>", "", $p);
			//$p = str_replace("\r\n","<br />",$p);
			$tc = [
					'policy' 	=> $p		
			];
			$dataku = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',				
				'data' 		=> $p	
			);
			
		}else{
			$dataku = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
		}
		http_response_code(200);
		echo json_encode($dataku);
	}
	
	function about_us(){		
		$policy = $this->Api_m->get_key_val();
		$p = isset($policy['about_us']) ? $policy['about_us'] : '';
		$tc = array();
		$dataku = array();
		if(!empty($p)){
			$p = preg_replace("/<p[^>]*?>/", "", $p);
			$p = str_replace("</p>", "", $p);
			//$p = str_replace("\r\n","<br />",$p);
			$tc = [
					'policy' 	=> $p		
			];
			$dataku = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',				
				'data' 		=> $p	
			);
			
		}else{
			$dataku = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
		}
		http_response_code(200);
		echo json_encode($dataku);
	}
	
	function contact_us(){		
		$policy = $this->Api_m->get_key_val();
		$p = isset($policy['contact_us']) ? $policy['contact_us'] : '';
		$tc = array();
		$dataku = array();
		if(!empty($p)){
			$p = preg_replace("/<p[^>]*?>/", "", $p);
			$p = str_replace("</p>", "", $p);
			//$p = str_replace("\r\n","<br />",$p);
			$tc = [
					'policy' 	=> $p		
			];
			$dataku = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',				
				'data' 		=> $p	
			);
			
		}else{
			$dataku = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
		}
		http_response_code(200);
		echo json_encode($dataku);
	}
	
	function faq(){		
		$faq = $this->access->readtable('faq','',array('deleted_at'=>null))->result_array();
		$dt = array();
		$result = array();
		$answer = '';
		$question = '';
		if(!empty($faq)){
			foreach($faq as $f){
				$answer = preg_replace("/<p[^>]*?>/", "", $f['answer']);
				$answer = str_replace("</p>", "", $answer);
				//$answer = str_replace("\r\n","<br />",$answer);
				$question = preg_replace("/<p[^>]*?>/", "", $f['question']);
				$question = str_replace("</p>", "", $question);
				//$question = str_replace("\r\n","<br />",$question);
				$dt[] = array(
					"id_faq"		=> $f['id_faq'],
					"question"		=> $question,
					"answer"		=> $answer
				);
			}
		}
		
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }
	}
	
	function get_category(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$keyword = isset($param['keyword']) ? $param['keyword'] : '';
		$tipe = isset($param['tipe']) ? (int)$param['tipe'] : '';
		$_like = array();
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			$_like = array('kategori.nama_kategori'=>$keyword);
		}
		$sort = array('kategori.nama_kategori','ASC');
		$where = array('kategori.deleted_at'=>null,'tipe'=>$tipe);
		$kategori = $this->access->readtable('kategori','',$where,'','',$sort,'','',$_like)->result_array();
		$dt = array();
		if(!empty($kategori)){
			foreach($kategori as $k){				
				if($k['nama_kategori'] != 'Banner'){
					$dt[] = array(
						"id_kategori"	=> $k['id_kategori'],
						"nama_kategori"	=> $k['nama_kategori'],
						"img"			=> !empty($k['img']) ? base_url('uploads/kategori/'.$k['img']) : null,
					);
				}
			}
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }
	}
	
	function get_type(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$keyword = isset($param['keyword']) ? $param['keyword'] : '';
		$id_kategori = isset($param['id_kategori']) ? (int)$param['id_kategori'] : '';
		$_like = array();
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			$_like = array('sub_kategori.nama_sub'=>$keyword);
		}
		$sort = array('ABS(priority)','ASC');
		$selects = array('id_sub','nama_sub','img','priority');
		$where = array('sub_kategori.deleted_at'=>null,'id_kategori'=>$id_kategori);
		$kategori = $this->access->readtable('sub_kategori',$selects,$where,'','',$sort,'','',$_like)->result_array();
		$dt = array();
		if(!empty($kategori)){
			foreach($kategori as $k){				
				if($k['nama_sub'] != 'Banner'){
					$dt[] = array(
						"id_type"		=> $k['id_sub'],
						"nama_type"		=> $k['nama_sub'],
						"priority"		=> (int)$k['priority'],
						"img"			=> !empty($k['img']) ? base_url('uploads/sub_kategori/'.$k['img']) : null,
					);
				}
			}
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }
	}
	
	function get_store(){
		$dt = array();
		$param = $this->input->post();
		$id_city = isset($param['id_city']) ? (int)$param['id_city'] : '';
		$where = array();
		$where = array('store.deleted_at'=>null);
		if($id_city > 0) $where += array('store.id_city'=>$id_city);
		$store = $this->access->readtable('store','',$where,array('city' => 'city.id_city = store.id_city','provinsi' => 'provinsi.id_provinsi = store.id_provinsi'),'','','LEFT')->result_array();		
		if(!empty($store)){
			foreach($store as $p){
				
				$dt[] = array(
					'id_store'	=> $p['id_op'],						
					'nama'	=> $p['nama'],						
					'alamat'	=> $p['deskripsi'],						
					'longitude'	=> $p['longitude'],						
					'latitude'	=> $p['latitude'],						
					'id_provinsi'	=> $p['id_provinsi'],						
					'nama_provinsi'	=> $p['nama_provinsi'],						
					'id_city'	=> $p['id_city'],						
					'nama_kota'	=> $p['nama_city']
				);
			}			
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }
	}
	
	function store_detail(){
		$dt = array();
		$param = $this->input->post();
		$id_store = isset($param['id_store']) ? (int)$param['id_store'] : '';
		$where = array();
		$where = array('store.deleted_at'=>null,'store.id_op'=>$id_store);
		
		$store = $this->access->readtable('store','',$where,array('city' => 'city.id_city = store.id_city','provinsi' => 'provinsi.id_provinsi = store.id_provinsi'),'','','LEFT')->row();		
		if(!empty($store)){
			$dt = array(
				'id_store'	=> $store->id_op,						
				'nama'		=> $store->nama,						
				'alamat'	=> $store->deskripsi,						
				'longitude'	=> $store->longitude,						
				'latitude'	=> $store->latitude,						
				'id_provinsi'	=> $store->id_provinsi,						
				'provinsi'	=> $store->nama_provinsi,						
				'id_city'	=> $store->id_city,						
				'nama_kota'	=> $store->nama_city
			);		
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }
	}
	
	function get_city(){
		$dt = array();
		$param = $this->input->post();
		$id_provinsi = isset($param['id_provinsi']) ? (int)$param['id_provinsi'] : 0;
		$where = array();
		$where = array('deleted_at'=>null);
		$provinsi = '';
		if($id_provinsi > 0){
			$where += array('id_provinsi'=>$id_provinsi);
			$_prov = $this->access->readtable('provinsi','',array('deleted_at'=>null,'id_provinsi'=>$id_provinsi))->row();	
			$provinsi = $_prov->nama_provinsi;
		}
		$city = $this->access->readtable('city','',$where)->result_array();	
		
		if(!empty($city)){
			foreach($city as $p){
				
				$dt[] = array(
					'id_provinsi'	=> $p['id_provinsi'],						
					// 'nama_provinsi'	=> $provinsi,						
					'id_city'	=> $p['id_city'],						
					'nama_kota'	=> $p['nama_city']
				);
			}			
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }
	}
	
	function get_provinsi(){
		$dt = array();	
		$_prov = $this->access->readtable('provinsi','',array('deleted_at'=>null))->result_array();		
		if(!empty($_prov)){
			foreach($_prov as $p){
				
				$dt[] = array(
					'id_provinsi'	=> $p['id_provinsi'],						
					'nama_provinsi'	=> $p['nama_provinsi']
				);
			}			
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }
	}
	
	function get_kec(){
		$dt = array();
		$param = $this->input->post();
		$id_city = isset($param['id_city']) ? (int)$param['id_city'] : 0;
		$where = array();
		$where = array('deleted_at'=>null);
		
		if($id_city > 0){
			$where += array('id_city'=>$id_city);			
		}
		$city = $this->access->readtable('kecamatan','',$where)->result_array();		
		if(!empty($city)){
			foreach($city as $p){
				
				$dt[] = array(
					'id_city'	=> $p['id_city'],						
										
					'id_kec'	=> $p['id_kec'],						
					'nama_kec'	=> $p['nama_kec']
				);
			}			
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> null	
			);
            http_response_code(200);
			echo json_encode($result);
        }
	}
	
	function get_kel(){
		$dt = array();
		$param = $this->input->post();
		$id_kec = isset($param['id_kec']) ? (int)$param['id_kec'] : 0;
		$where = array();
		$where = array('deleted_at'=>null);
		
		if($id_kec > 0){
			$where += array('id_kec'=>$id_kec);			
		}
		$city = $this->access->readtable('kelurahan','',$where)->result_array();		
		if(!empty($city)){
			foreach($city as $p){
				
				$dt[] = array(
					'id_kec'	=> $p['id_kec'],							
					'id_kel'	=> $p['id_kelurahan'],						
					'nama_kel'	=> $p['nama_kel'],
					'kode_pos'	=> $p['kode_pos']
				);
			}			
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> null	
			);
            http_response_code(200);
			echo json_encode($result);
        }
	}
	
	public function banner_forum(){       
		$_banner = '';
		$_banner = $this->access->readtable('banner','',array('deleted_at'=>null,'tipe'=>2))->result_array();	
		$dt = array();
		$path = '';
		$dataku = array();		
		if(!empty($_banner)){
			foreach($_banner as $k){
				$path = !empty($k['img']) ? base_url('uploads/banner/'.$k['img']) : null;
				$dt[] = array(
					'id_banner'		=> $k['id_banner'],						
					'title'			=> $k['title'],						
					'description'	=> $k['ket'],						
					'image'			=> $path
				);
			}
			
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }		
		
    }
	
	public function banner_tutorial(){       
		$_banner = '';
		$_banner = $this->access->readtable('banner','',array('deleted_at'=>null,'tipe'=>1))->result_array();	
		$dt = array();
		$path = '';
		$dataku = array();		
		if(!empty($_banner)){
			foreach($_banner as $k){
				$path = !empty($k['img']) ? base_url('uploads/banner/'.$k['img']) : null;
				$dt[] = array(
					'id_banner'		=> $k['id_banner'],	
					'title'			=> $k['title'],						
					'description'	=> $k['ket'],		
					'image'			=> $path
				);
			}
			
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }		
		
    }
	
	public function banner_keuntungan(){       
		$_banner = '';
		$_banner = $this->access->readtable('banner','',array('deleted_at'=>null,'tipe'=>3))->result_array();	
		$dt = array();
		$path = '';
		$dataku = array();		
		if(!empty($_banner)){
			foreach($_banner as $k){
				$path = !empty($k['img']) ? base_url('uploads/banner/'.$k['img']) : null;
				$dt[] = array(
					'id_banner'		=> $k['id_banner'],	
					'title'			=> $k['title'],						
					'description'	=> $k['ket'],		
					'image'			=> $path
				);
			}
			
		}
		if (!empty($dt)){
			$result = array(
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $dt	
			);
            http_response_code(200);
			echo json_encode($result);
        }else{
            $result = array(
				'err_code' 	=> '04',
				'err_msg' 	=> 'Data not be found',
				'data' 		=> ''	
			);
            http_response_code(200);
			echo json_encode($result);
        }		
		
    }
	
	function get_master_kerusakan(){
		$param = $this->input->post();
		$device_cat = isset($param['device_cat']) ? (int)$param['device_cat'] : 0;
		$device_type = isset($param['device_type']) ? (int)$param['device_type'] : 0;
		$where = array();
		$where = array('master_kerusakan.deleted_at'=>null);
		if($device_cat > 0) $where += array('master_kerusakan.device_cat'=>$device_cat);
		if($device_type > 0) $where += array('master_kerusakan.device_type'=>$device_type);
		$selects = array('master_kerusakan.*','kategori.nama_kategori','sub_kategori.nama_sub');
		$m_kerusakan = $this->access->readtable('master_kerusakan',$selects,$where,array('kategori' => 'kategori.id_kategori = master_kerusakan.device_cat','sub_kategori' => 'sub_kategori.id_sub = master_kerusakan.device_type'),'','','LEFT')->result_array();
		if(!empty($m_kerusakan)){
			foreach($m_kerusakan as $mk){
				$varian = '';
				$_v = array();
				if(!empty($mk['varian'])){
					$varian = $mk['varian'];
					$_v = explode(',',$varian);
				}
				$dt[] = array(
					'id'			=> $mk['id'],
					'device_cat'	=> $mk['device_cat'],
					'device_type'	=> $mk['device_type'],
					'nama'			=> $mk['nama_sp'],
					'nama_kategori'	=> $mk['nama_kategori'],
					'nama_sub'		=> $mk['nama_sub'],
					'harga'			=> $mk['harga'],
					'varian'		=> !empty($varian) ? $_v : '',
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
				'data' 		=> ''	
			);
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	public function master_akun_bank(){
		$_banner = '';
		$_banner = $this->access->readtable('master_akun_bank','',array('deleted_at'=>null))->result_array();		
		$dt = array();
		$result = array();		
		if(!empty($_banner)){
			foreach($_banner as $k){
				
				$dt[] = array(
					'id_bank'		=> $k['id_bank'],						
					'nama_bank'		=> $k['nama_bank'],
					'holder_name'	=> $k['holder_name'],
					'no_rek'		=> $k['no_rek']	
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

	public function area_layanan(){
		$_banner = '';
		$_banner = $this->access->readtable('area_layanan','',array('area_layanan.deleted_at'=>null),array('store' => 'store.id_op = area_layanan.id_store'),'','','LEFT')->result_array();		
		$dt = array();
		$result = array();		
		if(!empty($_banner)){
			foreach($_banner as $k){
				
				$dt[] = array(
					'id_area'		=> $k['id_area'],						
					'nama_area'		=> $k['nama_area'],
					'id_store'		=> $k['id_store'],
					'nama_store'	=> $k['nama']	
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
	
	function get_biaya_layanan(){		
		$term_condition = $this->Api_m->get_key_val();
		$biaya_pickup_device = isset($term_condition['biaya_pickup_device']) ? str_replace('.','',$term_condition['biaya_pickup_device']) : '';
		$biaya_home_service = isset($term_condition['biaya_home_service']) ? str_replace('.','',$term_condition['biaya_home_service']) : '';
		$tc = array();
		
		if(!empty($biaya_pickup_device) || !empty($biaya_home_service)){
			$tc = array(
				'biaya_pickup_device'	=> str_replace(',','',$biaya_pickup_device),
				'biaya_home_service'	=> str_replace(',','',$biaya_home_service),
			);
			$dataku = array(				
				'err_code' 	=> '00',
				'err_msg' 	=> 'ok',
				'data' 		=> $tc	
			);
			
		}else{
			$dataku = array(				
                'err_code' => '04',
                'err_msg' => 'Data not be found',
				'data' 	=> null
			);
			
		}
		http_response_code(200);
		echo json_encode($dataku);
	}
}
