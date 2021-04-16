<style type="text/css">
media (min-width: 768px)
.col-sm-offset-2 {
    margin-left: 16.66666667%;
}
.select2 {
width:100%!important;
border-radius: 0px !important;
}

</style>
<?php 

$id_news = !empty($news) ? (int)$news->id_news : 0;
$title = !empty($news) ? $news->title : '';
$descr_title = !empty($news) ? $news->deskripsi_title : '';
$sub_title = !empty($news) ? $news->subtitle : '';
$descr_subtitle = !empty($news) ? $news->deskripsi_sub : '';
$img = !empty($news->img) ? base_url('uploads/news/'.$news->img) : '';
$thumbnail = !empty($news->thumbnail) ? base_url('uploads/news/'.$news->thumbnail) : '';

?>
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
<br/>
<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form News</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form" id="frm_qa" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
              <div class="box-body">
			  <div class="row">
			  <div class="col-sm-12">
				<div class="form-group">
                  <label for="exampleInputPassword1">Title</label><span class="label label-danger pull-right title_error"></span>
				  <input type="text" class="form-control" name="title" id="title" value="<?php echo $title;?>" placeholder="Title" autocomplete="off" />
                  
                  <input type="hidden" class="form-control" name="id_news" id="id_news" value="<?php echo $id_news;?>" />
                </div>
			 
				<div class="form-group">
                  <label for="exampleInputPassword1">Description Title</label><span class="label label-danger pull-right descr_title_error"></span>
                  <textarea class="form-control" name="descr_title" id="descr_title" placeholder="Description" rows=5><?php echo $descr_title;?></textarea>
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Sub Title</label><span class="label label-danger pull-right sub_title_error"></span>
				  <input type="text" class="form-control" name="sub_title" id="sub_title" value="<?php echo $sub_title;?>" placeholder="Sub Title" autocomplete="off" />
                </div>
				<div class="form-group">
                  <label for="exampleInputPassword1">Description Sub Title</label><span class="label label-danger pull-right descr_subtitle_error"></span>
                  <textarea class="form-control" name="descr_subtitle" id="descr_subtitle" placeholder="Description" rows=5><?php echo $descr_subtitle;?></textarea>
                </div>
				
			  </div>
				<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
					<div class="fileupload-new thumbnail" style="width: 200px; height: 160px; margin-bottom:5px;">
						<img id="blah" style="width: 190px; height: 150px;" src="" alt="">
				
					</div>
					<div class="form-group">
						<label>Image</label><span class="label label-danger pull-right"></span>
						<input type="file" class="form-control custom-file-input" name="userfile" id="userfile" accept="image/*" />
                 
					</div>
				</div>
				
				</div>
				<div class="col-sm-4 col-sm-offset-2">
					<div class="form-group">
					<div class="fileupload-new thumbnail" style="width: 200px; height: 160px; margin-bottom:5px;">
						<img id="blah_tumbnail" style="width: 190px; height: 150px;" src="" alt="">
				
					</div>
					<div class="form-group">
						<label>Thumbnail</label><span class="label label-danger pull-right"></span>
						<input type="file" class="form-control custom-file-input" name="my_thumbnail" id="my_thumbnail" accept="image/*" />
                 
					</div>
				</div>
				
				</div>
				</div>
              </div>
              </div>
              <!-- /.box-body -->

             <div class="box-footer">
               
                <button type="button" class="btn btn-danger btn_canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
                <button type="button" class="btn btn-success btn_save"><i class="fa fa-check"></i> Save</button>
              </div>
            </form>
          </div>


	
<script type="text/javascript">
var img = '<?php echo !empty($img) ? $img : base_url('uploads/no_photo.jpg');?>';
var thumbnail = '<?php echo !empty($thumbnail) ? $thumbnail : base_url('uploads/no_photo.jpg');?>';
console.log(thumbnail);
$('#blah').attr('src', img);
$('#blah_tumbnail').attr('src', thumbnail);
$('.btn_save').click(function(){	
	$('.title_error').text('');
	$('.descr_title_error').text('');
	$('.sub_title_error').text('');
	$('.descr_subtitle_error').text('');
	var title = $('#title').val();
	var descr_title = $('#descr_title').val();
	var sub_title = $('#sub_title').val();
	var descr_subtitle = $('#descr_subtitle').val();
	if(title == ''){
		$('.title_error').text('required');
		return false;
	}
	if(descr_title == ''){
		$('.descr_title_error').text('required');
		return false;
	}
	
	
	var url = '<?php echo site_url('berita/simpan');?>';
	$('#frm_qa').attr('action', url);
	$('#frm_qa').submit();	
});

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
$("#my_thumbnail").change(function(){
	$('#blah_tumbnail').attr('src', '');
	readURL2(this);
});
function readURL2(input) {
   if (input.files && input.files[0]) {
        var reader = new FileReader();            
        reader.onload = function (e) {
            $('#blah_tumbnail').attr('src', e.target.result);
        }            
        reader.readAsDataURL(input.files[0]);
    }
}
$('.btn_canc').click(function(){
	window.location = '<?php echo site_url('berita');?>';
});
$('.btn_ok').click(function(){
	window.location = '<?php echo site_url('berita');?>';
});

</script>
