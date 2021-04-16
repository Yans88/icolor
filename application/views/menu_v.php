

<ul class="sidebar-menu">
<li class="hide <?php 
	 $menu_home_arr= array('home', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>home">
			<img height="20" src="<?php echo base_url().'assets/theme_admin/img/home.png'; ?>"> <span>Beranda</span>
		</a>
</li>
<?php if($_MEMBERS > 0){ ?>
<li class="<?php 
	 $menu_home_arr= array('members', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>members">
			<i class="glyphicon glyphicon-stats"></i> <span>Members</span>
		</a>
</li>
<?php } ?>
<?php if($_TOOLS > 0){ ?>
<li class="hide <?php 
	 $menu_home_arr= array('tools', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>tools">
			<i class="glyphicon glyphicon-stats"></i> <span>Tools</span>
		</a>
</li>
<?php } ?>
<?php if($_SPPARTS > 0){ ?>
<li class="hide <?php 
	 $menu_home_arr= array('spare_parts', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>spare_parts">
			<i class="glyphicon glyphicon-stats"></i> <span>Spare Parts</span>
		</a>
</li>
<?php } ?>
<?php if($_MKERUSAKAN > 0){ ?> 
<li class="<?php 
	 $menu_home_arr= array('master_kerusakan', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>master_kerusakan">
			<i class="glyphicon glyphicon-stats"></i> <span>Price Check</span>
		</a>
</li>
<?php } ?>
<?php if($_TUTOR > 0){ ?> 
<li class="<?php 
	 $menu_home_arr= array('tutorial', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>tutorial">
			<i class="glyphicon glyphicon-stats"></i> <span>Tutorial</span>
		</a>
</li>
<?php } ?>
<?php if($_FORUM > 0){ ?> 
<li class="<?php 
	 $menu_home_arr= array('forum', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>forum">
			<i class="glyphicon glyphicon-stats"></i> <span>Forum</span>
		</a>
</li>
<?php } ?>
<?php if($_NEWS > 0){ ?> 
<li class="<?php 
	 $menu_home_arr= array('berita', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>berita">
			<i class="glyphicon glyphicon-stats"></i> <span>News</span>
		</a>
</li>
<?php } ?>
<?php if($_HOMES > 0 || $_PICKUPS > 0 || $_KIRIMDEVICE > 0 || $_INSTORE > 0){ ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('booking_service');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Booking Service</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	
	<?php if($_HOMES > 0){ ?>
	<li class="<?php if ($this->uri->segment(1) == 'booking_service' && $this->uri->segment(2) == 'home_service'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>booking_service/home_service"><i class="fa fa-folder-open-o"></i> Home Service </a></li>
	<?php } ?>
	<?php if($_PICKUPS > 0){ ?>
	<li class="<?php if ($this->uri->segment(1) == 'booking_service' && $this->uri->segment(2) == 'pickup_device'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>booking_service/pickup_device"><i class="fa fa-folder-open-o"></i> Pickup Device </a></li>	
	<?php } ?>
	<?php if($_KIRIMDEVICE > 0){ ?>	
	<li class="<?php if ($this->uri->segment(1) == 'booking_service' && $this->uri->segment(2) == 'kirim_ketoko'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>booking_service/kirim_ketoko"><i class="fa fa-folder-open-o"></i> Kirim Device ke Toko </a></li>
	<?php } ?>
	<?php if($_INSTORE > 0){ ?>
	<li class="<?php if ($this->uri->segment(1) == 'booking_service' && ($this->uri->segment(2) == 'instore' || $this->uri->segment(2) == 'add_instore')){ echo 'active'; } ?>"><a href="<?php echo base_url();?>booking_service/instore"><i class="fa fa-folder-open-o"></i> Instore </a></li>
	<?php } ?>
	</ul>
</li>
<?php } ?>
<?php if($_ORDER_PARTS > 0){ ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('order_part_s');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Order Part Service</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	<li class="<?php if ($this->uri->segment(1) == 'order_part_s' && $this->uri->segment(2) == 'new_order'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>order_part_s/new_order"><i class="fa fa-folder-open-o"></i> New Order </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'order_part_s' && $this->uri->segment(2) == 'onprocess'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>order_part_s/onprocess"><i class="fa fa-folder-open-o"></i> On Progress </a></li>	
	<li class="<?php if ($this->uri->segment(1) == 'order_part_s' && $this->uri->segment(2) == 'completed'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>order_part_s/completed"><i class="fa fa-folder-open-o"></i> Completed </a></li>
	
	
	
	</ul>
</li>
<?php } ?>
<?php if($_ORDER_SHOP > 0){ ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('order_shop');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Order Shop</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	<li class="<?php if ($this->uri->segment(1) == 'order_shop' && $this->uri->segment(2) == 'new_order'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>order_shop/new_order"><i class="fa fa-folder-open-o"></i> New Order </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'order_shop' && $this->uri->segment(2) == 'onprocess'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>order_shop/onprocess"><i class="fa fa-folder-open-o"></i> Dikirim </a></li>	
	<li class="<?php if ($this->uri->segment(1) == 'order_shop' && $this->uri->segment(2) == 'completed'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>order_shop/completed"><i class="fa fa-folder-open-o"></i> Completed </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'order_shop' && $this->uri->segment(2) == 'cancel'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>order_shop/cancel"><i class="fa fa-folder-open-o"></i> Cancel </a></li>
	
	
	</ul>
</li>
<?php } ?>

<li  class="treeview <?php 
	 $menu_trans_arr= array('report');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Report</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	<li class="<?php if ($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'booking_service'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>report/booking_service"><i class="fa fa-folder-open-o"></i> Booking Service </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'order_ps'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>report/order_ps"><i class="fa fa-folder-open-o"></i> Order Part Service </a></li>	
	<li class="<?php if ($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'order_shop'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>report/order_shop"><i class="fa fa-folder-open-o"></i> Shop Product </a></li>
	
	
	
	</ul>
</li>

<?php if($_PREDEEM > 0 || $_DREDEEM > 0){ ?>
<li class="treeview <?php 
	 $menu_trans_arr= array('redeem','');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Redeem</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	<?php if($_PREDEEM > 0){ ?>
	<li class="<?php if ($this->uri->segment(1) == 'redeem' && $this->uri->segment(2) == 'product'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>redeem/product"><i class="fa fa-folder-open-o"></i> Product Redeem </a></li>
	<?php } ?>
	<?php if($_DREDEEM > 0){ ?>
	<li class="<?php if ($this->uri->segment(1) == 'redeem' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>redeem"><i class="fa fa-folder-open-o"></i> Daftar Redeem</a></li>
    <?php } ?>
   
	</ul>
</li>
<?php } ?>
<?php if($_CATEGORY > 0){ ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('category');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Category</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	<li class="<?php if ($this->uri->segment(1) == 'category' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>category"><i class="fa fa-folder-open-o"></i> Gadget </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'category' && $this->uri->segment(2) == 'spare_parts'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>category/spare_parts"><i class="fa fa-folder-open-o"></i> Spare Parts </a></li>	
	
	
	
	<li class="<?php if ($this->uri->segment(1) == 'category' && $this->uri->segment(2) == 'tools'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>category/tools"><i class="fa fa-folder-open-o"></i> Tools </a></li>
	
	<li class="<?php if ($this->uri->segment(1) == 'category' && $this->uri->segment(2) == 'acc'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>category/acc"><i class="fa fa-folder-open-o"></i> Accessories </a></li>
	
	</ul>
</li>
<?php } ?>
<?php if($_PRODUCT > 0){ ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('product');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>iColor Shop</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	<li class="<?php if ($this->uri->segment(1) == 'product' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>product"><i class="fa fa-folder-open-o"></i> Gadget </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'product' && $this->uri->segment(2) == 'spare_parts'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>product/spare_parts"><i class="fa fa-folder-open-o"></i> Spare Parts </a></li>	
	
	
	
	<li class="<?php if ($this->uri->segment(1) == 'product' && $this->uri->segment(2) == 'tools'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>product/tools"><i class="fa fa-folder-open-o"></i> Tools </a></li>
	
	<li class="<?php if ($this->uri->segment(1) == 'product' && $this->uri->segment(2) == 'acc'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>product/acc"><i class="fa fa-folder-open-o"></i> Accessories </a></li>
	
	</ul>
</li>
<?php } ?>
<?php if($_BANNER > 0){ ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('banner');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Banner</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	<li class="<?php if ($this->uri->segment(1) == 'banner' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>banner"><i class="fa fa-folder-open-o"></i> Tutorial </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'banner' && $this->uri->segment(2) == 'forum'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>banner/forum"><i class="fa fa-folder-open-o"></i> Forum </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'banner' && $this->uri->segment(2) == 'benefit'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>banner/benefit"><i class="fa fa-folder-open-o"></i> Keuntungan </a></li>
	
	</ul>
</li>
<?php } ?>
<?php if($_STORE > 0 || $_KURIR > 0 || $_TEKNISI > 0 || $_AREA > 0 || $_PROVINCE > 0 || $_FAQ > 0 || $_BANKICOLOR > 0 || $_LEVELROLE > 0 || $_USERS > 0 || $_SPOINT > 0 || $_SETTING > 0){ ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('setting','user','faq','province','outlet','kurir','teknisi','master_bank','setting_point','area','role');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/data.png'; ?>">
		<span>Master Data</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	
	<?php if($_STORE > 0){ ?>
	<li class="<?php if ($this->uri->segment(1) == 'outlet'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>outlet"><i class="fa fa-folder-open-o"></i> Store </a></li>
	<?php } ?>
	<?php if($_KURIR > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'kurir'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>kurir"><i class="fa fa-folder-open-o"></i> Kurir </a></li>
	<?php } ?>
	<?php if($_TEKNISI > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'teknisi'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>teknisi"><i class="fa fa-folder-open-o"></i> Teknisi </a></li>
	<?php } ?>
	<?php if($_AREA > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'area'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>area"><i class="fa fa-folder-open-o"></i> Area </a></li>	
	<?php } ?>
	<?php if($_PROVINCE > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'province'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>province"><i class="fa fa-folder-open-o"></i> Province </a></li>	
	<?php } ?>
	<?php if($_FAQ > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'faq'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>faq"><i class="fa fa-folder-open-o"></i> FAQ </a></li>	
	<?php } ?>
	<?php if($_BANKICOLOR > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'master_bank'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>master_bank"><i class="fa fa-folder-open-o"></i> Data Bank iColor </a></li>
	<?php } ?>
	<?php if($_LEVELROLE > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'role'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>role"><i class="fa fa-folder-open-o"></i> Level & Role </a></li>
	<?php } ?>
	<?php if($_USERS > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'user'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>user"><i class="fa fa-folder-open-o"></i> Users </a></li>
	<?php } ?>
	<?php if($_SPOINT > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'setting_point'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>setting_point"><i class="fa fa-folder-open-o"></i> Setting Point</a></li>
	<?php } ?>
	<?php if($_SETTING > 0){ ?> 
	<li class="<?php if ($this->uri->segment(1) == 'setting'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>setting"><i class="fa fa-folder-open-o"></i> Setting </a></li>
	<?php } ?>
	</ul>
</li>
<?php } ?>

</ul>