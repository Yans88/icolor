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

<div class="modal fade" role="dialog" id="confirm_del">
          <div class="modal-dialog" style="width:300px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>

              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" id="del_isd" value="">
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success yes_del">Yes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>



<div class="modal fade" role="dialog" id="import_dialog">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Import</strong></h4>
              </div>
			 
              <div class="modal-body">
				<form role="form" action="<?php echo site_url('members/import');?>" id="frm_import" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
				<div class="row">
				 <div class="form-group">
                  <label>Pilih file (.csv or .xls)</label><span class="label label-danger pull-right"></span>
                  <input type="file" class="form-control custom-file-input" name="user_import" id="user_import" accept=".csv, .xls" required />
                 
                </div>
                </div>
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="submit" class="btn btn-success">Import</button>               
              </div>
            </div>
			</form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<br/>
 <div class="box box-success">

<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">

    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:15%">Name</th>			
			<th style="text-align:center; width:15%">Email</th>		
			<th style="text-align:center; width:15%">Tgl.Registrasi</th>		
			<th style="text-align:center; width:12%">DoB</th>
			<th style="text-align:center; width:10%">Point</th>		
			<th style="text-align:center; width:7%">Action</th>
		</tr>
		</thead>
		<tbody>
			
		</tbody>

	</table>
</div>

</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off");
$('.btn_appr').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#status').val(4);
	$('#appr').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#appr").modal('show');
});
$('.btn_rej').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#status').val(3);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var status = $('#status').val();	
	var url = '<?php echo site_url('members/appr_rej');?>';
	$.ajax({
		data : {id : id, status:status},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data member telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});
		}
	});
});

$('.yes_appr').click(function(){
	var id = $('#del_id').val();
	var status = $('#status').val();
	var kd_cust = $('#kd_cust').val();
	var slp_code = $('#id_sls').val();
	var limit_credit = $('#limit_credit').val();
	var id_whs = $('#id_whs').val();
	var ocrcode_c = $('#ocrcode_c').val();
	$('.limit_credit_error').text('');
	$('.kd_cust_error').text('');
	$('.slp_code_error').text('');
	if(kd_cust == ''){
		$('.kd_cust_error').text('Kode Customer harus di isi');
		return false;
	}
	if(slp_code == ''){
		$('.slp_code_error').text('Sales Person Code harus di isi');
		return false;
	}
	var url = '<?php echo site_url('members/appr_rej');?>';
	$.ajax({
		data : {id : id, status:status, limit_credit:limit_credit,kd_cust:kd_cust,id_sls:slp_code,id_whs:id_whs,ocrcode_c:ocrcode_c},
		url : url,
		type : "POST",
		success:function(response){
			$('#appr').modal('hide');
			$("#id_text").html('<b>Success,</b> Data member telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});
		}
	});

});

$('.btn_import').click(function(){	
	$('#import_dialog').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#import_dialog').modal('show');
});
$('.btn_export').click(function(){	
	var url = '<?php echo site_url('members/export_r');?>';
	window.location.href = url;
});

$(function() {
	var path_role= '<?php echo site_url('members/members_data');?>';
    var dataTable = $('#example88').removeAttr('width').DataTable({
        processing: true,
        "serverSide": true,
        "scrollX": true,		
        "ajax":{
            url :path_role, // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling				
                $("#example88").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#example88").css("display","none");
            }
        },
		columnDefs: [
			{ "width": "4%", "targets": 0 },
			{ "width": "20%", "targets": 1 },
			{ "width": "19%", "targets": 2 },
			{ "width": "15%", "targets": 3 },
			{ "width": "12%", "targets": 4 },
			{ "width": "10%", "targets": 5 },
			{ "width": "7%", "targets": 6 },			
			{ "className": "text-center", "targets": 0 }
		],
		fixedColumns: true,
		"order": [[ 0, "ASC" ]],
        "language": {
			"lengthMenu": "Display _MENU_ Record per halaman",
            "zeroRecords": "Nothing found - sorry",
            "info": "Tampil halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch":        "Cari ",
            "oPaginate": {
				"sFirst":    "Pertama",
				"sLast":    "Terakhir",
				"sNext":    "Berikut",
				"sPrevious": "Sebelum"
            }
        }
    });
});

$('#limit_credit').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});
</script>
