<style type="text/css">
media (min-width: 768px)
.col-sm-offset-2 {
    margin-left: 16.66666667%;
}
.select2 {
width:100%!important;
border-radius: 0px !important;
}
.list-group-unbordered>.list-group-item {
    border-left: 0;
    border-right: 0;
    border-radius: 0;
    padding-left: 0;
    padding-right: 0;
	background-color:#f5f5f5;
	padding:9px;
}
.list-group-item {
    position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid #ddd;
}
.list-group-item:first-child {
    border: 0px;
    
}
.timeline > li > .timeline-item {margin-left:10px;}
.timeline:before {background:none; border:none;}
.margin {
    margin: 10px;
	margin-bottom:2px;
}
.timeline > li > .timeline-item > .timeline-body, .timeline > li > .timeline-item > .timeline-footer {
    padding-left: 40px;
}
a{color:#000;}
a:hover{color:#000;}
.img-thumbnail{display:inline-block; margin:3px; height:180px;}
hr {
    border-top: 1px solid #555;
	margin-top:0;
}
</style>
<?php 
$id = !empty($bs) ? (int)$bs->id_booking : 0;
$layanan = !empty($bs) ? (int)$bs->layanan : 0;
$pembayaran = !empty($bs) ? (int)$bs->pembayaran : 0;
$nmr_antrian = !empty($bs->nmr_antrian) ? (int)$bs->nmr_antrian : '-';
$nama = !empty($bs) ? $bs->nama.' '.$bs->last_name : '-';
$tgl_service = !empty($bs->tgl_service) ? date('d-m-Y', strtotime($bs->tgl_service)): '-';
$wa = !empty($bs) ? $bs->wa : '-'; 
$ig = !empty($bs) ? $bs->ig : '-';
$alamat = !empty($bs) ? $bs->alamat : '-';
$catatan = !empty($bs) ? $bs->catatan : '-';
$kerusakan = !empty($bs) ? $bs->kerusakan : '-';
$nama_cat = !empty($bs) ? $bs->nama_cat : '-';
$nama_type = !empty($bs) ? $bs->nama_type : '-';
$serial_number = !empty($bs) ? $bs->serial_number : '-';
$imei = !empty($bs->imei) ? $bs->imei : '-';
$nama_tk = !empty($bs->nama_tk) ? $bs->nama_tk : '-';
$passcode = !empty($bs->passcode) ? $bs->passcode : '-';
$jns_layanan = '-';
$jns_pembayaran = '-';
if($layanan == 1){
	$jns_layanan = 'Home Service, <strong>Nama Teknisi</strong> : '.$nama_tk;
}
if($layanan == 2){
	$jns_layanan = 'Pickup Device, <strong>Nama Kurir</strong> : '.$nama_tk;
}
if($layanan == 3){
	$jns_layanan = 'Kirim Device ke toko';
}
if($layanan == 4){
	$jns_layanan = 'Instore';
}
if($pembayaran == 1){
	$jns_pembayaran = 'Cash';
}
if($pembayaran == 2){
	$jns_pembayaran = 'Manual Transfer';
}
?>
<div class="modal fade" role="dialog" id="frm_dialog_sp">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add spare parts</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_sp" method="post" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				
					
					<div class="form-group">
					  <label>Spare Parts</label><span class="label label-danger pull-right list_sp_error"></span>
						<select class="form-control" name="list_sp" id="list_sp" onchange="return get_variant(this.value);" style="width:100%;">
															
						</select>
					</div>	
					<div class="form-group input_variant">
					  <label>Varian</label><span class="label label-danger pull-right list_variant_error"></span>
						<select class="form-control" name="list_variant" id="list_variant" style="width:100%;">
															
						</select>
					</div>
					
				</form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success btn_save_sp">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div> 
<div class="modal fade" role="dialog" id="confirm_del">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<br/>
<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Main</a></li>
              
              <li class=""><a href="#gambar" data-toggle="tab" aria-expanded="false">History Status</a></li>
             
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="activity">
                <!-- Post -->
				
				<div class="row">
				
			  <div class="col-md-6">
			  
                <ul class="list-group list-group-unbordered">
					<li class="list-group-item">
					  <b>No.Transaksi</b> <a class="pull-right"><?php echo $id;?></a>
					</li>
					<li class="list-group-item">
					  <b>Nama Member</b> <a class="pull-right"><?php echo $nama;?></a>
					</li>
					<li class="list-group-item">
					  <b>WhatsApp</b> <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $wa;?>" class="pull-right"><?php echo $wa;?></a>
					</li>
					<li class="list-group-item">
					  <b>Instagram</b> <a class="pull-right"><?php echo $ig;?></a>
					</li>
					<li class="list-group-item">
					  <b>Pembayaran</b> <a class="pull-right"><?php echo $jns_pembayaran;?></a>
					</li>
					<li class="list-group-item">
					  <b>Alamat</b> <a class="pull-right"><?php echo $alamat;?></a>
					</li>
					<li class="list-group-item">
					  <b>Catatan</b> <a class="pull-right"><?php echo $catatan;?></a>
					</li>
					<li class="list-group-item">
					  <b>Kerusakan</b> <a class="pull-right"><?php echo $kerusakan;?></a>
					</li>
				</ul>
              </div>
			  <div class="col-md-6">
                <ul class="list-group list-group-unbordered">
					<li class="list-group-item">
					  <b>Tgl.Service</b> <a class="pull-right"><?php echo $tgl_service;?></a>
					</li>
					<li class="list-group-item">
					  <b>Jenis Layanan</b> <a class="pull-right"><?php echo $jns_layanan;?></a>
					</li>
					<li class="list-group-item">
					  <b>No.Antrian</b> <a class="pull-right"><?php echo $nmr_antrian;?></a>
					</li>
					<li class="list-group-item">
					  <b>Imei</b> <a class="pull-right"><?php echo $imei;?></a>
					</li>
					<li class="list-group-item">
					  <b>Serial Number</b> <a class="pull-right"><?php echo $serial_number;?></a>
					</li>
					<li class="list-group-item">
					  <b>Pass Code</b> <a class="pull-right"><?php echo $passcode;?></a>
					</li>
					<li class="list-group-item">
					  <b>Device Category</b> <a class="pull-right"><?php echo $nama_cat;?></a>
					</li>
					<li class="list-group-item">
					  <b>Device Type</b> <a class="pull-right"><?php echo $nama_type;?></a>
					</li>
					
				</ul>
				
              </div>
			 
              </div>
			   <hr style="margin-bottom:5px; margin-top:5px;"/>
			   <div class="row"><div class="col-sm-12">
				<h4><strong>Spare Parts</strong></h4>
				<?php if($layanan > 1) { ?>
				<div class="pull-right" style="margin-top:-30px;">
					<button class="btn btn-warning btn-xs add_sp">Add Spare Parts</button>
				</div>
				<?php } ?>
				<div class="my_sp"></div>
					
					
       
              </div>
              </div>
              </div>
			<div class="tab-pane" id="gambar">
				<table id="example88" class="table table-bordered table-striped">
					<thead><tr>
						<th style="text-align:center; width:4%">No.</th>
						
						<th style="text-align:center; width:10%">Tanggal</th>		
						<th style="text-align:center; width:17%">Status</th>		
						<th style="text-align:center; width:35%">Catatan</th>		
						<th style="text-align:center; width:15%">PIC</th>							
						
					</tr>
					</thead>
					<tbody>
						<tr>
						<?php if(!empty($history)){
							$i = 1;
							foreach($history as $h){
								$status_name = array();
								$status_name += array(
									1	=> 'Booking',
									2	=> 'On Schedule',
									3	=> 'Diterima',
									4	=> 'Waiting Diagnostik',
									5	=> 'Diagnostik',
									6	=> 'Need approval customer',
									7	=> 'On Progress',
									8	=> 'Waiting pickup by customer',
									9	=> 'Done',
									10	=> 'Cancelled',
									11	=> 'Pembayaran terverifikasi',
									12	=> 'Pembayaran rejected',
									13	=> 'Paket telah diterima customer',
								);
								if($layanan == 1){
									unset($status_name[1]);									
									unset($status_name[8]);									
									$status_name += array(
										1	=> 'Menunggu Jadwal Teknisi',
										8	=> 'Cancelled'
									);
								}
								if($layanan == 2){
									unset($status_name[1]);									
									$status_name += array(
										1	=> 'Menunggu Jadwal Kurir'
									);
								}
								if($layanan == 3){
									unset($status_name[1]);
									unset($status_name[2]);
									$status_name += array(
										1	=> 'Menunggu konfirmasi kurir dari customer',
										2	=> 'Dalam pengiriman',
									);
								}
								if($layanan == 4){
									unset($status_name[1]);									
									$status_name += array(
										1	=> 'Menunggu antrian'
									);
								}
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.date('d-m-Y H:i', strtotime($h['created_at'])).'</td>';	
								echo '<td>'.$status_name[(int)$h['status']].'</td>';	
								echo '<td>'.$h['catatan'].'</td>';	
								echo '<td>'.$h['name'].'</td>';	
								echo '</tr>';
							}								
						}?>
						</tr>			  
					</tbody>
				</table>
            </div>
            </div>
            <!-- /.tab-content -->
          </div>
<script>
$('.input_variant').hide();
var id_booking = '<?php echo $id;?>';
load_sp(id_booking);
$('.add_sp').click(function(){
	$('.list_sp_error').text('');
	$('#frm_sp').find("input[type=text], select").val("");
	var url = '<?php echo site_url('booking_service/get_kerusakan');?>';
	$('.input_variant').hide();
	$('#list_tools').html('');
	$('#list_variant').html('');
	$.ajax({
		data:{id_booking:id_booking},
		type:'POST',
		url : url,
		success:function(response){				
			if(response.length > 0){					
				$('#list_sp').html(response);
				$("#list_sp").select2({});
			}				
		}
	});		
	$('#frm_dialog_sp').modal({
		backdrop: 'static',
		keyboard: false
	});	
	$('#frm_dialog_sp').modal('show');
});
function get_variant(){	
	var url = '<?php echo site_url('booking_service/get_variant');?>';
	var id_sp = $('#list_sp').val();
	$('.input_variant').hide();
	$('#list_variant').html('');
	var html = '';
	$.ajax({
		data:{id_sp:id_sp},
		type:'POST',
		url : url,
		success:function(response){		
			console.log(response);
			if(response.length > 0){
				$('.input_variant').show();
				html += response;
				$('#list_variant').html(response);
				$("#list_variant").select2({});				
			}else{
				html +='<option value="-">Data not found</option>';
				$('#list_variant').html(html);
			}				
		}
	});		
	
}
$('.btn_save_sp').click(function(){
	$('.list_sp_error').text('');
	var dt_tools = $('#list_sp').val();
	var variant = $('#list_variant').val();
	
	if(dt_tools == null || dt_tools == ''){
		$('.list_sp_error').text('Silahkan pilih spare parts');
		return false;
	}
	if(variant == null || variant == ''){
		$('.list_variant_error').text('Silahkan pilih variant');
		return false;
	}
	var url = '<?php echo site_url('booking_service/simpan_sp');?>';
	$.ajax({
		data:{dt_tools:dt_tools,id_booking:id_booking,variant:variant},
		type:'POST',
		url : url,
		success:function(response){
			$('#frm_dialog_sp').modal('hide');
			// $("#id_text").html('<b>Success,</b> Data tools sudah ditambahkan');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				
			// });			
			load_sp(id_booking);			
		}
	});	
});
function load_sp(id_booking){
	if(id_booking > 0){
		var url = '<?php echo site_url('booking_service/get_mykerusakan');?>';
		$('.my_sp').html('');
		$.ajax({
			data:{'id_booking' : id_booking},
			type:'POST',
			url : url,
			success:function(response){				
				$('.my_sp').html(response);
			}
		})	
	}
}
function del_sp(id){
	$('#del_id').val(id);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
}
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('booking_service/del_sp');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			load_sp(id_booking);		
		}
	});
	
});
</script>