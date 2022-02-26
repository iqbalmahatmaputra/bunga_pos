<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
	<div class="col-md-4">
		<h2>Rekap Data Inventory</h2>
	</div>
	<div class="col-md-4 text-center">
		<div id="message">
			<?php echo $this->session->userdata('message') != '' ? $this->session->userdata('message') : ''; ?>
		</div>
	</div>
	<div class="col-md-4 text-right">
		<div style="margin-top:20px;">
		
		</div>

	</div>
</div>
<div class="card-body">
<form action="<?= base_url('report/cariTanggalJsonInven'); ?>" method="GET">
	<div class="row">
		<div class="col-md-3">
		<input type="text" class="form-control" placeholder="Kode Produk"
								id="kt_datatable_search_query" name="kode" autofocus/>
		</div>
		<div class="col-md-3">
		<input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" placeholder="Tanggal Mulai " />
	
		</div>
		<div class="col-md-3">
		<input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
							placeholder="Tanggal Selesai" />
		</div>
		<div class="col-md-3">
		<input type="submit" class="btn btn-light-primary px-6 font-weight-bold" value="Search">
		</div>
	</div>
	</form>
	<br>
	
	<!--end::Search Form-->
	<!--end: Search Form-->
	<!--begin: Datatable-->
    
	<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
	<!--end: Datatable-->
</div>
<?php $this->load->view('templates/footer');?><script type="text/javascript">
	var KTDatatableJsonRemoteDemo = function () {
		// Private functions

		// basic demo
		var demo = function () {
			var datatable = $('#kt_datatable').KTDatatable({
				// datasource definition
				data: {
					type: 'remote',
					source: BASE_URL + 'report/jsonInven',
					pageSize: 10,
				},

				// layout definition
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

				// columns definition
				columns: [

					{
						field: 'id_produk',
						title: '#',
						sortable: false,
						width: 20,
						type: 'number',
						selector: {
							class: ''
						},
						textAlign: 'center',
					}, {
						field: 'kode_produk',
						title: 'Kode Produk',
					}, {
						field: 'nama_produk',
						title: 'Nama Produk',
					}, 
					// {
					// 	field: 'tanggal_produk_stok',
					// 	title: 'Tanggal Stok',
					// },
					 {
						field: 'stok',
						title: 'Total Stok',
						
					},
					  {
						field: 'status',
						title: 'Status',
					  }
					// }, {
					// 	field: 'total_harga',
					// 	title: 'Total Penjualan',
					// 	template: function(row) {
					// 		return 'Rp. <span style="text-align: right;">'+ new Intl.NumberFormat(['ban', 'id']).format(row.total_harga)+'</span>';
					// 	}
					// }
					// , {
					//     field: 'action',
					//     title: 'Aksi',
					// }
				],

			});
		};

		return {
			// public functions
			init: function () {
				demo();
			}
		};
	}();


	$(document).ready(function () {

		KTDatatableJsonRemoteDemo.init();
		
	});

</script>
<script type="text/javascript">

</script>