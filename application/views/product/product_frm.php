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
		height: 295px;
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
.thumbnail{display:inline-block; margin:3px;}
.dropzone .dz-preview.dz-image-preview {
    background: white transparent;
}
.user-block img {
    width: 40px;
    height: 40px;
    float: left;
}
.img-bordered-sm {
    border: 2px solid #d2d6de;
    padding: 2px;
}
.img-circle {
    border-radius: 50%;
}
img {
    vertical-align: middle;
}
img {
    border: 0;
}
.user-block .username {
    font-size: 16px;
    font-weight: 600;
}
.user-block .username, .user-block .description, .user-block .comment {
    display: block;
    margin-left: 50px;
}
.user-block .description {
    color: #999;
    font-size: 13px;
}
.user-block .username, .user-block .description, .user-block .comment {
    display: block;
    margin-left: 50px;
}

.users-list, .mailbox-attachments {
    list-style: none;
    margin: 0;
    padding: 0;
}
.users-list>li {
    width: 25%;
    float: left;
    padding: 10px;
    text-align: center;
}
.users-list>li img {
   
    max-width: 100%;
    height: auto;
}
	.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 20px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 12px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2ab934;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(37px);
  -ms-transform: translateX(37px);
  transform: translateX(37px);
}

/*------ ADDED CSS ---------*/
.on
{
  display: none;
}

.on, .off
{
  color: white;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 50%;
  font-size: 10px;
  font-family: Verdana, sans-serif;
}

input:checked+ .slider .on
{display: block;}

input:checked + .slider .off
{display: none;}

