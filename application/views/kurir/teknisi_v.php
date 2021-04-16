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
	.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
	.toggle.ios .toggle-handle { border-radius: 20px; }
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
	}

?>
<div class="modal fade" role="dialog" id="frm_user">
          <div class="modal-dialog" style="width:450px;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Teknisi</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="form_users" autocomplete="off">
                <!-- text input -->
				
                <div class="form-group">
                  <label>Nama</label><span class="label label-danger pull-right nama_error"></span>
                  <input type="text" class="form-control" name="nama" id="nama" value="" placeholder="Nama" autocomplete="off" />
                  <input type="hidden" value="" name="id_user" id="id_user">
                </div>
				
				 <div class="form-group">
                  <label>Email</label><span class="label label-danger pull-right email_error"></span>
                  <input type="text" class="form-control" name="email" id="email" value="" placeholder="Email" autocomplete="off" />
                </div>	

				
				
				
				
				<div class="form-group">
                  <label>Phone</label><span class="label label-danger pull-right phone_error"></span>
                  <input type="text" class="form-control" name="phone" id="phone" value="" placeholder="Phone" autocomplete="off" />
                </div>
				
				
				
				<div class="form-group">
                  <label>Store</label><span class="label label-danger pull-right store_error"></span>
                  <select class="form-control" name="store" id="store" style="width:100%;">
					  <option value="">- Pilih Store -</option>
					  <?php if(!empty($store)){
						foreach($store as $s){
							echo '<option value="'.$s['id_op'].'">'.$s['nama'].'</option>';
						}
					  }?>
				  </select>
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




 <div class="box box-success">
 <div class="box-header">
    <button class="btn btn-success add_user"><i class="fa fa-plus"></i> Add</button>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            
            <th style="text-align:center; width:20%">Nama</th>		
            <th style="text-align:center; width:20%">Email</th>		
            <th style="text-align:center; width:20%">Phone</th>		
            <th style="text-align:center; width:20%">Store</th>		
						
			<th style="text-align:center; width:13%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				
				$info = '';			
						
				if(!empty($kurir)){		
					foreach($kurir as $k){	
						$info = $k['id'].'Þ'.$k['nama'].'Þ'.$k['email'].'Þ'.$k['phone'].'Þ'.$k['id_store'];						
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';						
						echo '<td>'.$k['nama'].'</td>';						
						echo '<td>'.$k['email'].'</td>';						
						echo '<td>'.$k['phone'].'</td>';						
						echo '<td>'.$k['nama_store'].'</td>';						
						
						echo '<td align="center" style="vertical-align: middle;">		
			
			<button title="Edit" id="'.$info.'" class="btn btn-xs btn-success edit_user"><i class="fa fa-edit"></i> Edit</button>
			<button title="Delete" id="'.$k['id'].'" class="btn btn-xs btn-danger del_news"><i class="fa fa-trash-o"></i> Delete</button>		
						</td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
$("#store").select2({});
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
$('.add_user').click(function(){
	$('.nama_error').text('');
	$('.email_error').text('');	
	$('.phone_error').text('');
	$('.store_error').text('');
	$('#form_users').find("input[type=text], select, input[type=hidden]").val("");
	$('#frm_user').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_user').modal('show');
});
$('.edit_user').click(function(){
	$('.nama_error').text('');
	$('.email_error').text('');	
	$('.phone_error').text('');
	$('.store_error').text('');
	$('#form_users').find("input[type=text], select").val("");
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_user').val(dt[0]);
	$('#nama').val(dt[1]);
	
	$('#email').val(dt[2]);
	$('#phone').val(dt[3]);	
	
	$('#store').val(dt[4]).trigger('change.select2');;	
	
	$('#frm_user').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_user').modal('show');
});

$('.yes_save').click(function(){
	var nama = $('#nama').val();	
	var email = $('#email').val();
	var phone = $('#phone').val();	
	var store = $('#store').val();
	$('.nama_error').text('');
	$('.email_error').text('');	
	$('.phone_error').text('');
	$('.store_error').text('');
	if(nama <= 0 || nama == '') {
		$('.nama_error').text('Nama harus diisi');
		return false;
	}
	if(email <= 0 || email == '') {
		$('.email_error').text('Email harus diisi');
		return false;
	}	
	if(phone == '') {
		$('.phone_error').text('Phone harus dipilih');
		return false;
	}	
	if(store == '') {
		$('.store_error').text('Store harus dipilih');
		return false;
	}
	if(!(validateEmail(email))){
		$('.email_error').text('Email tidak valid');
		return false;
	}
	var dt = $('#form_users').serialize();
	var url = '<?php echo site_url('teknisi/save');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){			
			if(response > 0){
				$('#frm_user').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah disimpan');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})
});
$('.del_news').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('teknisi/del');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data telah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});
$('#phone').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "");
  });
});
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


$(function() {               
    $('#example88').dataTable({});
});


</script>