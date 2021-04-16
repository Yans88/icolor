
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Point</h3>
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
				<div class="row">
				<div class="col-md-4">
				
				
					<?php 
					echo form_open('');
					//nama sekolah
					$data = array(
		              'name'        => 'first_login',
		              'id'			=> 'first_login',
		              'class'		=> 'form-control',
		              'placeholder'	=> 'Buat akun & 1st login',
		              'value'       => $first_login,		   
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Buat akun & 1st login', 'first_login');
					echo form_input($data);
					echo '<br>';
					
					//nama ketua
					$data = array(
		              'name'        => 'complete_profile',
		              'id'			=> 'complete_profile',
		              'class'		=> 'form-control',
					  'placeholder'	=> 'Lengkapi data profile',
		              'value'       => $complete_profile,		           
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Lengkapi data profile', 'complete_profile');
					echo form_input($data);
					echo '<br>';
					
					
					
					//hp ketua
					$data = array(
		              'name'        => 'complete_address',
		              'id'			=> 'complete_address',
		              'class'		=> 'form-control',
					  'placeholder'	=> 'Lengkapi alamat Pengiriman order',
		              'value'       => $complete_address,		              
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Lengkapi alamat Pengiriman order', 'complete_address');
					echo form_input($data);
					
					
					echo '</div>';
					echo '<div class="col-md-4">';
					$data = array(
		              'name'        => 'first_simulasi_hrg',
		              'id'			=> 'first_simulasi_hrg',
		              'class'		=> 'form-control',
					  'placeholder'	=> 'Cek harga service',
		              'value'       => $first_simulasi_hrg,		              
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Cek harga service', 'first_simulasi_hrg');
					echo form_input($data);
					echo '<br>';

					$data = array(
		              'name'        => 'order_bs',
		              'id'			=> 'order_bs',
		              'class'		=> 'form-control',
					  'placeholder'	=> 'Book service',
		              'value'       => $order_bs,		              
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Book service', 'order_bs');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'order_part',
		              'id'			=> 'order_part',
		              'class'		=> 'form-control',
					  'placeholder'	=> 'Order part',
		              'value'       => $order_part,		              
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Order part', 'order_part');
					echo form_input($data);
					
					echo '</div>';
					echo '<div class="col-md-4">';
					$data = array(
		              'name'        => 'order_shop',
		              'id'			=> 'order_shop',
		              'class'		=> 'form-control',
					  'placeholder'	=> 'Shop',
		              'value'       => $order_shop,		              
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Shop', 'order_shop');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'first_komen_forum',
		              'id'			=> 'first_komen_forum',
		              'class'		=> 'form-control',
					  'placeholder'	=> '1st komentar di forum',
		              'value'       => $first_komen_forum,		              
		              'style'       => 'width: 100%'
	            	);
					echo form_label('1st komentar di forum', 'first_komen_forum');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'first_komen_tutor',
		              'id'			=> 'first_komen_tutor',
		              'class'		=> 'form-control',
					  'placeholder'	=> '1st komentar di tutorial',
		              'value'       => $first_komen_tutor,		              
		              'style'       => 'width: 100%'
	            	);
					echo form_label('1st komentar di tutorial', 'first_komen_tutor');
					echo form_input($data);
				echo '</div>';
				echo '</div>';
				

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
				
			</div><!-- /.box-body -->
		</div>
	</div>
</div>

<script>

$('.form-control').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
})

</script>