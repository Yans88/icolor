<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tutorial extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('tutorial')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Tutorial';
		$this->data['judul_utama'] = 'Tutorial';
		$this->data['judul_sub'] = 'List';
		
		$this->data['tutorial'] = $this->access->readtable('tutorial','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('tutorial/tutorial_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function add($id=0){
		if(!$this->session->userdata('login') || !$this->session->userdata('tutorial')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Tutorial';
		$this->data['judul_utama'] = 'Tutorial';
		$this->data['judul_sub'] = 'Form';		
		$this->data['category'] = $this->access->readtable('kategori','', array('deleted_at'=>null,'tipe'=>1))->result_array();
		$tutorial = '';
		$dt_section = '';
		$dt_step = '';
		$comment = '';
		$member_like = '';
		$member_share = '';
		$cnt_like = '';
		if($id > 0) {
			$tutorial = $this->access->readtable('tutorial','', array('id'=>$id, 'deleted_at'=>null))->row();
			$dt_section = $this->access->readtable('tutorial_section','', array('id_tutor'=>$id, 'deleted_at'=>null))->result_array();
			$dt_step = $this->access->readtable('tutorial_step','', array('id_tutor'=>$id, 'deleted_at'=>null))->result_array();
			$sort = array('ABS(tutorial_comment.id)','DESC');
			$select = array('customer.*','tutorial_comment.comment','tutorial_comment.id','tutorial_comment.updated_at as comment_tgl');
			$comment = $this->access->readtable('tutorial_comment',$select,array('id_tutorial'=>$id,'tutorial_comment.deleted_at'=>null),array('customer'=>'customer.id_customer = tutorial_comment.id_member'),'',$sort,'LEFT')->result_array();
			$sort = array('ABS(tutorial_like.id)','DESC');
			$select = array('customer.*','tutorial_like.id','tutorial_like.updated_at');
			$member_like = $this->access->readtable('tutorial_like',$select,array('id_tutorial'=>$id),array('customer'=>'customer.id_customer = tutorial_like.id_member'),'',$sort,'LEFT')->result_array();
			$sort = array('ABS(tutorial_share.id)','DESC');
			$select = array('customer.*','tutorial_share.id','tutorial_share.updated_at as tgl');
			$member_share = $this->access->readtable('tutorial_share',$select,array('id_tutorial'=>$id),array('customer'=>'customer.id_customer = tutorial_share.id_member'),'',$sort,'LEFT')->result_array();
			$cnt_like = count($member_like);
		}
		$this->data['dt_section'] = $dt_section;
		$this->data['tutorial'] = $tutorial;
		$this->data['dt_step'] = $dt_step;
		$this->data['comment'] = $comment;
		$this->data['member_like'] = $member_like;
		$this->data['member_share'] = $member_share;
		$this->data['dt_tab'] = '';
		$this->data['isi'] = $this->load->view('tutorial/tutorial_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function save_step(){
		if(!$this->session->userdata('login') || !$this->session->userdata('tutorial')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$id_tutorial = isset($_POST['id_tutorial']) ? (int)$_POST['id_tutorial'] : 0;
		$id_step = isset($_POST['id_step']) ? (int)$_POST['id_step'] : 0;
		$id_section_step = isset($_POST['id_section_step']) ? (int)$_POST['id_section_step'] : 0;
		$step = isset($_POST['step']) ? $_POST['step'] : '';
		$deskripsi_step = isset($_POST['deskripsi_step']) ? $_POST['deskripsi_step'] : '';
		
		$save = 0;
		$dt_simpan = array();
		$dt_simpan = array(				
				'step'			=> $step,
				'ket'			=> $deskripsi_step
		);
		if($id_step > 0){
			$dt_simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$this->access->updatetable('tutorial_step', $dt_simpan, array('id_step'=>$id_step));   
			$save = $id_step;
		}else{
			$dt_simpan += array('created_at' => $tgl,'id_section' => $id_section_step,'id_tutor' => $id_tutorial,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('tutorial_step', $dt_simpan);   
		}
		echo $save;
	}
	
	function add_section($id=0){
		$this->data['judul_browser'] = 'Tutorial';
		$this->data['judul_utama'] = 'Tutorial';
		$this->data['judul_sub'] = 'Form';		
		$this->data['category'] = $this->access->readtable('kategori','', array('deleted_at'=>null))->result_array();
		$tutorial = '';
		$dt_section = '';
		$dt_step = '';
		if($id > 0) {
			$tutorial = $this->access->readtable('tutorial','', array('id'=>$id, 'deleted_at'=>null))->row();
			$dt_section = $this->access->readtable('tutorial_section','', array('id_tutor'=>$id, 'deleted_at'=>null))->result_array();
			$dt_step = $this->access->readtable('tutorial_step','', array('id_tutor'=>$id, 'deleted_at'=>null))->result_array();
		}
		$this->data['dt_section'] = $dt_section;
		$this->data['dt_step'] = $dt_step;
		$this->data['tutorial'] = $tutorial;
		$this->data['dt_tab'] = 'section';
		$this->data['isi'] = $this->load->view('tutorial/tutorial_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function save_tutor(){
		$tgl = date('Y-m-d H:i:s');
		$id_tutorial = isset($_POST['id_tutorial']) ? (int)$_POST['id_tutorial'] : 0;
		$id_category = isset($_POST['id']) ? (int)$_POST['id'] : 0;
		$reload = isset($_POST['reload']) ? (int)$_POST['reload'] : 0;
		$judul = isset($_POST['judul']) ? $_POST['judul'] : '';
		$difficulty = isset($_POST['difficulty']) ? $_POST['difficulty'] : '';
		$device_cat = isset($_POST['device_cat']) ? $_POST['device_cat'] : '';
		$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
		$video_o = isset($_POST['video_o']) ? $_POST['video_o'] : '';
		$time_required = isset($_POST['time_required']) ? $_POST['time_required'] : '';
		$device_type = isset($_POST['device_type']) ? $_POST['device_type'] : '';
		$introduction = isset($_POST['introduction']) ? $_POST['introduction'] : '';
		$config['upload_path']   = FCPATH.'/uploads/tutorials/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '8096';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$simpan = array();
		$simpan = array(
			'title'				=>	$judul,
			'introduction'		=>	$introduction,
			'deskripsi'			=>	$deskripsi,
			'difficulty'		=>	$difficulty,
			'time_required'		=>	$time_required,
			'video_overview'	=>	$video_o,
			'device_cat'		=>	$device_cat,
			'device_type'		=>	$device_type
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }
		$where = array();
		$save = 0;	
		if($id_tutorial > 0){
			$where = array('id'=>$id_tutorial);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$this->access->updatetable('tutorial', $simpan, $where);   
			$save = $id_tutorial;   
		}else{
			$simpan += array('created_at' => $tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('tutorial', $simpan);   
		}		
		if($save > 0){
			$data_fcm = array(
				'id'			=> $save,			
				'title'			=> 'iColor',
				'type'			=> 1,
				'message'		=> $judul
			);
			$notif_fcm = array(
				'title'		=> 'iColor',
				'body'		=> $judul,
				'badge'		=> 1,
				'sound'		=> 'Default'
			);
			$this->load->library('send_notif');
			$get_member = $this->access->readtable('customer',array('id_member','fcm_token'),array('deleted_at'=>null,'tutorial >'=>0))->result_array();
			$ids = array();
			$dt_insert = array();
			if(!empty($get_member)){
				foreach($get_member as $gm){
					if(!empty($gm['fcm_token'])){
						array_push($ids, $gm['fcm_token']);
						$dt_insert[] = array(
							'id_member'		=> $gm['id_customer'],
							'type'			=> 1,
							'id_data'		=> $save,
							'pesan'			=> 'New Tutorial - '.$judul,
							'created_at'	=> $tgl,
						);
					}						
				}
				$notif = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);
				if(!empty($dt_insert)) $this->db->insert_batch('history_notif', $dt_insert);
			}
			$this->session->set_flashdata('message', 'Anda berhasil menginput data');
			redirect(site_url('tutorial/add/'.$save));
		}
	}
	
	function get_type(){
		$id_category = isset($_POST['id']) ? (int)$_POST['id'] : 0;
		$where = array('deleted_at'=>null,'id_kategori'=>$id_category);		
		$type = $this->access->readtable('sub_kategori','',$where)->result_array();		
		$html = '';
		if(!empty($type)){
			foreach($type as $t){
				$html .='<option value="'.$t['id_sub'].'">'.$t['nama_sub'].'</option>';
			}
		}else{
			$html .='<option value="">Data not found</option>';
		}
		echo $html;
	}
	
	function get_tools(){
		$id_tutorial = isset($_POST['id_tutorial']) ? (int)$_POST['id_tutorial'] : 0;
		$mytools = $this->access->readtable('tutorial_tools','',array('tutorial_tools.id_tutorial'=>$id_tutorial,'tutorial_tools.deleted_at'=>null))->result_array();
		$_mt = array();
		if(!empty($mytools)){
			foreach($mytools as $mt) array_push($_mt, $mt['id_tools']);
		}
		
		$tools = $this->access->readtable('shop_product','',array('deleted_at'=>null,'kategori'=>3))->result_array();
		$html = '';
		if(!empty($tools)){
			foreach($tools as $t){
				if(!in_array($t['id_product'], $_mt)) $html .='<option value="'.$t['id_product'].'">'.$t['nama_product'].'</option>';
			}
		}
		if(empty($html)) $html .='<option value="">Data not found</option>';
		echo $html;
	}
	
	function get_spare_parts(){
		$id_tutorial = isset($_POST['id_tutorial']) ? (int)$_POST['id_tutorial'] : 0;
		$mytools = $this->access->readtable('tutorial_sp','',array('id_tutorial'=>$id_tutorial,'deleted_at'=>null))->result_array();
		
		$_mt = array();
		if(!empty($mytools)){
			foreach($mytools as $mt) array_push($_mt, $mt['id_sp']);
		}
		
		$spare_parts = $this->access->readtable('shop_product','',array('deleted_at'=>null,'kategori'=>2))->result_array();
		$html = '';
		if(!empty($spare_parts)){
			foreach($spare_parts as $t){
				if(!in_array($t['id_product'], $_mt)) $html .='<option value="'.$t['id_product'].'">'.$t['nama_product'].'</option>';
			}
		}
		if(empty($html)) $html .='<option value="">Data not found</option>';
		echo $html;
	}

	function get_mytools(){
		$id_tutorial = isset($_POST['id_tutorial']) ? (int)$_POST['id_tutorial'] : 0;
		$selects = array('shop_product.*','tutorial_tools.id');
		$tools = $this->access->readtable('tutorial_tools',$selects,array('tutorial_tools.id_tutorial'=>$id_tutorial,'tutorial_tools.deleted_at'=>null,'shop_product.deleted_at'=>null),array('shop_product'=>'shop_product.id_product = tutorial_tools.id_tools'),'','','LEFT')->result_array();
		$res = '';
		$i=1;
		if(!empty($tools)){
			foreach($tools as $t){
				$res .= '<li><span class="text" style="color:#000 !important">'.$i++.'. '.$t['nama_product'].'</span>
						<div class="tools" style="display:inline-block; color:#000 !important">'.number_format($t['hrg_final'],0,'',',').' <i class="fa fa-trash-o" style="margin-left:10px; color:#dd4b39 !important;" onclick="return delete_tools('.$t['id'].');"></i></div>';
			}
		}else{
			$res = '<li><span class="text" style="color:#dd4b39 !important">Data not foud</span></li>';
		}
		echo $res;
	}
	
	function del_tools(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('tutorial_tools', $data, $where);
	}
	
	function del_section(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_section' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('tutorial_section', $data, $where);
	}
	
	function del_sp(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('tutorial_sp', $data, $where);
	}
	
	function del_comment(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('tutorial_comment', $data, $where);
	}
	
	function get_sp(){
		$id_tutorial = isset($_POST['id_tutorial']) ? (int)$_POST['id_tutorial'] : 0;
		$selects = array('shop_product.*','tutorial_sp.id');
		$tools = $this->access->readtable('tutorial_sp',$selects,array('tutorial_sp.id_tutorial'=>$id_tutorial,'tutorial_sp.deleted_at'=>null,'shop_product.deleted_at'=>null),array('shop_product'=>'shop_product.id_product = tutorial_sp.id_sp'),'','','LEFT')->result_array();
		$res = '';
		$i=1;
		if(!empty($tools)){
			foreach($tools as $t){
				$res .= '<li><span class="text" style="color:#000 !important">'.$i++.'. '.$t['nama_product'].'</span>
						<div class="tools" style="display:inline-block; color:#000 !important">'.number_format($t['hrg_final'],0,'',',').' <i class="fa fa-trash-o" style="margin-left:10px; color:#dd4b39 !important;" onclick="return delete_sp('.$t['id'].');"></i></div>';
			}
		}else{
			$res .= '<li><span class="text" style="color:#dd4b39 !important">Data not foud</span></li>';
		}
		echo $res;
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('tutorial', $data, $where);
	}
	
	public function del_step(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_step' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('tutorial_step', $data, $where);
	}
	
	function simpan_tools(){
		$tgl = date('Y-m-d H:i:s');
		$id_tutorial = isset($_POST['id_tutorial']) ? $_POST['id_tutorial'] : 0;
		$dt_tools = isset($_POST['dt_tools']) ? $_POST['dt_tools'] : 0;
		$dt_save = array();
		for($i = 0; $i < count($dt_tools); $i++){
			$dt_save[] = array(
				'id_tutorial' 	=> $id_tutorial,
				'id_tools' 		=> $dt_tools[$i],
				'created_at' 	=> $tgl,
				'created_by' 	=> $this->session->userdata('operator_id')
			);
		}
		if(!empty($dt_save)) $this->db->insert_batch('tutorial_tools', $dt_save);;
	}
	
	function simpan_sp(){
		$tgl = date('Y-m-d H:i:s');
		$id_tutorial = isset($_POST['id_tutorial']) ? $_POST['id_tutorial'] : 0;
		$dt_tools = isset($_POST['dt_tools']) ? $_POST['dt_tools'] : 0;
		$dt_save = array();
		for($i = 0; $i < count($dt_tools); $i++){
			$dt_save[] = array(
				'id_tutorial' 	=> $id_tutorial,
				'id_sp' 		=> $dt_tools[$i],
				'created_at' 	=> $tgl,
				'created_by' 	=> $this->session->userdata('operator_id')
			);
		}
		if(!empty($dt_save)) $this->db->insert_batch('tutorial_sp', $dt_save);;
	}
	
	public function simpan_cat(){
		$tgl = date('Y-m-d H:i:s');
		$id_tools = isset($_POST['id_tools']) ? (int)$_POST['id_tools'] : 0;
		$tools = isset($_POST['tools']) ? $_POST['tools'] : '';
		$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
		$harga = isset($_POST['harga']) ? str_replace('.','',$_POST['harga']) : 0;
		$harga = str_replace(',','',$harga);
		$config['upload_path']   = FCPATH.'/uploads/spare_parts/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array();
		$simpan = array(
				'nama'		=>	$tools,
				'harga'		=>	$harga,
				'deskripsi'	=>	$deskripsi
			);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$where = array();
		$save = 0;	
		if($id_tools > 0){
			$where = array('id_spare_parts'=>$id_tools);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->updatetable('spare_parts', $simpan, $where);   
		}else{
			$simpan += array('created_at' => $tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('spare_parts', $simpan);   
		} 
		redirect(site_url('spare_parts'));
	}
	
	function simpan_section(){
		$tgl = date('Y-m-d H:i:s');
		$id_section = isset($_POST['id_section']) ? (int)$_POST['id_section'] : 0;
		$id_tutorial = isset($_POST['id_tutorial']) ? (int)$_POST['id_tutorial'] : 0;
		$section = isset($_POST['section']) ? $_POST['section'] : '';
		$dt_simpan = array(
			'section'	=> $section
		);
		$save = 0;
		if($id_section > 0){
			$dt_simpan += array('updated_by' => $this->session->userdata('operator_id'));
			$this->access->updatetable('tutorial_section', $dt_simpan, array('id_section'=>$id_section));  
			$save = $id_section;
		}else{
			$dt_simpan += array('id_tutor'=>$id_tutorial,'created_at' => $tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('tutorial_section', $dt_simpan); 
		}
		echo $save;
	}
	
	function get_mygbr(){
		$id_step = isset($_POST['id_step']) ? $_POST['id_step'] : '';		
		$step_gbr = $this->access->readtable('tutorial_step_gbr','',array('id_step'=>$id_step,'tutorial_step_gbr.deleted_at'=>null))->result_array();
		$html = '';
		if(!empty($step_gbr)){
			foreach($step_gbr as $sg){
				$html .='<div class="col-sm-2 first" style="padding-left:0; padding-right:0;">	
						<div class="thumbnail" style="height:176px;"><img height="180" width="220" src="'.base_url('uploads/step/'.$sg['gbr']).'" alt="..." class="margin"><button onclick="return del_img('.$sg['id_step_img'].');" class="btn btn-block btn-xs btn-danger" style="margin-top:3px; bottom:12px;">Delete</button>
						</div>						
					</div>';
			}
		}
		$html .='<div class="col-sm-2" title="Add Image" onclick="return add_gbrr('.$id_step.');" style="padding-left:0; padding-right:0; cursor: pointer;">	
				<div class="thumbnail"><img height="240" width="220" src="'.base_url('assets/add_img.png').'" alt="Add Image" class="margin">
					<span class="label label-info"  style="display:block; height:24px; padding-top:7px;">Add Image</span>
				</div>
				</div>';
		
		echo $html;
	}
	
	function del_img_section(){
		$id_step_img = isset($_POST['id_step_img']) ? $_POST['id_step_img'] : '';
		$step_gbr = $this->access->readtable('tutorial_step_gbr','',array('id_step_img'=>$id_step_img))->row();
		$id_step = (int)$step_gbr->id_step;		
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_step_img' => $id_step_img
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		$this->access->updatetable('tutorial_step_gbr', $data, $where);
		echo $id_step;
	}
	
	function proses_upload(){
        $config['upload_path']   = FCPATH.'/uploads/step/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$tgl = date('Y-m-d H:i:s');
		$id_step = isset($_POST['id_step']) ? (int)$_POST['id_step'] : 0;
		$id_tutorial = isset($_POST['id_tutorial']) ? (int)$_POST['id_tutorial'] : 0;
		$dataa = array();
        if($this->upload->do_upload('userfile_step')){
        	$token=$this->input->post('token_foto');
        	$nama=$this->upload->data('file_name');			
			$dataa = array(
				'gbr'		=> $nama,
				'id_step'	=> $id_step,
				'id_tutor'	=> $id_tutorial,
				'created_at' => $tgl,
				'created_by'=>$this->session->userdata('operator_id'),
				'token'		=> $token
			);
        	$this->access->inserttable('tutorial_step_gbr', $dataa); 
        }
		echo $id_step;
	}
	
	function remove_foto(){
		//Ambil token foto
		$del =0;
		$id_step =0;
		$token=$this->input->post('token');		
		$foto=$this->db->get_where('tutorial_step_gbr',array('token'=>$token));
		if($foto->num_rows()>0){			
			$hasil=$foto->row();
			$nama_foto=$hasil->gbr;
			$id_step=$hasil->id_step;
			if(file_exists($file=FCPATH.'/uploads/step/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('tutorial_step_gbr',array('token'=>$token));

		}
		echo $id_step;
	}
	
	function kirim_notif($save=0, $pesan=''){
		
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
