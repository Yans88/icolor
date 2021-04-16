<style type="text/css">
media (min-width: 768px)
.col-sm-offset-2 {
    margin-left: 16.66666667%;
}
.select2 {
width:100%!important;
border-radius: 0px !important;
}
.list-group-unbordered>.list-group-item {
    border-left: 0;
    border-right: 0;
    border-radius: 0;
    padding-left: 0;
    padding-right: 0;
	background-color:#f5f5f5;
	padding:9px;
}
.list-group-item {
    position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid #ddd;
}
.list-group-item:first-child {
    border: 0px;
    
}
.timeline > li > .timeline-item {margin-left:10px;}
.timeline:before {background:none; border:none;}
.margin {
    margin: 10px;
	margin-bottom:2px;
}
.timeline > li > .timeline-item > .timeline-body, .timeline > li > .timeline-item > .timeline-footer {
    padding-left: 40px;
}
a{color:#000;}
a:hover{color:#000;}
.img-thumbnail{display:inline-block; margin:3px; height:180px;}
hr {
    border-top: 1px solid #555;
	margin-top:0;
}
</style>
<?php 
$id = !empty($bs) ? (int)$bs->id_order : 0;
$layanan = !empty($bs) ? (int)$bs->layanan : 0;
$pembayaran = !empty($bs) ? (int)$bs->pembayaran : 0;
$dp = !empty($dp) ? (int)$bs->dp : 0;
$nama = !empty($bs) ? $bs->nama.' '.$bs->last_name : '-';
$created_at = !empty($bs->created_at) ? date('d-m-Y H:i', strtotime($bs->created_at)): '-';
$wa = !empty($bs) ? $bs->wa : '-'; 
$ig = !empty($bs) ? $bs->ig : '-';
$alamat = !empty($bs) ? $bs->alamat : '-';
$nama_cat = !empty($bs) ? $bs->nama_cat : '-';
$nama_type = !empty($bs) ? $bs->nama_type : '-';

$jns_pembayaran = '-';
$_dp = $dp > 0 ? 'DP 50%' : 'Lunas';
if($pembayaran == 1){
	$jns_pembayaran = $_dp.' - Cash';
}
if($pembayaran == 2){
	$jns_pembayaran = $_dp.' - Manual Transfer';
}

$date_transfer = !empty($bs->date_transfer) ? date('d-m-Y H:i', strtotime($bs->date_transfer)): '';
$status_transfer_date = !empty($bs->status_transfer_date) ? date('d-m-Y H:i', strtotime($bs->status_transfer_date)): '';
$proses_date = !empty($bs->proses_date) ? date('d-m-Y H:i', strtotime($bs->proses_date)): '';
$completed_date = !empty($bs->completed_date) ? date('d-m-Y H:i', strtotime($bs->completed_date)): '';
$catatan_adm_payment = !empty($bs->catatan_adm_payment) ? $bs->catatan_adm_payment : '-';
$catatan_adm_proses = !empty($bs->catatan_adm_proses) ? $bs->catatan_adm_proses : '-';
$catatan_adm_completed = !empty($bs->catatan_adm_completed) ? $bs->catatan_adm_completed : '-';
?>

<br/>
<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Main</a></li>
              
              <li class=""><a href="#gambar" data-toggle="tab" aria-expanded="false">History Status</a></li>
             
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="activity">
                <!-- Post -->
				
				<div class="row">
				
			  <div class="col-md-6">
			  
                <ul class="list-group list-group-unbordered">
					
					<li class="list-group-item">
					  <b>Nama Member</b> <a class="pull-right"><?php echo $nama;?></a>
					</li>
					<li class="list-group-item">
					  <b>WhatsApp</b> <a title="WhatsApp" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $wa;?>" class="pull-right"><?php echo $wa;?></a>
					</li>
					<li class="list-group-item">
					  <b>Instagram</b> <a class="pull-right"><?php echo $ig;?></a>
					</li>
					
					<li class="list-group-item">
					  <b>Alamat</b> <a class="pull-right"><?php echo $alamat;?></a>
					</li>
					
					
				</ul>
              </div>
			  <div class="col-md-6">
                <ul class="list-group list-group-unbordered">
					<li class="list-group-item">
					  <b>Tanggal</b> <a class="pull-right"><?php echo $created_at;?></a>
					</li>
					
					<li class="list-group-item">
					  <b>Device Category</b> <a class="pull-right"><?php echo $nama_cat;?></a>
					</li>
					<li class="list-group-item">
					  <b>Device Type</b> <a class="pull-right"><?php echo $nama_type;?></a>
					</li>
					<li class="list-group-item">
					  <b>Pembayaran</b> <a class="pull-right"><?php echo $jns_pembayaran;?></a>
					</li>				
					
				</ul>
				
              </div>
			 
              </div>
			   <hr style="margin-bottom:5px; margin-top:5px;"/>
			   <div class="row"><div class="col-sm-12">
				<h4><strong>Spare Parts</strong></h4>
				
				<div class="my_sp"></div>
					
					
       
              </div>
              </div>
              </div>
			<div class="tab-pane" id="gambar">
				<table id="example88" class="table table-bordered table-striped">
					<thead><tr>
						<th style="text-align:center; width:4%">No.</th>
						
						<th style="text-align:center; width:10%">Tanggal</th>		
						<th style="text-align:center; width:15%">Status</th>		
						<th style="text-align:center; width:35%">Catatan</th>		
						<th style="text-align:center; width:15%">PIC</th>							
						
					</tr>
					</thead>
					<tbody>
						<tr>
							
						<?php 
							$i=1;
							if(!empty($completed_date)){
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$completed_date.'</td>';	
								echo '<td>Completed</td>';	
								echo '<td>'.$catatan_adm_completed.'</td>';	
								echo '<td>'.$dt_adm[$bs->completed_by].'</td>';	
								echo '</tr>';
							}
							if(!empty($proses_date)){
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$proses_date.'</td>';	
								echo '<td>On Process</td>';	
								echo '<td>'.$catatan_adm_proses.'</td>';	
								echo '<td>'.$dt_adm[$bs->proses_by].'</td>';	
								echo '</tr>';
							}
							if(!empty($status_transfer_date)){
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$status_transfer_date.'</td>';	
								if((int)$bs->status_transfer == 4){
									echo '<td>Pembayaran diterima</td>';
								}else{
									echo '<td>Pembayaran ditolak</td>';
								}
									
								echo '<td>'.$catatan_adm_payment.'</td>';	
								echo '<td>'.$dt_adm[$bs->status_transfer_by].'</td>';	
								echo '</tr>';
							}
							
							if(!empty($date_transfer)){
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$date_transfer.'</td>';	
								echo '<td>Transfer</td>';	
								echo '<td>-</td>';	
								echo '<td>-</td>';	
								echo '</tr>';
							}
							echo '<tr>';
							echo '<td align="center">'.$i++.'.</td>';
							echo '<td>'.$created_at.'</td>';	
							echo '<td>Order</td>';	
							echo '<td>-</td>';	
							echo '<td>-</td>';	
							echo '</tr>';					
						?>
						</tr>			  
					</tbody>
				</table>
            </div>
            </div>
            <!-- /.tab-content -->
          </div>
<script>
var id_booking = '<?php echo $id;?>';
load_sp(id_booking);

function load_sp(id_booking){
	if(id_booking > 0){
		var url = '<?php echo site_url('order_part_s/get_mykerusakan');?>';
		$('.my_sp').html('');
		$.ajax({
			data:{'id_booking' : id_booking},
			type:'POST',
			url : url,
			success:function(response){				
				$('.my_sp').html(response);
			}
		})	
	}
}

</script>