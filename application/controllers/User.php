<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('users')){
			$this->no_akses();
			return false;
		}		
		$this->data['judul_browser'] = 'User';
		$this->data['judul_utama'] = 'List';
		$this->data['judul_sub'] = 'Users';
		$this->data['title_box'] = 'List of users';
		$this->data['level'] = '';		
		$select = array('admin.*','level.level_name');
		$this->data['users'] = $this->access->readtable('admin','',array('admin.deleted_at'=>null),array('level' => 'level.id = admin.id_level'),'','','LEFT')->result_array();	
			
		$this->data['isi'] = $this->load->view('user_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function add($id_user =''){
		if(!$this->session->userdata('login') || !$this->session->userdata('users')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'User';
		$this->data['judul_utama'] = 'User';
		$this->data['judul_sub'] = 'Add';
		$this->data['user'] = '';
		$this->data['level'] = $this->access->readtable('level','',array('level.deleted_at'=>null))->result_array();
		$this->data['store'] = $this->access->readtable('store','',array('deleted_at'=>null))->result_array();
		if($id_user > 0) $this->data['user'] = $this->access->readtable('admin','',array('operator_id'=>$id_user))->row();		
		$this->data['isi'] = $this->load->view('user_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function save(){		
		if(!$this->session->userdata('login') || !$this->session->userdata('users')){
			$this->no_akses();
			return false;
		}			
		$save =0;
		$id_user = isset($_POST['id_user']) ? $_POST['id_user'] : '';		
		$id_level = isset($_POST['id_level']) ? $_POST['id_level'] : '';		
		$name = $_POST['name'];				
		$list_store = isset($_POST['list_store']) ? $_POST['list_store'] : '';		
		
		$status = $_POST['status'];
		
		$username = md5(strtolower($_POST['username']));
		$password = isset($_POST['password']) ? md5($_POST['password']) : '';	
		$_user = $this->converter->encode(strtolower($_POST['username']));
		$_pass = isset($_POST['password']) ? $this->converter->encode($_POST['password']) : '';	
		$te = '';
		$_id_te = '';
		$te = $this->access->readtable('admin','',array('username' => $username,'deleted_at' => null))->row();
		$_id_te = count($te) > 0 ? $te->operator_id : 0;
		$dt_store = array();
		$id_store = '';
		$nama_store = '';
		for($i = 0; $i < count($list_store); $i++){
			$dt_store[] = $list_store[$i];
			$id_store = implode(',',$dt_store);
		}
		if(!empty($id_store)){
			$sql_member = 'SELECT * FROM store WHERE deleted_at is null and id_op IN ('.$id_store.')';
			$_dt_member = $this->db->query($sql_member)->result_array();
			if(!empty($_dt_member)){
				foreach($_dt_member as $st){
					$nm_store[] = $st['nama'];
					$nama_store = implode(', ',$nm_store);
				}
			}
		}
		// if(count($te) > 0 && $id_user != $_id_te){
			// $save = 'taken';
			// echo $save;
			// return false;
		// }
		$data = array(			
			'name'			=> $name,
			'username'		=> $username,	
			'status'		=> $status,	
			'id_level'		=> $id_level,	
			'id_store'		=> $id_store,	
			'store_name'	=> $nama_store,	
			'_user'			=> $_user,
			'_pass'			=> $_pass	
		);
		if(!empty($password)){
			$data += array('password' => $password);
		}		
		$where = array();
		if(!empty($id_user)){
			$data += array('modified_by'	=> $this->session->userdata('operator_id'));			
			$where = array('operator_id'=>$id_user);
			$save = $this->access->updatetable('admin', $data, $where);
		}else{
			$data += array('create_date' => date('Y-m-d'), 'create_user' => $this->session->userdata('operator_id'));
			$save = $this->access->inserttable('admin', $data);
		}		
		echo $save;	
		
	}
	
	public function del(){	
		if(!$this->session->userdata('login')){
			$this->no_akses();
			return false;
		}
		$data = array(			
			'deleted_at'	=> date('Y-m-d')		
		);
		$where = array('operator_id'=> $_POST['id']);
		echo $this->access->updatetable('admin', $data, $where);
	}	
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<br/><div class="alert alert-danger" style="margin-left:0;">Anda tidak memiliki Akses.</div><div class="error-page">
        <h3 class="text-red"><i class="fa fa-warning text-yellow"></i> Oops! No Akses.</h3></div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}


}
