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
<div class="modal fade" role="dialog" id="confirm_req_cancel">
          <div class="modal-dialog" style="width:520px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation Request Cancel</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Pelanggan telah melakukan request cancel pada transaksi ini,<br/>silahkan pilih untuk proses selanjutnya </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="catatan_req_cancel" id="catatan_req_cancel" placeholder="Catatan" rows=5></textarea>
                 
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">
                               
                             
                <button type="button" class="btn btn-warning yes_rej_req">Reject Req. Cancel</button>               
                <button type="button" class="btn btn-danger yes_appr_req">Approve Req. Cancel</button>               
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
				<h4 class="text-center">Apakah anda yakin <br/>akan mengirimkan paket pada transaksi ini ? </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="catatan_booking" id="catatan_booking" placeholder="Catatan" rows=5></textarea>
                 <input type="hidden" value="" name="id_booking" id="id_booking">
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>               
                             
                <button type="button" class="btn btn-success yes_appr">Kirim</button>               
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
<div class="modal fade" role="dialog" id="confirm_booking_onprocess">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin <br/>akan memproses pesanan ini ? </h4>
				<br/>
				<div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="catatan_booking_onprocess" id="catatan_booking_onprocess" placeholder="Catatan" rows=5></textarea>
                 
                </div>
              </div>
              <div class="modal-footer" style="margin-top:0px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>               
                             
                <button type="button" class="btn btn-success yes_appr_onprocess">Proses</button>               
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
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>		
			<th style="text-align:center; width:15%">Customer</th>	
			<th style="text-align:center; width:20%">Alamat</th>	
			<th style="text-align:center; width:13%">Total</th>		
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
				if(!empty($booking_service)){		
					foreach($booking_service as $c){	
						$path_payment ='';
						$_info = '';
						$_status = '';
						$btn_action = '';
						
						$path_payment = !empty($c['img_transfer']) ? base_url('uploads/payment/'.$c['img_transfer']) : base_url('uploads/no_photo.jpg');						
						$_info = $c['id_booking'].'Þ'.$c['bank_name'].'Þ'.$c['no_rek'].'Þ'.$c['nama_rek'].'Þ'.number_format($c['jml_transfer'],0,'',',').'Þ'.date('d-m-Y H:i',strtotime($c['date_transfer'])).'Þ'.$path_payment.'Þ'.(int)$c['status_transfer'].'Þ'.$c['catatan_adm_payment'];
						if($c['pembayaran'] == 1) $payment = 'Cash';
						
						if($c['pembayaran'] == 2) $payment = 'Manual Transfer';
						if($c['pembayaran'] == 2 && (int)$c['status_transfer'] >= 1 && $c['status'] > 2) $payment = '<a href="#import_dialog" title="View data payment" id="'.$_info.'" >Manual Transfer</a>';
						if($c['pembayaran'] == 2 && (int)$c['status_transfer'] == 2 && $c['status'] >= 7) $payment = '<a href="#import_dialog" title="View data payment" id="'.$_info.'" >Paid</a>';
						if($c['pembayaran'] == 2 && (int)$c['status_transfer'] == 3 && $c['status'] >= 7) $payment = '<a href="#import_dialog" title="View data payment" id="'.$_info.'" >Reject</a>';
						if($c['status'] == 1){
							$_status = '<small class="label label-info"><strong>Waiting Payment</strong></small><br/>';							
						}
						
						if($c['status'] == 3){
							$_status = '<small class="label label-warning"><strong>Payment Rejected</strong></small>';
						}
						if($c['status'] == 4){
							$_status = '<small class="label label-success"><strong>Payment Verified</strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_order'].'" class="btn btn-xs btn-warning btn_confirm"> On Progress </button><br/>';
						}
						if($c['status'] == 5){
							$_status = '<small class="label label-success"><strong>On Process</strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_order'].'" class="btn btn-xs btn-warning btn_kirim">Kirim </button><br/>';
						}
						if($c['status'] == 6){
							$_status = '<small class="label label-danger"><strong>Request Cancel</strong></small>';
							$btn_action = '<button style="width:68px; margin-bottom:3px;" id="'.$c['id_order'].'" class="btn btn-xs btn-warning btn_confirm_req_cancel"> Confirm </button><br/>';
						}
						if($c['status'] == 2 || $c['status_transfer'] == 1){
							$_status = '<small class="label label-warning"><strong>Waiting Verify Payment</strong></small>';
							$btn_action = '<a href="#import_dialog" title="View data payment" id="'.$_info.'" ><button style="width:68px; margin-bottom:3px;" id="'.$_info.'" class="btn btn-xs btn-success"> Confirm </button></a><br/>';
						}
						if($c['status'] == 7){
							$_status = '<small class="label label-warning"><strong>Dikirim</strong></small>';
							
						}
						if($c['status'] == 8){
							$_status = '<small class="label label-success"><strong>Completed</strong></small>';
							
						}
						if($c['status'] == 9){
							$_status = '<small class="label label-danger"><strong>Cancel</strong></small>';
						}
						
						//7 => dikirimkan, 8 => complete, 9=>cancel
						$btn_action .= '<a href="'.site_url('order_shop/bs_detail/'.$c['id_order']).'"><button style="width:68px;" title="View" class="btn btn-xs btn-info"> View </button></a>';
						
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.$c['nama'].'</td>';
						
						
						echo '<td>'.$c['alamat'].'</a></td>';
						if($c['status_transfer'] > 1){
							echo '<td>Total : <a href="#import_dialog" title="View data payment" id="'.$_info.'" >'.number_format($c['ttl_order'],0,'',',').'</a><br/>'.$_status.'</td>';
						}else{
							echo '<td>Total : '.number_format($c['ttl_order'],0,'',',').'<br/>'.$_status.'</td>';
						}
						
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
$('.btn_confirm_req_cancel').click(function(){
	var val = $(this).get(0).id;
	$('#confirm_req_cancel').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#catatan_req_cancel').val('');
	$('#id_booking').val('');
	$('#id_booking').val(val);
	$('#confirm_req_cancel').modal('show');
});
$('.btn_kirim').click(function(){
	var val = $(this).get(0).id;
	$('#confirm_booking').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#id_booking').val('');
	$('#id_booking').val(val);
	$('#confirm_booking').modal('show');
});
$('.btn_confirm').click(function(){
	var val = $(this).get(0).id;
	$('#confirm_booking').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#id_booking').val('');
	$('#id_booking').val(val);
	$('#confirm_booking_onprocess').modal('show');
});
$('.yes_appr_onprocess').click(function(){
	var id_booking = $('#id_booking').val();
	var catatan = $('#catatan_booking_onprocess').val();
	var url = '<?php echo site_url('order_shop/appr_reject');?>';
	$.ajax({
		data:{status:7,catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_booking_onprocess').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
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
$('.yes_appr').click(function(){
	var id_booking = $('#id_booking').val();
	var catatan = $('#catatan_booking').val();
	var url = '<?php echo site_url('order_shop/set_kirim');?>';
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
$('.yes_complete').click(function(){
	var id_booking = $('#id_booking').val();
	var catatan = $('#catatan_complete').val();
	var url = '<?php echo site_url('order_shop/set_completed');?>';
	$.ajax({
		data:{status:6,catatan:catatan,id_booking:id_booking},
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
$('.btn_appr').click(function(){
	var id_booking = $('#id_trans').val();
	var catatan = $('#catatan_payment').val();
	var url = '<?php echo site_url('order_shop/set_payment');?>';
	$.ajax({
		data:{status:4,catatan:catatan,id_booking:id_booking},
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
$('.yes_appr_req').click(function(){
	var id_booking = $('#id_booking').val();
	var catatan = $('#catatan_req_cancel').val();
	var url = '<?php echo site_url('order_shop/set_req_cancel');?>';
	$.ajax({
		data:{status:9,catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_req_cancel').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah di update');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})	
});
$('.yes_rej_req').click(function(){
	var id_booking = $('#id_booking').val();
	var catatan = $('#catatan_req_cancel').val();
	var url = '<?php echo site_url('order_shop/set_req_cancel');?>';
	$.ajax({
		data:{status:4,catatan:catatan,id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_req_cancel').modal('hide');
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
	var url = '<?php echo site_url('order_shop/set_payment');?>';
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
    $('#example88').dataTable({});
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
