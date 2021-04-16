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
  width: 310%;
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
		<label>Store</label>
		 <select style="width:150px; height:25px;" name="store" id="store">
            <option value="">- Pilih Store -</option>
            <?php if(!empty($list_store)) { 
				foreach($list_store as $ls){
					if($store == $ls['id_op']){
						echo '<option value="'.$ls['id_op'].'" selected>'.$ls['nama'].'</option>';
					}else{
						echo '<option value="'.$ls['id_op'].'">'.$ls['nama'].'</option>';
					}
				}
			}?>		
		</select> <strong>||</strong>
		<label>Layanan</label>
		 <select style="width:150px; height:25px;" name="jns_layanan" id="jns_layanan">
            	<option value="">- Pilih Layanan -</option>
            	<option value="1" <?php echo $jns_layanan == 1 ? ' selected ' : '';?>>Home Service</option>
            	<option value="2" <?php echo $jns_layanan == 2 ? ' selected ' : '';?>>Pickup Device</option>
            	<option value="3" <?php echo $jns_layanan == 3 ? ' selected ' : '';?>>Kirim Device</option>
            	<option value="4" <?php echo $jns_layanan == 4 ? ' selected ' : '';?>>Instore</option>
            	
            	
					
		</select> <strong>||</strong>
        <label>Tanggal</label>
        <input type="text" name="tgl" id="tgl" value="<?php echo $tgl;?>" style="width:150px;" required>        
              
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
			<th style="text-align:center;">IG Customer</th>	
			<th style="text-align:center;">Category Device</th>	
			<th style="text-align:center;">Type Device</th>	
			<th style="text-align:center;">IMEI</th>	
			<th style="text-align:center;">Pass Code</th>	
			<th style="text-align:center; width:20%;">Kerusakan Part & Variant</th>	
			<th style="text-align:center;">Harga Part</th>	
			<th style="text-align:center;">Garansi</th>	
			<th style="text-align:center;">Nama Teknisi</th>	
			<th style="text-align:center;">Durasi Pengerjaan</th>	
			<th style="text-align:center; width:15%;">Jadwal Teknisi/Kurir</th>	
			<th style="text-align:center; width:15%;">Nama Kurir</th>	
			<th style="text-align:center; width:15%;">No. Resi</th>	
			<th style="text-align:center; width:13%;">Status</th>	
			<th style="text-align:center; width:13%;">Jenis Layanan</th>	
						
		</tr>
		</thead>
		<tbody>
			
		</tbody>
	
	</table>
</div>

</div>
<link href="<?php echo base_url(); ?>assets/daterangepicker-master/daterangepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/daterangepicker-master/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/daterangepicker-master/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
var tgl = $('#tgl').val();
var jns_layanan = $('#jns_layanan').val();
var store = $('#store').val();

// $(function() {               
    // $('#example88').dataTable({scrollX: "1500px"});
// });

$(function() {
	var path_role= '<?php echo site_url('report/load_data_bs');?>';
    var dataTable = $('#example88').removeAttr('width').DataTable({
        processing: true,
        "serverSide": true,
        "scrollX": true,
        "ajax":{
            url :path_role, // json datasource
            type: "post",  // method  , by default get
			data : {'tgl' : tgl,'jns_layanan':jns_layanan,'store':store},
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
			{ "width": "10%", "targets": 7 },
			{ "width": "10%", "targets": 8 },
			{ "width": "12%", "targets": 9 },
			{ "width": "10%", "targets": 10 },
			{ "width": "10%", "targets": 11 },
			{ "width": "10%", "targets": 12 },
			{ "width": "15%", "targets": 13 },
			{ "width": "10%", "targets": 14 },
			{ "width": "10%", "targets": 15 },
			{ "width": "10%", "targets": 16 },
			{ "width": "10%", "targets": 17 },
			{ "width": "12%", "targets": 18 },
			{ "width": "10%", "targets": 19 },
			{ "width": "10%", "targets": 20 },
			{ "width": "12%", "targets": 21 },
			{ "width": "12%", "targets": 22 },
			{
				"targets": 0,
				"className": "text-center",
			},
			{
				"targets": 14,
				"className": "text-right",
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
	window.location.href = '<?php echo site_url('report/booking_service');?>';
	
});

$("#btn_submit").click(function(){	
	var url = '<?php echo site_url('report/booking_service');?>';
	$('#search_report').attr('action', url);
	$('#search_report').submit();
});
$("#print").click(function(){	
	var url = '<?php echo site_url('report/export_bs');?>';
	$('#search_report').attr('action', url);
	$('#search_report').submit();
});
</script>
