<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Berita extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('news')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'News';
		$this->data['judul_utama'] = 'News';
		$this->data['judul_sub'] = 'List';
		$this->data['news'] = $this->access->readtable('news','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('news/news_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function add_news($id=0){
		if(!$this->session->userdata('login') || !$this->session->userdata('news')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'News';
		$this->data['judul_utama'] = 'News';
		$this->data['judul_sub'] = 'Add/Edit';
		$news = '';
		if($id > 0) $news = $this->access->readtable('news','',array('deleted_at'=>null,'id_news'=>$id))->row();
		$this->data['news'] = $news;
		$this->data['isi'] = $this->load->view('news/news_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_news' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=>$this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('news', $data, $where);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d');
		$id_news = isset($_POST['id_news']) ? (int)$_POST['id_news'] : 0;
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$descr_title = isset($_POST['descr_title']) ? $_POST['descr_title'] : '';		
		$sub_title = isset($_POST['sub_title']) ? $_POST['sub_title'] : '';		
		$descr_subtitle = isset($_POST['descr_subtitle']) ? $_POST['descr_subtitle'] : '';	
		$config = array();
		$config['upload_path']   = FCPATH.'/uploads/news/';
        $config['allowed_types'] = 'jpeg|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array();	
		$simpan = array(			
			'title'				=> $title,
			'deskripsi_title'	=> $descr_title,
			'subtitle'			=> $sub_title,
			'deskripsi_sub'		=> $descr_subtitle
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$config = array();
		$config['upload_path']   = FCPATH.'/uploads/news/';
        $config['allowed_types'] = 'jpeg|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		
		if(!$this->upload->do_upload('my_thumbnail')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('thumbnail'	=> $gambar);
        }	
		$where = array();
		$save = 0;	
		if($id_news > 0){
			$where = array('id_news'=>$id_news);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->updatetable('news', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('news', $simpan); 
			if($save > 0){
				$data_fcm = array(
					'id'			=> $save,			
					'title'			=> 'iColor',
					'type'			=> 3,
					'message'		=> $title
				);
				$notif_fcm = array(
					'title'		=> 'iColor',
					'body'		=> $title,
					'badge'		=> 1,
					'sound'		=> 'Default'
				);
				$this->load->library('send_notif');
				$get_member = $this->access->readtable('customer',array('id_member','fcm_token'),array('deleted_at'=>null,'news >'=>0))->result_array();
				$ids = array();
				$dt_insert = array();
				if(!empty($get_member)){
					foreach($get_member as $gm){
						if(!empty($gm['fcm_token'])){
							array_push($ids, $gm['fcm_token']);
							$dt_insert[] = array(
								'id_member'		=> $gm['id_customer'],
								'type'			=> 3,
								'id_data'		=> $save,
								'pesan'			=> 'New News - '.$title,
								'created_at'	=> $tgl,
							);
						}						
					}
					$notif = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);
					if(!empty($dt_insert)) $this->db->insert_batch('history_notif', $dt_insert);
				}
			}	
		}  
		redirect(site_url('berita'));
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
