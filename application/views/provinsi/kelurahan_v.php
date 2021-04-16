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
                  <label>Kelurahan</label><span class="label label-danger pull-right kelurahan_error"></span>
                  <input type="text" class="form-control" name="kelurahan" id="kelurahan" value="" placeholder="Kelurahan" autocomplete="off" />
                  <input type="hidden" value="" name="id_kel" id="id_kel">
                  <input type="hidden" value="" name="id_kec" id="id_kec">
                </div>
				
				<div class="form-group">
                  <label>Kode Pos</label><span class="label label-danger pull-right kode_pos_error"></span>
                  <input type="text" class="form-control" name="kode_pos" id="kode_pos" value="" placeholder="Kode Pos" autocomplete="off" />
                  
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
    <a href="#"><button class="btn btn-success add_category"><i class="fa fa-plus"></i> Add Kelurahan</button></a>
	<ol class="breadcrumb">
        <li><a href="<?php echo site_url('province');?>">Provinsi</a></li>
		<li><a href="<?php echo site_url('province/city/'.$id_provinsi);?>"><?php echo $provinsi->nama_provinsi;?></a></li>
		<li><a href="<?php echo site_url('province/kecamatan/'.$id_city);?>"><?php echo $city->nama_city;?></a></li>
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
			<th style="text-align:center; width:12%">Id Kelurahan</th>			
			<th style="text-align:center; width:50%">Kelurahan</th>			
			<th style="text-align:center; width:15%">Kode Pos</th>			
			
			<th style="text-align:center; width:14%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';	
				$path = '';		
				if(!empty($kelurahan)){		
					foreach($kelurahan as $s){	
						$view_sub = '';
						$view_sub = site_url('province/kelurahan/'.$s['id_kec']);
						$info = $s['id_kelurahan'].'Þ'.$s['nama_kel'].'Þ'.$s['kode_pos'];
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.ucwords($s['id_kelurahan']).'</td>';
						echo '<td>'.ucwords($s['nama_kel']).'</td>';
						echo '<td>'.$s['kode_pos'].'</td>';
						
						
						echo '<td align="center" style="vertical-align: middle;">	
			
			<button id="'.$info.'" title="Edit"  class="btn btn-xs btn-success edit_category"><i class="fa fa-edit"></i> Edit</button>
			<button title="Delete" id="'.$s['id_kelurahan'].'" class="btn btn-xs btn-danger del_category"><i class="fa fa-trash-o"></i> Delete</button>		
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
var id_kec = '<?php echo $id_kec;?>';
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 

$('.add_category').click(function(){
	$('#frm_cat').find("input[type=text], select, input[type=hidden]").val("");	
	$('.kecamatan_error').text('');
	$('.kode_pos').text('');
	$('#id_kec').val(id_kec);
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});
$('.edit_category').click(function(){
	$('#frm_cat').find("input[type=text], select").val("");
	$('.kelurahan_error').text('');
	$('.kode_pos').text('');
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_kel').val(dt[0]);
	$('#id_kec').val(id_kec);
	$('#kelurahan').val(dt[1]);
	$('#kode_pos').val(dt[2]);
	
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
	var url = '<?php echo site_url('province/del_kel');?>';
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
	var kode_pos = $('#kode_pos').val();
	var kelurahan = $('#kelurahan').val();
	$('.kelurahan_error').text('');
	$('.kode_pos_error').text('');
	if(kelurahan <= 0 || kelurahan == '') {
		$('.kelurahan_error').text('Kelurahan harus diisi');
		return false;
	}
	if(kode_pos <= 0 || kode_pos == '') {
		$('.kode_pos_error').text('Kode Pos harus diisi');
		return false;
	}
	var dt = $('#frm_cat').serialize();
	var url = '<?php echo site_url('province/simpan_kel');?>';
	$('#frm_cat').attr('action', url);
	$('#frm_cat').submit();
	
});



$(function() {               
    $('#example88').dataTable({});
});

$('#kode_pos').keyup(function(event) {  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/[^.\d]/g, "");
	});	
});

</script>
