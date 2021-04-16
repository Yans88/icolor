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
$id_store = !empty($store) ? (int)$store->id_op : 0;
$name_store = !empty($store) ? $store->nama : '';
$_user = !empty($store) ? $this->converter->decode($store->_user) : ''; 
$_pass = !empty($store) ? $this->converter->decode($store->_pass) : ''; 
$longitude = !empty($store) ? $store->longitude : '';
$latitude = !empty($store) ? $store->latitude : '';
$deskripsi = !empty($store) ? $store->deskripsi : '';
$id_provinsi = !empty($store) ? (int)$store->id_provinsi : '';
$id_city = !empty($store) ? (int)$store->id_city : '';

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

<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form outlet</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form" id="frm_item">
              <div class="box-body">
			  <div class="row">
			  <div class="col-sm-12">
				<div class="form-group">
                  <label for="exampleInputPassword1">Nama Store</label><span class="label label-danger pull-right name_store_error"></span>
                  <input type="text" class="form-control" name="name_store" id="name_store" placeholder="Nama Store" value="<?php echo $name_store;?>" >
                  <input type="hidden" class="form-control" name="id_store" id="id_store" value="<?php echo $id_store;?>" >
                </div>
			  </div>
			  <div class="col-md-6">
                <div class="form-group">
					<label for="exampleInputPassword1">Provinsi</label><span class="label label-danger pull-right provinsi_error"></span>
					  <select class="form-control" name="provinsi" id="provinsi"  onchange="return get_type(this.value);">
							<option value=''>- Pilih -</option>
							<?php if(!empty($provinsi)){
								foreach($provinsi as $c){
									if($id_provinsi == $c['id_provinsi']){
										echo '<option value="'.$c['id_provinsi'].'" selected>'.$c['nama_provinsi'].'</option>';
									}else{
										echo '<option value="'.$c['id_provinsi'].'">'.$c['nama_provinsi'].'</option>';
									}
								}
							}?>
					</select>
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Kota</label><span class="label label-danger pull-right kota_error"></span>
					  <select class="form-control" name="kota" id="kota" disabled>
							<option value=''>- Pilih -</option>
							
					</select>
				</div>
                
               
				
				
              </div>
			  <div class="col-md-6">
				<div class="form-group">
                  <label for="exampleInputPassword1">Latitude</label><span class="label label-danger pull-right latitude_error"></span>
                  <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude" value="<?php echo $latitude;?>" >
                </div>
				<div class="form-group">
                  <label for="exampleInputPassword1">Longitude</label><span class="label label-danger pull-right longitude_error"></span>
                  <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude" value="<?php echo $longitude;?>" >
                </div>
                
				
				
              </div>
			  <div class="col-sm-12">
				<div class="form-group">
                  <label for="exampleInputPassword1">Alamat</label><span class="label label-danger pull-right alamat_error"></span>
                  <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat" rows=5><?php echo $deskripsi;?></textarea>
                </div>
			  </div>
              </div>
              </div>
              <!-- /.box-body -->

             <div class="box-footer">
               
                <button type="button" class="btn btn-danger btn_canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
                <button type="button" class="btn btn-success btn_save"><i class="fa fa-check"></i> Save</button>
              </div>
            </form>
          </div>


	
<script type="text/javascript">
var id_provinsi = '<?php echo (int)$id_provinsi > 0 ? (int)$id_provinsi : 0;?>';
var id_city = '<?php echo (int)$id_city > 0 ? (int)$id_city : 0;?>';
if(id_provinsi > 0) get_type(id_provinsi, id_city);
function get_type(id, id_city){	
	var url = '<?php echo site_url('outlet/get_city');?>';
	$('#kota').prop('disabled', true);
	$('#kota').html('');
	var html = '<option ="">- Pilih -</option>';
	$.ajax({
		data:{id:id},
		type:'POST',
		url : url,
		success:function(response){				
			if(response.length > 0){
				html += response;
				$('#kota').html(html);
				$('#kota').prop('disabled', false);
				$('#kota').val(device_type);
			}				
		}
	});		
	
}
$('.btn_save').click(function(){
	var name_store = $('#name_store').val();
	var username = $('#username').val();
	var password = $('#password').val();
	var latitude = $('#latitude').val();
	var longitude = $('#longitude').val();
	var alamat = $('#alamat').val();
	$('.name_store_error').text('');
	$('.username_error').text('');
	$('.password_error').text('');
	$('.latitude_error').text('');
	$('.longitude_error').text('');
	$('.alamat_error').text('');
	if(name_store <= 0 || name_store == '') {
		$('.name_store_error').text('Nama Store harus diisi');
		return false;
	}
	// if(username <= 0 || username == '') {
		// $('.username_error').text('Username harus diisi');
		// return false;
	// }
	// if(password == '') {
		// $('.password_error').text('Password harus diisi');
		// return false;
	// }
	if(latitude == '') {
		$('.latitude_error').text('Latitude harus diisi');
		return false;
	}
	if(longitude == '') {
		$('.longitude_error').text('Longitude harus diisi');
		return false;
	}
	if(alamat == '') {
		$('.alamat_error').text('Alamat harus diisi');
		return false;
	}
	var url = '<?php echo site_url('outlet/simpan');?>';
	var dt = $('#frm_item').serialize();
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){
			if(response > 0){
				$('#confirm_success').modal({
					backdrop: 'static',
					keyboard: false
				});
				$('#confirm_success').modal('show');							
			}
		}
	})	
	
 });
$('.btn_canc').click(function(){
	window.location = '<?php echo site_url('outlet');?>';
});
$('.btn_ok').click(function(){
	window.location = '<?php echo site_url('outlet');?>';
});

</script>
