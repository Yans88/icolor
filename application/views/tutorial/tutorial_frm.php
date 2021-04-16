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
</style>
<?php 
$id_tutorial = (int)$tutorial->id > 0 ? (int)$tutorial->id : 0;
$title = !empty($tutorial->title) ? $tutorial->title : '';
$introduction = !empty($tutorial->introduction) ? $tutorial->introduction : '';
$deskripsi = !empty($tutorial->deskripsi) ? $tutorial->deskripsi : '';
$difficulty = !empty($tutorial->difficulty) ? $tutorial->difficulty : '';
$time_required = !empty($tutorial->time_required) ? $tutorial->time_required : '';
$video_overview = !empty($tutorial->video_overview) ? $tutorial->video_overview : '';
$device_cat = !empty($tutorial->device_cat) ? $tutorial->device_cat : '';
$device_type = !empty($tutorial->device_type) ? $tutorial->device_type : '';

$img = !empty($tutorial->img) ? base_url('uploads/tutorials/'.$tutorial->img) : '';
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
<div class="modal fade" role="dialog" id="frm_dialog_section">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Section</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">			
                <!-- text input -->					
					<div class="form-group">
						<label>Section</label><span class="label label-danger pull-right section_error"></span>
						<input type="text" class="form-control" name="section" id="section" value="" placeholder="Section" autocomplete="off" />
						<input type="hidden" value="" name="id_section" id="id_section">
					</div>	
					              
				

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success btn_save_section">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div> 
<div class="modal fade" role="dialog" id="confirm_delete_step">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id_step" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del_step">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_del_step_gbr">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id_step_img" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del_step_gbr">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_delete_tools">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id_tools" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del_tools">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_delete_section">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id_section" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del_section">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_delete_sp">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id_sp" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del_sp">Delete</button>               
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
				<input type="hidden" id="id_step_gbr" value="">
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
<div class="modal fade" role="dialog" id="frm_dialog_step">
          <div class="modal-dialog" style="width:800px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add/Edit Step</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_step" method="post" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				
					<input type="hidden" value="" name="id_step" id="id_step">
					<input type="hidden" value="" name="id_section_step" id="id_section_step">
					<div class="form-group">
					  <label>Step</label><span class="label label-danger pull-right step_error"></span>
					  <input type="text" class="form-control" name="step" id="step" value="" placeholder="Step" autocomplete="off" />
					</div>	
					<div class="form-group">
					  <label>Deskripsi</label><span class="label label-danger pull-right deskripsi_step_error"></span>
					  <textarea class="form-control" name="deskripsi_step" id="deskripsi_step" placeholder="Deskripsi" autocomplete="off" rows="10"></textarea>
					</div>               
				</form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_save_step">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div> 
<div class="modal fade" role="dialog" id="frm_dialog_sp">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add spare parts</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_sp" method="post" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				
					
					<div class="form-group">
					  <label>Spare Parts</label><span class="label label-danger pull-right list_sp_error"></span>
						<select class="form-control" name="list_sp[]" id="list_sp" style="width:100%;" multiple="multiple">
															
						</select>
					</div>	
					              
				</form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success btn_save_sp">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div> 