/*--------- END --------*/

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;}
.tags-input-wrapper {
            background: #ffffff;
            padding: 10px;          
            border: 1px solid #ccc
        }

        .tags-input-wrapper input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
        }

        .tags-input-wrapper .tag {
            display: inline-block;
            background-color: #009432;
            color: white;
           
            padding: 0px 3px 0px 7px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .tags-input-wrapper .tag a {
            margin: 0 7px 3px;
            display: inline-block;
            cursor: pointer;
        }
</style>
<?php 
$id_product = (int)$product->id_product > 0 ? (int)$product->id_product : 0;
$device_cat = (int)$product->device_cat > 0 ? (int)$product->device_cat : 0;
$device_type = (int)$product->device_type > 0 ? (int)$product->device_type : 0;
$preorder = (int)$product->preorder > 0 ? (int)$product->preorder : 0;
$stok = (int)$product->qty > 0 ? number_format($product->qty,0,'',',') : 0; 
$harga = (int)$product->harga > 0 ? number_format($product->harga,0,'',',') : 0; 
$diskon = (int)$product->diskon > 0 ? number_format($product->diskon,0,'',',') : 0; 
$nama_product = !empty($product->nama_product) ? $product->nama_product : '';
$rincian_produk = !empty($product->rincian_produk) ? $product->rincian_produk : '';
$deskripsi = !empty($product->deskripsi) ? $product->deskripsi : '';
$video = !empty($product->video) ? $product->video : '';
$varian = !empty($product->varian) ? $product->varian : '';
$waktu_po = !empty($product->waktu_po) && $preorder > 0 ? $product->waktu_po : '';
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dropzone/dropzone.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dropzone/basic.min.css') ?>">

<br/>
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
<div class="modal fade" role="dialog" id="confirm_success">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Success</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Data telah disimpan </h4>
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success btn_ok">Ok</button>               
                            
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="add_gbr">
          <div class="modal-dialog" style="width:650px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Add Image</strong></h4>
              </div>
			 
              <div class="modal-body">
				
				<div class="dropzone" style="border: 1px dashed #0087F7;">

				  <div class="dz-message">
					
				   <h3> Klik atau Drop gambar disini (Ukuran file Maks. 2Mb)</h3>
				  </div>

				</div>
            </div>
			<div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Exit</button>               
                             
              </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
</div> 
     
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?php echo $dt_tab !='section' ? 'active' : '';?>"><a href="#activity" data-toggle="tab" aria-expanded="true">Main</a></li>
			  <?php if($id_product > 0){ ?>
              <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Gambar</a></li>
              <?php } ?>
            </ul>
            <div class="tab-content">
              <div class="tab-pane <?php echo $dt_tab !='section' ? 'active' : '';?>" id="activity">
				
					<div class="box direct-chat direct-chat-warning">            
						
						<div class="box-body">
				<?php if (!empty($this->session->flashdata('message'))) { ?>
                <div class='alert alert-info alert-dismissable'>   
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
					<div><b><?php echo $this->session->flashdata('message');?></b></div>
				</div>
				<?php } ?>
				
						<div class="direct-chat-messages">
						
							<form role="form" id="frm_tutor_main" method="post" enctype="multipart/form-data">
								<div class="row">
								 
								  <div class="col-md-6">
									
									
									<div class="form-group">
									  <label for="exampleInputPassword1">Nama Produk</label><span class="label label-danger pull-right nama_produk_error"></span>
									  <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk" value="<?php echo $nama_product;?>" >
									  <input type="hidden" class="form-control" name="id_product" id="id_product" value="<?php echo $id_product;?>" >
									  <input type="hidden" class="form-control" name="kategori" id="kategori" value="<?php echo $kategori;?>" >
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Harga</label><span class="label label-danger pull-right harga_error"></span>
									  <input type="text" class="input_number form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga;?>" >
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Stok</label><span class="label label-danger pull-right stok_error"></span>
									  <input type="text" class="input_number form-control" name="stok" id="stok" placeholder="Stok" value="<?php echo $stok;?>" >
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Diskon(%)</label><span class="label label-danger pull-right diskon_error"></span>
									  <input type="text" class="input_number form-control" name="diskon" id="diskon" placeholder="Diskon(%)" value="<?php echo $diskon;?>" >
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Video(Url)</label><span class="label label-danger pull-right diskon_error"></span>
									  <input type="text" class="form-control" name="video" id="video" placeholder="Video(Url" value="<?php echo $video;?>" >
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Rincian Produk</label><span class="label label-danger pull-right rincian_produk_error"></span>
									  <textarea class="form-control" name="rincian_produk" id="rincian_produk" placeholder="Rincian Produk" rows=10><?php echo $rincian_produk;?></textarea>
									</div>
									
									
									
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="exampleInputPassword1">Category</label><span class="label label-danger pull-right device_cat_error"></span>
									  <select class="form-control" name="device_cat" id="device_cat"  onchange="return get_type(this.value);">
										<option value=''>- Pilih -</option>
										<?php if(!empty($category)){
											foreach($category as $c){
												if($device_cat == $c['id_kategori']){
													echo '<option value="'.$c['id_kategori'].'" selected>'.$c['nama_kategori'].'</option>';
												}else{
													echo '<option value="'.$c['id_kategori'].'">'.$c['nama_kategori'].'</option>';
												}
												
											}
										}?>
										
										
									  </select>
									</div>
									
									<div class="form-group">
									  <label for="exampleInputPassword1">Type</label><span class="label label-danger pull-right device_type_error"></span>
									  <select class="form-control" name="device_type" id="device_type" disabled>
										<option value=''>- Pilih -</option>
										
										
										
									  </select>
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Pre-order</label><label style="margin-bottom:2px; margin-top:0px;" class="switch pull-right"><input type="checkbox" name="po" class="po" value=1 <?php echo $preorder > 0 ? ' checked' : '';?> >
									  <div class="slider round"><!--ADDED HTML --><span class="on">Yes</span><span class="off">No</span><!--END--></div></label>
									  <input type="text" class="form-control" name="waktu_po" id="waktu_po" placeholder="Waktu Pre-order" value="<?php echo $waktu_po;?>" disabled>
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Varian</label><span class="label label-danger pull-right varian_error"></span>
									  <input type="text" name="varian" id="varian" value="<?php echo $varian;?>" />
									</div>
									
									<div class="form-group">
									  <label for="exampleInputPassword1">Deskripsi</label><span class="label label-danger pull-right deskripsi_error"></span>
									  <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi" rows=10><?php echo $deskripsi;?></textarea>
									</div>
									
								  </div>
								 
								  </div>
							</form>
					
							
						<div class="clearfix"></div>
						<div class="pull-right">
							<button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>	
										
							<button type="button" class="btn btn-success" id="btn_save_main"><i class="fa fa-check"></i> Save</button>				
						</div>

						</div>
                 
						</div>
					</div>
				
              
				
					
				
               
                <!-- /.post -->
              </div>
              
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
				
					<button class="btn btn-success btn_add_gbr" style="margin-bottom:10px;"><i class="fa fa-plus"></i> Add Gambar</button>
					
                <!-- The timeline -->
				<div class="box box-info">
					
            
					<div class="box-body">
						<div class="row">
							<div class="load_gbr"></div>
							
						</div>
						
					</div>
            <!-- /.box-body -->
					
					</div>
				
					
				</div>
              <!-- /.tab-pane -->

              
			  
			 
			  
			  

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
			
          </div>
          <!-- /.nav-tabs-custom -->
    
        <!-- /.col -->
      
      <!-- /.row -->


<script type="text/javascript" src="<?php echo base_url('assets/dropzone/dropzone.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tags/tagplug.js') ?>"></script>
<script>
$("#success-alert").hide();
localStorage.clear();
function del_img(id){
	$('#del_id').val(id);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
}
$('.back').click(function(){
	var kategori = '<?php echo (int)$kategori > 0 ? (int)$kategori : 0;?>';
	var urli = '';
	if(kategori == 1) urli = '<?php echo site_url('product');?>';
	if(kategori == 2) urli = '<?php echo site_url('product/spare_parts');?>';
	if(kategori == 3) urli = '<?php echo site_url('product/tools');?>';
	if(kategori == 4) urli = '<?php echo site_url('product/acc');?>';
	window.location.href = urli;
	
});
var tagInput1 = new TagsInput({
    selector: 'varian',
    duplicate : false,
    max : 10
});
var varian = '<?php echo $varian;?>';
if(varian != ''){
	var nameArr = varian.split(',');
	tagInput1.addData(nameArr);
	
}

var id_product = '<?php echo (int)$id_product > 0 ? (int)$id_product : 0;?>';
var id_kategori = '<?php echo (int)$device_cat > 0 ? (int)$device_cat : 0;?>';
var device_type = '<?php echo (int)$device_type > 0 ? (int)$device_type : 0;?>';
if(id_kategori > 0) get_type(id_kategori, device_type);
load_gbr(id_product);
function get_type(id, device_type){	
	var url = '<?php echo site_url('tutorial/get_type');?>';
	$('#device_type').prop('disabled', true);
	$('#device_type').html('');
	var html = '<option ="">- Pilih -</option>';
	$.ajax({
		data:{id:id},
		type:'POST',
		url : url,
		success:function(response){				
			if(response.length > 0){
				html += response;
				$('#device_type').html(html);
				$('#device_type').prop('disabled', false);
				$('#device_type').val(device_type);
			}				
		}
	});		
	
}
$('.po').click(function(){
	$('#waktu_po').prop('disabled', true);
	$('#waktu_po').val('');	
	if($(this).is(':checked')){
		$('#waktu_po').prop('disabled', false);
		$('#waktu_po').val('<?php echo $waktu_po;?>');
	}
	
});
Dropzone.autoDiscover = false;

	var foto_upload= new Dropzone(".dropzone",{
		url: "<?php echo site_url('product/proses_upload');?>",
		maxFilesize: 2,
		method:"post",
		acceptedFiles:"image/*",
		paramName:"userfile_step",
		dictInvalidFileType:"Type file ini tidak dizinkan",
		addRemoveLinks:true
	});


	//Event ketika Memulai mengupload
	foto_upload.on("sending",function(a,b,c){
		a.token=Math.random();
		c.append("id_product",id_product);
		c.append("token_foto",a.token); //Menmpersiapkan token untuk masing masing foto
	});
	foto_upload.on("complete",function(a,b,c){		
		load_gbr(id_product);
	});

	//Event ketika foto dihapus
	foto_upload.on("removedfile",function(a){
		var token=a.token;
		$.ajax({
			type:"post",
			data:{token:token},
			url:"<?php echo site_url('product/remove_foto') ?>",
			cache:false,
			dataType: 'json',
			success: function(){				
				load_gbr(id_product);
			},
			error: function(){
				console.log("Error");

			}
		});
	});
$('.btn_add_gbr').click(function(){
	$('#frm_gbr').find("input[type=text], select, input[type=hidden], input[type=file]").val("");
	
	$('#add_gbr').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#add_gbr').modal('show');
});
function load_gbr(id_product){	
	if(id_product > 0){
		var url = '<?php echo site_url('product/get_mygbr');?>';
		$('.load_gbr').html('');
		$.ajax({
			data:{'id_product' : id_product},
			type:'POST',
			url : url,
			success:function(response){	
		
				$('.load_gbr').html(response);
			}
		})	
	}
}
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('product/del_img');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			if(response > 0){
				$('#confirm_del').modal('hide');
				load_gbr(id_product);	
			}			
		}
	});
	
});
$('#btn_save_main').click(function(){	
	var nama_produk = $('#nama_produk').val();
	var harga = $('#harga').val();
	var stok = $('#stok').val();
	var diskon = $('#diskon').val();
	var device_cat = $('#device_cat').val();
	var device_type = $('#device_type').val();
	var deskripsi = $('#deskripsi').val();
	var rincian_produk = $('#rincian_produk').val();
	$('.nama_produk_error').text('');
	$('.harga_error').text('');
	$('.stok_error').text('');
	$('.diskon_error').text('');
	$('.device_cat_error').text('');
	$('.device_type_error').text('');
	$('.deskripsi_error').text('');
	$('.rincian_produk_error').text('');
	
	if(nama_produk == ''){
		$('.nama_produk_error').text('Nama Produk harus diisi');
		return false;
	}
	if(harga == ''){
		$('.harga_error').text('Harga harus diisi');
		return false;
	}
	if(stok == ''){
		$('.stok_error').text('Stok harus diisi');
		return false;
	}
	
	if(device_cat == ''){
		$('.device_cat_error').text('Device category harus diisi');
		return false;
	}
	if(device_type == '' || device_type <= 0){
		$('.device_type_error').text('Device type harus diisi');
		return false;
	}
	
	
	if(rincian_produk == ''){
		$('.rincian_produk_error').text('Rincian Produk harus diisi');
		return false;
	}
	if(deskripsi == ''){
		$('.deskripsi_error').text('Deskripsi harus diisi');
		return false;
	}
	var dt = $('#frm_tutor_main').serialize();
	var url = '<?php echo site_url('product/save_produk');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){				
			if(response > 0){
				localStorage.setItem("id_shop_product", response);
				$('#confirm_success').modal({
					backdrop: 'static',
					keyboard: false
				});
				$("#confirm_success").modal('show');
			}
		}
	})	
});
$('.btn_ok').click(function(){
	var res = localStorage.getItem("id_shop_product");
	localStorage.clear();
	var urli = '<?php echo site_url('product/edit_product');?>/'+res;
	window.location.href = urli;
});
$('.input_number').keyup(function(event) {  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/[^.\d]/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	});	
});


</script>   