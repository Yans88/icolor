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
.page-header {
    margin: 10px 0 20px 0;
    
}
.page-header {
    padding-bottom: 9px;
    border-bottom: 1px solid #eee;
}
.attachment {
    border-radius: 3px;
    background: #f4f4f4;
    margin-left: 45px;
    margin-right: 15px;
    margin-bottom: 15px;
    padding: 10px;
}
</style>
<?php 
$id_forum = (int)$forum->id > 0 ? (int)$forum->id : 0;
$title = !empty($forum->title) ? $forum->title : '';
$deskripsi = !empty($forum->deskripsi) ? $forum->deskripsi : '';
$device_cat = !empty($forum->device_cat) ? $forum->device_cat : '';
$device_type = !empty($forum->device_type) ? $forum->device_type : '';
$nama_kategori = !empty($forum->nama_kategori) ? $forum->nama_kategori : '';
$nama_sub = !empty($forum->nama_sub) ? $forum->nama_sub : '';
$img = !empty($forum->img) ? base_url('uploads/forum/'.$forum->img) : base_url('uploads/no_photo.jpg');
print_r($dt_reply);
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dropzone/dropzone.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dropzone/basic.min.css') ?>">
<br/>
<div class="modal fade" role="dialog" id="confirm_delete_comment">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id_comment" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del_comment">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_delete_reply">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id_reply" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del_reply">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>    
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#komentar" data-toggle="tab" aria-expanded="false">Komentar</a></li>
		<li class=""><a href="#like_share" data-toggle="tab" aria-expanded="false">Like - Share</a></li>
    </ul>
    <div class="tab-content">
		
			  <div class="tab-pane active" id="komentar">
                <div class='alert alert-info alert-dismissable' id="success-alert">
   
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
					<div id="id_text"><b>Welcome</b></div>
				</div>
				<h2 class="page-header">
					<?php echo $title;?> 
					<small class="pull-right"><?php echo date('d-M-Y H:i', strtotime($forum->created_at));?> </small>	
				</h2>
				
				<p><?php echo $deskripsi;?></p>
				<hr/>				
				<div class="post my_comment" style="margin-left:20px; margin-right:20px;">
                  
					
				</div>
				</div>
			  
			  <div class="tab-pane" id="like_share">
				<div class="row">
					<div class="col-md-6">
						<div class="box box-danger">
							<div class="box-header with-border">
							<h3 class="box-title"><?php echo !empty($member_like) ? count($member_like) : '';?> Like</h3>

                 
							</div>
                <!-- /.box-header -->
							<div class="box-body no-padding">
							  <ul class="users-list clearfix">
								<?php if(!empty($member_like)){ 
									foreach($member_like as $m_like){
										$photo = '';
										$photo = !empty($m_like['photo']) ? base_url('uploads/members/'.$m_like['photo']) : base_url('uploads/no_photo.jpg');
								?>
								<li>
								  <img src="<?php echo $photo;?>" alt="User Image">
								  <a class="users-list-name" href="#"><a href="#"><?php echo $m_like['nama'];?></a></a>
								  
								</li>
								
								<?php } }else{
									echo '<h3 style="text-align:center;"><strong>Not Found</strong></h3>';
								}?>	
							  </ul>
							  <!-- /.users-list -->
							</div>
                <!-- /.box-body -->
                
                <!-- /.box-footer -->
						</div>
					</div>
					<div class="col-md-6">
						<div class="box box-warning">
							<div class="box-header with-border">
							<h3 class="box-title"><?php echo !empty($member_share) ? count($member_share) : '';?> Share</h3>
							
							</div>
                <!-- /.box-header -->
							<div class="box-body no-padding">
							  <ul class="users-list clearfix">
								<?php if(!empty($member_share)){ 
									foreach($member_share as $ms){
										$photo = '';
										$photo = !empty($ms['photo']) ? base_url('uploads/members/'.$ms['photo']) : base_url('uploads/no_photo.jpg');
								?>
								<li>
								  <img src="<?php echo $photo;?>" alt="User Image">
								  <a class="users-list-name" href="#"><a href="#"><?php echo $ms['nama'];?></a></a>
								  
								</li>
								
								<?php } }else{
									echo '<h3 style="text-align:center;"><strong>Not Found</strong></h3>';
								}?>								
							  </ul>
							  <!-- /.users-list -->
							</div>
                <!-- /.box-body -->
                
                <!-- /.box-footer -->
						</div>
					
					</div>
				</div>
					
              </div>
	
	
	</div>
			
</div>
       
<script type="text/javascript" src="<?php echo base_url('assets/dropzone/dropzone.min.js') ?>"></script>
<script>
$("#success-alert").hide();
var img = '<?php echo !empty($tutorial->img) ? base_url('uploads/tutorials/'.$tutorial->img) : base_url('uploads/no_photo.jpg');?>';
$('.back').click(function(){
	history.back();
});
var id_forum = '<?php echo $id_forum;?>';
load_tools(id_forum);

function load_tools(){
	if(id_forum > 0){
		var url = '<?php echo site_url('forum/load_comment');?>';
		$('#my_comment').html('');
		$.ajax({
			data:{'id_forum' : id_forum},
			type:'POST',
			url : url,
			success:function(response){		
				console.log(response);
				$('.my_comment').html(response);
			}
		})	
	}
}
function delete_comment(id_category){	
	$('#del_id_comment').val(id_category);
	$('#confirm_delete_comment').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_delete_comment").modal('show');
}
$('.yes_del_comment').click(function(){
	var id = $('#del_id_comment').val();	
	var url = '<?php echo site_url('forum/del_comment');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_delete_comment').modal('hide');
			$("#id_text").html('<b>Success,</b> Data sudah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				load_tools(id_forum);	
			});			
					
		}
	});
});
function delete_reply(id_category){	
	$('#del_id_reply').val(id_category);
	$('#confirm_delete_reply').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_delete_reply").modal('show');
}
$('.yes_del_reply').click(function(){
	var id = $('#del_id_reply').val();	
	var url = '<?php echo site_url('forum/del_reply');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_delete_reply').modal('hide');
			$("#id_text").html('<b>Success,</b> Data sudah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				load_tools(id_forum);
			});			
						
		}
	});
});
</script>   