<div class="modal fade" role="dialog" id="frm_dialog_tools">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add tools</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_tools" method="post" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				
					
					<div class="form-group">
					  <label>Tools</label><span class="label label-danger pull-right list_tools_error"></span>
						<select class="form-control" name="list_tools[]" id="list_tools" style="width:100%;" multiple="multiple">
															
						</select>
					</div>	
					              
				</form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success btn_save_tools">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div> 
     
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?php echo $dt_tab !='section' ? 'active' : '';?>"><a href="#activity" data-toggle="tab" aria-expanded="true">Main</a></li>
              <?php if($id_tutorial > 0){ ?>
			  <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Tools - Spare Parts</a></li>
              <li class="<?php echo $dt_tab =='section' ? 'active' : '';?>"><a href="#settings" data-toggle="tab" aria-expanded="false">Section</a></li>
			   <li class=""><a href="#komentar" data-toggle="tab" aria-expanded="false">Komentar</a></li>
			   <li class=""><a href="#like_share" data-toggle="tab" aria-expanded="false">Like - Share</a></li>
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
								  <div class="col-sm-12">
									<div class="form-group">
									  <label for="exampleInputPassword1">Title</label><span class="label label-danger pull-right judul_error"></span>
									  <input type="text" class="form-control" name="judul" id="judul" placeholder="Title" value="<?php echo $title;?>" >
									  <input type="hidden" value="" name="reload" id="reload">
									  <input type="hidden" class="form-control" name="id_tutorial" id="id_tutorial" value="<?php echo $id_tutorial;?>" >
									</div>
								  </div>
								  <div class="col-md-6">
									
									
									<div class="form-group">
									  <label for="exampleInputPassword1">Difficulty</label><span class="label label-danger pull-right difficulty_error"></span>
									  <input type="text" class="form-control" name="difficulty" id="difficulty" placeholder="Difficulty" value="<?php echo $difficulty;?>" >
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Device Category</label><span class="label label-danger pull-right device_cat_error"></span>
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
									  <label for="exampleInputPassword1">Deskripsi</label><span class="label label-danger pull-right deskripsi_error"></span>
									  <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi" rows=5><?php echo $deskripsi;?></textarea>
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Video Overview(Url)</label><span class="label label-danger pull-right video_o_error"></span>
									  <input type="text" class="form-control" name="video_o" id="video_o" placeholder="Video Overview(Url)" value="<?php echo $video_overview;?>" >
									</div>
									<div class="form-group">
										<label>Image</label><span class="label label-danger pull-right"></span>
											<input type="file" class="form-control custom-file-input" name="userfile" id="userfile" accept="image/*" />
									 
									</div>
									
									
								  </div>
								  <div class="col-md-6">
								   
									<div class="form-group">
									  <label for="exampleInputPassword1">Time Required</label><span class="label label-danger pull-right time_required_error"></span>
									  <input type="text" class="form-control" name="time_required" id="time_required" placeholder="Time Required" value="<?php echo $time_required;?>" >
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Device Type</label><span class="label label-danger pull-right device_type_error"></span>
									  <select class="form-control" name="device_type" id="device_type" disabled>
										<option value=''>- Pilih -</option>
										
										
										
									  </select>
									</div>
									<div class="form-group">
									  <label for="exampleInputPassword1">Introduction</label><span class="label label-danger pull-right introduction_error"></span>
									  <textarea class="form-control" name="introduction" id="introduction" placeholder="Introduction" rows=5><?php echo $introduction;?></textarea>
									</div>
									<div class="form-group">
										<div class="fileupload-new thumbnail" style="width: 200px; height: 150px; margin-bottom:5px;">
											<img id="blah" style="width: 200px; height: 140px;" src="<?php echo $img;?>" alt="">
									
										</div>                 
									</div>
								  </div>
								 
								  </div>
							</form>
					
							
						<div class="clearfix"></div>
						<div class="pull-right">
							<button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>	
							<button type="button" class="btn btn-warning hide" id="btn_save_main_close"><i class="fa fa-check"></i> Save & Close</button>				
							<button type="button" class="btn btn-success" id="btn_save_main"><i class="fa fa-check"></i> Save</button>				
						</div>

						</div>
                 
						</div>
					</div>
				
              
				
					
				
               
                <!-- /.post -->
              </div>
              
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
				<div class='alert alert-info alert-dismissable' id="success-alert">   
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
					<div id="id_text"><b>Form Tutorial</b></div>
				</div>
				<div class="row">
				<div class="col-md-6">
                <div class="box direct-chat direct-chat-warning">            
						<div class="box-header with-border">
							<h3 class="box-title">Tools</h3>
							<button class="btn btn-success btn-xs pull-right add_tools" style="margin-right:5px; margin-top:10px;">Add Tools</button>	
						</div>
						<div class="box-body">
                 
						<div class="direct-chat-messages">
							<ul class="todo-list ui-sortable my_tools">      
               
			   
                
							</ul>
						</div>
                 
						</div>
					</div>
					</div>
					
					<div class="col-md-6">
					<div class="box direct-chat direct-chat-warning">            
						<div class="box-header with-border">
							<h3 class="box-title">Spare Parts</h3>       
							<button class="btn btn-success btn-xs pull-right add_sp" style="margin-right:5px; margin-top:10px;">Add Spare Parts</button>	
						</div>
						<div class="box-body">
                 
						<div class="direct-chat-messages">
							<ul class="todo-list ui-sortable my_sp">
                
               
			   
                
							</ul>
					
					

						</div>
                 
						</div>
						</div>
						</div>
						<div class="clearfix"></div>
						<div class="pull-right">										
							<button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>				
						</div>
					</div>
					
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane <?php echo $dt_tab =='section' ? 'active' : '';?>" id="settings">
				<button class="btn btn-success btn-xs add_section" style="margin-right:5px; margin-bottom:10px">Add Section</button>
				<?php if(!empty($dt_section)){ 
					foreach($dt_section as $ds){
				?>
				<div class="box direct-chat direct-chat-warning">            
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo $ds['section'];?></h3>
						<button class="btn btn-warning btn-xs pull-right add_step" id="<?php echo $ds['id_section'];?>" style="margin-right:5px; margin-top:10px;">Add Step</button>	
						<button class="btn btn-info btn-xs pull-right edit_section" id="<?php echo $ds['id_section'].'Þ'.$ds['section'];?>" style="margin-right:5px; margin-top:10px;">Edit Section</button>	
						<button class="btn btn-danger btn-xs pull-right del_section" id="<?php echo $ds['id_section'].'Þdel';?>" style="margin-right:5px; margin-top:10px;">Delete Section</button>	
					</div>
					<div class="box-body">
						<?php if(!empty($dt_step)){
							$i = 0;
							foreach($dt_step as $dts){
								if($dts['id_section'] == $ds['id_section']){
									$i = 1;
									$i++;
						?>
						<div class="direct-chat-messages">
								<div class="box box-solid box-primary collapsed-box">
			<div class="box-header">
				
				<div class="box-title" style="font-size:15px; font-weight:600"><?php echo $dts['step'];?></div>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm btn_edit_step" id="<?php echo $dts['id_step'].'Þ'.$dts['step'].'Þ'.$dts['ket'];?>" title="Edit"><i class="fa fa-edit"></i></button>
					<button class="btn btn-primary btn-sm btn_del_step" id="<?php echo $dts['id_step'];?>" title="Delete"><i class="fa fa-trash-o"></i></button>
					<button class="btn btn-primary btn-sm btn_coll2" onclick="return load_gbr('<?php echo $dts['id_step'];?>');" data-widget="collapse"><i class="glyphicon glyphicon-chevron-right"></i></button>
				</div>
			</div>
			<div class="box-body" style="display: none;">
				
				
				<div class="row" style="margin-left:15px;">
					<p><?php echo $dts['ket'];?></p>
					<div class="load_gbrku<?php echo $dts['id_step'];?>"></div>
					
					
				</div>
				
				
				
			</div>
			
			</div>
					

						</div>
						<?php }else{
							// if($i == 0) echo 'Not Found';
						}
						}}else{
							echo 'Not Found';
						}?>
						
						
                 
					</div>
				</div>
				<?php } }else{
					echo 'Not found';
				}?>
			
              </div>
			  
			  <div class="tab-pane" id="komentar">
				
                <!-- The timeline -->
				<?php if(!empty($comment)){ 
					foreach($comment as $c){
						$photo = '';
						$view_member = '';
						$view_member = site_url('members/detail/'.$c['id_customer']);
						$photo = !empty($c['photo']) ? base_url('uploads/members/'.$c['photo']) : base_url('uploads/no_photo.jpg');
				?>
				
				<div class="post" style="margin-left:20px; margin-right:20px;" id="<?php echo 'del'.$c['id'];?>">
                  <div class="user-block">
                    <img src="<?php echo $photo;?>" alt="user image">
                        <span class="username">
							<a title="View member detail" href="<?php echo $view_member;?>"><?php echo $c['nama'];?></a>
							<a href="#confirm_del" id="<?php echo $c['id'];?>" style="color:red;" title="Hapus komentar" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                    <span class="description"><?php echo date('d-M-Y H:i', strtotime($c['comment_tgl']));?></span>
                  </div>
                  <!-- /.user-block -->
                  <p><?php echo $c['comment'];?></p>
                 <hr/>
                </div>
				
				<?php  } }else{
					echo '<h3 style="text-align:center;"><strong>Not Found</strong></h3>';
				}					?>
					
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

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
			
          </div>
          <!-- /.nav-tabs-custom -->
    
        <!-- /.col -->
      
      <!-- /.row -->


<script type="text/javascript" src="<?php echo base_url('assets/dropzone/dropzone.min.js') ?>"></script>
<script>
$("#success-alert").hide();
var img = '<?php echo !empty($tutorial->img) ? base_url('uploads/tutorials/'.$tutorial->img) : base_url('uploads/no_photo.jpg');?>';
$('.back').click(function(){
	history.back();
});
var id_tutorial = '<?php echo (int)$id_tutorial > 0 ? (int)$id_tutorial : 0;?>';
var id_kategori = '<?php echo (int)$device_cat > 0 ? (int)$device_cat : 0;?>';
var device_type = '<?php echo (int)$device_type > 0 ? (int)$device_type : 0;?>';
if(id_kategori > 0) get_type(id_kategori, device_type);
load_tools(id_tutorial);
load_sp(id_tutorial); 
function del_img(id_step_img){	
	$('#del_id_step_img').val(id_step_img);
	$('#confirm_del_step_gbr').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del_step_gbr").modal('show');
}
$('.yes_del_step_gbr').click(function(){
	var id = $('#del_id_step_img').val();	
	var url = '<?php echo site_url('tutorial/del_img_section');?>';
	$.ajax({
		data : {id_step_img : id},
		url : url,
		type : "POST",
		success:function(response){
			load_gbr(response);	
			$('#confirm_del_step_gbr').modal('hide');
			
		}
	});
	
})
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
Dropzone.autoDiscover = false;

	var foto_upload= new Dropzone(".dropzone",{
		url: "<?php echo site_url('tutorial/proses_upload');?>",
		maxFilesize: 2,
		method:"post",
		acceptedFiles:"image/*",
		paramName:"userfile_step",
		dictInvalidFileType:"Type file ini tidak dizinkan",
		addRemoveLinks:true,
		params: {
			id_tutorial:id_tutorial
		}
	});


	//Event ketika Memulai mengupload
	foto_upload.on("sending",function(a,b,c){
		a.token=Math.random();
		c.append("id_step",$('#id_step_gbr').val());
		c.append("token_foto",a.token); //Menmpersiapkan token untuk masing masing foto
	});
	foto_upload.on("complete",function(a,b,c){
		var id_step = $('#id_step_gbr').val();
		load_gbr(id_step);
	});

	//Event ketika foto dihapus
	foto_upload.on("removedfile",function(a){
		var token=a.token;
		$.ajax({
			type:"post",
			data:{token:token},
			url:"<?php echo site_url('tutorial/remove_foto') ?>",
			cache:false,
			dataType: 'json',
			success: function(res){
				console.log(res);
				load_gbr(res);
			},
			error: function(){
				console.log("Error");

			}
		});
	});	
function add_gbrr(id){
	$('#frm_gbr').find("input[type=text], select, input[type=hidden], input[type=file]").val("");
	$('#id_step_gbr').val(id);
	$('#add_gbr').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#add_gbr').modal('show');
}
$('.btn_save_tools').click(function(){
	$('.list_tools_error').text('');
	var dt_tools = $('#list_tools').val();
	if(dt_tools == null || dt_tools == ''){
		$('.list_tools_error').text('Silahkan pilih tools');
		return false;
	}
	var url = '<?php echo site_url('tutorial/simpan_tools');?>';
	$.ajax({
		data:{dt_tools:dt_tools,id_tutorial:id_tutorial},
		type:'POST',
		url : url,
		success:function(response){
			$('#frm_dialog_tools').modal('hide');
			// $("#id_text").html('<b>Success,</b> Data tools sudah ditambahkan');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				
			// });			
			load_tools(id_tutorial);			
		}
	});	
});
$('.btn_save_sp').click(function(){
	$('.list_sp_error').text('');
	var dt_tools = $('#list_sp').val();
	
	if(dt_tools == null || dt_tools == ''){
		$('.list_sp_error').text('Silahkan pilih spare parts');
		return false;
	}
	var url = '<?php echo site_url('tutorial/simpan_sp');?>';
	$.ajax({
		data:{dt_tools:dt_tools,id_tutorial:id_tutorial},
		type:'POST',
		url : url,
		success:function(response){
			$('#frm_dialog_sp').modal('hide');
			// $("#id_text").html('<b>Success,</b> Data tools sudah ditambahkan');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				
			// });			
			load_sp(id_tutorial);			
		}
	});	
});
$('.add_sp').click(function(){
	$('.list_sp_error').text('');
	$('#frm_sp').find("input[type=text], select").val("");
	var url = '<?php echo site_url('tutorial/get_spare_parts');?>';
	$('#list_tools').html('');
	$.ajax({
		data:{id_tutorial:id_tutorial},
		type:'POST',
		url : url,
		success:function(response){				
			if(response.length > 0){					
				$('#list_sp').html(response);
				$("#list_sp").select2({});
			}				
		}
	});		
	$('#frm_dialog_sp').modal({
		backdrop: 'static',
		keyboard: false
	});	
	$('#frm_dialog_sp').modal('show');
});
$('.add_tools').click(function(){
	$('.list_tools_error').text('');
	$('#frm_tools').find("input[type=text], select").val("");
	var url = '<?php echo site_url('tutorial/get_tools');?>';
	$('#list_tools').html('');
	$.ajax({
		data:{id_tutorial:id_tutorial},
		type:'POST',
		url : url,
		success:function(response){				
			if(response.length > 0){					
				$('#list_tools').html(response);
				$("#list_tools").select2({});
			}				
		}
	});		
	$('#frm_dialog_tools').modal({
		backdrop: 'static',
		keyboard: false
	});	
	$('#frm_dialog_tools').modal('show');
});
$('.del_section').click(function(){
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#del_id_section').val(dt[0]);
	$('#confirm_delete_section').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_delete_section").modal('show');
});
$('.btn_del_step').click(function(){
	var val = $(this).get(0).id;
	$('#del_id_step').val(val);
	$('#confirm_delete_step').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_delete_step").modal('show');
});
$('.yes_del_step').click(function(){
	var id = $('#del_id_step').val();	
	var url = '<?php echo site_url('tutorial/del_step');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_delete_step').modal('hide');
			// $("#id_text").html('<b>Success,</b> Data tools sudah dihapus');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				
			// });			
			var urli = '<?php echo site_url('tutorial/add_section');?>/'+id_tutorial;
			window.location.href = urli;			
		}
	});
	
});
$('.yes_del_section').click(function(){
	var id = $('#del_id_section').val();	
	var url = '<?php echo site_url('tutorial/del_section');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_delete_section').modal('hide');
			// $("#id_text").html('<b>Success,</b> Data tools sudah dihapus');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				
			// });			
			var urli = '<?php echo site_url('tutorial/add_section');?>/'+id_tutorial;
			window.location.href = urli;			
		}
	});
	
});
function delete_tools(id_category){	
	$('#del_id_tools').val(id_category);
	$('#confirm_delete_tools').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_delete_tools").modal('show');
}
function delete_sp(id_category){	
	$('#del_id_sp').val(id_category);
	$('#confirm_delete_sp').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_delete_sp").modal('show');
}
$('.yes_del_tools').click(function(){
	var id = $('#del_id_tools').val();	
	var url = '<?php echo site_url('tutorial/del_tools');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_delete_tools').modal('hide');
			// $("#id_text").html('<b>Success,</b> Data tools sudah dihapus');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				
			// });			
			load_tools(id_tutorial);			
		}
	});
});
$('.yes_del_sp').click(function(){
	var id = $('#del_id_sp').val();	
	var url = '<?php echo site_url('tutorial/del_sp');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_delete_sp').modal('hide');
			// $("#id_text").html('<b>Success,</b> Data tools sudah dihapus');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				
			// });			
			load_sp(id_tutorial);			
		}
	});
	
});
$('.edit_section').click(function(){	
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_section').val(dt[0]);	
	$('#section').val(dt[1]);	
	$('#frm_dialog_section').modal({
		backdrop: 'static',
		keyboard: false
	});
	
	$('#frm_dialog_section').modal('show');
});
$('.add_section').click(function(){	
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_section').val('');	
	$('#section').val('');	
	$('#frm_dialog_section').modal({
		backdrop: 'static',
		keyboard: false
	});
	
	$('#frm_dialog_section').modal('show');
});
$('.btn_save_section').click(function(){
	var id_section = $('#id_section').val();	
	var section = $('#section').val();
	$('.section_error').text('');
	if(section == ''){
		$('.section_error').text('Section harus diisi');
		return false;
	}
	var url = '<?php echo site_url('tutorial/simpan_section');?>';
	$.ajax({
		data:{section:section,id_tutorial:id_tutorial,id_section:id_section},
		type:'POST',
		url : url,
		success:function(response){
			$('#frm_dialog_section').modal('hide');
			// $("#id_text").html('<b>Success,</b> Data tools sudah ditambahkan');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				
			// });			
			var urli = '<?php echo site_url('tutorial/add_section');?>/'+id_tutorial;
			window.location.href = urli;
		}
	});	
});
$('.btn_edit_step').click(function(){
	$('#frm_step').find("input[type=text], select").val("");
	$('.step_error').text('');
	$('.deskripsi_step_error').text('');
	$('#step').val('');
	$('#deskripsi_step').val('');
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_step').val(dt[0]);
	$('#step').val(dt[1]);
	$('#deskripsi_step').val(dt[2]);
	$('#frm_dialog_step').modal({
		backdrop: 'static',
		keyboard: false
	});
	
	$('#frm_dialog_step').modal('show');
});
$('.add_step').click(function(){
	$('#frm_step').find("input[type=text], select").val("");
	$('.step_error').text('');
	$('.deskripsi_step_error').text('');
	$('#id_section_step').val('');
	$('#id_step').val('');
	$('#step').val('');
	$('#deskripsi_step').val('');
	var val = $(this).get(0).id;
	// var dt = val.split('Þ');
	$('#id_section_step').val(val);	
	$('#frm_dialog_step').modal({
		backdrop: 'static',
		keyboard: false
	});
	
	$('#frm_dialog_step').modal('show');
});
$('.yes_save_step').click(function(){
	$('.step_error').text('');
	$('.deskripsi_step_error').text('');
	var step = $('#step').val();
	var deskripsi_step = $('#deskripsi_step').val();
	if(step == ''){
		$('.step_error').text('required');
		return false;
	}
	if(deskripsi_step == ''){
		$('.deskripsi_step_error').text('required');
		return false;
	}
	var dt = $('#frm_step').serialize()+ '&id_tutorial=' + id_tutorial;
	var url = '<?php echo site_url('tutorial/save_step');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){				
			if(response > 0){
				var urli = '<?php echo site_url('tutorial/add_section');?>/'+id_tutorial;
				window.location.href = urli;
			}
		}
	})	
});
function save_main(){
	
}
$('#btn_save_main').click(function(){
	var judul = $('#judul').val();
	var difficulty = $('#difficulty').val();
	var time_required = $('#time_required').val();
	var video_o = $('#video_o').val();
	var device_cat = $('#device_cat').val();
	var device_type = $('#device_type').val();
	var deskripsi = $('#deskripsi').val();
	var introduction = $('#introduction').val();
	$('.judul_error').text('');
	$('.difficulty_error').text('');
	$('.time_required_error').text('');
	$('.video_o_error').text('');
	$('.device_cat_error').text('');
	$('.device_type_error').text('');
	$('.deskripsi_error').text('');
	$('.introduction_error').text('');
	if(judul == ''){
		$('.judul_error').text('Judul harus diisi');
		return false;
	}
	if(difficulty == ''){
		$('.difficulty_error').text('Difficulty harus diisi');
		return false;
	}
	if(time_required == ''){
		$('.time_required_error').text('Time required harus diisi');
		return false;
	}
	if(video_o == ''){
		$('.video_o_error').text('Video overview harus diisi');
		return false;
	}
	if(device_cat == ''){
		$('.device_cat_error').text('Device category harus diisi');
		return false;
	}
	if(device_type == ''){
		$('.device_type_error').text('Device type harus diisi');
		return false;
	}
	
	if(deskripsi == ''){
		$('.deskripsi_error').text('Deskripsi harus diisi');
		return false;
	}
	if(introduction == ''){
		$('.introduction_error').text('Introduction harus diisi');
		return false;
	}
	$('#reload').val(1);
	var url = '<?php echo site_url('tutorial/save_tutor');?>';
	$('#frm_tutor_main').attr('action', url);
	$('#frm_tutor_main').submit();
	
});
$('#btn_save_main_close').click(function(){
	save_main();
	$('#reload').val(0);
	var url = '<?php echo site_url('tutorial/save_tutor');?>';
	$('#frm_tutor_main').attr('action', url);
	$('#frm_tutor_main').submit();
	
});
function load_tools(){
	if(id_tutorial > 0){
		var url = '<?php echo site_url('tutorial/get_mytools');?>';
		$('#my_tools').html('');
		$.ajax({
			data:{'id_tutorial' : id_tutorial},
			type:'POST',
			url : url,
			success:function(response){				
				$('.my_tools').html(response);
			}
		})	
	}
}
function load_sp(){
	if(id_tutorial > 0){
		var url = '<?php echo site_url('tutorial/get_sp');?>';
		$('.my_sp').html('');
		$.ajax({
			data:{'id_tutorial' : id_tutorial},
			type:'POST',
			url : url,
			success:function(response){				
				$('.my_sp').html(response);
			}
		})	
	}
}


