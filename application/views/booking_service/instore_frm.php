<style type="text/css">
media (min-width: 768px)
.col-sm-offset-2 {
    margin-left: 16.66666667%;
}
.select2 {
width:100%!important;
border-radius: 0px !important;
}

</style>
<?php 

$id_news = !empty($news) ? (int)$news->id_news : 0;
$title = !empty($news) ? $news->title : '';
$descr_title = !empty($news) ? $news->deskripsi_title : '';
$sub_title = !empty($news) ? $news->subtitle : '';
$descr_subtitle = !empty($news) ? $news->deskripsi_sub : '';
$img = !empty($news->img) ? base_url('uploads/news/'.$news->img) : '';

?>
<div class="modal fade" role="dialog" id="confirm_success">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Success</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Data telah disimpan </h4>
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success btn_ok">Ok</button>               
                            
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<br/>
<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form Booking Service</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form" id="frm_instore">
				 <div class="box-body">
					<div class="row">
								  
						<div class="col-md-6">
									
							<div class="form-group">
								<label for="exampleInputPassword1">Member</label><span class="label label-danger pull-right member_error"></span>
								<select class="form-control" name="id_member" id="id_member">
									<option value=''>- Pilih -</option>
									
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">WhatsApp</label><span class="label label-danger pull-right wa_error"></span>
								<input type="text" class="form-control" name="wa" id="wa" placeholder="WhatsApp" value="" >
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Instagram</label><span class="label label-danger pull-right ig_error"></span>
								<input type="text" class="form-control" name="ig" id="ig" placeholder="Instagram" value="" >
							</div>
										
							
							
							<div class="form-group">
								<label for="exampleInputPassword1">Serial Number</label><span class="label label-danger pull-right serial_number_error"></span>
								<input type="text" class="form-control" name="serial_number" id="serial_number" placeholder="Serial Number" >
							</div>
							
							<div class="form-group">
								<label for="exampleInputPassword1">IMEI</label><span class="label label-danger pull-right imei_error"></span>
								<input type="text" class="form-control" name="imei" id="imei" placeholder="IMEI" >
							</div>
							
							<div class="form-group">
								<label for="exampleInputPassword1">Kerusakan</label><span class="label label-danger pull-right kerusakan_error"></span>
								<textarea class="form-control" name="kerusakan" id="kerusakan" placeholder="Kerusakan" rows=5><?php echo $deskripsi;?></textarea>
							</div>
									
						</div>
						<div class="col-md-6">
								   
							<div class="form-group">
								<label for="exampleInputPassword1">Tgl. Service</label><span class="label label-danger pull-right tgl_service_error"></span>
								<input type="text" class="form-control" name="tgl_service" id="tgl_service" placeholder="Tgl. Service" value="" >
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Device Category</label><span class="label label-danger pull-right device_cat_error"></span>
								<select class="form-control" name="device_cat" id="device_cat"  onchange="return get_type(this.value);">
									<option value=''>- Pilih -</option>
									<?php if(!empty($category)){
										foreach($category as $c){
											if($device_cat == $c['id_kategori']){
												echo '<option value="'.$c['id_kategori'].'" selected>'.$c['nama_kategori'].'</option>';
											}else{
												echo '<option value="'.$c['id_kategori'].'">'.$c['nama_kategori'].'</option>';
											}
										}
									}?>
										
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Device Type</label><span class="label label-danger pull-right device_type_error"></span>
								<select class="form-control" name="device_type" id="device_type" disabled>
									<option value=''>- Pilih -</option>
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Passcode</label><span class="label label-danger pull-right passcode_error"></span>
								<input type="text" class="form-control" name="passcode" id="passcode" placeholder="Passcode" >
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Pembayaran</label><span class="label label-danger pull-right pembayaran_error"></span>
								<select class="form-control" name="pembayaran" id="pembayaran">
									<option value=''>- Pilih -</option>
									<option value=1> Cash</option>
									<option value=2> Manual Transfer</option>
								</select>
							</div>		
							<div class="form-group">
								<label for="exampleInputPassword1">Catatan</label><span class="label label-danger pull-right catatan_error"></span>
								<textarea class="form-control" name="catatan" id="catatan" placeholder="Catatan" rows=5></textarea>
							</div>
									
						</div>
						
						<div class="col-sm-12">
							<div class="form-group">
								<label for="exampleInputPassword1">Alamat</label><span class="label label-danger pull-right alamat_error"></span>
								<input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" >
							</div>
						</div>		 
								
					</div>
				</div>
				<div class="box-footer">
               
					<button type="button" class="btn btn-danger btn_canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
					<button type="button" class="btn btn-success btn_save"><i class="fa fa-check"></i> Save</button>
				</div>
								  
							</form>
							
          </div>


