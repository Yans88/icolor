<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
	.table > tbody > tr > td{
		vertical-align : middle;
	}
	.custom-file-input::-webkit-file-upload-button {
		visibility: hidden;
	}
	.custom-file-input::before {
	  content: 'Select Photo';
	  display: inline-block;
	  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
	  border: 1px solid #999;
	  border-radius: 3px;
	  padding: 1px 4px;
	  outline: none;
	  white-space: nowrap;
	  -webkit-user-select: none;
	  cursor: pointer;
	  text-shadow: 1px 1px #fff;
	  font-weight: 700;  
	}
	.custom-file-input:hover::before {	 
	  color: #d3394c;
	}

	.custom-file-input:active::before {
	  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
	  color: #d3394c;
	}

</style>
<?php
$tanggal = date('Y-m');

	
$id_level = isset($level->id) ? $level->id : '';
$level_name = isset($level->level_name) ? $level->level_name : '';
$members = isset($level->members) && $level->members > 0 ? 'checked' : '';
$tools	 = isset($level->tools	) && $level->tools	 > 0 ? 'checked' : '';
$spare_parts = isset($level->spare_parts) && $level->spare_parts > 0 ? 'checked' : '';
$master_kerusakan = isset($level->master_kerusakan) && $level->master_kerusakan > 0 ? 'checked' : '';
$tutorial = isset($level->tutorial) && $level->tutorial > 0 ? 'checked' : '';
$forum = isset($level->forum) && $level->forum > 0 ? 'checked' : '';
$news = isset($level->news) && $level->news > 0 ? 'checked' : '';
$home_service = isset($level->home_service) && $level->home_service > 0 ? 'checked' : '';
$pickup_service = isset($level->pickup_service) && $level->pickup_service > 0 ? 'checked' : '';
$kirim_device = isset($level->kirim_device) && $level->kirim_device > 0 ? 'checked' : '';
$instore = isset($level->instore) && $level->instore > 0 ? 'checked' : '';
$order_part_s = isset($level->order_part_s) && $level->order_part_s > 0 ? 'checked' : '';
$order_shop = isset($level->order_shop) && $level->order_shop > 0 ? 'checked' : '';
$product_redeem = isset($level->product_redeem) && $level->product_redeem > 0 ? 'checked' : '';
$daftar_redeem = isset($level->daftar_redeem) && $level->daftar_redeem > 0 ? 'checked' : '';
$category = isset($level->category) && $level->category > 0 ? 'checked' : '';
$product = isset($level->product) && $level->product > 0 ? 'checked' : '';
$banner = isset($level->banner) && $level->banner > 0 ? 'checked' : '';
$store = isset($level->store) && $level->store > 0 ? 'checked' : '';
$kurir = isset($level->kurir) && $level->kurir > 0 ? 'checked' : '';
$teknisi = isset($level->teknisi) && $level->teknisi > 0 ? 'checked' : '';
$area = isset($level->area) && $level->area > 0 ? 'checked' : '';
$province = isset($level->province) && $level->province > 0 ? 'checked' : '';
$faq = isset($level->faq) && $level->faq > 0 ? 'checked' : '';
$bank_icolor = isset($level->bank_icolor) && $level->bank_icolor > 0 ? 'checked' : '';
$level_role = isset($level->level_role) && $level->level_role > 0 ? 'checked' : '';
$users = isset($level->users) && $level->users > 0 ? 'checked' : '';
$setting_point = isset($level->setting_point) && $level->setting_point > 0 ? 'checked' : '';
$setting = isset($level->setting) && $level->setting > 0 ? 'checked' : '';


?>

<div class="box box-success">

