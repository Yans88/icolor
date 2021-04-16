<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Member extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		$this->load->library('converter');
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }
	
    function reg(){	
		$tgl = date('Y-m-d H:i:s');
		$login = '';
		$param = $this->input->post();
		$first_name = isset($param['first_name']) ? $param['first_name'] : '';
		$last_name = isset($param['last_name']) ? $param['last_name'] : '';		
		$email = isset($param['email']) ? strtolower($param['email']) : '';		
		$password = isset($param['password']) ? $param['password'] : '';		
		$phone_number = isset($param['phone_number']) ? $param['phone_number'] : '';		
		$fb_id = isset($param['fb_id']) ? $param['fb_id'] : '';		
		$apple_id = isset($param['apple_id']) ? $param['apple_id'] : '';		
		
		$login = '';
		$result = array();
		$id_customer = 0;
		if(empty($apple_id)){
			if(empty($first_name)){			
				$result = [
						'err_code'		=> '06',
						'err_msg'		=> 'first_name require'
					];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
			if(empty($email)){			
				$result = [
						'err_code'		=> '06',
						'err_msg'		=> 'email require'
					];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {			
				$result = [
						'err_code'		=> '05',
						'err_msg'		=> 'email invalid format'
					];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
			if(empty($password)){			
				$result = [
						'err_code'		=> '06',
						'err_msg'		=> 'password require'
					];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
			
			if(empty($phone_number)){			
				$result = [
						'err_code'		=> '06',
						'err_msg'		=> 'phone_number require'
					];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
			$ptn = "/^0/";
			$rpltxt = "62";
			$phone_number = preg_replace($ptn, $rpltxt, $phone_number);	
			$login = '';
			$login = $this->access->readtable('customer','',array('phone'=>$phone_number))->row();
			$id_customer =  0;
			$id_customer =  (int)$login->id_customer;
			if($id_customer > 0){			
				$result = [
						'err_code'		=> '07',
						'err_msg'		=> 'phone_number already exist'
					];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
			$login = '';
			$login = $this->access->readtable('customer','',array('email'=>$email))->row();
			$id_customer =  0;
			$id_customer = (int)$login->id_customer;
			if($id_customer > 0){			
				$result = [
						'err_code'		=> '07',
						'err_msg'		=> 'email already exist'
					];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
		}else{
			$login = '';
			$first_name = '';
			$last_name = '';
			$email = '';
			$phone_number = '';
			$password = '';
			$fb_id = '';
			$where = array();
			$where = array('apple_id'=>$apple_id);		
			$login = $this->access->readtable('customer','',$where)->row();
			$id_customer =  (int)$login->id_customer;
			if($id_customer > 0){			
				$result = [
						'err_code'		=> '07',
						'err_msg'		=> 'apple_id already exist'
					];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
		}
		
		
		$dt_simpan = array();
		$dt_simpan = array(				
				'nama'			=> $first_name,
				'last_name'		=> $last_name,
				'email'			=> $email,
				'phone'			=> $phone_number,				
				'pass'			=> !empty($password) ? md5($password) : '',
				'_pass'			=> !empty($password) ? $this->converter->encode($password) : '',			
				'verify_email'	=> 0,				
				'fb_id'			=> $fb_id,				
				'apple_id'		=> $apple_id,				
				'created_at'	=> $tgl
			);
		
		$save = 0;
		$id = '';
		$content_member = '';
		$save = $this->access->inserttable('customer', $dt_simpan);	
		if($save){
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}
	
			$this->load->library('send_notif');
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $email;
			$subject = $out['subj_email_register'];
			$content_member = $out['content_verifyReg'];
			$content = str_replace('[#name#]', $first_name, $content_member);
			$id = $this->converter->encode($save);
			$link = VERIFY_REGISTER_LINK.'='.$id;
			$href = '<a href="'.$link.'">'.$link.'</a>';
			$content = str_replace('[#verify_link#]', $href, $content);
			$this->send_notif->send_email($from,$pass, $to,$subject, $content);
			$dt_simpan +=array('id_member'=>$save, 'link_verify_email'=>$link);
		}
		$result = [
					'err_code'	=> '00',
					'err_msg'	=> 'ok',
					'data'		=> $dt_simpan,
				];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function send_verify_email(){		
		$link = '';
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		if(empty($id_member)){			
			$result = [
					'err_code'		=> '06',
					'err_msg'		=> 'id_member require'
				];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$login = $this->access->readtable('customer','',array('id_customer'=>$id_member,'verify_email'=>0))->row();
		$id_customer =  (int)$login->id_customer;
		if($id_customer > 0){
			//$id = $login->id_customer;
			$nama_member = $login->nama;
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}
	
			$this->load->library('send_notif');
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $email;
			$subject = $out['subj_email_register'];
			$content_member = $out['content_verifyReg'];
			$content = str_replace('[#name#]', $nama_member, $content_member);
			$id = $this->converter->encode($id_customer);
			$link = VERIFY_REGISTER_LINK.'='.$id;
			$href = '<a href="'.$link.'">'.$link.'</a>';
			$content = str_replace('[#verify_link#]', $href, $content);
			$send = $this->send_notif->send_email($from,$pass, $to,$subject, $content);
			error_log(serialize($send));
			$result = [
					'err_code'	=> '00',
					'err_msg'	=> 'Akun kamu sedang diverifikasi, harap cek email!',
					'data'		=> array('link_verify_email'=>$link),
				];
		}else{
			$result = [
					'err_code'	=> '04',
					'err_msg'	=> 'data not found'
				];
		}
		http_response_code(200);
		echo json_encode($result);
	}	
	
	function login(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$pass = isset($param['password']) && !empty($param['password']) ? md5($param['password']) : '';		
		$phone_numberku = isset($param['phone_number']) ? $param['phone_number'] : '';
		if(empty($pass)){			
			$result = [
					'err_code'		=> '06',
					'err_msg'		=> 'password require'
				];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$login = '';
		$ptn = "/^0/";
		$rpltxt = "62";
		$phone_number = preg_replace($ptn, $rpltxt, $phone_numberku);	
		$where = array();
		$where = array('phone'=>$phone_number,'pass'=>$pass);		
		$login = $this->access->readtable('customer','',$where)->row();		
		if(empty($login)){
			$login = '';
			$where = array();
			$where = array('email'=>$phone_numberku,'pass'=>$pass);		
			$login = $this->access->readtable('customer','',$where)->row();
		}
		$id_customer =  (int)$login->id_customer;
		$dt_cust = array();
		$result = array();		
		if($id_customer > 0){
			$photo = !empty($login->photo) ? base_url('uploads/members/'.$login->photo) : null;
			$dt_cust = array(
					'id_member'		=> $id_customer,
					'nama'			=> $login->nama,
					'last_name'		=> $login->last_name,
					'email'			=> $login->email,
					'phone'			=> $login->phone,
					'dob'			=> $login->dob,
					'point'			=> $login->point,
					'id_kota'		=> $login->id_city,
					'alamat'		=> $login->alamat,
					'photo'			=> $photo,
					'password'		=> $this->converter->encode($login->_pass),
					'kota'			=> '',
					'apple_id'			=> $login->apple_id,					
					'fb_id'			=> $login->fb_id,					
					'first_login'			=> !empty($login->first_login) ? 1 : 0,					
					'completed_profile'			=> !empty($login->completed_profile) ? 1 : 0,					
					'completed_address'			=> !empty($login->completed_address) ? 1 : 0,					
					'first_simulasi'		=> !empty($login->first_simulasi) ? 1 : 0,					
					'first_komen_forum'		=> (int)$login->first_komen_forum,					
					'first_komen_tutor'		=> (int)$login->first_komen_tutor,					
					'verify_email'	=> $login->verify_email				
				);
				$result = [
					'err_code'	=> '00',
					'err_msg'	=> 'ok',
					'data'		=> $dt_cust
				];
		}else{
			$result = [
					'err_code'	=> '06',
					'err_msg'	=> 'login invalid'
				];
		}
		http_response_code(200);
		echo json_encode($result);		
	}
	
	function profile(){
		$tgl = date('Y-m-d');
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$select = array('customer.*','city.nama_city');
		$login = $this->access->readtable('customer','',array('id_customer'=>$id_member),array('city' => 'city.id_city = customer.id_city'),'','','LEFT')->row();
		$id_customer =  (int)$login->id_customer;		
		$dt_cust = array();
		$result = array();		
		if($id_customer > 0){
			$photo = !empty($login->photo) ? base_url('uploads/members/'.$login->photo) : null;
			$first_login = !empty($login->first_login) ? 1 : 0;
			$completed_profile = !empty($login->completed_profile) ? 1 : 0;
			$point = (int)$login->point;
			$reward_point = 0;
			if($first_login == 0){
				$this->load->model('Setting_point_m');
				$setting_point = $this->Setting_point_m->get_key_val();
				$reward_point = str_replace('.','',$setting_point['first_login']);
				$reward_point = str_replace(',','',$reward_point);
				$reward_point = (int)$reward_point;
				$point = (int)$login->point + $reward_point;
				$simpan_history = array();
				$simpan_history = array(
					"id_member"			=> $id_member,
					"tgl"				=> date('Y-m-d H:i:s'),
					"id_tr"				=> date('Y-m-d H:i:s'),
					"type"				=> 1,
					"description"		=> "Add Points First Login",
					"nilai"				=> $reward_point
				);				
				$upd = array();
				$upd = array('point'=>$point,'first_login'=>date('Y-m-d H:i:s'));
				$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
				$this->access->inserttable("point_history",$simpan_history);
			}
			if($completed_profile == 0){
				$this->complete_profile($id_member);
				$login = $this->access->readtable('customer','',array('id_customer'=>$id_member),array('city' => 'city.id_city = customer.id_city'),'','','LEFT')->row();
			}
			$dt_cust = array(
					'id_member'		=> $id_customer,
					'nama'			=> $login->nama,
					'last_name'		=> $login->last_name,
					'pass'			=> $login->last_name,
					'email'			=> $login->email,
					'phone'			=> $login->phone,
					'dob'			=> $login->dob,
					'gender'		=> $login->jk,
					'point'			=> $point,
					'id_kota'		=> $login->id_city,
					'kota'			=> $login->nama_city,
					'alamat'		=> $login->alamat,
					'photo'			=> $photo,
					'password'		=> $this->converter->encode($login->_pass),
					'kota'			=> '',
					'fb_id'			=> $login->fb_id,	
					'apple_id'			=> $login->apple_id,	
					'first_login'			=> !empty($login->first_login) ? 1 : 0,	
					'completed_profile'			=> !empty($login->completed_profile) ? 1 : 0,					
					'completed_address'			=> !empty($login->completed_address) ? 1 : 0,
					'first_simulasi'		=> !empty($login->first_simulasi) ? 1 : 0,					
					'first_komen_forum'		=> (int)$login->first_komen_forum,					
					'first_komen_tutor'		=> (int)$login->first_komen_tutor,
					'verify_email'	=> $login->verify_email,
					'get_point'		=> $reward_point,	
			);
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt_cust
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Data not found'
			];
		}
		
		http_response_code(200);
		echo json_encode($result);	
	}
	
	function login_fb(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();	
		$fb_id = isset($param['fb_id']) ? $param['fb_id'] : '';
		if(empty($fb_id)){			
			$result = [
					'err_code'		=> '06',
					'err_msg'		=> 'fb_id require'
				];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$login = '';
		$where = array();
		$where = array('fb_id'=>$fb_id);		
		$login = $this->access->readtable('customer','',$where)->row();
		$id_customer =  (int)$login->id_customer;
		$dt_cust = array();
		$result = array();		
		if($id_customer > 0){
			$photo = !empty($login->photo) ? base_url('uploads/members/'.$login->photo) : null;
			$dt_cust = array(
					'id_member'		=> $id_customer,
					'nama'			=> $login->nama,
					'last_name'		=> $login->last_name,
					'email'			=> $login->email,
					'phone'			=> $login->phone,
					'dob'			=> $login->dob,
					'point'			=> $login->point,
					'id_kota'		=> $login->id_city,
					'alamat'		=> $login->alamat,
					'photo'			=> $login->img,
					'password'		=> $this->converter->decode($login->_pass),
					'kota'			=> '',
					'apple_id'			=> $login->apple_id,	
					'fb_id'			=> $login->fb_id,	
					'first_login'			=> !empty($login->first_login) ? 1 : 0,	
					'completed_profile'			=> !empty($login->completed_profile) ? 1 : 0,					
					'completed_address'			=> !empty($login->completed_address) ? 1 : 0,
					'first_simulasi'		=> !empty($login->first_simulasi) ? 1 : 0,					
					'first_komen_forum'		=> (int)$login->first_komen_forum,					
					'first_komen_tutor'		=> (int)$login->first_komen_tutor,
					'verify_email'	=> $login->verify_email				
				);
				$result = [
					'err_code'	=> '00',
					'err_msg'	=> 'ok',
					'data'		=> $dt_cust
				];
		}else{
			$result = [
					'err_code'	=> '06',
					'err_msg'	=> 'login invalid'
				];
		}
		http_response_code(200);
		echo json_encode($result);		
	}
	
	function login_apple(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();	
		$apple_id = isset($param['apple_id']) ? $param['apple_id'] : '';
		if(empty($apple_id)){			
			$result = [
					'err_code'		=> '06',
					'err_msg'		=> 'apple_id require'
				];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$login = '';
		$where = array();
		$where = array('apple_id'=>$apple_id);		
		$login = $this->access->readtable('customer','',$where)->row();
		$id_customer =  (int)$login->id_customer;
		$dt_cust = array();
		$result = array();		
		if($id_customer > 0){
			$photo = !empty($login->photo) ? base_url('uploads/members/'.$login->photo) : null;
			$dt_cust = array(
					'id_member'		=> $id_customer,
					'nama'			=> $login->nama,
					'last_name'		=> $login->last_name,
					'email'			=> $login->email,
					'phone'			=> $login->phone,
					'dob'			=> $login->dob,
					'point'			=> $login->point,
					'id_kota'		=> $login->id_city,
					'alamat'		=> $login->alamat,
					'photo'			=> $login->img,
					'password'		=> $this->converter->decode($login->_pass),
					'kota'			=> '',
					'apple_id'			=> $login->apple_id,	
					'first_login'			=> !empty($login->first_login) ? 1 : 0,	
					'completed_profile'			=> !empty($login->completed_profile) ? 1 : 0,					
					'completed_address'			=> !empty($login->completed_address) ? 1 : 0,
					'first_simulasi'		=> !empty($login->first_simulasi) ? 1 : 0,					
					'first_komen_forum'		=> (int)$login->first_komen_forum,					
					'first_komen_tutor'		=> (int)$login->first_komen_tutor,
					'verify_email'	=> $login->verify_email				
				);
				$result = [
					'err_code'	=> '00',
					'err_msg'	=> 'ok',
					'data'		=> $dt_cust
				];
		}else{
			$result = [
					'err_code'	=> '06',
					'err_msg'	=> 'login invalid'
				];
		}
		http_response_code(200);
		echo json_encode($result);		
	}
	
	function login_gmail(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();			
		$email = isset($param['email']) ? $param['email'] : '';
		if(empty($email)){			
			$result = [
					'err_code'		=> '06',
					'err_msg'		=> 'email require'
				];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result = [
				'err_code'	=> '02',
				'err_msg'	=> 'email invalid format'
			];
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}
		$login = '';
		$where = array();
		$where = array('email'=>$email);		
		$login = $this->access->readtable('customer','',$where)->row();
		$id_customer =  (int)$login->id_customer;
		$dt_cust = array();
		$result = array();		
		if($id_customer > 0){
			$photo = !empty($login->photo) ? base_url('uploads/members/'.$login->photo) : null;
			$dt_cust = array(
					'id_member'		=> $id_customer,
					'nama'			=> $login->nama,
					'last_name'		=> $login->last_name,
					'email'			=> $login->email,
					'phone'			=> $login->phone,
					'dob'			=> $login->dob,
					'id_kota'		=> $login->id_city,
					'alamat'		=> $login->alamat,
					'photo'			=> $photo,
					'password'		=> $this->converter->encode($login->_pass),
					'kota'			=> '',
					'fb_id'			=> $login->fb_id,	
					'first_login'			=> !empty($login->first_login) ? 1 : 0,	
					'completed_profile'			=> !empty($login->completed_profile) ? 1 : 0,					
					'completed_address'			=> !empty($login->completed_address) ? 1 : 0,
					'first_simulasi'		=> !empty($login->first_simulasi) ? 1 : 0,					
					'first_komen_forum'		=> (int)$login->first_komen_forum,					
					'first_komen_tutor'		=> (int)$login->first_komen_tutor,
					'verify_email'	=> $login->verify_email				
				);
				$result = [
					'err_code'	=> '00',
					'err_msg'	=> 'ok',
					'data'		=> $dt_cust
				];
		}else{
			$result = [
					'err_code'	=> '06',
					'err_msg'	=> 'login invalid'
				];
		}
		http_response_code(200);
		echo json_encode($result);		
	}
	
	
	function edit(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$first_name = isset($param['first_name']) ? $param['first_name'] : '';
		$last_name = isset($param['last_name']) ? $param['last_name'] : '';		
		$password = isset($param['password']) ? $param['password'] : '';				
		$id_city = isset($param['id_city']) ? (int)$param['id_city'] : 0;				
		$gender = isset($param['gender']) ? (int)$param['gender'] : 0;				
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';				
		$dob = isset($param['dob']) && !empty($param['dob']) ? new DateTime($param['dob']) : '';
		$dob = !empty($dob) ? $dob->format('Y-m-d') : '';
		if($id_member == 0){
			$result = [
				'err_code'	=> '07',
				'err_msg'	=> 'id_member require'
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}		
		$_login = '';
		$id_customer = 0;
		$dt_simpan = array();
		$dt_simpan = array(
				'nama'			=> $first_name,
				'last_name'		=> $last_name,
				'dob'			=> $dob,
				'jk'			=> $gender,
				'id_city'		=> $id_city,
				'alamat'			=> $alamat
			);
		if(!empty($password))$dt_simpan += array('pass' => md5($password),'_pass' => $this->converter->encode($password));		
		$config['upload_path'] = "./uploads/members/";
		$config['allowed_types'] = "jpg|png|jpeg|";
		$config['max_size']	= '2048';
		
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload',$config);
		$upl = '';
		
		if(!empty($_FILES['photo'])){
			$upl = '';
			if($this->upload->do_upload('photo')){
				$upl = $this->upload->data();
				$dt_simpan += array("photo"	=> $upl['file_name']);
			}
		}
		$this->access->updatetable('customer',$dt_simpan, array("id_customer" => $id_member));
		
		$result = [
			'err_code'	=> '00',
			'err_msg'	=> 'Profile updated.',
			'data'		=> $dt_simpan
		];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function forgot_pass(){
		$result = array();
		$nama = '';
		$new_pass = '';
		$save = '';
		$param = $this->input->post();
		$email = isset($param['email']) ? $param['email'] : '';

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result = [
				'err_code'	=> '06',
				'err_msg'	=> 'Email invalid format'
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$chk_email = $this->access->readtable('customer','',array('email'=>$email,'deleted_at'=>null))->row();
		$ketemu = !empty($chk_email) ? (int)$chk_email->id_customer : 0;
		$verify_email = (int)$chk_email->verify_email > 0 ? 1 : 0;
		if((int)$ketemu <= 0){
			$result = [
				'err_code'	=> '07',
				'err_msg'	=> 'Email Not Registered'
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		if((int)$verify_email <= 0){
			$result = [
				'err_code'	=> '08',
				'err_msg'	=> 'Email belum diverifikasi'
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		if($ketemu > 0){
			$_tgl = date("YmdHis");
			$numerics = '0123456789'.$_tgl;			
			$new_pass = substr(str_shuffle($numerics), 0, 8);			
			$data = array("pass"=>md5($new_pass),"_pass" => $this->converter->encode($new_pass));
			$this->access->updatetable('customer',$data, array("id_customer" => $chk_email->id_customer));
			$save = $email;
		}

		if($save == $email){
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}

			$nama = $chk_email->nama.' '.$chk_email->last_name;
			$this->load->library('send_notif');
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $email;
			$subject = "Reset Password";
			$content_member = $out['content_forgotPin'];

			$content = str_replace('[#name#]', $nama, $content_member);
			$content = str_replace('[#new_pass#]', $new_pass, $content);
			$content = str_replace('[#email#]', $email, $content);
			$send = $this->send_notif->send_email($from,$pass, $to,$subject, $content);
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK, New password was send to your email'
			];			
		}else{
			$result = [
				'err_code'	=> '05',
				'err_msg'	=> 'Insert has problem'
			];
		}
		http_response_code(200);
		echo json_encode($result);

	}
	
	function get_mydevice(){
		$param = $this->input->post();
		$id_customer = isset($param['id_member']) ? (int)$param['id_member'] : '';
		$select = array('my_device.imei','my_device.id','my_device.nama_device','my_device.device_cat','my_device.device_type','kategori.nama_kategori','kategori.img as img_device_cat','kategori.tipe','sub_kategori.nama_sub','sub_kategori.img as img_device_type');
		$my_device = $this->access->readtable('my_device',$select,array('id_cust'=>$id_customer,'my_device.deleted_at'=>null),array('kategori' => 'kategori.id_kategori = my_device.device_cat', 'sub_kategori' => 'sub_kategori.id_sub = my_device.device_type'),'','','LEFT')->result_array();
		$dt_device = array();
		if(!empty($my_device)){
			foreach($my_device as $md){
				$dt_device[] = array(
					'id_device' 		=> $md['id'],
					'imei' 				=> $md['imei'],
					'nama_device' 		=> $md['nama_device'],
					'device_cat' 		=> $md['device_cat'],
					'device_type' 		=> $md['device_type'],
					'tipe' 				=> $md['tipe'],
					'device_cat_name' 	=> $md['nama_kategori'],
					'device_type_name' 	=> $md['nama_sub'],
					'img_device_cat' 	=> !empty($md['img_device_cat']) ? base_url('uploads/kategori/'.$md['img_device_cat']) : null,
					'img_device_type' 	=> !empty($md['img_device_type']) ? base_url('uploads/sub_kategori/'.$md['img_device_type']) : null,
					'condition' 		=> $md['kondisi'],
				);
			}
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt_device,
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'data not found',
				'data'		=> null,
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function mydevice_detail(){
		$param = $this->input->post();
		$id_device = isset($param['id_device']) ? (int)$param['id_device'] : '';
		$select = array('my_device.imei','my_device.id','my_device.nama_device','my_device.device_cat','my_device.device_type','kategori.nama_kategori','kategori.img as img_device_cat','kategori.tipe','sub_kategori.nama_sub','sub_kategori.img as img_device_type');
		$my_device = $this->access->readtable('my_device',$select,array('id'=>$id_device,'my_device.deleted_at'=>null),array('kategori' => 'kategori.id_kategori = my_device.device_cat', 'sub_kategori' => 'sub_kategori.id_sub = my_device.device_type'),'','','LEFT')->row();
		$dt_device = array();
		if(!empty($my_device)){
			$dt_device = array(
				'id_device' 		=> $my_device->id,
				'imei' 				=> $my_device->imei,
				'nama_device' 		=> $my_device->nama_device,
				'device_cat' 		=> $my_device->device_cat,
				'device_type' 		=> $my_device->device_type,
				'tipe' 				=> $my_device->tipe,
				'nama_kategori' 	=> $my_device->nama_kategori,
				'nama_sub' 			=> $my_device->nama_sub,				
				'img_device_cat' 	=> !empty($my_device->img_device_cat) ? base_url('uploads/kategori/'.$my_device->img_device_cat) : null,
				'img_device_type' 	=> !empty($my_device->img_device_type) ? base_url('uploads/sub_kategori/'.$my_device->img_device_cat) : null,
				'condition' 		=> $my_device->kondisi,
				);
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt_device,
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'data not found',
				'data'		=> null,
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function add_mydevice(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_device = isset($param['id_device']) ? (int)$param['id_device'] : '';
		$id_customer = isset($param['id_member']) ? (int)$param['id_member'] : '';
		$device_cat = isset($param['device_cat']) ? (int)$param['device_cat'] : '';
		$device_type = isset($param['device_type']) ? (int)$param['device_type'] : '';
		$condition = isset($param['condition']) ? $param['condition'] : '';
		$nama_device = isset($param['nama_device']) ? $param['nama_device'] : '';
		$imei = isset($param['imei']) ? $param['imei'] : '';
		$simpan = array(
			'imei'			=> $imei,
			'nama_device'	=> $nama_device,
			'device_cat'	=> $device_cat,
			'device_type'	=> $device_type,
			'kondisi'		=> $condition,
		);
		$save = 0;
		if($id_device > 0){
			$this->access->updatetable('my_device',$simpan, array("id" => $id_device));
			$save = $id_device;
		}else{
			$simpan += array('created_at' => $tgl,'id_cust'=>$id_customer);
			$save = $this->access->inserttable('my_device', $simpan);	
		}
		if($save > 0){
			unset($simpan['id_cust']);
			$simpan += array('id_device' => $save);
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'Saved',
				'data'		=> $simpan
			];	
		}else{
			$result = [
				'err_code'	=> '05',
				'err_msg'	=> 'insert has problem'
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function add_myaddress(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_address = isset($param['id_address']) ? (int)$param['id_address'] : '';
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : '';
		$id_provinsi = isset($param['id_provinsi']) ? (int)$param['id_provinsi'] : '';
		$id_city = isset($param['id_city']) ? (int)$param['id_city'] : '';
		$id_kec = isset($param['id_kec']) ? (int)$param['id_kec'] : '';
		$id_kel = isset($param['id_kel']) ? (int)$param['id_kel'] : '';
		$kode_pos = isset($param['kode_pos']) ? (int)$param['kode_pos'] : '';
		$nama_alamat = isset($param['alamat']) ? $param['nama_alamat_pengiriman'] : '';
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';
		$simpan = array(			
			'id_provinsi'	=> $id_provinsi,
			'id_city'		=> $id_city,
			'id_kec'		=> $id_kec,
			'id_kel'		=> $id_kel,
			'kode_pos'		=> $kode_pos,
			'nama_alamat'	=> $nama_alamat,
			'alamat'		=> $alamat,
		);
		$save = 0;
		
		if($id_address > 0){
			$this->access->updatetable('my_address',$simpan, array("id" => $id_address));
			$save = $id_address;
		}else{
			$simpan += array('created_at' => $tgl,'id_cust'=>$id_member);
			$save = $this->access->inserttable('my_address', $simpan);
			$login = $this->access->readtable('customer','',array('id_customer'=>$id_member))->row();
			$completed_address = !empty($login->completed_address) ? 1 : 0;
			$point = (int)$login->point;
			$reward_point = 0;
			if($completed_address == 0){
				$this->load->model('Setting_point_m');
				$setting_point = $this->Setting_point_m->get_key_val();
				$reward_point = str_replace('.','',$setting_point['complete_address']);
				$reward_point = str_replace(',','',$reward_point);
				$reward_point = (int)$reward_point;
				$point = (int)$login->point + $reward_point;
				$simpan_history = array();
				$simpan_history = array(
					"id_member"			=> $id_member,
					"tgl"				=> date('Y-m-d H:i:s'),
					"id_tr"				=> date('Y-m-d H:i:s'),
					"type"				=> 1,
					"description"		=> "Completed Address",
					"nilai"				=> $reward_point
				);				
				$upd = array();
				$upd = array('point'=>$point,'completed_address'=>date('Y-m-d H:i:s'));
				$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
				$this->access->inserttable("point_history",$simpan_history);
			}
		}
		
		if($save > 0){
			unset($simpan['id_cust']);
			$simpan += array('id_address' => $save);
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'Saved',
				'data'		=> $simpan
			];	
		}else{
			$result = [
				'err_code'	=> '05',
				'err_msg'	=> 'insert has problem'
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_myaddress(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : '';
		$select = array('my_address.id','my_address.alamat','my_address.nama_alamat','my_address.id_provinsi','my_address.id_city','my_address.id_kec','my_address.id_kel','my_address.kode_pos','provinsi.nama_provinsi','city.nama_city','kelurahan.nama_kel','kecamatan.nama_kec');
		$my_address = $this->access->readtable('my_address',$select,array('my_address.id_cust'=>$id_member,'my_address.deleted_at'=>null),array('provinsi' => 'provinsi.id_provinsi = my_address.id_provinsi', 'city' => 'city.id_city = my_address.id_city','kecamatan' => 'kecamatan.id_kec = my_address.id_kec','kelurahan' => 'kelurahan.id_kelurahan = my_address.id_kel'),'','','LEFT')->result_array();
		$dt_device = array();
		if(!empty($my_address)){
			foreach($my_address as $md){
				$dt_device[] = array(
					'id_address' 		=> $md['id'],
					'id_provinsi' 		=> $md['id_provinsi'],
					'id_city' 			=> $md['id_city'],
					'id_kec' 			=> $md['id_kec'],
					'id_kel' 			=> $md['id_kel'],					
					'nama_alamat' 		=> $md['nama_alamat'],
					'alamat' 			=> $md['alamat'],
					'nama_provinsi' 	=> $md['nama_provinsi'],
					'nama_city' 		=> $md['nama_city'],
					'nama_kec' 			=> $md['nama_kec'],
					'nama_kel' 			=> $md['nama_kel'],
					'kode_pos' 			=> $md['kode_pos'],
						
				);
			}
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt_device,
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'data not found',
				'data'		=> null,
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function myaddress_detail(){
		$param = $this->input->post();
		$id_address = isset($param['id_address']) ? (int)$param['id_address'] : '';
		$select = array('my_address.id','my_address.alamat','my_address.nama_alamat','my_address.id_provinsi','my_address.id_city','my_address.id_kec','my_address.id_kel','my_address.kode_pos','provinsi.nama_provinsi','city.nama_city','kelurahan.nama_kel','kecamatan.nama_kec');
		$my_address = $this->access->readtable('my_address',$select,array('my_address.id'=>$id_address,'my_address.deleted_at'=>null),array('provinsi' => 'provinsi.id_provinsi = my_address.id_provinsi', 'city' => 'city.id_city = my_address.id_city','kecamatan' => 'kecamatan.id_kec = my_address.id_kec','kelurahan' => 'kelurahan.id_kelurahan = my_address.id_kel'),'','','LEFT')->row();
		$dt_device = array();
		if(!empty($my_address)){
			$dt_device = array(
				'id_address' 		=> $my_address->id,
				'id_provinsi' 		=> $my_address->id_provinsi,
				'id_city' 			=> $my_address->id_city,
				'id_kec' 			=> $my_address->id_kec,
				'id_kel' 			=> $my_address->id_kel,
				'nama_alamat' 		=> $my_address->nama_alamat,
				'alamat' 			=> $my_address->alamat,
				'nama_provinsi' 	=> $my_address->nama_provinsi,
				'nama_city' 		=> $my_address->nama_city,
				'nama_kec' 			=> $my_address->nama_kec,
				'nama_kel' 			=> $my_address->nama_kel,
				'kode_pos' 			=> $my_address->kode_pos,					
			);
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt_device,
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'data not found',
				'data'		=> null,
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function del_mydevice(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_device = isset($param['id_device']) ? (int)$param['id_device'] : '';
		$simpan = array(
			'deleted_at'	=> $tgl
		);
		$this->access->updatetable('my_device',$simpan, array("id" => $id_device));
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> null
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function del_myaddress(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_address = isset($param['id_address']) ? (int)$param['id_address'] : '';
		$simpan = array(
			'deleted_at'	=> $tgl
		);
		$this->access->updatetable('my_address',$simpan, array("id" => $id_address));
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> null
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_history_point(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : '';
		$sort = array('abs(id_history)','DESC');
		$my_point = $this->access->readtable('point_history','',array('id_member'=>$id_member),'','',$sort)->result_array();
		$dt = array();
		$result = array();
		if(!empty($my_point)){
			foreach($my_point as $mp){
				$dt[] = array(
					'type' 			=> $mp['type'],
					'tgl' 			=> $mp['tgl'],
					'description' 	=> $mp['description'],
					'nilai' 		=> $mp['nilai'],
					'id_tr' 		=> $mp['id_tr']
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
	
	function set_point_simulasi(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : '';
		$login = $this->access->readtable('customer','',array('id_customer'=>$id_member))->row();
		$first_simulasi = !empty($login->first_simulasi) ? 1 : 0;
		$reward_point = 0;
		if($first_simulasi <= 0){
			$this->load->model('Setting_point_m');
			$setting_point = $this->Setting_point_m->get_key_val();
			$reward_point = str_replace('.','',$setting_point['first_simulasi_hrg']);
			$reward_point = str_replace(',','',$reward_point);
			$reward_point = (int)$reward_point;
			$point = (int)$login->point + $reward_point;
			$simpan_history = array();
			$upd = array();
			$upd = array('point'=>$point,'first_simulasi'=>date('Y-m-d H:i:s'));
			$simpan_history = array(
					"id_member"			=> $id_member,
					"tgl"				=> date('Y-m-d H:i:s'),
					"id_tr"				=> date('Y-m-d H:i:s'),
					"type"				=> 2,
					"description"		=> "Add Points First Simulasi Harga",
					"nilai"				=> $reward_point
			);	
			$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member));  
			$this->access->inserttable("point_history",$simpan_history);
		}
		$result = array(
			'err_code'	=> '00',
			'err_msg'	=> 'ok',
			'data'		=> $reward_point,
			'get_point'	=> $reward_point,
		);
		http_response_code(200);
		echo json_encode($result);
	}
	
	function set_notif(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : '';
		$order_part = isset($param['order_part']) ? (int)$param['order_part'] : '';
		$order_shop = isset($param['order_shop']) ? (int)$param['order_shop'] : '';
		$order_bs = isset($param['order_bs']) ? (int)$param['order_bs'] : '';
		$tutorial = isset($param['tutorial']) ? (int)$param['tutorial'] : '';
		$news = isset($param['news']) ? (int)$param['news'] : '';
		$forum = isset($param['forum']) ? (int)$param['forum'] : '';
		$dt_upd = array();
		if($order_part > 0){
			$order_part = $order_part > 1 ? 0 : $order_part;
			$dt_upd += array('order_part'=>$order_part);
		}
		if($order_shop > 0){
			$order_shop = $order_shop > 1 ? 0 : $order_shop;
			$dt_upd += array('order_shop'=>$order_shop);
		}
		if($order_bs > 0){
			$order_bs = $order_bs > 1 ? 0 : $order_bs;
			$dt_upd += array('order_bs'=>$order_bs);
		}
		if($tutorial > 0){
			$tutorial = $tutorial > 1 ? 0 : $tutorial;
			$dt_upd += array('tutorial'=>$tutorial);
		}
		if($news > 0){
			$news = $news > 1 ? 0 : $news;
			$dt_upd += array('news'=>$news);
		}
		if($forum > 0){
			$forum = $forum > 1 ? 0 : $forum;
			$dt_upd += array('forum'=>$forum);
		}
		if(!empty($dt_upd))	$this->access->updatetable('customer', $dt_upd, array('id_customer'=>$id_member)); 
		$dt_notif = $this->access->readtable('customer','',array('id_customer '=>$id_member))->row();
		$dt = array(
			'id_member'		=> (int)$dt_notif->id_customer,
			'order_part'	=> (int)$dt_notif->order_part,
			'order_shop'	=> (int)$dt_notif->order_shop,
			'order_bs'		=> (int)$dt_notif->order_bs,
			'tutorial'		=> (int)$dt_notif->tutorial,
			'news'			=> (int)$dt_notif->news,
			'forum'			=> (int)$dt_notif->forum
		);
		$result = array();
		$result = array(
			'err_code'	=> '00',
			'err_msg'	=> 'ok',
			'data'		=> $dt			
		);
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_notif(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : '';		
		$dt_notif = $this->access->readtable('customer','',array('id_customer '=>$id_member))->row();
		$dt = array(
			'id_member'		=> (int)$dt_notif->id_customer,
			'order_part'	=> (int)$dt_notif->order_part,
			'order_shop'	=> (int)$dt_notif->order_shop,
			'order_bs'		=> (int)$dt_notif->order_bs,
			'tutorial'		=> (int)$dt_notif->tutorial,
			'news'			=> (int)$dt_notif->news,
			'forum'			=> (int)$dt_notif->forum
		);
		$result = array();
		$result = array(
			'err_code'	=> '00',
			'err_msg'	=> 'ok',
			'data'		=> $dt			
		);
		http_response_code(200);
		echo json_encode($result);
	}
	
	function list_notif(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;		
		$type = isset($param['type']) ? (int)$param['type'] : 0;	
		$where = array('id_member '=>$id_member);
		if($type > 0){
			$where += array('type'=>$type);
		}
		$dt_notif = $this->access->readtable('history_notif','',$where)->result_array();
		if(!empty($dt_notif)){
			foreach($dt_notif as $dn){
				$dt[] = array(
					'id_member'		=> $dn['id_member'],
					'id_data'		=> $dn['id_data'],
					'type'			=> $dn['type'],
					'title'			=> 'iColor',
					'pesan'			=> $dn['pesan'],
					'created_at'	=> $dn['created_at']
				);
			}
			$result = array(
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt			
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
	
	function upd_fcm(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;		
		$fcm_token = isset($param['fcm_token']) ? $param['fcm_token'] : '';
		$result = array();
		if($id_member == 0){
			$result = [
				'err_code'	=> '07',
				'err_msg'	=> 'id_member require'
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$simpan = array(
			'fcm_token'	=> $fcm_token
		);
		$this->access->updatetable('customer',$simpan, array("id_customer"=>$id_member));
		$result = [
			'err_code'	=> '00',
			'err_msg'	=> 'ok'
		];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function kirim_email(){
		$param = $this->input->post();
		$subject = isset($param['subject']) ? $param['subject'] : '';
		$name = isset($param['name']) ? $param['name'] : '';
		$email = isset($param['email']) ? $param['email'] : '';
		$problem = isset($param['problem']) ? $param['problem'] : '';
		$category = isset($param['category']) ? $param['category'] : '';
		$opsi_val_arr = $this->sm->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}
		$kirim_email = $out['kirim_email'];
		$email_to = 'bernard@andtechnology.mobi,agung@andtechnology.mobi';
		$from = $out['email'];
		$pass = $out['pass'];
		$config['upload_path'] = "./uploads/email/";
		$config['allowed_types'] = "*";
		$config['max_size']	= '16048';
		$new_name = time().'_'.$_FILES["attach"]['name'];
		$config['file_name'] = $new_name;
		$this->load->library('upload',$config);
		$upl = '';
		$this->load->library('send_notif');
		$content = str_replace('[#name#]', $name, $kirim_email);
		$content = str_replace('[#email#]', $email, $content);
		$content = str_replace('[#problem#]', $problem, $content);
		$content = str_replace('[#category#]', $category, $content);
		$attach = '';
		if(!empty($_FILES['attach'])){
			$upl = '';
			if($this->upload->do_upload('attach')){
				$upl = $this->upload->data();
				$attach = $upl['full_path'];
			}
		}
		$send = $this->send_notif->send_email($from,$pass, $email_to,$subject, $content,$attach);
		$result = [
			'err_code'	=> '00',
			'err_msg'	=> 'Terima kasih telah mengirimkan Email'
		];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function complete_profile($id_member=0){
		$login = $this->access->readtable('customer','',array('id_customer'=>$id_member),array('city' => 'city.id_city = customer.id_city'),'','','LEFT')->row();
		$my_address = $this->access->readtable('my_address','',array('my_address.id_cust'=>$id_member,'my_address.deleted_at'=>null))->row();
		$nama = !empty($login->nama) ? 1 : 0;
		$last_name = !empty($login->last_name) ? 1 : 0;
		$dob = !empty($login->dob) ? 1 : 0;
		$jk = (int)$login->jk > 0 ? 1 : 0;
		$id_city = (int)$login->id_city > 0 ? 1 : 0;
		$myAddress = (int)$my_address->id > 0 ? 1 : 0;
		if($nama > 0 && $last_name > 0 && $dob > 0 && $jk > 0 && $id_city > 0 && $myAddress > 0){
			$this->load->model('Setting_point_m');
			$setting_point = $this->Setting_point_m->get_key_val();
			$reward_point = str_replace('.','',$setting_point['complete_profile']);
			$reward_point = str_replace(',','',$reward_point);
			$reward_point = (int)$reward_point;
			$point = (int)$login->point + $reward_point;
			$simpan_history = array();
			$simpan_history = array(
				"id_member"			=> $id_member,
				"tgl"				=> date('Y-m-d H:i:s'),
				"id_tr"				=> date('Y-m-d H:i:s'),
				"type"				=> 11,
				"description"		=> "Add Points Completed Profile",
				"nilai"				=> $reward_point
			);				
			$upd = array();
			$upd = array('point'=>$point,'completed_profile'=>date('Y-m-d H:i:s'));
			$this->access->updatetable('customer', $upd, array('id_customer'=>$id_member,'completed_profile'=>null));  
			$this->access->inserttable("point_history",$simpan_history);
		}
	}
	
}
