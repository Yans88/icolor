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
	.breadcrumb{
		float:right;
		background:transparent;
		margin-bottom : 0;
	}
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
	}

?>

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

<div class="modal fade" role="dialog" id="frm_category">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add/Edit</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" autocomplete="off" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="form-group">
                  <label>Kecamatan</label><span class="label label-danger pull-right kecamatan_error"></span>
                  <input type="text" class="form-control" name="kecamatan" id="kecamatan" value="" placeholder="Kecamatan" autocomplete="off" />
                  <input type="hidden" value="" name="id_city" id="id_city">
                  <input type="hidden" value="" name="id_kec" id="id_kec">
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
</div>


 <div class="box box-success">
 <div class="box-header">
    <a href="#"><button class="btn btn-success add_category"><i class="fa fa-plus"></i> Add Kecamatan</button></a>
	<ol class="breadcrumb">
        <li><a href="<?php echo site_url('province');?>">Provinsi</a></li>
		<li><a href="<?php echo site_url('province/city/'.$id_provinsi);?>"><?php echo $provinsi->nama_provinsi;?></a></li>
		<li class="active"><a><?php echo $judul_utama;?></a></li>
    </ol>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:12%">Id Kecamatan</th>			
			<th style="text-align:center; width:60%">Kecamatan</th>			
			
			<th style="text-align:center; width:24%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';	
				$path = '';		
				if(!empty($kecamatan)){		
					foreach($kecamatan as $s){	
						$view_sub = '';
						$view_sub = site_url('province/kelurahan/'.$s['id_kec']);
						$info = $s['id_kec'].'Þ'.$s['nama_kec'];
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.ucwords($s['id_kec']).'</td>';
						echo '<td>'.ucwords($s['nama_kec']).'</td>';
						
						
						echo '<td align="center" style="vertical-align: middle;">	
			<a href="'.$view_sub.'" title="List Kelurahan"><button class="btn btn-xs btn-info"><i class="fa fa-bars"></i> List Kelurahan</button></a>
			<button id="'.$info.'" title="Edit"  class="btn btn-xs btn-success edit_category"><i class="fa fa-edit"></i> Edit</button>
			<button title="Delete" id="'.$s['id_kec'].'" class="btn btn-xs btn-danger del_category"><i class="fa fa-trash-o"></i> Delete</button>		
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
var id_city = '<?php echo $id_city;?>';
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 

$('.add_category').click(function(){
	$('#frm_cat').find("input[type=text], select, input[type=hidden]").val("");	
	$('.city_error').text('');
	$('#id_city').val(id_city);
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});
$('.edit_category').click(function(){
	$('#frm_cat').find("input[type=text], select").val("");
	$('.city_error').text('');
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_kec').val(dt[0]);
	$('#id_city').val(id_city);
	$('#kecamatan').val(dt[1]);
	
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});

$('.del_category').click(function(){
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
	var url = '<?php echo site_url('province/del_kec');?>';
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

$('.yes_save').click(function(){
	var kecamatan = $('#kecamatan').val();
	$('.kecamatan_error').text('');
	if(kecamatan <= 0 || kecamatan == '') {
		$('.kecamatan_error').text('Kecamatan harus diisi');
		return false;
	}
	var dt = $('#frm_cat').serialize();
	var url = '<?php echo site_url('province/simpan_kec');?>';
	$('#frm_cat').attr('action', url);
	$('#frm_cat').submit();
	
});



$(function() {               
    $('#example88').dataTable({});
});



</script>
