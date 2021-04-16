<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
	.box-header {
		color: #444;
		display: block;
		padding: 10px;
		position: relative;
	}
	.form-control[readonly]{
		background-color: #fff;
		cursor:text;
	}
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
	}

?>
<div class="modal fade" role="dialog" id="confirm_cancel">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="catatan_cancel" id="catatan_cancel" placeholder="Catatan" rows=5></textarea>
                 
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">                               
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>              
                <button type="button" class="btn btn-success btn_setcancel">Set Cancel</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_complete">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="catatan_complete" id="catatan_complete" placeholder="Catatan" rows=5></textarea>
                 
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">                               
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>              
                <button type="button" class="btn btn-success btn_setcomplete">Set Complete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_st">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="catatan_st" id="catatan_st" placeholder="Catatan" rows=5></textarea>
                 
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">
                               
                <button type="button" class="btn btn-warning btn_waiting_pickup">Waiting Pickup by Customer</button>               
                <button type="button" class="btn btn-success btn_onprogress">On Progress</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_booking">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="catatan_booking" id="catatan_booking" placeholder="Catatan" rows=5></textarea>
                 
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">
                               
                <button type="button" class="btn btn-warning btn_waiting_need">Waiting Approval Customer</button>               
                <button type="button" class="btn btn-success btn_onprogress">On Progress</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="frm_tk">
          <div class="modal-dialog" style="width:442px;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Info Pengiriman</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				 <div class="form-group">
                  <label>Kurir</label>
                  <input type="text" class="form-control" name="nama_tk" id="nama_tk" value="" placeholder="Kurir" autocomplete="off" readonly />
                </div>
				
				 <div class="form-group">
                  <label>No. AWB</label>
                  <input type="text" class="form-control" name="email_tk" id="email_tk" value="" placeholder="No. AWB" autocomplete="off" readonly />
                </div>
				<div class="form-group">
                  <label for="pemeriksa">Photo Resi</label>
					<div class="fileupload-new thumbnail" style="width: 400px; height: 255px;">
						<img id="blah_resi" style="width: 400px; height: 240px;" src="" alt="">
					</div>
                </div>
              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>               
                             
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_terima">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin telah menerima paket ini ? </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label><span class="label label-danger pull-right catatan_terima_error"></span>
                  <textarea class="form-control" name="catatan_terima" id="catatan_terima" placeholder="Catatan" rows=5></textarea>
                 
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_terima">Ya, telah diterima</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_diagnostic">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="catatan_diagnostic" id="catatan_diagnostic" placeholder="Catatan" rows=5></textarea>
                 
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_diagnostic">Set diagnostic</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_wd">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label><span class="label label-danger pull-right catatan_terima_error"></span>
                  <textarea class="form-control" name="catatan_wd" id="catatan_wd" placeholder="Catatan" rows=5></textarea>
                 
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_wd">Set waiting diagnostic</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="import_dialog">
          <div class="modal-dialog" style="width:800px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Manual Transfer</strong></h4>
              </div>
			 
              <div class="modal-body">
				<form role="form" id="frm_import" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
				<div class="row">
				<div class="col-md-6">
				<div class="form-group">
                  <label for="pemeriksa">Confirmation date</label>
				  <input type="text" class="form-control" name="confirm_date" id="confirm_date" placeholder="Name" readonly>
                  <input type="hidden" class="form-control" name="id_trans" id="id_trans" value="">
                </div>
				<div class="form-group">
					<label for="pemeriksa">Bank</label>
					<input type="text" class="form-control" name="confirm_bank" id="confirm_bank" placeholder="Bank" readonly>		
                </div>
				<div class="form-group">
					<label for="pemeriksa">Sender</label>
					<input type="text" class="form-control" name="confirm_sender" id="confirm_sender" placeholder="Sender dan No.Rekening" readonly>		
                </div> 
				<div class="form-group">
					<label for="pemeriksa">Jumlah Transfer</label>
					<input type="text" class="form-control" name="jml_transfer" id="jml_transfer" placeholder="Jumlah Transfer" readonly>		
                </div> 
                </div>
				<div class="col-md-6">
				
				
				<div class="form-group">
                  <label for="pemeriksa">Photo bukti pembayaran</label><span class="label label-danger pull-right deskripsi_error"></span>
					<div class="fileupload-new thumbnail" style="width: 350px; height: 255px;">
						<img id="blah_selfie" style="width: 350px; height: 240px;" src="" alt="">
					</div>
                </div>
				
                </div>
				<div class="col-sm-12">
					<label for="pemeriksa">Catatan</label>
					<input type="text" class="form-control" name="catatan_payment" id="catatan_payment" placeholder="Catatan" readonly >	
				</div>
                </div>
				
              </div>
              <div class="modal-footer verify_acc" style="margin-top:0px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-warning btn_rej">Reject</button>               
                <button type="button" class="btn btn-success btn_appr">Approve</button>               
              </div>
            </div>
			</form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="frm_category">
          <div class="modal-dialog" style="width:500px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Set Kurir</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="form-group">
                  <label>Kurir</label><span class="label label-danger pull-right teknisi_error"></span>
					<select class="form-control" name="teknisi" id="teknisi" style="width:100%;">
						<option value=''>- Pilih Kurir -</option>
						<?php if(!empty($teknisi)){
							foreach($teknisi as $t){
								echo '<option value='.$t['id'].'>'.$t['nama'].'</option>';
								
							}
						}?>							
					</select>
                  <input type="hidden" value="" name="id_booking" id="id_booking">
                  
                </div>
				<div class="form-group">
                  <label>Tanggal</label><span class="label label-danger pull-right tgl_error"></span>
                  <input type="text" class="form-control" name="tgl" id="tgl" value="" placeholder="Tanggal" autocomplete="off" readonly />
                  
                  
                </div>
                <div class="form-group">
                  <label>Catatan</label><span class="label label-danger pull-right category_error"></span>
                  <textarea class="form-control" name="catatan" id="catatan" placeholder="Catatan" rows=5></textarea>
                 
                </div>
                
				
				</div>
                
              </form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_save">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>


 <div class="box box-success">