<div class="box-body">	
<form name="frm_editrole" id="frm_editrole"  method="post">
	<table  class="table table-bordered table-reponsive">	
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:left">Level</th>			
		</tr>
		<tr style="border:none;">			
			<td class="h_tengah" style="vertical-align:middle; border:none;">		
				<table class="table table-responsive">
					<tr style="vertical-align:middle; border:none;">
						<td style="border:none;" width="10%"><b> Level Name </td>
						<td style="border:none;" width="2%">:</td>
						<td style="border:none;">
						<input name="level_name" value="<?php echo $level_name;?>" type="text" style="width:100%; height:24px; padding-left: 5px;"/>
						</td>
						<input name="id_level" value="<?php echo $id_level;?>" type="hidden" style="width:100%; height:24px;"/>
					</tr>
				</table>
			</td>			
		</tr>	
	</table>
	
	<table  class="table table-bordered table-reponsive">	
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:left" colspan=2>Role(Hak akses management)</th>			
		</tr>
		<tr style="border-top:none;">			
			<td class="h_tengah" style="vertical-align:middle; border-top:none; width:50%;">		
				<table class="table table-responsive">
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;" width="60%"><b>Members</b></td>				
						<td style="border-top:none;">
							<input name="members" <?php echo $members;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr class="hide" style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Tools</b></td>				
						<td style="border-top:none;">
							<input name="tools" <?php echo $tools;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Spare Parts</b></td>				
						<td style="border-top:none;">
							<input name="spare_parts" <?php echo $spare_parts;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Price Check</b></td>				
						<td style="border-top:none;">
							<input name="master_kerusakan" <?php echo $master_kerusakan;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Tutorial</b></td>				
						<td style="border-top:none;">
							<input name="tutorial" <?php echo $tutorial;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Forum</b></td>				
						<td style="border-top:none;">
							<input name="forum" <?php echo $forum;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>News</b></td>				
						<td style="border-top:none;">
							<input name="news" <?php echo $news;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Booking Service > Home Service</b></td>				
						<td style="border-top:none;">
							<input name="home_service" <?php echo $home_service;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Booking Service > Pickup Device</b></td>				
						<td style="border-top:none;">
							<input name="pickup_service" <?php echo $pickup_service;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Booking Service > Kirim Device ke Toko</b></td>				
						<td style="border-top:none;">
							<input name="kirim_device" <?php echo $kirim_device;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Booking Service > Instore</b></td>				
						<td style="border-top:none;">
							<input name="instore" <?php echo $instore;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Order Part Service</b></td>				
						<td style="border-top:none;">
							<input name="order_part_s" <?php echo $order_part_s;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Order Shop</b></td>				
						<td style="border-top:none;">
							<input name="order_shop" <?php echo $order_shop;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Redeem > Product</b></td>				
						<td style="border-top:none;">
							<input name="product_redeem" <?php echo $product_redeem;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Redeem > Daftar Redeem</b></td>				
						<td style="border-top:none;">
							<input name="daftar_redeem" <?php echo $daftar_redeem;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					
				</table>
			</td>			
			<td class="h_tengah" style="width:50%; border-top:none;">		
				<table class="table table-responsive">
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Category</b></td>				
						<td style="border-top:none;">
							<input name="category" <?php echo $category;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;" width="45%"><b>Shop Product</b></td>		
						<td style="border-top:none;">
							<input name="product" <?php echo $product;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Banners</b></td>				
						<td style="border-top:none;">
							<input name="banner" <?php echo $banner;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;" width="60%"><b>Master Data > Store</b></td>		
						<td style="border-top:none;">
							<input name="store" <?php echo $store;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > Kurir</b></td>		
						<td style="border-top:none;">
							<input name="kurir" <?php echo $kurir;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > Teknisi</b></td>		
						<td style="border-top:none;">
							<input name="teknisi" <?php echo $teknisi;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > Area</b></td>		
						<td style="border-top:none;">
							<input name="area" <?php echo $area;?> type="checkbox" value=1 />
						</td>
					</tr>
				
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > Province</b></td>				
						<td style="border-top:none;">
							<input name="province" <?php echo $province;?> type="checkbox" value=1 />
						</td>
					</tr>					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > FAQ</b></td>				
						<td style="border-top:none;">
							<input name="faq" <?php echo $faq;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > Data Bank iColor</b></td>				
						<td style="border-top:none;">
							<input name="bank_icolor" <?php echo $bank_icolor;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > Level & Role</b></td>				
						<td style="border-top:none;">
							<input name="level_role" <?php echo $level_role;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > Users</b></td>				
						<td style="border-top:none;">
							<input name="users" <?php echo $users;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > Setting Point</b></td>				
						<td style="border-top:none;">
							<input name="setting_point" <?php echo $setting_point;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Data > Setting</b></td>				
						<td style="border-top:none;">
							<input name="setting" <?php echo $setting;?> type="checkbox" value=1 />
						</td>
					</tr>
									
					
				</table>
			</td>			
		</tr>	
	</table>
	
</form>
	

</div>
<div class="box-footer" style="height:55px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<button type="button" class="btn btn-danger canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>	
		<button type="button" class="btn btn-success save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$(".canc").click(function(){
	window.location = '<?php echo site_url('role');?>';
});
$('.save').click(function(){
	var data = $("#frm_editrole").serialize();
	console.log(data);
	var url = '<?php echo site_url('role/save');?>';
	$.ajax({
		url : url,
		type : 'POST',
		data : data,
		success:function(res){
			console.log(res);
			if(res > 0){
				window.location = '<?php echo site_url('role');?>';
			}
		}
	});
});

 
</script>
