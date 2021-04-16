
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Setting</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php if($tersimpan == 'Y') { ?>
					<div class="box-body">
						<div class="alert alert-success alert-dismissable">
		                    <i class="fa fa-check"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data berhasil disimpan.
		                </div>
					</div>
				<?php } ?>

				<?php if($tersimpan == 'N') { ?>
					<div class="box-body">
						<div class="alert alert-danger alert-dismissable">
		                    <i class="fa fa-warning"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data tidak berhasil disimpan, silahkan ulangi beberapa saat lagi.
		                </div>
					</div>
				<?php } 
				
				?>

				<div class="form-group">
					<?php 
					echo form_open('');
					//nama sekolah
					$data = array(
		              'name'        => 'email',
		              'id'			=> 'email',
		              'class'		=> 'form-control',
		              'value'       => $email,		   
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Email', 'email');
					echo form_input($data);
					echo '<br>';
					
					//nama ketua
					$data = array(
		              'name'        => 'pass',
		              'id'			=> 'pass',
		              'class'		=> 'form-control',
		              'value'       => $pass,		           
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Mail Password', 'pass');
					echo form_input($data);
					echo '<br>';
					
					
					
					//hp ketua
					$data = array(
		              'name'        => 'subj_email_register',
		              'id'			=> 'subj_email_register',
		              'class'		=> 'form-control',
		              'value'       => $subj_email_register,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Subject Email for Registration', 'subj_email_register');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'biaya_pickup_device',
		              'id'			=> 'biaya_pickup_device',
		              'class'		=> 'form-control',
		              'value'       => $biaya_pickup_device,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Biaya layanan pickup device', 'biaya_pickup_device');
					echo form_input($data);
					echo '<br>';

					$data = array(
		              'name'        => 'biaya_home_service',
		              'id'			=> 'biaya_home_service',
		              'class'		=> 'form-control',
		              'value'       => $biaya_home_service,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Biaya layanan home service', 'biaya_home_service');
					echo form_input($data);
					echo '<br>';
					
					// alamat
					
					
					$data = array(
		              'name'        => 'content_forgotPin',
		              'id'			=> 'content_forgotPin',
		              'class'		=> 'form-control',
		              'value'       => $content_forgotPin,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Content forgot Password', 'content_forgotPin');
					echo form_textarea($data);
					echo '<br>';

					
					
					$data = array(
		              'name'        => 'content_verifyReg',
		              'id'			=> 'content_verifyReg',
		              'class'		=> 'form-control',
		              'value'       => $content_verifyReg,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Content Email for Verify Registration', 'content_verifyReg');
					echo form_textarea($data);
					echo '<br>';					
					
					$data = array(
		              'name'        => 'term_condition',
		              'id'			=> 'term_condition',
		              'class'		=> 'form-control',
		              'value'       => $term_condition,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Term & Condition', 'term_condition');
					echo form_textarea($data);
					echo '<br/>';	

					$data = array(
		              'name'        => 'about_us',
		              'id'			=> 'about_us',
		              'class'		=> 'form-control',
		              'value'       => $about_us,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('About us', 'about_us');
					echo form_textarea($data);
					echo '<br/>';			
					
					$data = array(
		              'name'        => 'policy',
		              'id'			=> 'policy',
		              'class'		=> 'form-control',
		              'value'       => $policy,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Policy', 'policy');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'tc_home_s',
		              'id'			=> 'tc_home_s',
		              'class'		=> 'form-control',
		              'value'       => $tc_home_s,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Term Condition Home Service', 'tc_home_s');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'tc_pickup_d',
		              'id'			=> 'tc_pickup_d',
		              'class'		=> 'form-control',
		              'value'       => $tc_pickup_d,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Term Condition Pickup Device', 'tc_pickup_d');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'tc_kirim_d',
		              'id'			=> 'tc_kirim_d',
		              'class'		=> 'form-control',
		              'value'       => $tc_kirim_d,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Term Condition Kirim Device', 'tc_kirim_d');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'tc_instore',
		              'id'			=> 'tc_instore',
		              'class'		=> 'form-control',
		              'value'       => $tc_instore,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Term Condition Instore', 'tc_instore');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'email_icolorshop',
		              'id'			=> 'email_icolorshop',
		              'class'		=> 'form-control',
		              'value'       => $email_icolorshop,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Email order iColor shop', 'email_icolorshop');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'email_bs',
		              'id'			=> 'email_bs',
		              'class'		=> 'form-control',
		              'value'       => $email_bs,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Email booking service', 'email_bs');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'email_redeempoint',
		              'id'			=> 'email_redeempoint',
		              'class'		=> 'form-control',
		              'value'       => $email_redeempoint,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Email redeem point', 'email_redeempoint');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'email_orderpart',
		              'id'			=> 'email_orderpart',
		              'class'		=> 'form-control',
		              'value'       => $email_orderpart,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Email order part', 'email_orderpart');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'kirim_email',
		              'id'			=> 'kirim_email',
		              'class'		=> 'form-control',
		              'value'       => $kirim_email,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Kirim Email', 'kirim_email');
					echo form_textarea($data);
					// echo '<br/>';
					
					// $data = array(
		              // 'name'        => 'about_us',
		              // 'id'			=> 'about_us',
		              // 'class'		=> 'form-control',
		              // 'value'       => $about_us,		              
		              // 'style'       => 'width: 97%;'
	            	// );
					// echo form_label('About us', 'about_us');
					// echo form_textarea($data);
					// echo '<br/>';
					
					// $data = array(
		              // 'name'        => 'contact_us',
		              // 'id'			=> 'contact_us',
		              // 'class'		=> 'form-control',
		              // 'value'       => $contact_us,		              
		              // 'style'       => 'width: 97%'
	            	// );
					// echo form_label('Contact us', 'contact_us');
					// echo form_textarea($data);
					// echo '<br/>';

					// submit
					$data = array(
				    'name' 		=> 'submit',
				    'id' 		=> 'submit',
				    'class' 	=> 'btn btn-primary',
				    'value'		=> 'true',
				    'type'	 	=> 'submit',
				    'content' 	=> 'Update'
					);
					echo '<br>';
					echo form_button($data);


					echo form_close();

					?>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script>
$("input").attr("autocomplete", "off"); 
 $(function (config) {
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('content_verifyReg');
	
	CKEDITOR.replace('content_forgotPin');
  	CKEDITOR.replace('term_condition');
  	CKEDITOR.replace('about_us');
	CKEDITOR.replace('policy');
	CKEDITOR.replace('tc_home_s');
	CKEDITOR.replace('tc_pickup_d');
	CKEDITOR.replace('tc_kirim_d');
	CKEDITOR.replace('tc_instore');
	CKEDITOR.replace('email_icolorshop');
	CKEDITOR.replace('email_bs');
	CKEDITOR.replace('email_redeempoint');
	CKEDITOR.replace('email_orderpart');
	CKEDITOR.replace('kirim_email');
	// CKEDITOR.replace('about_us');
	
});
$('#biaya_home_service').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
})
$('#biaya_pickup_device').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
})
</script>