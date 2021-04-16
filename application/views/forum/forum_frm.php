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
$id = !empty($store) ? (int)$store->id : 0;
$title = !empty($store) ? $store->title : '';
$device_cat = !empty($store->device_cat) ? $store->device_cat : '';
$device_type = !empty($store->device_type) ? $store->device_type : '';
$img = !empty($store->img) ? base_url('uploads/forum/'.$store->img) : '';
$deskripsi = !empty($store) ? $store->deskripsi : '';


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
              <h3 class="box-title">Form forum</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form" id="frm_item" method="post" enctype="multipart/form-data">
              <div class="box-body">
			  <div class="row">
			  <div class="col-sm-12">
				<div class="form-group">
                  <label for="exampleInputPassword1">Title</label><span class="label label-danger pull-right title_error"></span>
                  <input type="text" class="form-control" name="jdl" id="jdl" placeholder="Title" value="<?php echo $title;?>" >
                  <input type="hidden" class="form-control" name="id_forum" id="id_forum" value="<?php echo $id;?>" >
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
						<label>Image</label><span class="label label-danger pull-right"></span>
						<input type="file" class="form-control custom-file-input" name="userfile" id="userfile" accept="image/*" />
										 
					</div>
					<div class="form-group">
						<div class="fileupload-new thumbnail" style="width: 200px; height: 150px; margin-bottom:5px;">
							<img id="blah" style="width: 200px; height: 140px;" src="<?php echo $img;?>" alt="">
						</div>                 
					</div>
				
              </div>
			  <div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">Device Type</label><span class="label label-danger pull-right device_type_error"></span>
					<select class="form-control" name="device_type" id="device_type" disabled>
					<option value=''>- Pilih -</option>										
					</select>
				</div>
				<div class="form-group">
                  <label for="exampleInputPassword1">Description</label><span class="label label-danger pull-right deskripsi_error"></span>
                  <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Description" rows=9><?php echo $deskripsi;?></textarea>
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
var id_kategori = '<?php echo (int)$device_cat > 0 ? (int)$device_cat : 0;?>';
var device_type = '<?php echo (int)$device_type > 0 ? (int)$device_type : 0;?>';
if(id_kategori > 0) get_type(id_kategori, device_type);
var img = '<?php echo !empty($store->img) ? base_url('uploads/forum/'.$store->img) : base_url('uploads/no_photo.jpg');?>';
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
$('.btn_save').click(function(){
	var title = $('#title').val();
	var device_cat = $('#device_cat').val();
	var device_type = $('#device_type').val();
	var deskripsi = $('#latitude').val();
	
	$('.title_error').text('');
	$('.device_cat_error').text('');
	$('.device_type_error').text('');
	$('.deskripsi_error').text('');
	
	if(title <= 0 || title == '') {
		$('.title_error').text('Title harus diisi');
		return false;
	}
	if(device_cat <= 0 || device_cat == '') {
		$('.device_cat_error').text('Device Category harus diisi');
		return false;
	}
	if(device_type <= 0 || device_type == '') {
		$('.device_type_error').text('Device type harus diisi');
		return false;
	}
	if(deskripsi == '') {
		$('.deskripsi_error').text('Description harus diisi');
		return false;
	}
	var url = '<?php echo site_url('forum/simpan');?>';	
	$('#frm_item').attr('action', url);
	$('#frm_item').submit();
	
 });
$('.btn_canc').click(function(){
	window.location = '<?php echo site_url('forum');?>';
});
$('.btn_ok').click(function(){
	window.location = '<?php echo site_url('forum');?>';
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
if(img != ''){
	$('#blah').attr('src', img);	
}
</script>
