<?php $this->load->view('templates/header');?>
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css"> -->
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>  -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">


<div class="card card-custom overflow-hidden">
	<div class="card-body p-0">


		<!-- begin: Invoice-->
		<!-- begin: Invoice header-->
		<div class="row justify-content-center py-8 px-8 py-md-10">
			<div class="col-md-12">

				<div class="row container">
					
				<input type="hidden" name="no_faktur" value="<?php echo $penjualan->no_faktur; ?>">
						<input type="hidden" name="id_penjualan" value="<?php echo $penjualan->id_penjualan; ?>">
						<table class="table table-borderless">
							<!-- <thead>
								<th>
									Kode Produk
								</th>
								<th>Stok</th>
								<th>Jumlah</th>
								<th>Harga</th>
								<th>Total Harga</th>
								<th>Aksi</th>
							</thead> -->
							<tr>
								<td>

									<div class="form-group">
										<label for="varchar">Kode Produk </label>
										<input type="text" name="kode_produk" id="kode_produk" class="form-control input-sm"
											autofocus>
									</div>
								</td>
							
							<td colspan="5">

								<div id="detail_barang"></div>
							</td>
							</tr>
				


				</table>
				
			</div>
		</div>
	</div>
	<div class="row justify-content-center py-8 px-8 py-md-10">
		<div class="col-md-12">


			<form action="<?php echo base_url('produk_penjualan/selesai') ?>" method="POST">
				<input type="hidden" name="no_faktur" value="<?php echo $penjualan->no_faktur; ?>">
				<input type="hidden" name="id_penjualan" value="<?php echo $penjualan->id_penjualan; ?>">
				
				<div class="border-bottom w-100"></div>
				<div class="d-flex justify-content-between pt-6">
					<div class="d-flex flex-column flex-root">
						<span class="font-weight-bolder mb-2">Tanggal Invoice</span>
						<span class="opacity-70"><?php echo date("d-m-Y"); ?></span>
					</div>
					<div class=" d-flex flex-column flex-root">
						<span class="font-weight-bolder mb-2">No Invoice</span>
						<span
							class="opacity-70">QG-<?php echo $penjualan->no_faktur."-".$penjualan->id_penjualan ?></span>
					</div>
					<div class=" d-flex flex-column flex-root">
						<span class="font-weight-bolder mb-2 mr-3">Kepada</span>
						<span class="opacity-70">
							<input type="text" class="form-control" name="tujuan" id="tujuan" placeholder="Tujuan"
								required />
					</div>
					<div class="d-flex flex-column flex-root">
						<span class="font-weight-bolder mb-2">Pencatat Invoice</span>
						<span class="opacity-70">
							<select class="form-control selectpicker" data-size="7" data-live-search="true"
								name="id_user" id="id_user" required>
								<option value="">Pilih Petugas</option>
								<?php
$produks = $this->db->get("user")->result();
foreach ($produks as $key => $value) {
    ?>
								<option value="<?php echo $value->id_user; ?>
"><?php echo $value->nama_user; ?></option>
								<?php
}
?>
							</select>
						</span>
					</div>
				</div>
		</div>
	</div>
	<!-- end: Invoice header-->


	<!-- begin: Invoice body-->
	<div class=" row justify-content-center py-8 px-8 py-md-10 ">

	<table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="80px">No</th>
		    <th>ID Produk</th>
		    <th>Jumlah</th>
		    <th>Total Harga</th>
		    <th width="200px">Action</th>
                </tr>
            </thead>

        </table>

	</div>
	<!-- end: Invoice body-->





	<!-- begin: Invoice footer-->
	<div class="row bg-gray">
		<div class="col-md-6"></div>
		<div class="col-md-6">
			<h4>Total Penjualan : Rp. <a id="total_akhir"></a></h4>
		</div>
	</div>

	<!-- end: Invoice footer-->

	<!-- begin: Invoice action-->
	<div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
		<div class="col-md-9">
			<div class="d-flex justify-content-between">
				<a href="<?php echo base_url('penjualan/delete/'.$penjualan->id_penjualan); ?>" type="button"
					class="btn btn-light-danger font-weight-bold">Hapus
					Invoice</a>
				<button type="submit" class="btn btn-primary font-weight-bold">Print
					Invoice</button>
			</div>
		</div>
	</div>
	<!-- end: Invoice action-->
	</form> <!-- end: Invoice-->
</div>


</div>

<?php $this->load->view('templates/footer');?>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">
	var i = 0;
	var sum = 0;
	$(document).ready(function () {
		$("#kode_produk").autocomplete({
			autoFill: true,
			source: "<?php echo site_url('produk/get_autocomplete/?');?>"
		});

		$("#kode_produk").focus();
		$("#kode_produk").on('blur keyup change click', function () {
			var kode_produk = {
				kode_produk: $(this).val()
			};
			var id_penjualan = <?= $penjualan->id_penjualan;?>;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('produk/get_barang/'. $penjualan->jenis.'/'. $penjualan->id_penjualan);?>",
				data: kode_produk,
				success: function (msg) {
					$('#detail_barang').html(msg);

				}
			});
		});

		$("#kode_produk").keypress(function (e) {
			if (e.which == 13) {
				$("#jumlah").focus();
			}
		});
		
	
		$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
                {
                    return {
                        "iStart": oSettings._iDisplayStart,
                        "iEnd": oSettings.fnDisplayEnd(),
                        "iLength": oSettings._iDisplayLength,
                        "iTotal": oSettings.fnRecordsTotal(),
                        "iFilteredTotal": oSettings.fnRecordsDisplay(),
                        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                    };
                };

                var table = $("#mytable").dataTable({
                    initComplete: function() {
                        var api = this.api();
                        $('#mytable_filter input')
                                .off('.DT')
                                .on('keyup.DT', function(e) {
                                    if (e.keyCode == 13) {
                                        api.search(this.value).draw();
                            }
                        });
                    },
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {"url": "<?php echo base_url(); ?>produk/jsonProdukPenjualan/<?= $penjualan->id_penjualan ?>", "type": "POST"},
                    columns: [
                        {
                            "data": "id_produk",
                            "orderable": false
                        },{"data": "id_produk"},{"data": "qty"},{"data": "total_harga"},
                        {
                            "data" : "action",
                            "orderable": false,
                            "className" : "text-center"
                        }
                    ],
                    order: [[0, 'desc']],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
				setInterval( function () {
    table.ajax.reload();
}, 100 );
				
            });


</script>
