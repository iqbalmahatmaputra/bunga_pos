<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
	<div class="col-md-4">
		<h2>Produk Detail</h2>
	</div>
	<div class="col-md-8 text-center">
		<div id="message">
			<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
		</div>
	</div>
</div>

<div class="card card-custom gutter-b" >
	<div class="card-body" id="printableArea">
		<div class="d-flex">
			<!--begin: Pic-->
			<div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
				<div class="symbol symbol-50 symbol-lg-120">
                
					<img alt="Pic" src="<?php echo base_url();?>assets/img/queen_logo.jpg" >
                  </div>

				<div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
					<span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
				</div>
			</div>
			<!--end: Pic-->

			<!--begin: Info-->
			<div class="flex-grow-1">
				<!--begin: Title-->
				<div class="d-flex align-items-center justify-content-between flex-wrap">
					<div class="mr-3">
						<!--begin::Name-->
						<a href="#"
							class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">
							QG-<?php echo $no_faktur."-".$id_penjualan ?> <i
								class="flaticon2-correct text-success icon-md ml-2"></i>
						</a>
						<!--end::Name-->


					</div>

				</div>
				<!--end: Title-->

				<!--begin: Content-->
				<div class="d-flex align-items-center flex-wrap justify-content-between">
					<div class="flex-grow-1 font-weight-bold text-dark-50 py-5 py-lg-2 mr-5">
						<div class="row">
							<div class="col-4">
								Kepada</div>
							<div class="col-8">
								: <?php echo $tujuan; ?></div>
						</div>
                        <div class="row">
							<div class="col-4">
								Alamat</div>
							<div class="col-8">
								: <?php echo $alamat; ?></div>
						</div>
                        <div class="row">
							<div class="col-4">
								No Handphone</div>
							<div class="col-8">
								: <?php echo $no_hp; ?></div>
						</div>
                       
					</div>


				</div>
				<!--end: Content-->
			</div>
			<!--end: Info-->
		</div>





	</div>
	<!--begin: Items-->
</div>
</div>

<?php $this->load->view('templates/footer');?>

