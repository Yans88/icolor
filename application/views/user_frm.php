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
$id_user = !empty($user) ? (int)$user->operator_id : 0;

$_user = !empty($user) ? $this->converter->decode($user->_user) : ''; 
$_pass = !empty($user) ? $this->converter->decode($user->_pass) : ''; 
$name = !empty($user) ? $user->name : '';
$id_store = !empty($user->id_store) ? $user->id_store : '';

$id_level = !empty($user->id_level) ? (int)$user->id_level : '';
$status = !empty($user->status) ? (int)$user->status : '';
$tipe = !empty($user->tipe) ? (int)$user->tipe : '';

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
              <h3 class="box-title">Form user</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form" id="frm_item">
              <div class="box-body">
			  <div class="row">
			  
			  <div class="col-md-6">
                <input type="hidden" value="<?php echo $id_user;?>" name="id_user" id="id_user">
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Username</label><span class="label label-danger pull-right username_error"></span>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $_user;?>" >
                </div>
				<div class="form-group">
                  <label for="exampleInputPassword1">Password</label><span class="label label-danger pull-right password_error"></span>
                  <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $_pass;?>" >
                </div>
				<div class="form-group">
                  <label for="exampleInputPassword1">Nama</label><span class="label label-danger pull-right name_error"></span>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Nama" value="<?php echo $name;?>" >
                </div>
				
              </div>
			  <div class="col-md-6">
				<div class="form-group">
                  <label>Status</label><span class="label label-danger pull-right status_error"></span>
                  <select class="form-control" name="status" id="status" >
					  <option value="">-- Pilih Status --</option>
					  <option value=1 <?php echo $status == 1 ? ' selected' : '';?>>Active</option>
					  <option value=0 <?php echo $status == 0 && !empty($status) ? ' selected' : '';?>>Inactive</option>
				  </select>
                </div>	
				<div class="form-group">
                  <label>Level</label><span class="label label-danger pull-right id_level_error"></span>
                  <select class="form-control" name="id_level" id="id_level" >
					  <option value="">-- Pilih Level --</option>
						<?php if(!empty($level)){
							foreach($level as $l){
								if($id_level == $l['id']){
									echo '<option value='.$l['id'].' selected>'.$l['level_name'].'</option>';
								}else{
									echo '<option value='.$l['id'].'>'.$l['level_name'].'</option>';
								}							
							}
						}?>
				  </select>
                </div>	
               <div class="form-group">
					  <label>Store</label><span class="label label-danger pull-right list_sp_error"></span>
						<select class="form-control" name="list_store[]" id="list_store" style="width:100%;" multiple="multiple">
							<option value="">-- Pilih Store --</option>	
							<?php if(!empty($store)){
								foreach($store as $s){
									echo '<option value='.$s['id_op'].'>'.$s['nama'].'</option>';							
								}
							}?>
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


	
<script type="text/javascript">
$("#list_store").select2({ placeholder: "-- Pilih Store --",closeOnSelect: false});
var id_store = '<?php echo $id_store;?>';
if(id_store != ''){
	var selectedValues = id_store.split(',');
	$("#list_store").val(selectedValues).trigger('change');
}
$('.btn_save').click(function(){
	var name = $('#name').val();
	var username = $('#username').val();
	var password = $('#password').val();
	var latitude = $('#latitude').val();
	var longitude = $('#longitude').val();
	var alamat = $('#alamat').val();
	$('.name_error').text('');
	$('.username_error').text('');
	$('.password_error').text('');
	
	
	if(username <= 0 || username == '') {
		$('.username_error').text('Username harus diisi');
		return false;
	}
	if(password == '') {
		$('.password_error').text('Password harus diisi');
		return false;
	}
	if(name <= 0 || name == '') {
		$('.name_error').text('Nama harus diisi');
		return false;
	}
	if(alamat == '') {
		$('.alamat_error').text('Alamat harus diisi');
		return false;
	}
	var url = '<?php echo site_url('user/save');?>';
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
	window.location = '<?php echo site_url('user');?>';
});
$('.btn_ok').click(function(){
	window.location = '<?php echo site_url('user');?>';
});

</script>
