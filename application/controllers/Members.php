<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);	
	}	
	
	public function index() {
		
		if(!$this->session->userdata('login') || !$this->session->userdata('members')){
			$this->no_akses();
			return false;
		}	
		
		$this->data['judul_browser'] = 'Member';
		$this->data['judul_utama'] = 'Member';
		$this->data['judul_sub'] = 'iColor';
		$this->data['title_box'] = 'List of Member';
		
		$this->data['isi'] = $this->load->view('members/member_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function members_data(){
		ini_set('memory_limit', '-1');
        $requestData= $_REQUEST;
		$order = $requestData['order'];
	
		$col = 0;
        $dir = "";
        $sort = array();
        if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
		if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		$columns_valid = array(
			"customer.id_customer",
            "customer.nama",
            "customer.email",            
            "customer.created_at",
            "customer.dob",            
        );
		if(!isset($columns_valid[$col])) {
            $sort = array('customer.id_customer','ASC');
        } else {
            $sort = array($columns_valid[$col],$dir);
        }
		$where = array('customer.deleted_at'=>null);
		if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$member = $this->access->readtable('customer','',$where,'','',$sort,'','',array('customer.nama'=>$search), array('customer.last_name'=>$search,'customer.email'=>$search))->result_array();
						
		    $totalFiltered=count($member);
		    $totalData=count($member);
        }else{
			$member = $this->access->readtable('customer','',$where,'',array($requestData['length'],$requestData['start']),$sort,'')->result_array();			
			$members = $this->access->readtable('customer','',$where)->result_array();			
			$totalData = count($members);
			$totalFiltered=count($members);
        }
		$data = array();
        $nestedData=array();
		$jenis_layanan = '';		
		$i=1;
		if($requestData['start'] > 0){
			$i += $requestData['start'];
		}
		if(!empty($member)){            		
            foreach($member as $row) {
				$nestedData=array();
				if(empty($row['deleted_at'])){
					$view_member = '';
					$status = '';
					$status = '<small class="label label-danger">Unverified</small>';
					if($row['verify_email'] == 1){
						$status = '<small class="label label-info">Verified</small>';
					}
					$view_member = site_url('members/detail/'.$row['id_customer']);
					$nestedData[] = $i++.'.';				
					$nestedData[] = $row['nama'].''.$row['last_name'].'<br/>'.$row['phone'];			 	
					$nestedData[] = $row['email'].'<br/>'.$status;			
						
					$nestedData[] = date('d-M-Y', strtotime($row['created_at']));			
					$nestedData[] = date('d-M-Y', strtotime($row['dob']));			
					$nestedData[] = $row['point'];			
					$nestedData[] = '<a href="'.$view_member.'"/><button title="View" style="width:69px; margin-top:5px;"  class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</button></a>';								
					$data[] = $nestedData;
				}
			}            
        }
		$json_data = array(
            "draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalData), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

        echo json_encode($json_data);  // send data as json format
	}
	
	function detail($id=0){
		if(!$this->session->userdata('login') || !$this->session->userdata('members')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Customer';
		$this->data['judul_utama'] = 'Customer';
		$this->data['judul_sub'] = 'Detail';	
		$select = array('customer.*','city.nama_city');
		$this->data['customer'] = $this->access->readtable('customer','',array('id_customer'=>$id),array('city' => 'city.id_city = customer.id_city'),'','','LEFT')->row();
		$select = array('my_device.imei','my_device.id','my_device.nama_device','my_device.device_cat','my_device.device_type','kategori.nama_kategori','kategori.img as img_device_cat','kategori.tipe','sub_kategori.nama_sub','sub_kategori.img as img_device_type');
		$this->data['my_device'] = $this->access->readtable('my_device',$select,array('id_cust'=>$id,'my_device.deleted_at'=>null),array('kategori' => 'kategori.id_kategori = my_device.device_cat', 'sub_kategori' => 'sub_kategori.id_sub = my_device.device_type'),'','','LEFT')->result_array();
		$select = array('my_address.id','my_address.alamat','my_address.nama_alamat','my_address.id_provinsi','my_address.id_city','my_address.id_kec','my_address.id_kel','my_address.kode_pos','provinsi.nama_provinsi','city.nama_city','kelurahan.nama_kel','kecamatan.nama_kec');
		$this->data['my_address'] = $this->access->readtable('my_address',$select,array('my_address.id_cust'=>$id,'my_address.deleted_at'=>null),array('provinsi' => 'provinsi.id_provinsi = my_address.id_provinsi', 'city' => 'city.id_city = my_address.id_city','kecamatan' => 'kecamatan.id_kec = my_address.id_kec','kelurahan' => 'kelurahan.id_kelurahan = my_address.id_kel'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('members/customer_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function get_member(){
		$where = array('customer.deleted_at'=>null);
		$search = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';
		$sort = array('customer.nama','ASC');
		if(!empty($search)){
			$search = $this->db->escape_str($search);
			$member = $this->access->readtable('customer','',$where,'','',$sort,'','',array('customer.nama'=>$search))->result_array();
		}else{
			$member = $this->access->readtable('customer','',$where,'',array(5,0),$sort)->result_array();	
		}
		$data=array();
		if(!empty($member)){            		
            foreach($member as $row) {				
				if(empty($row['deleted_at'])){								
					if((int)$row['verify_email'] > 0){
						$data[] = array('id'=>$row['id_customer'],'text'=>$row['nama'].' '.$row['last_name'].'('.$row['email'].')');
					}else{
						$data[] = array('id'=>$row['id_customer'],'text'=>$row['nama'].' '.$row['last_name'].'('.$row['email'].')','disabled'=>true);
					}						
				}
			}            
        }
		echo json_encode($data);
	}
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	

}