<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
					
			<th style="text-align:center; width:13%">No.Booking</th>		
			<th style="text-align:center; width:20%">Customer</th>	
			<th style="text-align:center; width:15%">Device Category - Type</th>
			<th style="text-align:center; width:15%">Service</th>	
			<th style="text-align:center; width:15%">List Spare Parts</th>
			<th style="text-align:center; width:15%">Total</th>	
			<th style="text-align:center; width:8%">Action</th>	
			
			
			
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';	
				$payment = '';		
				$_status = '';		
				$btn_action = '';		
				$_class = '';
				$today = date_create(date('Y-m-d H:i:s'));
				if(!empty($booking_service)){		
					foreach($booking_service as $c){
						$_class = '';
						$default_work = 14 + (int)$c['extend_work'];
						if(!empty($c['tgl_diterima'])){							
							$tgl_diterima =  date_create($c['tgl_diterima']);						
							$diff  = date_diff($today, $tgl_diterima);
							$wktu_berjalan = (int)$default_work - (int)$diff->d;
							if((int)$wktu_berjalan <=4){
								//$_class = 'until_over';
							}
							if((int)$wktu_berjalan < 0){
								//$_class = 'over_work';
							}
						}			
						$path_payment ='';
						$_info = '';
						$info_kurir = '';
						$path_kurir = '';
						$btn_action = '';
						$dt_sp = '';
						$list_sp = '';
						$dt_sp = $sp[$c['id_booking']];
						$list_sp = !empty($dt_sp) ? implode(', ',$dt_sp) : '-';
						$path_kurir = !empty($c['img_kurir']) ? base_url('uploads/pengiriman/'.$c['img_kurir']) : base_url('uploads/no_photo.jpg');
						$info_kurir = $c['kurir'].'Þ'.$c['no_awb'].'Þ'.$c['catatan_pengiriman'].'Þ'.date('d-m-Y H:i',strtotime($c['tgl_kirim'])).'Þ'.$path_kurir;
						$path_payment = !empty($c['img_transfer']) ? base_url('uploads/payment/'.$c['img_transfer']) : base_url('uploads/no_photo.jpg');						
						$_info = $c['id_booking'].'Þ'.$c['bank_name'].'Þ'.$c['no_rek'].'Þ'.$c['nama_rek'].'Þ'.number_format($c['jml_transfer'],0,'',',').'Þ'.date('d-m-Y H:i',strtotime($c['date_transfer'])).'Þ'.$path_payment.'Þ'.(int)$c['status_transfer'].'Þ'.$c['catatan_adm_payment'];
						if($c['pembayaran'] == 1) $payment = 'Cash';
						if($c['pembayaran'] == 2) $payment = 'Manual Transfer';
						if($c['pembayaran'] == 2 && (int)$c['status_transfer'] == 1 && $c['status'] >= 7) $payment = '<a href="#import_dialog" title="View data payment" id="'.$_info.'" >Manual Transfer</a>';
						if($c['pembayaran'] == 2 && (int)$c['status_transfer'] == 2 && $c['status'] >= 7) $payment = '<a href="#import_dialog" title="View data payment" id="'.$_info.'" >Manual Transfer/Paid</a>';
						if($c['pembayaran'] == 2 && (int)$c['status_transfer'] == 3 && $c['status'] >= 7) $payment = '<a href="#import_dialog" title="View data payment" id="'.$_info.'" >Manual Transfer/Reject</a>';
						if($c['status'] == 1){
							$_status = '<small class="label label-info"><strong>Menunggu konfirmasi kurir dari customer</strong></small>';
								
						}
						if($c['status'] == 2){
							$_status = '<small class="label label-warning"><strong><a style="color:#ffffff;" id="'.$info_kurir.'" href="#getinfo_tk">Dalam Pengiriman</a></strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_booking'].'" class="btn btn-xs btn-success btn_confirm"> Diterima </button><br/>';
						}
						if($c['status'] == 3){
							$_status = '<small class="label label-success"><strong>Barang diterima iColor</strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_booking'].'" class="btn btn-xs btn-danger btn_w_diagnostic"> Waiting<br/>Diagnostic </button><br/>';
						}
						if($c['status'] == 4){
							$_status = '<small class="label label-warning"><strong>Waiting diagnostic</strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_booking'].'" class="btn btn-xs btn-success btn_diagnostic">Diagnostic </button><br/>';
						}
						if($c['status'] == 5){
							$_status = '<small class="label label-success"><strong>Diagnostic</strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_booking'].'" class="btn btn-xs btn-warning btn_confirm_booking"> Confirm </button><br/>';
						}
						if($c['status'] == 6){
							$_status = '<small class="label label-warning"><strong>Waiting approval customer</strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_booking'].'" class="btn btn-xs btn-danger btn_set_status"> Set Status </button><br/>';
						}
						if($c['status'] == 7){
							$_status = '<small class="label label-success"><strong>On Progress</strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_booking'].'" class="btn btn-xs btn-danger btn_set_complete"> Complete </button><br/>';
						}
						if($c['status'] == 8){
							$_status = '<small class="label label-danger"><strong>Waiting pickup by customer</strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_booking'].'" class="btn btn-xs btn-danger btn_set_cancel"> Cancel </button><br/>';
						}
						if($c['status'] == 9){
							if($c['pembayaran'] == 1) $payment = 'Cash/Paid';
							$_status = '<small class="label label-danger"><strong>Completed</strong></small>';							
						}
						if($c['status'] == 10){
							$_status = '<small class="label label-danger"><strong>Cancelled</strong></small>';							
						}
						$btn_action .= '<a href="'.site_url('booking_service/bs_detail/'.$c['id_booking']).'"><button style="width:68px;" title="View" class="btn btn-xs btn-info"> View </button></a>';
						$total = $c['biaya_layanan'] + $c['harga_sp'];
						echo '<tr class="'.$_class.'">';
						echo '<td align="center">'.$i++.'.</td>';
						
						echo '<td>'.$c['nmr_booking'].'<br/><b>Store</b> : '.$c['nama_store'].'</td>';
						echo '<td>'.$c['nama'].'<br>Alamat :'.$c['alamat'].', <a target="_blank" href="https://api.whatsapp.com/send?phone='.$c['wa'].'">'.$c['wa'].'</a></td>'; 
						echo '<td>'.$c['nama_cat'].' - '.$c['nama_type'].'</td>';
						echo '<td><b>Tgl.Service</b> : '.date('d-m-Y', strtotime($c['tgl_service'])).'<br/>'.$_status.'</td>';
						echo '<td>'.$list_sp.'</td>';
						echo '<td>Spare Parts : '.number_format($c['harga_sp'],0,'',',').'<br><b>Payment</b> : '.$payment.'</td>';
						echo '<td align="center">'.$btn_action.'</td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>
