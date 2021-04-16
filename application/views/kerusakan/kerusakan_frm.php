<style type="text/css">
media (min-width: 768px)
.col-sm-offset-2 {
    margin-left: 16.66666667%;
}
.select2 {
width:100%!important;
border-radius: 0px !important;
}
.tags-input-wrapper {
            background: #ffffff;
            padding: 10px;          
            border: 1px solid #ccc
        }

        .tags-input-wrapper input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
        }

        .tags-input-wrapper .tag {
            display: inline-block;
            background-color: #009432;
            color: white;
           
            padding: 0px 3px 0px 7px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .tags-input-wrapper .tag a {
            margin: 0 7px 3px;
            display: inline-block;
            cursor: pointer;
        }
</style>
<?php 
$id = !empty($master_kerusakan) ? (int)$master_kerusakan->id : 0;
$nama_sp = !empty($master_kerusakan) ? $master_kerusakan->nama_sp : '';
$device_cat = !empty($master_kerusakan) ? (int)$master_kerusakan->device_cat : '';
$device_type = !empty($master_kerusakan) ? (int)$master_kerusakan->device_type : '';
$harga = !empty($master_kerusakan) ? number_format($master_kerusakan->harga,0,'',',') : ''; 
$varian = !empty($master_kerusakan->varian) ? $master_kerusakan->varian : '';

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
              <h3 class="box-title">Form master kerusakan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form" id="frm_item">
              <div class="box-body">
			  <div class="row">
			  <div class="col-sm-12">
				
			  </div>
			  <div class="col-md-6">
                
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Nama</label><span class="label label-danger pull-right nama_sp_error"></span>
                  <input type="text" class="form-control" name="nama_sp" id="nama_sp" placeholder="Nama" value="<?php echo $nama_sp;?>" >
                  <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id;?>" >
                </div>
				<div class="form-group">
                  <label for="exampleInputPassword1">Harga</label><span class="label label-danger pull-right harga_error"></span>
                  <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga;?>" >
                </div>
				<div class="form-group">
					<label for="exampleInputPassword1">Varian</label><span class="label label-danger pull-right varian_error"></span>
					<input type="text" name="varian" id="varian" value="<?php echo $varian;?>" />
				</div>
				
              </div>
			  <div class="col-md-6">
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


<script type="text/javascript" src="<?php echo base_url('assets/tags/tagplug.js') ?>"></script>	
<script type="text/javascript">
var id_kategori = '<?php echo (int)$device_cat > 0 ? (int)$device_cat : 0;?>';
var device_type = '<?php echo (int)$device_type > 0 ? (int)$device_type :0;?>';
if(id_kategori > 0) get_type(id_kategori, device_type);
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
				if(device_type > 0){
					$('#device_type').val(device_type);
				}else{
					$('#device_type').val('');
				}
			}				
		}
	});		
	
}
$('.btn_save').click(function(){
	var nama_sp = $('#nama_sp').val();
	var harga = $('#harga').val();
	var device_cat = $('#device_cat').val();
	var device_type = $('#device_type').val();
	$('.nama_sp_error').text('');
	$('.harga_error').text('');
	$('.device_cat_error').text('');
	$('.device_type_error').text('');
	if(nama_sp <= 0 || nama_sp == '') {
		$('.nama_sp_error').text('Nama harus diisi');
		return false;
	}
	if(harga <= 0 || harga == '') {
		$('.harga_error').text('Harga harus diisi');
		return false;
	}
	if(device_cat == '') {
		$('.device_cat').text('Device Category harus diisi');
		return false;
	}
	if(device_type == '') {
		$('.device_type_error').text('Device Type harus diisi');
		return false;
	}
	
	var url = '<?php echo site_url('master_kerusakan/simpan');?>';
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
var tagInput1 = new TagsInput({
    selector: 'varian',
    duplicate : false,
    max : 10
});
var varian = '<?php echo $varian;?>';
if(varian != ''){
	var nameArr = varian.split(',');
	tagInput1.addData(nameArr);
	
}
$('.btn_canc').click(function(){
	window.location = '<?php echo site_url('master_kerusakan');?>';
});
$('.btn_ok').click(function(){
	window.location = '<?php echo site_url('master_kerusakan');?>';
});
$('#harga').keyup(function(event) {  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/[^.\d]/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	});	
});
</script>
