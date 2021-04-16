<style type="text/css">
media (min-width: 768px)
.col-sm-offset-2 {
    margin-left: 16.66666667%;
}
.select2 {
width:100%!important;
border-radius: 0px !important;
}
.table-bordered {
		border-bottom: none;
		border-left: none;
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

$nama = !empty($bs) ? $bs->nama.' '.$bs->last_name : '-';
$created_at = !empty($bs->created_at) ? date('d-m-Y H:i', strtotime($bs->created_at)): '-';

$alamat = !empty($bs) ? $bs->alamat : '-';
$nama_bank_icolor = !empty($bs->nama_bank_icolor) ? $bs->nama_bank_icolor : '-';
$no_rek_icolor = !empty($bs->no_rek_icolor) ? $bs->no_rek_icolor : '-';
$holder_name_icolor = !empty($bs->holder_name_icolor) ? $bs->holder_name_icolor : '-';
$catatan = !empty($bs->catatan) ? $bs->catatan : '-';
$status_transfer = '-';
if($bs->status_transfer == 1) $status_transfer = 'Waiting verify';
if($bs->status_transfer == 4) $status_transfer = 'Verified';
if($bs->status_transfer == 3) $status_transfer = 'Rejected';

$date_transfer = !empty($bs->date_transfer) ? date('d-m-Y H:i', strtotime($bs->date_transfer)): '';
$status_transfer_date = !empty($bs->status_transfer_date) ? date('d-m-Y H:i', strtotime($bs->status_transfer_date)): '';
$req_cancel = !empty($bs->req_cancel) &&(int)$bs->req_cancel > 0 ? (int)$bs->req_cancel: 0;
$req_cancel_date = !empty($bs->req_cancel_date) ? date('d-m-Y H:i', strtotime($bs->req_cancel_date)): '';
$appr_rej_req_cancel_date = !empty($bs->appr_rej_req_cancel_date) ? date('d-m-Y H:i', strtotime($bs->appr_rej_req_cancel_date)): '';
$tgl_kirim = !empty($bs->tgl_kirim) ? date('d-m-Y H:i', strtotime($bs->tgl_kirim)): '';
$proses_date = !empty($bs->proses_date) ? date('d-m-Y H:i', strtotime($bs->proses_date)): '';
$completed_at = !empty($bs->completed_at) ? date('d-m-Y H:i', strtotime($bs->completed_at)): '';
$catatan_adm_payment = !empty($bs->catatan_adm_payment) ? $bs->catatan_adm_payment : '-';
$catatan_adm_proses = !empty($bs->catatan_adm_proses) ? $bs->catatan_adm_proses : '-';
$catatan_adm_completed = !empty($bs->catatan_adm_completed) ? $bs->catatan_adm_completed : '-';
$appr_rej_req_cancel_note = !empty($bs->appr_rej_req_cancel_note) ? $bs->appr_rej_req_cancel_note : '-';
$catatan_kirim = !empty($bs->catatan_kirim) ? $bs->catatan_kirim : '-';

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
					  <b>Tanggal</b> <a class="pull-right"><?php echo $created_at;?></a>
					</li>
					<li class="list-group-item">
					  <b>Nama Member</b> <a class="pull-right"><?php echo $nama;?></a>
					</li>
					<li class="list-group-item">
					  <b>Status Pembayaran</b> <a class="pull-right"><?php echo $status_transfer;?></a>
					</li>	
					<li class="list-group-item" style="height:60px;">
					  <b>Alamat</b> <a class="pull-right"><?php echo $alamat;?></a>
					</li>
						
					
				</ul>
              </div>
			  <div class="col-md-6">
                <ul class="list-group list-group-unbordered">
					<li class="list-group-item">
					  <b>Bank iColor</b> <a class="pull-right"><?php echo $nama_bank_icolor;?></a>
					</li>
					
					<li class="list-group-item">
					  <b>No.rek iColor</b> <a class="pull-right"><?php echo $no_rek_icolor;?></a>
					</li>
					<li class="list-group-item">
					  <b>Holder name iColor</b> <a class="pull-right"><?php echo $holder_name_icolor;?></a>
					</li>
					<li class="list-group-item" style="height:60px;">
					  <b>Catatan</b> <a class="pull-right"><?php echo $catatan;?></a>
					</li>		
					
				</ul>
				
              </div>
			 
              </div>
			   <hr style="margin-bottom:5px; margin-top:5px;"/>
			   <div class="row"><div class="col-sm-12">
				<h4 style="margin-bottom:9px;"><strong>Spare Parts</strong></h4>
				
				
			<table class="table table-bordered table-reponsive">
				<thead>
					<tr>
						<td style="text-align:center; width:4%"><b>No.</b></td>
						<td style="text-align:center; width:30%"><b>Nama Produk</b></td>
						<td style="text-align:center; width:13%"><b>Varian</b></td>
						<td style="text-align:center; width:10%"><b>Qty</b></td>					
						<td style="text-align:center; width:15%"><b>Harga</b></td>					
						<td style="text-align:center; width:15%"><b>Sub Total</b></td>			
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;						
						if(!empty($bs_detail)){
							foreach($bs_detail as $_td){
								$subtotal = 0;
								$varian = '';
								$subtotal = $_td['jml'] * $_td['hrg_final'];
								$varian = !empty($_td['varian']) ? $_td['varian'] : '-';
								echo '<tr>';
								echo '<td align="center">'.$i.'.</td>';											
								echo '<td>'.$_td['nama_product'].'</td>';							
								echo '<td>'.$varian.'</td>';							
								echo '<td align="center">'.$_td['jml'].'</td>';															
								echo '<td align="right">'.number_format($_td['hrg_final'],0,'',',').'</td>';									
								echo '<td align="right">'.number_format($subtotal,0,'',',').'</td>';							
								echo '</tr>';
								
								$i++;
							}						
						}
						echo '<tr style="border:none;">';
							
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td align="right" style="border:none;"><b>Total</b></td>';			
							echo '<td align="right"><b>'.number_format($bs->ttl_order,0,',','.').'</b></td>';
							echo '</tr>';
					?>
					
				</tbody>
			</table>
		
	
			
		
		
					
					
       
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
							if((int)$bs->status == 9){
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$appr_rej_req_cancel_date.'</td>';	
								echo '<td>Canceled</td>';	
								echo '<td></td>';	
								echo '<td></td>';	
								echo '</tr>';
							}
							if(!empty($completed_at)){
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$completed_at.'</td>';	
								echo '<td>Completed</td>';	
								echo '<td></td>';	
								echo '<td></td>';	
								echo '</tr>';
							}
							if(!empty($tgl_kirim)){
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$tgl_kirim.'</td>';	
								echo '<td>Dikirimkan</td>';	
								echo '<td>'.$catatan_kirim.'</td>';	
								echo '<td>'.$dt_adm[$bs->dikirim_oleh].'</td>';	
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
							if(!empty($appr_rej_req_cancel_date)){
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$appr_rej_req_cancel_date.'</td>';	
								if((int)$bs->req_cancel == 4){
									echo '<td>Request Cancel rejected</td>';
								}else{
									echo '<td>Request Cancel approved</td>';
								}
									
								echo '<td>'.$appr_rej_req_cancel_note.'</td>';	
								echo '<td>'.$dt_adm[$bs->appr_rej_req_cancel_by].'</td>';	
								echo '</tr>';
							}
							if($req_cancel > 0){
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$req_cancel_date.'</td>';	
								echo '<td>Request Cancel</td>';	
								echo '<td></td>';	
								echo '<td></td>';	
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
// load_sp(id_booking);

function load_sp(id_booking){
	if(id_booking > 0){
		var url = '<?php echo site_url('order_shop/get_mykerusakan');?>';
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