<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);			
	}	
	
	public function booking_service() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_part_s')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Report';
		$this->data['judul_utama'] = 'Booking Service';
		$this->data['judul_sub'] = 'Report';		
		$tgl_skrg = date('d/m/Y');
		$tgl_before = date('d/m/Y',strtotime('-30 days'));
		$tgl_current = $tgl_before.' - '.$tgl_skrg;
		$tgl = isset($_POST['tgl']) ? $_POST['tgl'] : $tgl_current;
		$jns_layanan = isset($_POST['jns_layanan']) ? (int)$_POST['jns_layanan'] : 0;
		$store = isset($_POST['store']) ? (int)$_POST['store'] : '';
		$where = array('store.deleted_at'=>null);
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'store.id_op';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}	
		$this->data['list_store'] = $this->access->readtable('store','',$where,'','','','','','','',$field_in, $_id_ta)->result_array();		
		$this->data['tgl'] = $tgl;
		$this->data['jns_layanan'] = $jns_layanan;
		$this->data['store'] = $store;
		$this->data['isi'] = $this->load->view('report/report_bs', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function order_shop() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_part_s')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Report';
		$this->data['judul_utama'] = 'Shop Product';
		$this->data['judul_sub'] = 'Report';
		$tgl_skrg = date('d/m/Y');
		$tgl_before = date('d/m/Y',strtotime('-30 days'));
		$tgl_current = $tgl_before.' - '.$tgl_skrg;
		$tgl = isset($_POST['tgl']) ? $_POST['tgl'] : $tgl_current;
		$status = isset($_POST['status']) ? (int)$_POST['status'] : '';
		$this->data['tgl'] = $tgl;
		$this->data['status'] = $status;
		$this->data['isi'] = $this->load->view('report/report_os', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function order_ps() {			
		if(!$this->session->userdata('login') || !$this->session->userdata('order_part_s')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Report';
		$this->data['judul_utama'] = 'Order Part Service';
		$this->data['judul_sub'] = 'Report';
		$tgl_skrg = date('d/m/Y');
		$tgl_before = date('d/m/Y',strtotime('-30 days'));
		$tgl_current = $tgl_before.' - '.$tgl_skrg;
		$tgl = isset($_POST['tgl']) ? $_POST['tgl'] : $tgl_current;
		$status = isset($_POST['status']) ? (int)$_POST['status'] : '';
		$this->data['tgl'] = $tgl;
		$this->data['status'] = $status;
		$this->data['isi'] = $this->load->view('report/report_ps', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function load_data_bs(){
		ini_set('memory_limit', '-1');
        $requestData= $_REQUEST;
		// $select = array('members.*','admin.fullname'); 
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
			"bs_detail.id",
            "booking_service.tgl_service",
            "booking_service.nmr_booking",            
            "booking_service.nama_store",
            "customer.nama",            
        );
		if(!isset($columns_valid[$col])) {
            $sort = array('bs_detail.id','ASC');
        } else {
            $sort = array($columns_valid[$col],$dir);
        }
		$tgl = isset($_POST['tgl']) ? $_POST['tgl'] : '';		
		$jns_layanan = isset($_POST['jns_layanan']) ? (int)$_POST['jns_layanan'] : 0;	
		$store = isset($_POST['store']) ? (int)$_POST['store'] : 0;	
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'booking_service.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}	
		$member = array();
		$where = array('bs_detail.deleted_at'=>null);
		if($jns_layanan > 0){
			$where += array('booking_service.layanan'=>$jns_layanan);
		}
		if($store > 0){
			$where += array('booking_service.id_store'=>$store);
		}
		if(!empty($tgl)){
			$_tgl = !empty($tgl) ? explode('-', $tgl) : '';
			$start_date = !empty($tgl) ? str_replace('/','-',$_tgl[0]) : '';
			$end_date = !empty($tgl) ? str_replace('/','-',$_tgl[1]) : '';			
			
			$from = !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : $start_date;
			$to = !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : $end_date;
			if(!empty($from) && !empty($to)){
				$where += array('date_format(booking_service.tgl_service, "%Y-%m-%d") >='=> $from, 'date_format(booking_service.tgl_service, "%Y-%m-%d") <=' => $to);	
			}
		}
		$select = array('bs_detail.*','booking_service.*','customer.nama','customer.last_name','customer.email','bs_detail.nama_sp as bns','bs_detail.harga_sp as bhs');
		if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$member = $this->access->readtable('bs_detail',$select,$where,array('booking_service' => 'booking_service.id_booking = bs_detail.id_booking','customer' => 'customer.id_customer = booking_service.id_member'),'',$sort,'LEFT','',array('booking_service.nmr_booking'=>$search),'',$field_in, $_id_ta)->result_array();
						
		    $totalFiltered=count($member);
		    $totalData=count($member);
        }else{
			$member = $this->access->readtable('bs_detail',$select,$where,array('booking_service' => 'booking_service.id_booking = bs_detail.id_booking','customer' => 'customer.id_customer = booking_service.id_member'),array($requestData['length'],$requestData['start']),$sort,'LEFT','','','',$field_in, $_id_ta)->result_array();	
			
			$members = $this->access->readtable('bs_detail','',$where,array('booking_service' =>'booking_service.id_booking = bs_detail.id_booking'),'','','LEFT','','','',$field_in, $_id_ta)->result_array();
			
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
					$nam_sp = '';
					$nam_sp = $row['bns'];
					$status = '-';
					if(!empty($row['varian'])) $nam_sp .=' ('.$row['varian'].')';
					if($row['layanan'] == 1){
						$jenis_layanan = 'Home Service';
						$status = array();
						$status = array(
							1	=> 'Menunggu Jadwal Teknisi',
							2	=> 'On Schedule',
							9	=> 'Completed',
							10	=> 'Cancelled',
						);
					}
					if($row['layanan'] == 2){
						$jenis_layanan = 'Pickup Device';
						$status = array();
						$status = array(
							1	=> 'Menunggu Jadwal Kurir',
							2	=> 'On Schedule',
							3	=> 'Barang diterima iColor',
							4	=> 'Waiting diagnostic',
							5	=> 'Diagnostic',
							6	=> 'Waiting approval customer',
							7	=> 'On Progress',
							8	=> 'Waiting pickup by customer',
							9	=> 'Completed',
							10	=> 'Cancelled',
							13	=> 'Paket telah diterima customer',
						);
					}
					if($row['layanan'] == 3){
						$jenis_layanan = 'Kirim ke Toko';
						$status = array();
						$status = array(
							1	=> 'Menunggu konfirmasi kurir dari customer',
							2	=> 'Dalam Pengiriman',
							3	=> 'Barang diterima iColor',
							4	=> 'Waiting diagnostic',
							5	=> 'Diagnostic',
							6	=> 'Waiting approval customer',
							7	=> 'On Progress',
							8	=> 'Waiting pickup by customer',
							9	=> 'Completed',
							10	=> 'Cancelled',
						);
					}
					if($row['layanan'] == 4){
						$jenis_layanan = 'Instore';
						$status = array();
						$status = array(
							1	=> 'Menunggu antrian',							
							3	=> 'Barang diterima iColor',
							4	=> 'Waiting diagnostic',
							5	=> 'Diagnostic',
							6	=> 'Waiting approval customer',
							7	=> 'On Progress',
							8	=> 'Waiting pickup by customer',
							9	=> 'Completed',
							10	=> 'Cancelled',
						);
					}
					$nestedData[] = $i++.'.';				
					$nestedData[] = date('d-m-Y', strtotime($row['tgl_service']));			 	
					$nestedData[] = $row['nmr_booking'];			
					$nestedData[] = $row['nama_store'];			
					$nestedData[] = $row['nama'].' '.$row['last_name'];			
					$nestedData[] = $row['wa'];			
					$nestedData[] = $row['alamat'];			
					$nestedData[] = $row['email'];			
					$nestedData[] = $row['ig'];			
					$nestedData[] = $row['nama_cat'];			
					$nestedData[] = $row['nama_type'];			
					$nestedData[] = $row['imei'];			
					$nestedData[] = $row['passcode'];			
					$nestedData[] = $nam_sp;			
					$nestedData[] = number_format($row['bhs'],0,'',',');
					$nestedData[] = '-';			
					$nestedData[] = $row['nama_tk'];			
					$nestedData[] = '-';			
					$nestedData[] = !empty($row['jadwal_tk']) ? date('d-m-Y', strtotime($row['jadwal_tk'])) : '-';			
					$nestedData[] = $row['kurir'];			
					$nestedData[] = $row['no_awb'];			
					$nestedData[] = $status[(int)$row['status']];			
					$nestedData[] = $jenis_layanan;			
					$data[] = $nestedData;
				}
			}            
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalData), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

        echo json_encode($json_data);  // send data as json format
	}
	
	public function load_data_os(){
		ini_set('memory_limit', '-1');
        $requestData= $_REQUEST;
		// $select = array('members.*','admin.fullname'); 
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
			"shop_order.id_order ",
            "shop_order.created_at",
            "shop_order.id_order ",          
            "customer.nama",            
        );
		if(!isset($columns_valid[$col])) {
            $sort = array('shop_order.id_order','ASC');
        } else {
            $sort = array($columns_valid[$col],$dir);
        }
		$tgl = isset($_POST['tgl']) ? $_POST['tgl'] : '';		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : '';
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		// if((int)$mylevel > 1){
			// $field_in = 'booking_service.id_store';
			// $_store = explode(',',$my_store);
			// for($i=0;$i<count($_store); $i++){				
				// array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			// }
		// }	
		$member = array();
		$where = array();
		if($status > 0){
			$where += array('shop_order.status'=>$status);
		}
		if(!empty($tgl)){
			$_tgl = !empty($tgl) ? explode('-', $tgl) : '';
			$start_date = !empty($tgl) ? str_replace('/','-',$_tgl[0]) : '';
			$end_date = !empty($tgl) ? str_replace('/','-',$_tgl[1]) : '';			
			
			$from = !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : $start_date;
			$to = !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : $end_date;
			if(!empty($from) && !empty($to)){
				$where += array('date_format(shop_order.created_at, "%Y-%m-%d") >='=> $from, 'date_format(shop_order.created_at, "%Y-%m-%d") <=' => $to);	
			}
		}
		$select = array('shop_order_detail.*','shop_order.*','customer.nama','customer.last_name','customer.email','customer.phone');
		if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$member = $this->access->readtable('shop_order_detail',$select,$where,array('shop_order' => 'shop_order.id_order = shop_order_detail.id_order','customer' => 'customer.id_customer = shop_order.id_member'),'',$sort,'LEFT','',array('shop_order.order_no'=>$search),'',$field_in, $_id_ta)->result_array();
						
		    $totalFiltered=count($member);
		    $totalData=count($member);
        }else{
			$member = $this->access->readtable('shop_order_detail',$select,$where,array('shop_order' => 'shop_order.id_order = shop_order_detail.id_order','customer' => 'customer.id_customer = shop_order.id_member'),array($requestData['length'],$requestData['start']),$sort,'LEFT','','','',$field_in, $_id_ta)->result_array();	
			
			$members = $this->access->readtable('shop_order_detail','',$where,array('shop_order' => 'shop_order.id_order = shop_order_detail.id_order'),'','','LEFT','','','',$field_in, $_id_ta)->result_array();
			
			$totalData = count($members);
			$totalFiltered=count($members);
        }
		$data = array();
        $nestedData=array();
				
		$i=1;
		if($requestData['start'] > 0){
			$i += $requestData['start'];
		}
		 if(!empty($member)){            		
            foreach($member as $row) {
				$nestedData=array();
				if(empty($row['deleted_at'])){
					$nam_sp = '';
					$nam_sp = $row['nama_product'];
					$jml_before_disc = 0;
					$jml_before_disc = (int)$row['jml'] * $row['harga'];
					if(!empty($row['varian'])) $nam_sp .=' ('.$row['varian'].')';
					$nestedData[] = $i++.'.';				
					$nestedData[] = date('d-m-Y', strtotime($row['created_at']));			 	
					$nestedData[] = $row['order_no'];		
					$nestedData[] = $row['nama'].' '.$row['last_name'];			
					$nestedData[] = $row['phone'];			
					$nestedData[] = $row['alamat'];			
					$nestedData[] = $row['email'];			
					$nestedData[] = $nam_sp;			
					$nestedData[] = number_format($jml_before_disc,0,'',',');		
					$nestedData[] = (int)$row['diskon'] > 0 ? $row['diskon'].'%' : 0;			
					$nestedData[] = (int)$row['preorder'] > 0 ? 'Preorder' : 'Ready';			
					//$nestedData[] = '-';			
					$nestedData[] = $row['nama_bank_icolor'];			
					$nestedData[] = $row['bank_name'];			
					$nestedData[] = $row['no_rek'];			
					$nestedData[] = $row['nama_rek'];							
								
					$data[] = $nestedData;
				}
			}            
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalData), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

        echo json_encode($json_data);  // send data as json format
	}
	
	public function load_data_ops(){
		ini_set('memory_limit', '-1');
        $requestData= $_REQUEST;
		// $select = array('members.*','admin.fullname'); 
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
			"osp_detail.id",
            "order_sp.created_at",
            "osp_detail.id",
            "customer.nama",            
        );
		if(!isset($columns_valid[$col])) {
            $sort = array('osp_detail.id','ASC');
        } else {
            $sort = array($columns_valid[$col],$dir);
        }
		$tgl = isset($_POST['tgl']) ? $_POST['tgl'] : '';		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : '';	
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'order_sp.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}	
		$member = array();
		$where = array('osp_detail.deleted_at'=>null);
		if($status > 0){
			$where += array('order_sp.status'=>$status);
		}
		if(!empty($tgl)){
			$_tgl = !empty($tgl) ? explode('-', $tgl) : '';
			$start_date = !empty($tgl) ? str_replace('/','-',$_tgl[0]) : '';
			$end_date = !empty($tgl) ? str_replace('/','-',$_tgl[1]) : '';			
			
			$from = !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : $start_date;
			$to = !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : $end_date;
			if(!empty($from) && !empty($to)){
				$where += array('date_format(order_sp.created_at, "%Y-%m-%d") >='=> $from, 'date_format(order_sp.created_at, "%Y-%m-%d") <=' => $to);	
			}
		}
		$select = array('osp_detail.*','order_sp.*','customer.nama','customer.last_name','customer.email');
		if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$member = $this->access->readtable('osp_detail',$select,$where,array('order_sp' => 'order_sp.id_order = osp_detail.id_order','customer' => 'customer.id_customer = order_sp.id_member'),'',$sort,'LEFT','',array('order_sp.order_no'=>$search),'',$field_in, $_id_ta)->result_array();
						
		    $totalFiltered=count($member);
		    $totalData=count($member);
        }else{
			$member = $this->access->readtable('osp_detail',$select,$where,array('order_sp' => 'order_sp.id_order = osp_detail.id_order','customer' => 'customer.id_customer = order_sp.id_member'),array($requestData['length'],$requestData['start']),$sort,'LEFT','','','',$field_in, $_id_ta)->result_array();	
			$members = $this->access->readtable('osp_detail','',$where,array('order_sp' => 'order_sp.id_order = osp_detail.id_order'),'','','',$field_in, $_id_ta)->result_array();
			
			$totalData = count($members);
			$totalFiltered=count($members);
        }
		$data = array();
        $nestedData=array();
				
		$i=1;
		if($requestData['start'] > 0){
			$i += $requestData['start'];
		}
		 if(!empty($member)){            		
            foreach($member as $row) {
				$nestedData=array();
				if(empty($row['deleted_at'])){
					$nam_sp = '';
					$payment_name = '';
					$_status = '';
					$nam_sp = $row['nama_sp'];
					if(!empty($row['varian'])) $nam_sp .=' ('.$row['varian'].')';
					if((int)$row['pembayaran'] == 1) $payment_name = 'Cash';
					if((int)$row['pembayaran'] == 2) $payment_name = 'Manual Transfer';
					if((int)$row['status'] == 1) $_status = 'New Order';
					if((int)$row['status'] == 2) $_status = 'Waiting Verify Payment';
					if((int)$row['status'] == 3) $_status = 'Payment Rejected';
					if((int)$row['status'] == 4) $_status = 'Payment Verified';
					if((int)$row['status'] == 5) $_status = 'On Process';
					if((int)$row['status'] == 6) $_status = 'Completed';
					$nestedData[] = $i++.'.';				
					$nestedData[] = date('d-m-Y', strtotime($row['created_at']));			 	
					$nestedData[] = $row['order_no'];		
					$nestedData[] = $row['nama_store'];
					$nestedData[] = $row['nama'].' '.$row['last_name'];			
					$nestedData[] = $row['wa'];			
					$nestedData[] = $row['alamat'];			
					$nestedData[] = $row['email'];			
					$nestedData[] = $row['nama_cat'];			
					$nestedData[] = $row['nama_type'];						
					$nestedData[] = $nam_sp;			
					$nestedData[] = number_format($row['harga_sp'],0,'',',');								
					$nestedData[] = $_status;			
					$nestedData[] = $payment_name;			
					$nestedData[] = !empty($row['catatan_adm_payment']) ? $row['catatan_adm_payment'] : '-';			
					$data[] = $nestedData;
				}
			}            
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalData), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

        echo json_encode($json_data);  // send data as json format
	}
	
	function export_bs(){
		ini_set('memory_limit', '-1');
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setShowGridlines(false);
		$this->excel->getActiveSheet()->setTitle('Report Booking Service');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'Booking Service');		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('A1:W1');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
	
		$this->excel->getActiveSheet()->getStyle('A2:W2')->getFont()->setSize(10);				
		$this->excel->getActiveSheet()->getStyle('A2:W2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->getStyle('A2:W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->getStyle('A2:W2')->getFont()->setBold(true);
		$styleArray = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);				 																		
		// $this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(30); 

		$this->excel->getActiveSheet()->getStyle('A2:W2')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->setCellValue('A2', 'No.');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Tgl. Order');
		$this->excel->getActiveSheet()->setCellValue('C2', 'No. Order');
        $this->excel->getActiveSheet()->setCellValue('D2', 'Store');
		$this->excel->getActiveSheet()->setCellValue('E2', 'Nama Customer');
        $this->excel->getActiveSheet()->setCellValue('F2', 'No.Hp. Customer');
        $this->excel->getActiveSheet()->setCellValue('G2', 'Alamat Customer');
        $this->excel->getActiveSheet()->setCellValue('H2', 'Email Customer');
        $this->excel->getActiveSheet()->setCellValue('I2', 'IG Customer');
        $this->excel->getActiveSheet()->setCellValue('J2', 'Category Device');
        $this->excel->getActiveSheet()->setCellValue('K2', 'Type Device');
        $this->excel->getActiveSheet()->setCellValue('L2', 'IMEI');
        $this->excel->getActiveSheet()->setCellValue('M2', 'Pass Code');
        $this->excel->getActiveSheet()->setCellValue('N2', 'Kerusakan Part & Variant');
        $this->excel->getActiveSheet()->setCellValue('O2', 'Harga Part');
        $this->excel->getActiveSheet()->setCellValue('P2', 'Garansi');
        $this->excel->getActiveSheet()->setCellValue('Q2', 'Nama Teknisi');
        $this->excel->getActiveSheet()->setCellValue('R2', 'Durasi Pengerjaan');
        $this->excel->getActiveSheet()->setCellValue('S2', 'Jadwal Teknisi/Kurir');
        $this->excel->getActiveSheet()->setCellValue('T2', 'Nama Kurir');
        $this->excel->getActiveSheet()->setCellValue('U2', 'No. Resi');
        $this->excel->getActiveSheet()->setCellValue('V2', 'Status');        
        $this->excel->getActiveSheet()->setCellValue('W2', 'Jenis Layanan');        
        
		$this->excel->getActiveSheet()->getStyle('A2:W2')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					//->getStartColor()->setARGB('00c0ef');
					
		$tgl = isset($_POST['tgl']) ? $_POST['tgl'] : '';		
		$jns_layanan = isset($_POST['jns_layanan']) ? (int)$_POST['jns_layanan'] : 0;	
		$store = isset($_POST['store']) ? (int)$_POST['store'] : 0;	
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'booking_service.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}	
		$member = array();
		$where = array('bs_detail.deleted_at'=>null);
		if($jns_layanan > 0){
			$where += array('booking_service.layanan'=>$jns_layanan);
		}
		if($store > 0){
			$where += array('booking_service.id_store'=>$store);
		}
		if(!empty($tgl)){
			$_tgl = !empty($tgl) ? explode('-', $tgl) : '';
			$start_date = !empty($tgl) ? str_replace('/','-',$_tgl[0]) : '';
			$end_date = !empty($tgl) ? str_replace('/','-',$_tgl[1]) : '';			
			
			$from = !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : $start_date;
			$to = !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : $end_date;
			if(!empty($from) && !empty($to)){
				$where += array('date_format(booking_service.tgl_service, "%Y-%m-%d") >='=> $from, 'date_format(booking_service.tgl_service, "%Y-%m-%d") <=' => $to);	
			}
		}
		$select = array('bs_detail.*','booking_service.*','customer.nama','customer.last_name','customer.email','bs_detail.nama_sp as bns','bs_detail.harga_sp as bhs');
		$member = $this->access->readtable('bs_detail',$select,$where,array('booking_service' => 'booking_service.id_booking = bs_detail.id_booking','customer' => 'customer.id_customer = booking_service.id_member'),'',$sort,'LEFT','','','',$field_in, $_id_ta)->result_array();
		$jenis_layanan = '';	
		$i=3;
		$no = 1;
		if(!empty($member)){            		
            foreach($member as $row) {
				$nestedData=array();
				if(empty($row['deleted_at'])){
					$nam_sp = '';
					$nam_sp = $row['bns'];
					$status = '-';
					if(!empty($row['varian'])) $nam_sp .=' ('.$row['varian'].')';
					if($row['layanan'] == 1){
						$jenis_layanan = 'Home Service';	
						$status = array();
						$status = array(
							1	=> 'Menunggu Jadwal Teknisi',
							2	=> 'On Schedule',
							9	=> 'Completed',
							10	=> 'Cancelled',
						);
					}
					if($row['layanan'] == 2){
						$jenis_layanan = 'Pickup Device';	
						$status = array();
						$status = array(
							1	=> 'Menunggu Jadwal Kurir',
							2	=> 'On Schedule',
							3	=> 'Barang diterima iColor',
							4	=> 'Waiting diagnostic',
							5	=> 'Diagnostic',
							6	=> 'Waiting approval customer',
							7	=> 'On Progress',
							8	=> 'Waiting pickup by customer',
							9	=> 'Completed',
							10	=> 'Cancelled',
							13	=> 'Paket telah diterima customer',
						);
					}
					if($row['layanan'] == 3){
						$jenis_layanan = 'Kirim ke Toko';	
						$status = array();
						$status = array(
							1	=> 'Menunggu konfirmasi kurir dari customer',
							2	=> 'Dalam Pengiriman',
							3	=> 'Barang diterima iColor',
							4	=> 'Waiting diagnostic',
							5	=> 'Diagnostic',
							6	=> 'Waiting approval customer',
							7	=> 'On Progress',
							8	=> 'Waiting pickup by customer',
							9	=> 'Completed',
							10	=> 'Cancelled',
						);
					}
					if($row['layanan'] == 4){
						$jenis_layanan = 'Instore';	
						$status = array();
						$status = array(
							1	=> 'Menunggu antrian',							
							3	=> 'Barang diterima iColor',
							4	=> 'Waiting diagnostic',
							5	=> 'Diagnostic',
							6	=> 'Waiting approval customer',
							7	=> 'On Progress',
							8	=> 'Waiting pickup by customer',
							9	=> 'Completed',
							10	=> 'Cancelled',
						);
					}
					$this->excel->getActiveSheet()->setCellValue('A'.$i, $no++);
					$this->excel->getActiveSheet()->setCellValue('B'.$i, date('d-m-Y', strtotime($row['tgl_service'])));
					$this->excel->getActiveSheet()->setCellValue('C'.$i, $row['nmr_booking']);
					$this->excel->getActiveSheet()->setCellValue('D'.$i, $row['nama_store']);
					$this->excel->getActiveSheet()->setCellValue('E'.$i, $row['nama'].' '.$row['last_name']);
					$this->excel->getActiveSheet()->setCellValue('F'.$i, $row['wa']);	
					$this->excel->getActiveSheet()->setCellValue('G'.$i, $row['alamat']);
					$this->excel->getActiveSheet()->setCellValue('H'.$i, $row['email']);
					$this->excel->getActiveSheet()->setCellValue('I'.$i, $row['ig']);
					$this->excel->getActiveSheet()->setCellValue('J'.$i, $row['nama_cat']);
					$this->excel->getActiveSheet()->setCellValue('K'.$i, $row['nama_type']);
					$this->excel->getActiveSheet()->setCellValue('L'.$i, $row['imei']);
					$this->excel->getActiveSheet()->setCellValue('M'.$i, $row['passcode']);
					$this->excel->getActiveSheet()->setCellValue('N'.$i, $nam_sp);
					$this->excel->getActiveSheet()->setCellValue('O'.$i, $row['bhs']);
					$this->excel->getActiveSheet()->setCellValue('P'.$i, '-');
					$this->excel->getActiveSheet()->setCellValue('Q'.$i, $row['nama_tk']);
					$this->excel->getActiveSheet()->setCellValue('R'.$i, '-');
					$this->excel->getActiveSheet()->setCellValue('S'.$i, !empty($row['jadwal_tk']) ? date('d-m-Y', strtotime($row['jadwal_tk'])) : '-');
					$this->excel->getActiveSheet()->setCellValue('T'.$i, $row['kurir']);
					$this->excel->getActiveSheet()->setCellValue('U'.$i, $row['no_awb']);
					$this->excel->getActiveSheet()->setCellValue('V'.$i, $status[(int)$row['status']]);	
					$this->excel->getActiveSheet()->setCellValue('W'.$i, $jenis_layanan);	
					
					$this->excel->getActiveSheet()->getStyle('O'.$i)->getNumberFormat()->setFormatCode('0,000');
					$this->excel->getActiveSheet()->getStyle('A'.$i.':W'.$i)->applyFromArray($styleArray);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':W'.$i)->getFont()->setSize(10);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':W'.$i)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getStyle('B'.$i.':W'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);			
					$this->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':W'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$i++;
				}
			} 
			unset($styleArray);
        }
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		
		$filename ='reporting_booking_service.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 					 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  		
		$objWriter->save('php://output');
	}
	
	function export_ps(){
		ini_set('memory_limit', '-1');
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setShowGridlines(false);
		$this->excel->getActiveSheet()->setTitle('Report Part Service');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'Part Service');		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('A1:O1');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
		
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getFont()->setSize(10);				
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getFont()->setBold(true);
		$styleArray = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);				 																		
		// $this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(30); 

		$this->excel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->setCellValue('A2', 'No.');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Tgl. Order');
		$this->excel->getActiveSheet()->setCellValue('C2', 'No. Order');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Store');
        $this->excel->getActiveSheet()->setCellValue('E2', 'Nama Customer');
		$this->excel->getActiveSheet()->setCellValue('F2', 'No.Hp. Customer');
        $this->excel->getActiveSheet()->setCellValue('G2', 'Alamat Customer');
        $this->excel->getActiveSheet()->setCellValue('H2', 'Email Customer');
        $this->excel->getActiveSheet()->setCellValue('I2', 'Category Device');
        $this->excel->getActiveSheet()->setCellValue('J2', 'Type Device');
        $this->excel->getActiveSheet()->setCellValue('K2', 'Kerusakan Part & Variant');
        $this->excel->getActiveSheet()->setCellValue('L2', 'Harga');
        $this->excel->getActiveSheet()->setCellValue('M2', 'Status');
        $this->excel->getActiveSheet()->setCellValue('N2', 'Metode Pembayaran');
        $this->excel->getActiveSheet()->setCellValue('O2', 'Catatan');
            
        
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		
		$sort = array();
		$tgl = isset($_POST['tgl']) ? $_POST['tgl'] : '';		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : '';	
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		if((int)$mylevel > 1){
			$field_in = 'order_sp.id_store';
			$_store = explode(',',$my_store);
			for($i=0;$i<count($_store); $i++){				
				array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			}
		}	
		$member = array();
		$where = array('osp_detail.deleted_at'=>null);
		if($status > 0){
			$where += array('order_sp.status'=>$status);
		}
		if(!empty($tgl)){
			$_tgl = !empty($tgl) ? explode('-', $tgl) : '';
			$start_date = !empty($tgl) ? str_replace('/','-',$_tgl[0]) : '';
			$end_date = !empty($tgl) ? str_replace('/','-',$_tgl[1]) : '';			
			
			$from = !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : $start_date;
			$to = !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : $end_date;
			if(!empty($from) && !empty($to)){
				$where += array('date_format(order_sp.created_at, "%Y-%m-%d") >='=> $from, 'date_format(order_sp.created_at, "%Y-%m-%d") <=' => $to);	
			}
		}
		$select = array('osp_detail.*','order_sp.*','customer.nama','customer.last_name','customer.email');
		$member = $this->access->readtable('osp_detail',$select,$where,array('order_sp' => 'order_sp.id_order = osp_detail.id_order','customer' => 'customer.id_customer = order_sp.id_member'),'',$sort,'LEFT','','','',$field_in, $_id_ta)->result_array();	
		
		$i=3;
		$no = 1;
		if(!empty($member)){            		
            foreach($member as $row) {
				$nestedData=array();
				if(empty($row['deleted_at'])){
					$nam_sp = '';
					$payment_name = '';
					$_status = '';
					$nam_sp = $row['nama_sp'];
					if(!empty($row['varian'])) $nam_sp .=' ('.$row['varian'].')';
					if((int)$row['pembayaran'] == 1) $payment_name = 'Cash';
					if((int)$row['pembayaran'] == 2) $payment_name = 'Manual Transfer';
					if((int)$row['status'] == 1) $_status = 'New Order';
					if((int)$row['status'] == 2) $_status = 'Waiting Verify Payment';
					if((int)$row['status'] == 3) $_status = 'Payment Rejected';
					if((int)$row['status'] == 4) $_status = 'Payment Verified';
					if((int)$row['status'] == 5) $_status = 'On Process';
					if((int)$row['status'] == 6) $_status = 'Completed';
					
					$this->excel->getActiveSheet()->setCellValue('A'.$i, $no++);
					$this->excel->getActiveSheet()->setCellValue('B'.$i, date('d-m-Y', strtotime($row['created_at'])));
					$this->excel->getActiveSheet()->setCellValue('C'.$i, $row['order_no']);
					$this->excel->getActiveSheet()->setCellValue('D'.$i, $row['nama_store']);
					$this->excel->getActiveSheet()->setCellValue('E'.$i, $row['nama'].' '.$row['last_name']);
					$this->excel->getActiveSheet()->setCellValue('F'.$i, $row['wa']);
					$this->excel->getActiveSheet()->setCellValue('G'.$i, $row['alamat']);	
					$this->excel->getActiveSheet()->setCellValue('H'.$i, $row['email']);
					$this->excel->getActiveSheet()->setCellValue('I'.$i, $row['nama_cat']);
					$this->excel->getActiveSheet()->setCellValue('J'.$i, $row['nama_type']);
					$this->excel->getActiveSheet()->setCellValue('K'.$i, $nam_sp);
					$this->excel->getActiveSheet()->setCellValue('L'.$i, $row['harga_sp']);
					$this->excel->getActiveSheet()->setCellValue('M'.$i, $_status);
					$this->excel->getActiveSheet()->setCellValue('N'.$i, $payment_name);
					$this->excel->getActiveSheet()->setCellValue('O'.$i, !empty($row['catatan_adm_payment']) ? $row['catatan_adm_payment'] : '-');
										
					$this->excel->getActiveSheet()->getStyle('L'.$i)->getNumberFormat()->setFormatCode('0,000');
					$this->excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->applyFromArray($styleArray);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFont()->setSize(10);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getStyle('B'.$i.':O'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);			
					$this->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$i++;
				}
			} 
			unset($styleArray);
        }
		
		
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		
		$filename ='reporting_part_service.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 					 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  		
		$objWriter->save('php://output');
	}
	
	function export_os(){
		ini_set('memory_limit', '-1');
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setShowGridlines(false);
		$this->excel->getActiveSheet()->setTitle('Report Order Shop');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'Order Shop');		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('A1:O1');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getFont()->setSize(10);				
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getFont()->setBold(true);
		$styleArray = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);				 																		
		// $this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(30); 

		$this->excel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->setCellValue('A2', 'No.');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Tgl. Order');
		$this->excel->getActiveSheet()->setCellValue('C2', 'No. Order');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Nama Customer');
        $this->excel->getActiveSheet()->setCellValue('E2', 'No.Hp. Customer');
		$this->excel->getActiveSheet()->setCellValue('F2', 'Alamat Customer');
        $this->excel->getActiveSheet()->setCellValue('G2', 'Email Customer');
        $this->excel->getActiveSheet()->setCellValue('H2', 'Product & Variant');
        $this->excel->getActiveSheet()->setCellValue('I2', 'Jumlah Harga sebelum Diskon');
        $this->excel->getActiveSheet()->setCellValue('J2', 'Diskon');
        $this->excel->getActiveSheet()->setCellValue('K2', 'PO/Ready');
        $this->excel->getActiveSheet()->setCellValue('L2', 'Bank Penerima(iColor)');
        $this->excel->getActiveSheet()->setCellValue('M2', 'Bank Pengirim');
        $this->excel->getActiveSheet()->setCellValue('N2', 'No.Rek Pengirim');
        $this->excel->getActiveSheet()->setCellValue('O2', 'Nama Pengirim');
            
        
		$this->excel->getActiveSheet()->getStyle('A2:O2')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		
		$sort = array();
		$tgl = isset($_POST['tgl']) ? $_POST['tgl'] : '';		
		$status = isset($_POST['status']) ? (int)$_POST['status'] : '';	
		$my_store = $this->session->userdata('mystore');
		$mylevel = $this->session->userdata('mylevel');		
		$storee = array();
		$_id_ta = array();
		$field_in = '';
		// if((int)$mylevel > 1){
			// $field_in = 'booking_service.id_store';
			// $_store = explode(',',$my_store);
			// for($i=0;$i<count($_store); $i++){				
				// array_push($_id_ta,(int)str_replace(' ','',$_store[$i]));	
			// }
		// }	
		$member = array();
		$where = array();
		if($status > 0){
			$where += array('shop_order.status'=>$status);
		}
		if(!empty($tgl)){
			$_tgl = !empty($tgl) ? explode('-', $tgl) : '';
			$start_date = !empty($tgl) ? str_replace('/','-',$_tgl[0]) : '';
			$end_date = !empty($tgl) ? str_replace('/','-',$_tgl[1]) : '';			
			
			$from = !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : $start_date;
			$to = !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : $end_date;
			if(!empty($from) && !empty($to)){
				$where += array('date_format(shop_order.created_at, "%Y-%m-%d") >='=> $from, 'date_format(shop_order.created_at, "%Y-%m-%d") <=' => $to);	
			}
		}
		$select = array('shop_order_detail.*','shop_order.*','customer.nama','customer.last_name','customer.email','customer.phone');
		$member = $this->access->readtable('shop_order_detail',$select,$where,array('shop_order' => 'shop_order.id_order = shop_order_detail.id_order','customer' => 'customer.id_customer = shop_order.id_member'),'',$sort,'LEFT','','','',$field_in, $_id_ta)->result_array();		
		
		$i=3;
		$no = 1;
		if(!empty($member)){            		
            foreach($member as $row) {
				$nestedData=array();
				if(empty($row['deleted_at'])){
					$nam_sp = '';
					$nam_sp = $row['nama_product'];
					$jml_before_disc = 0;
					$jml_before_disc = (int)$row['jml'] * $row['harga'];
					if(!empty($row['varian'])) $nam_sp .=' ('.$row['varian'].')';				
					
					$this->excel->getActiveSheet()->setCellValue('A'.$i, $no++);
					$this->excel->getActiveSheet()->setCellValue('B'.$i, date('d-m-Y', strtotime($row['created_at'])));
					$this->excel->getActiveSheet()->setCellValue('C'.$i, $row['order_no']);
					
					$this->excel->getActiveSheet()->setCellValue('D'.$i, $row['nama'].' '.$row['last_name']);
					$this->excel->getActiveSheet()->setCellValue('E'.$i, $row['phone']);
					$this->excel->getActiveSheet()->setCellValue('F'.$i, $row['alamat']);	
					$this->excel->getActiveSheet()->setCellValue('G'.$i, $row['email']);
					$this->excel->getActiveSheet()->setCellValue('H'.$i, $nam_sp);
					$this->excel->getActiveSheet()->setCellValue('I'.$i, $jml_before_disc);
					$this->excel->getActiveSheet()->setCellValue('J'.$i, (int)$row['diskon'] > 0 ? $row['diskon'].'%' : 0);
					$this->excel->getActiveSheet()->setCellValue('K'.$i, (int)$row['preorder'] > 0 ? 'Preorder' : 'Ready');
					$this->excel->getActiveSheet()->setCellValue('L'.$i, $row['nama_bank_icolor']);
					$this->excel->getActiveSheet()->setCellValue('M'.$i, $row['bank_name']);
					$this->excel->getActiveSheet()->setCellValue('N'.$i, $row['no_rek']);
					$this->excel->getActiveSheet()->setCellValue('O'.$i, $row['nama_rek']);
										
					$this->excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('0000');
					$this->excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('0,000');
					$this->excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->applyFromArray($styleArray);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFont()->setSize(10);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getStyle('B'.$i.':O'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);			
					$this->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$i++;
				}
			} 
			unset($styleArray);
        }
		
		
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		
		$filename ='reporting_order_shop.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 					 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  		
		$objWriter->save('php://output');
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
