<?php $this->load->view('templates/header');?>

<div class="card-body">
<form action="<?= base_url('report/cek'); ?>" method="GET">
		<div class="row">
			<div class="col-md-3">
				<input type="text" class="form-control" placeholder="Kode Produk atau No Faktur"
					id="kt_datatable_search_query" name="kode" autofocus/>
			</div>
			<div class="col-md-3">
				<input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
					placeholder="Tanggal Mulai " />

			</div>
			<div class="col-md-3">
				<input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
					placeholder="Tanggal Selesai" />
			</div>
			<div class="col-md-3">
				<input type="submit" class="btn btn-light-primary px-6 font-weight-bold" name="search" value="Search">
				<input type="submit" class="btn btn-light-info px-6 font-weight-bold" name="cetak" value="Cetak">
			</div>
			
		</div>
	</form>
	<div class="mb-7">
		<div class="row align-items-center ">
			<div class="col-lg-8 col-xl-5">
				<div class="row align-items-center">

					<div class="d-flex align-items-center mr-10 ml-5">
						<div class="mr-6">
							<div class="font-weight-bold mb-2">Start Date</div>
							<?php if($tanggal_mulai){
									?>

							<span
								class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold"><?= $tanggal_mulai; ?></span>

							<?php
								}else{ ?>
							<span class="btn btn-sm btn-text btn-light-warning text-uppercase font-weight-bold">Inputkan
								dulu</span>
							<?php } ?>
						</div>
						<div class="">
							<div class="font-weight-bold mb-2">End Date</div>
							<?php if($tanggal_selesai){
									?>

							<span
								class="btn btn-sm btn-text btn-light-danger text-uppercase font-weight-bold"><?= $tanggal_selesai; ?></span>

							<?php
								}else{ ?>
							<span class="btn btn-sm btn-text btn-light-warning text-uppercase font-weight-bold">Inputkan
								dulu</span>
							<?php } ?>
						</div>
					</div>




				</div>
			</div>
			
		</div>
	</div>
	<!--end::Search Form-->
	<!--end: Search Form-->
	<!--begin: Datatable-->
	<!-- mulai atas -->
	<div class="row">
		<div class="card card-custom gutter-b">
			<div class="card-body">
				<div class="d-flex">
					<!--begin: Pic-->
					<div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
						<div class="symbol symbol-50 symbol-lg-120">
							<!-- <img alt="Pic" src="assets/media/project-logos/3.png"> -->
						</div>

						<div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
							<span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
						</div>
					</div>
					<!--end: Pic-->


					<div class="row">
						<div class="card  card-custom gutter-b">
							<div class="card-body">
								<table class="table table-bordered table-hover table-checkable" id="kt_datatable"
									style="margin-top: 13px !important">
									<thead>
										<tr>
											<th>Kode Produk</th>
											<th>Nama</th>
											<th>Tanggal Penjualan</th>
											<th>No Faktur</th>
											<th>Total Barang</th>
											<th>Total Harga</th>
											

										</tr>
									</thead>

									<tbody>
										<?php 
						$total_barang=0;
						$total_harga=0;
		foreach($cek as $u){ 
			
			$total_barang += $u->qty;
			$total_harga += ($u->total_harga* $u->qty);
		?>
										<tr>
											<td>
                                            <?php 
                                            $id_produk = $u->id_produk
                                            ?>
                                            <a href="<?php echo site_url('produk_stok/read/'.$id_produk); ?>"
													class="text-success pulse pulse-primary mr-5">
													<?php echo $u->kode_produk ?>
												</a>
                                            </td>
											<td><?php echo $u->nama_produk ?></td>
											<td><?php echo $u->tanggal_penjualan ?></td>
											<td>
                                          
                                            <a href="<?php echo site_url('penjualan/readFaktur/'.$u->no_faktur); ?>"
													class="text-success pulse pulse-primary mr-5">
													<?php echo $u->no_faktur ?>
												</a>
                                            </td>
											<td><?php echo $u->qty ?></td>
											<td style="text-align: right;"><?php echo number_format($u->total_harga* $u->qty, 0, ".", ".")  ?></td>
											
										</tr>
			<?php }?>
				<?php
				foreach($retur as $u){ 
			
					$total_barang += - $u->qty;
					$total_harga +=  - ($u->total_harga* $u->qty);
				?>
												<tr>
													<td>
													<?php 
													$id_produk = $u->id_produk
													?>
												
												<?php echo $u->kode_produk ?> 
													
													</td>
													<td><?php echo $u->nama_produk ?></td>
													<td><?php echo $u->tanggal_penjualan ?></td>
													<td>
													<p class="text-danger pulse pulse-primary">
															<?php echo $u->no_faktur ?>
														</p>
													</td>
													<td>
													<p class="text-danger pulse pulse-primary"><?php echo -$u->qty ?></p>
													</td>
													<td style="text-align: right;" ><p class="text-danger pulse pulse-primary"><?php echo number_format(-$u->total_harga* $u->qty, 0, ".", ".")  ?>
													</p>
													</td>
													
												</tr>
					<?php }?>
					

									</tbody>
									<tfoot>
										<tr>
											<th colspan="4">Total</th>
											<th><?=  number_format($total_barang , 0, ".", ".")?></th>
											<th style="text-align: right;"><?=  number_format($total_harga, 0, ".", ".") ?></th>
										

										</tr>
									</tfoot>
								</table>
							</div>
						</div>

						<!--end: Datatable-->
					</div>

				</div>
				<?php $this->load->view('templates/footer');?>

				<script type="text/javascript">
					var KTDatatablesDataSourceHtml = function () {

						var initTable1 = function () {
							var table = $('#kt_datatable');

							// begin first table
							table.DataTable({
								responsive: true,
								layout: {
									scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
									footer: false // display/hide footer
								},

								// column sorting
								sortable: true,

								pagination: true,

								search: {
									input: $('#kt_datatable_search_query'),
									key: 'generalSearch'
								},

							});

						};

						return {

							//main function to initiate the module
							init: function () {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function () {
						KTDatatablesDataSourceHtml.init();
					});

				</script>
