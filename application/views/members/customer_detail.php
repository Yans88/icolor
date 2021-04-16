<style>
	.profile-user-img {
		margin: 0 auto;
		width: 100px;
		padding: 3px;
		border: 3px solid #d2d6de;
	}

	.img-circle {
		border-radius: 50%;
	}
	.list-group-unbordered>.list-group-item {
		border-left: 0;
		border-right: 0;
		border-radius: 0;
		padding-left: 0;
		padding-right: 0;
	}
	.direct-chat-messages {
		-webkit-transform: translate(0, 0);
		-ms-transform: translate(0, 0);
		-o-transform: translate(0, 0);
		transform: translate(0, 0);
		padding: 10px;
		height: 230px;
		overflow: auto;
	}
	.direct-chat-text {
		border-radius: 5px;
		position: relative;
		padding: 5px 10px;
		background: #d2d6de;
		border: 1px solid #d2d6de;
		margin: 5px 0 0 5px;
		color: #444;
		display: block;
	}
	.direct-chat-warning .right>.direct-chat-text{
		background: #ddd;
		border-color: #ddd;
		color: #000;
	}
	.direct-chat-msg:before, .direct-chat-msg:after {
		content: " ";
		display: table;
	}
	:after, :before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	
	.direct-chat-msg:before, .direct-chat-msg:after {
		content: " ";
		display: table;
	}
	:after, :before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	
	.direct-chat-messages, .direct-chat-contacts {
		-webkit-transition: -webkit-transform .5s ease-in-out;
		-moz-transition: -moz-transform .5s ease-in-out;
		-o-transition: -o-transform .5s ease-in-out;
		transition: transform .5s ease-in-out;
	}
	.direct-chat-msg{
		display: block;
	}	
	.direct-chat-info {
		display: block;
		margin-bottom: 2px;
		font-size: 12px;
	}
	.direct-chat-text:before {
		position: absolute;
		right: 100%;		
		border-width: 8px !important;
		margin-top: 3px;
		border-right-color: #d2d6de;
		content: ' ';
		height: 0;
		width: 0;
		pointer-events: none;
	}
	.abt_me{
		height: 125px;
		overflow: auto;
	}
	.list-group{margin-bottom:0px;}
	.products-list {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.product-list-in-box>.item {
    -webkit-box-shadow: none;
    box-shadow: none;
    border-radius: 0;
    border-bottom: 1px solid #f4f4f4;
}
.products-list>.item {
    border-radius: 3px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    padding: 10px 0;
    background: #fff;
}
.img_task {
    margin: 0 auto;
	margin-bottom:10px;
    padding: 3px;
    border: 1px solid #d2d6de;
}
</style>
<?php 
$id_member = (int)$customer->id_customer > 0 ? (int)$customer->id_customer : 0;
$nama = !empty($customer->nama) ? $customer->nama : '';
$nama_belakang = !empty($customer->last_name) ? $customer->last_name : '';
$nama .= ' '.$nama_belakang;
$photo = !empty($customer->photo) ? base_url('uploads/members/'.$customer->photo) : base_url('uploads/no_photo.jpg');
$phone = !empty($customer->phone) ? $customer->phone : '';
$email = !empty($customer->email) ? $customer->email : '';
$point = !empty($customer->point) ? $customer->point : 0;
$dob = !empty($customer->dob) ? date('d-M-Y', strtotime($customer->dob)) : '';
$jk = (int)$customer->jk > 1 ? 'Female' : 'Male';
$verify_email = (int)$customer->verify_email > 0 ? '<small class="label label-success"><strong>Active</strong></small>' : '<small class="label label-danger"><strong>Unverified</strong></small>';
$alamat = !empty($customer->alamat) ? $customer->alamat.', '.$customer->nama_city : '-';
?>

<br/>
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $photo;?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $nama;?></h3>

              <p class="text-muted text-center">+<?php echo $phone;?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Poin</b> <a class="pull-right"><?php echo number_format($point,0,'',',');?></a>
                </li>
               
				
                <li class="list-group-item">
                  <b>Date of Birth</b> <a class="pull-right"><?php echo $dob;?></a>
                </li>
				<li class="list-group-item">
                  <b>Gender</b> <a class="pull-right"><?php echo $jk;?></a>
                </li>
				<li class="list-group-item">
                  <b>Email</b> <a class="pull-right"><?php echo $email;?></a>
                </li>
				
				<li class="list-group-item">
                  <b>Verified email</b> <a class="pull-right"><?php echo $verify_email;?></a>
                </li>
				
				
				
				
              </ul>

              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary abt_me">
            <div class="box-header with-border">
              <h3 class="box-title">Alamat</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              

              <p class="text-muted">
                <?php echo $alamat;?>
              </p>
				<hr style="margin-bottom:8px;margin-top:0px;">

            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">History</a></li>
              <li><a href="#timeline" data-toggle="tab" aria-expanded="false">Device & Address</a></li>
              <li class="hide"><a href="#settings" data-toggle="tab" aria-expanded="false">KTP - Photo Selfie</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="activity">
				
					<div class="box direct-chat direct-chat-warning">            
						<div class="box-header with-border">
							<h3 class="box-title">Transaksi</h3>                
						</div>
						<div class="box-body">
                 
						<div class="direct-chat-messages">
						
							<?php 
							echo '<ul class="todo-list ui-sortable msg_history">';
							$date_point = '';
							if(!empty($trans_coin)){
								foreach($trans_coin as $ph){								
									$date_point = '';
									$date_point = date("d-M-Y", strtotime($ph['created_at']));
									echo '<li><span class="text" style="color:#000 !important;font-size: 12px; font-weight:normal;"><b>ID Transaksi : #'.$ph['id_trans'].'<br/>Jumlah coin : ' .number_format($ph['jml'],0,'',',').'<br/>Nominal : '.number_format($ph['nominal'],2,',','.').'<br/>Kode unik : '.$ph['kode_unik'].'<br/>Total Rp. ' .number_format($ph['total'],2,',','.').'</b></span><div class="tools" style="display:inline-block; color:#dd4b39 !important">';					
										
									echo '<span style="font-size:12px; font-weight:normal;">'.$date_point.'</span>';
									if($ph['status'] == 1) echo '<br/><small class="label label-info"><strong>New Order</strong></small>';
									if($ph['status'] == 2) echo '<br/><small class="label label-warning"><strong>Confirmed</strong></small>';
										if($ph['status'] == 3) echo '<br/><small class="label label-danger"><strong>Rejected</strong></small>';
									if($ph['status'] == 4) echo '<br/><small class="label label-success"><strong>Approved</strong></small>';	
				  
								}
							}else{
								echo '<li><span class="text" style="color:#000 !important;font-size: 12px;"><b>Not found</b></li>';
							}
							echo '</ul>';
							?>
					
							
					

						</div>
                 
						</div>
					</div>
				
              
				
					<div class="box direct-chat direct-chat-warning">            
						<div class="box-header with-border">
							<h3 class="box-title">Redeem</h3>                
						</div>
						<div class="box-body">
                 
						<div class="direct-chat-messages">
							<?php 
							echo '<ul class="todo-list ui-sortable msg_history">';
							$date_point = '';
							if(!empty($trans_premium)){
								foreach($trans_premium as $ph){								
									$date_point = '';
									$date_point = date("d-M-Y", strtotime($ph['created_at']));
									echo '<li><span class="text" style="color:#000 !important;font-size: 12px; font-weight:normal;"><b>ID Transaksi : #'.$ph['no_trans'].'<br/>Jumlah hari : ' .number_format($ph['jml'],0,'',',').'<br/>Nominal : '.number_format($ph['nominal'],2,',','.').'<br/>Kode unik : '.$ph['kode_unik'].'<br/>Total Rp. ' .number_format($ph['total'],2,',','.').'</b></span><div class="tools" style="display:inline-block; color:#dd4b39 !important">';					
										
									echo '<span style="font-size:12px; font-weight:normal;">'.$date_point.'</span>';
									if($ph['status'] == 1) echo '<br/><small class="label label-info"><strong>New Order</strong></small>';
									if($ph['status'] == 2) echo '<br/><small class="label label-warning"><strong>Confirmed</strong></small>';
									if($ph['status'] == 3) echo '<br/><small class="label label-danger"><strong>Rejected</strong></small>';
									if($ph['status'] == 4) echo '<br/><small class="label label-success"><strong>Approved</strong></small>';		
									echo '</li>';
								}
							}else{
								echo '<li><span class="text" style="color:#000 !important;font-size: 12px;"><b>Not found</b></li>';
							}
							echo '</ul>';
							?>
					
					

						</div>
                 
						</div>
					</div>
				
               
                <!-- /.post -->
              </div>
              
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <div class="box direct-chat direct-chat-warning">            
						<div class="box-header with-border">
							<h3 class="box-title">List My Device</h3>                
						</div>
						<div class="box-body">
							<table id="example88" class="table table-bordered table-striped">
							<thead><tr>
								<th style="text-align:center; width:4%">No.</th>
								<th style="text-align:center; width:15%">Device Name</th>			
								<th style="text-align:center; width:15%">Imei</th>		
								<th style="text-align:center; width:15%">Tipe</th>		
								<th style="text-align:center; width:12%">Category</th>
								<th style="text-align:center; width:10%">Type Name</th>		
								<th style="text-align:center; width:7%">Condition</th>
							</tr>
							</thead>
							<tbody>
								<?php
									$i =1;
									
									if(!empty($my_device)){
										foreach($my_device as $e){
											$_tipe = '';
											if($e['tipe'] == 1) $_tipe = 'Gadget';
											if($e['tipe'] == 2) $_tipe = 'Spare parts';
											if($e['tipe'] == 3) $_tipe = 'Tools';
											if($e['tipe'] == 4) $_tipe = 'Accessories';
											echo '<tr>';
											echo '<td align="center">'.$i++.'.</td>';
											echo '<td>'.$e['nama_device'].'</td>';
											echo '<td>'.$e['imei'].'</td>';				
											echo '<td>'.$_tipe.'</td>'; 
											echo '<td>'.$e['nama_kategori'].'</td>'; 
											echo '<td>'.$e['nama_sub'].'</td>';											
											echo '<td>'.$e['kondisi'].'</td>';											
											echo '</td>';
											echo '</tr>';
										}
									}
								?>
							</tbody>

						</table>
						
                 
						</div>
					</div>
					
					<div class="box direct-chat direct-chat-warning">            
						<div class="box-header with-border">
							<h3 class="box-title">List My Address</h3>                
						</div>
						<div class="box-body">
							<table id="example_address" class="table table-bordered table-striped">
							<thead><tr>
								<th style="text-align:center; width:4%">No.</th>
								<th style="text-align:center; width:30%">Nama alamat</th>			
								<th style="text-align:center; width:65%">Alamat</th>		
								
							</tr>
							</thead>
							<tbody>
								<?php
									$i =1;									
									if(!empty($my_address)){
										foreach($my_address as $e){											
											echo '<tr>';
											echo '<td align="center">'.$i++.'.</td>';
											echo '<td>'.$e['nama_alamat'].'</td>';
											echo '<td>'.$e['alamat'].', '.$e['nama_kel'].', '.$e['nama_kec'].', '.$e['nama_city'].', '.$e['nama_provinsi'].', '.$e['kode_pos'].'</td>';				
											echo '</td>';
											echo '</tr>';
										}
									}
								?>
							</tbody>

						</table>
						
                 
						</div>
					</div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <div class="row margin-bottom">
					<div class="col-sm-6">
						<p><strong>KTP</strong></p>
						<img class="img-responsive img_task" src="<?php echo $_ktp;?>" alt="KTP">
                    </div>
					<div class="col-sm-6">
						<p><strong>Photo Selfie</strong></p>
						<img class="img-responsive img_task" src="<?php echo $photo_selfie;?>" alt="Photo Selfie">
                    </div>
					 <!--
					<br/>
                   <div class="col-sm-12">
					<?php if(!empty($cv_file)) { ?>
					<iframe src="https://docs.google.com/gview?url='<?php echo $cv_file;?>'&embedded=true" style="width:700px; height:400px;" frameborder="0"></iframe>
                  </div>
                    <?php } else{
						echo '<h3><strong>CV File Not Found</strong></h3>';
					}?>
                    <!-- /.col -->
                  </div>
              </div>
			  <div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>	
			
	</div>
</div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
			
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
<script>
$('.back').click(function(){
	history.back();
});
$(function() {
    $('#example88').dataTable({});
});
$(function() {
    $('#example_address').dataTable({});
});
</script>   