function load_gbr(id_step){
	
	if(id_step > 0){
		var url = '<?php echo site_url('tutorial/get_mygbr');?>';
		$('.load_gbrku1'+id_step).html('');
		$.ajax({
			data:{'id_step' : id_step},
			type:'POST',
			url : url,
			success:function(response){				
				$('.load_gbrku'+id_step).html(response);
			}
		})	
	}
}
$("#userfile").change(function(){
	$('#blah').attr('src', '');
	readURL(this);
});
function readURL(input) {
   if (input.files && input.files[0]) {
        var reader = new FileReader();            
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }            
        reader.readAsDataURL(input.files[0]);
    }
}
if(img != ''){
	$('#blah').attr('src', img);	
}
$('a[href$="#confirm_del"]').on( "click", function() {	
	var val = $(this).get(0).id;	
	$('#del_id_comment').val(val);	
	$('#confirm_delete_comment').modal({
		backdrop: 'static',
		keyboard: false
	});
   $('#confirm_delete_comment').modal('show');
});
$('.yes_del_comment').click(function(){
	var id = $('#del_id_comment').val();	
	var url = '<?php echo site_url('tutorial/del_comment');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#del'+id).hide();
			$('#confirm_delete_comment').modal('hide');					
		}
	});
	
});
</script>   