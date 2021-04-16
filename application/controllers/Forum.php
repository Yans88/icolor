<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('forum')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Forum';
		$this->data['judul_utama'] = 'Forum';
		$this->data['judul_sub'] = 'List';
		$this->data['tipe'] = 1;
		$this->data['category'] = $this->access->readtable('forum','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('forum/forum_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function add($id=0){
		if(!$this->session->userdata('login') || !$this->session->userdata('forum')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Forum';
		$this->data['judul_utama'] = 'Forum';
		$this->data['judul_sub'] = 'Add';
		$this->data['store'] = '';
		$this->data['category'] = $this->access->readtable('kategori','', array('deleted_at'=>null,'tipe'=>1))->result_array();
		if($id > 0) $this->data['store'] = $this->access->readtable('forum','',array('id'=>$id))->row();		
		$this->data['isi'] = $this->load->view('forum/forum_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function view($id=0){
		if(!$this->session->userdata('login') || !$this->session->userdata('forum')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Forum';
		$this->data['judul_utama'] = 'Forum';
		$this->data['judul_sub'] = 'Add';
		$forum = '';		
		$select = '';		
		$member_like = '';		
		$member_share = '';		
		if($id > 0) {
			$select = array('forum.*','kategori.nama_kategori','sub_kategori.nama_sub');
			$forum = $this->access->readtable('forum',$select,array('id'=>$id),array('kategori'=>'kategori.id_kategori = forum.device_cat','sub_kategori'=>'sub_kategori.id_sub = forum.device_type'),'','','LEFT')->row();
			$sort = array('ABS(forum_like.id)','DESC');
			$select = array('customer.*','forum_like.id','forum_like.updated_at as tgl');
			$member_like = $this->access->readtable('forum_like',$select,array('id_forum'=>$id),array('customer'=>'customer.id_customer = forum_like.id_member'),'',$sort,'LEFT')->result_array();
			$sort = array('ABS(forum_share.id)','DESC');
			$select = array('customer.*','forum_share.id','forum_share.updated_at as tgl');
			$member_share = $this->access->readtable('forum_share',$select,array('id_forum'=>$id),array('customer'=>'customer.id_customer = forum_share.id_member'),'',$sort,'LEFT')->result_array();
			
		}		
		$this->data['forum'] = $forum;				
		$this->data['member_like'] = $member_like;				
		$this->data['member_share'] = $member_share;				
		$this->data['isi'] = $this->load->view('forum/forum_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function load_comment(){
		$id = isset($_POST['id_forum']) ? (int)$_POST['id_forum'] : 0;
		$sort = array('ABS(forum_comment.id)','DESC');
		$select = array('customer.*','forum_comment.comment','forum_comment.id','forum_comment.updated_at as tgl');
		$comment = $this->access->readtable('forum_comment',$select,array('id_forum'=>$id,'forum_comment.deleted_at'=>null),array('customer'=>'customer.id_customer = forum_comment.id_member'),'',$sort,'LEFT')->result_array();
		$select = array();
		$sort = array('ABS(forum_reply_comment.id)','ASC');
		$select = array('customer.*','forum_reply_comment.comment','forum_reply_comment.id','forum_reply_comment.updated_at as tgl','forum_reply_comment.id_comment');
		$comment_reply = $this->access->readtable('forum_reply_comment',$select,array('id_forum'=>$id,'forum_reply_comment.deleted_at'=>null),array('customer'=>'customer.id_customer = forum_reply_comment.id_member'),'',$sort,'LEFT')->result_array();
		$html = '';
		$dt_reply = array();
		
		if(!empty($comment_reply)){
			foreach($comment_reply as $cr){
				$_photo = '';
				
				$_photo = !empty($cr['photo']) ? base_url('uploads/members/'.$cr['photo']) : base_url('uploads/no_photo.jpg');
				$dt_reply[$cr['id_comment']][] = array(
					'id'		=> $cr['id'],
					'id_customer'		=> $cr['id_customer'],
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
				$view_member = '';
				$view_member = site_url('members/detail/'.$c['id_customer']);
				$photo = !empty($c['photo']) ? base_url('uploads/members/'.$c['photo']) : base_url('uploads/no_photo.jpg');
				$html .='<div class="user-block">
                    <img src="'.$photo.'" alt="user image">
                        <span class="username">
							<a href="'.$view_member.'">'.$c['nama'].'</a>
							<a href="javascript:void(0)" onclick="return delete_comment('.$c['id'].');" style="color:red;" title="Hapus komentar" class="pull-right btn-box-tool "><i class="fa fa-times"></i></a>
                        </span>
                    <span class="description">'.date('d-M-Y H:i', strtotime($c['tgl'])).'</span>
                  </div>
                  <!-- /.user-block -->
                  <p>'.$c['comment'].'</p>';
				
				if(count($dt_reply[$c['id']]) > 0){
					for($i=0;$i < count($dt_reply[$c['id']]); $i++){
						$view_member = '';
						$view_member = site_url('members/detail/'.$dt_reply[$c['id']][$i]['id_customer']);
						$html .='<div class="attachment">
                  <div class="user-block">
                    <img src="'.$dt_reply[$c['id']][$i]['photo'].'" alt="user image">
                        <span class="username">
							<a href="'.$view_member.'">'.$dt_reply[$c['id']][$i]['nama'].'</a>
							<a href="javascript:void(0)" onclick="return delete_reply('.$dt_reply[$c['id']][$i]['id'].');" style="color:red;" title="Hapus komentar" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                    <span class="description">'.date('d-M-Y', strtotime($dt_reply[$c['id']][$i]['tgl'])).'</span>
                  </div>
				  <p>'.$dt_reply[$c['id']][$i]['comment'].'</p>
                </div>';
					}
				}
				
                $html .='<hr/>';            
				
			}
		}else{
			$html = '<h3 style="text-align:center;"><strong>Not Found</strong></h3>';
		}
		echo $html;
	}
		
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('forum', $data, $where);
	}
	
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id_forum = isset($_POST['id_forum']) ? (int)$_POST['id_forum'] : 0;
		$title = isset($_POST['jdl']) ? $_POST['jdl'] : '';
		$device_cat = isset($_POST['device_cat']) ? $_POST['device_cat'] : '';			
		$device_type = isset($_POST['device_type']) ? $_POST['device_type'] : '';
		$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';	
		$config['upload_path']   = FCPATH.'/uploads/forum/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array();
		$simpan = array('deskripsi'=>$deskripsi,'title'=>$title,'device_cat'=>$device_cat,'device_type'=>$device_type);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$where = array();
		$save = 0;	
		if($id_forum > 0){
			$where = array('id'=>$id_forum);
			$save = $this->access->updatetable('forum', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('forum', $simpan);   
			if($save > 0){
				$data_fcm = array(
					'id'			=> $save,			
					'title'			=> 'iColor',
					'type'			=> 2,
					'message'		=> "New Forum"
				);
				$notif_fcm = array(
					'title'		=> 'iColor',
					'body'		=> "New forum",
					'badge'		=> 1,
					'sound'		=> 'Default'
				);
				$this->load->library('send_notif');
				$get_member = $this->access->readtable('customer',array('id_member','fcm_token'),array('deleted_at'=>null,'forum >'=>0))->result_array();
				$ids = array();
				$dt_insert = array();
				if(!empty($get_member)){
					foreach($get_member as $gm){
						if(!empty($gm['fcm_token'])){
							array_push($ids, $gm['fcm_token']);
							$dt_insert[] = array(
								'id_member'		=> $gm['id_customer'],
								'type'			=> 2,
								'id_data'		=> $save,
								'pesan'			=> 'New Forum - '.$title,
								'created_at'	=> $tgl,
							);
						}						
					}
					$notif = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);
					if(!empty($dt_insert)) $this->db->insert_batch('history_notif', $dt_insert);
				}
			}
		} 
		redirect(site_url('forum'));
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
		echo $this->access->updatetable('forum_comment', $data, $where);
	}
	
	function del_reply(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('forum_reply_comment', $data, $where);
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