<link href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.js"></script>	
<script type="text/javascript">
// $("#id_member").select2({});
$("#id_member").select2({
	ajax: { 
	   url: "<?php echo site_url('members/get_member');?>",
	   type: "post",
	   dataType: 'json',
	   delay: 250,
	   data: function (params) {
		return {
		  searchTerm: params.term // search term
		};
	   },
	   processResults: function (response) {
		 return {
			results: response
		 };
	   },
	   cache: true
	}
});
function get_type(id, device_type){	
	var url = '<?php echo site_url('tutorial/get_type');?>';
	$('#device_type').prop('disabled', true);
	$('#device_type').html('');
	var html = '<option ="">- Pilih -</option>';
	$.ajax({
		data:{id:id},
		type:'POST',
		url : url,
		success:function(response){				
			if(response.length > 0){
				html += response;
				$('#device_type').html(html);
				$('#device_type').prop('disabled', false);
				$('#device_type').val(device_type);
			}				
		}
	});		
	
}
$('#tgl_service').datetimepicker({
	dayOfWeekStart : 1,
	changeYear: false,
	timepicker:false,
	scrollInput:false,
	format:'d-m-Y',
	lang:'en',
	minDate:'0'
});
$('.btn_save').click(function(){	
	$('.id_member_error').text('');
	$('.wa_error').text('');
	$('.ig_error').text('');
	$('.alamat_error').text('');
	$('.tgl_service_error').text('');
	$('.device_cat_error').text('');
	$('.device_type_error').text('');
	$('.pembayaran_error').text('');
	$('.kerusakan_error').text('');
	$('.catatan_error').text('');
	var id_member = $('#id_member').val();
	var wa = $('#wa').val();
	var ig = $('#ig').val();
	var alamat = $('#alamat').val();
	var tgl_service = $('#tgl_service').val();
	var device_cat = $('#device_cat').val();
	var device_type = $('#device_type').val();
	var pembayaran = $('#pembayaran').val();
	var kerusakan = $('#kerusakan').val();
	var catatan = $('#catatan').val();
	if(id_member <= 0 || id_member == ''){
		$('id_member_error').text('Member harus dipilih');
		return false;
	}
	if(tgl_service <= 0 || tgl_service == ''){
		$('tgl_service_error').text('Tgl.Service harus diisi');
		return false;
	}
	if(wa <= 0 || wa == ''){
		$('wa_error').text('WhatsApp harus diisi');
		return false;
	}
	if(device_cat <= 0 || device_cat == ''){
		$('device_cat_error').text('Device Category harus dipilih');
		return false;
	}
	if(ig <= 0 || ig == ''){
		$('ig_error').text('Instagram harus diisi');
		return false;
	}
	if(device_type <= 0 || device_type == ''){
		$('device_type_error').text('Device Type harus dipilih');
		return false;
	}
	if(alamat <= 0 || alamat == ''){
		$('alamat_error').text('Alamat harus diisi');
		return false;
	}
	if(pembayaran <= 0 || pembayaran == ''){
		$('pembayaran_error').text('Pembayaran harus dipilih');
		return false;
	}
	if(kerusakan <= 0 || kerusakan == ''){
		$('kerusakan_error').text('Kerusakan harus diisi');
		return false;
	}
	var dt = $('#frm_instore').serialize();
	var url = '<?php echo site_url('booking_service/simpan_instore');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){				
			if(response > 0){
				alert('Data telah disimpan');
				var urli = '<?php echo site_url('booking_service/bs_detail');?>/'+response;
				window.location.href = urli;
			}
		}
	})		
});


$('.btn_canc').click(function(){
	window.location = '<?php echo site_url('booking_service/instore');?>';
});
$('.btn_ok').click(function(){
	window.location = '<?php echo site_url('booking_service/instore');?>';
});

</script>
