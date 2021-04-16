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
	.form-control[readonly]{
		background-color: #fff;
		cursor:text;
	}
	table{
  margin: 0 auto;
  width: 200%;
  clear: both;
  border-collapse: collapse;
  table-layout: fixed; 
  word-wrap:break-word; 
}
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
	}

?>



 <div class="box box-success">
<div class="box-header">
	
	<div class="pull-right box-tools">
        <form action="" method="post" autocomplete="off" class="pull-right" id="search_report">
		<label>Status</label>
		 <select style="width:150px; height:25px;" name="status" id="status">
            	<option value="">- Pilih Status -</option>
            	<option value="1" <?php echo $status == 1 ? ' selected ' : '';?>>New Order</option>
            	<option value="2" <?php echo $status == 2 ? ' selected ' : '';?>>Waiting Verify Payment</option>
            	<option value="3" <?php echo $status == 3 ? ' selected ' : '';?>>Payment Rejected</option>
            	<option value="4" <?php echo $status == 4 ? ' selected ' : '';?>>Payment Verified</option>
            	<option value="5" <?php echo $status == 5 ? ' selected ' : '';?>>On Process</option>
            	<option value="6" <?php echo $status == 6 ? ' selected ' : '';?>>Completed</option>
            	
					
		</select> <strong>||</strong>
        <label>Tanggal</label>
        <input type="text" name="tgl" id="tgl" value="<?php echo $tgl;?>" style="width:150px;" required>
        <input type="hidden" name="_grade" id="_grade" value="<?php echo $grade;?>">  
              
        <button type="button" id="btn_submit" class="btn btn-xs btn-success" style="height:27px;"><i class="glyphicon glyphicon-search"></i> Search</button>
		<button type="button" class="btn btn-xs btn-warning res" style="height:27px;"><i class="glyphicon glyphicon-refresh"></i> Reset</button>
        <button type="button" id="print" class="btn btn-xs btn-info" style="height:27px;"><i class="glyphicon glyphicon-share-alt"></i> Export</button>               
		</form>
    </div>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center;width:4%;">No.</th>					
			<th style="text-align:center;">Tgl. Order</th>		
			<th style="text-align:center;">No.Order</th>			
			<th style="text-align:center;">Store</th>			
			<th style="text-align:center;">Nama Customer</th>	
			<th style="text-align:center;">No.Hp. Customer</th>	
			<th style="text-align:center; width:15%;">Alamat Customer</th>	
			<th style="text-align:center;">Email Customer</th>	
			<th style="text-align:center;">Category Device</th>	
			<th style="text-align:center;">Type Device</th>				
			<th style="text-align:center;">Kerusakan Part & Variant</th>	
			<th style="text-align:center;">Harga</th>	
			<th style="text-align:center; width:20%;">Status</th>	
			<th style="text-align:center;">Metode Pembayaran</th>	
			<th style="text-align:center;">Catatan</th>			
						
		</tr>
		</thead>
		<tbody>
			
		</tbody>
	
	</table>
</div>

</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/daterangepicker-master/daterangepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/daterangepicker-master/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/daterangepicker-master/daterangepicker.js"></script>	
<script type="text/javascript">
$("#success-alert").hide();
var tgl = $('#tgl').val();
var status = $('#status').val();
// $(function() {               
    // $('#example88').dataTable({scrollX: "1500px"});
// });

$(function() {
	var path_role= '<?php echo site_url('report/load_data_ops');?>';
    var dataTable = $('#example88').removeAttr('width').DataTable({
        processing: true,
        "serverSide": true,
        "scrollX": true,		
        "ajax":{
            url :path_role, // json datasource
            type: "post",  // method  , by default get
			data : {'tgl' : tgl,'status':status},
            error: function(){  // error handling
				
                $("#example88").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#example88").css("display","none");
            }
        },
		columnDefs: [
			{ "width": "4%", "targets": 0 },
			{ "width": "10%", "targets": 1 },
			{ "width": "10%", "targets": 2 },
			{ "width": "12%", "targets": 3 },
			{ "width": "13%", "targets": 4 },
			{ "width": "15%", "targets": 5 },
			{ "width": "15%", "targets": 6 },
			{ "width": "12%", "targets": 7 },
			{ "width": "12%", "targets": 8 },
			{ "width": "17%", "targets": 9 },
			{ "width": "10%", "targets": 10 },
			{ "width": "13%", "targets": 11 },
			{ "width": "13%", "targets": 12 },
			{ "width": "15%", "targets": 13 },
			{ "width": "15%", "targets": 14 },
					
			
			{
				"targets": 0,
				"className": "text-center",
			}
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
$(function() {
  $('input[name="tgl"]').daterangepicker({
    opens: 'left',
	autoUpdateInput: false,
	maxDate: moment().format('D/MM/Y'),
	locale: {
      format: 'D/MM/Y'
    }
  });
});
$('input[name="tgl"]').on('apply.daterangepicker', function(ev, picker) {	
    $(this).val(picker.startDate.format('D/MM/Y') + ' - ' + picker.endDate.format('D/MM/Y'));	
});

$('input[name="tgl"]').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
});
$('.res').click(function(){
	window.location.href = '<?php echo site_url('report/order_ps');?>';
	
});
$("#btn_submit").click(function(){	
	var url = '<?php echo site_url('report/order_ps');?>';
	$('#search_report').attr('action', url);
	$('#search_report').submit();
});
$("#print").click(function(){	
	var url = '<?php echo site_url('report/export_ps');?>';
	$('#search_report').attr('action', url);
	$('#search_report').submit();
});
</script>