<link href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
$("#teknisi").select2({});
$("input").attr("autocomplete", "off"); 
$('#tgl').datetimepicker({
	dayOfWeekStart : 1,
	changeYear: false,
	timepicker:false,
	scrollInput:false,
	format:'d-m-Y',
	lang:'en',
	minDate: '<?php echo date('d/m/Y');?>'
});
$('a[href$="#import_dialog"]').on( "click", function() {
	$('.verify_acc').hide();
	$('#blah_selfie').attr('src', '');
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_trans').val(dt[0]);
	$('#confirm_date').val(dt[5]);
	$('#confirm_bank').val(dt[1]);	
	$('#confirm_sender').val(dt[2]+' - '+dt[3]);	
	$('#jml_transfer').val(dt[4]);	
	$('#blah_selfie').attr('src', dt[6]);
	$('#catatan_payment').val(dt[8]);	
	if(dt[7] == 1) {
		$('.verify_acc').show();
		$('#catatan_payment').attr("readonly", false); 
	}
	$('#import_dialog').modal({
		backdrop: 'static',
		keyboard: false
	});
   $('#import_dialog').modal('show');
});
$('a[href$="#getinfo_tk"]').on( "click", function() {
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#nama_tk').val(dt[0]);	
	$('#email_tk').val(dt[1]);
	$('#blah_resi').attr('src', dt[4]);
	$('#frm_tk').modal({
		backdrop: 'static',
		keyboard: false
	});
   $('#frm_tk').modal('show');
});
$('.btn_confirm').click(function(){	
	$('#frm_cat').find("input[type=text], select").val("");	
	var val = $(this).get(0).id;
	
	$('#confirm_terima').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#id_booking').val(val);
	$('#confirm_terima').modal('show');
});
$('.btn_w_diagnostic').click(function(){	
	$('#frm_cat').find("input[type=text], select").val("");	
	var val = $(this).get(0).id;
	
	$('#confirm_wd').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#id_booking').val(val);
	$('#confirm_wd').modal('show');
});
$('.yes_wd').click(function(){
	var catatan = $('#catatan_wd').val();
	var id_booking = $('#id_booking').val();
	var url = '<?php echo site_url('booking_service/set_waiting_diagnostic');?>';
	$.ajax({
		data:{catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_wd').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.yes_terima').click(function(){
	var catatan_terima = $('#catatan_terima').val();
	var id_booking = $('#id_booking').val();
	var url = '<?php echo site_url('booking_service/set_terima');?>';
	$.ajax({
		data:{id_booking:id_booking,catatan:catatan_terima},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_terima').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.yes_save').click(function(){
	var teknisi = $('#teknisi').val();
	var tgl = $('#tgl').val();
	$('.teknisi_error').text('');
	$('.tgl_error').text('');
	if(teknisi <= 0 || teknisi == '') {
		$('.teknisi_error').text('Kurir harus dipilih');
		return false;
	}
	if(tgl == '') {
		$('.tgl_error').text('Tanggal harus diisi');
		return false;
	}
	var url = '<?php echo site_url('booking_service/set_kurir');?>';
	$('#tgl').attr("readonly", false); 
	var dt = $('#frm_cat').serialize();
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#frm_category').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
	
});
$('.btn_appr').click(function(){
	var id_booking = $('#id_trans').val();
	var catatan = $('#catatan_payment').val();
	var url = '<?php echo site_url('booking_service/set_payment');?>';
	$.ajax({
		data:{status:2,catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#import_dialog').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.btn_rej').click(function(){
	var id_booking = $('#id_trans').val();
	var catatan = $('#catatan_payment').val();
	var url = '<?php echo site_url('booking_service/set_payment');?>';
	$.ajax({
		data:{status:3,catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#import_dialog').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.btn_diagnostic').click(function(){	
	$('#frm_cat').find("input[type=text], select").val("");	
	var val = $(this).get(0).id;
	
	$('#confirm_diagnostic').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#id_booking').val(val);
	$('#confirm_diagnostic').modal('show');
});
$('.yes_diagnostic').click(function(){
	var catatan = $('#catatan_diagnostic').val();
	var id_booking = $('#id_booking').val();
	var url = '<?php echo site_url('booking_service/set_diagnostic');?>';
	$.ajax({
		data:{catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_diagnostic').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.btn_set_status').click(function(){	
	$('#frm_cat').find("input[type=text], select").val("");	
	var val = $(this).get(0).id;
	
	$('#confirm_st').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#id_booking').val(val);
	$('#confirm_st').modal('show');
});
$('.btn_waiting_need').click(function(){
	var catatan = $('#catatan_booking').val();
	var id_booking = $('#id_booking').val();
	var url = '<?php echo site_url('booking_service/need_approval');?>';
	$.ajax({
		data:{catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_booking').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.btn_onprogress').click(function(){
	var catatan = $('#catatan_booking').val();
	if(catatan == '') catatan = $('#catatan_st').val();
	var id_booking = $('#id_booking').val();
	var url = '<?php echo site_url('booking_service/set_onprogress');?>';
	$.ajax({
		data:{catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_booking').modal('hide');
				$('#confirm_st').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.btn_waiting_pickup').click(function(){
	var catatan = $('#catatan_st').val();
	var id_booking = $('#id_booking').val();
	var url = '<?php echo site_url('booking_service/set_pickup_by_cust');?>';
	$.ajax({
		data:{catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_booking').modal('hide');
				$('#confirm_st').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.btn_setcancel').click(function(){
	var catatan = $('#catatan_cancel').val();	
	var id_booking = $('#id_booking').val();
	var url = '<?php echo site_url('booking_service/set_cancel');?>';
	$.ajax({
		data:{catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_cancel').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.btn_setcomplete').click(function(){
	var catatan = $('#catatan_complete').val();	
	var id_booking = $('#id_booking').val();
	var url = '<?php echo site_url('booking_service/set_complete');?>';
	$.ajax({
		data:{catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_complete').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.btn_set_cancel').click(function(){	
	$('#frm_cat').find("input[type=text], select").val("");	
	var val = $(this).get(0).id;
	
	$('#confirm_cancel').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#id_booking').val(val);
	$('#confirm_cancel').modal('show');
});
$('.btn_set_complete').click(function(){	
	$('#frm_cat').find("input[type=text], select").val("");	
	var val = $(this).get(0).id;
	
	$('#confirm_complete').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#id_booking').val(val);
	$('#confirm_complete').modal('show');
});
$('.btn_confirm_booking').click(function(){	
	$('#frm_cat').find("input[type=text], select").val("");	
	var val = $(this).get(0).id;
	
	$('#confirm_booking').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#id_booking').val(val);
	$('#confirm_booking').modal('show');
});
$("#userfile").change(function(){
	$('#blah').attr('src', '');
	readURL(this);
});
function readURL(input) {
   if (input.files && input.files[0]) {
        var reader = new FileReader();            
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }            
        reader.readAsDataURL(input.files[0]);
    }
}

$(function() {               
    $('#example88').dataTable({scrollX: "1500px"});
});

$('.first').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
				// return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
			}
		}
	});
</script>
