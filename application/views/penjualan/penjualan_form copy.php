<?php $this->load->view('templates/header');?>
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css"> -->
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>  -->

<div class="card card-custom overflow-hidden">
	<div class="card-body p-0">
	<div class="row py-8 px-8 py-md-10">
			<form action="<?php echo base_url().'produk/add_to_cart'?>" method="post">
				<div class="col-4">
					<div class="form-group">
						<label for="varchar">Kode Produk </label>
						<input type="text" name="kode_produk" id="kode_produk" class="form-control input-sm">
					</div>
				</div>
				
					<div id="detail_barang"></div>

				</form>
			</div>
		<form action="<?php echo base_url('produk_penjualan/selesai') ?>" method="POST">
			<input type="hidden" name="no_faktur" value="<?php echo $penjualan->no_faktur; ?>">
			<input type="hidden" name="id_penjualan" value="<?php echo $penjualan->id_penjualan; ?>">
			<!-- begin: Invoice-->
			<!-- begin: Invoice header-->
			<div class="row justify-content-center py-8 px-8 py-md-10">
				<div class="col-md-12">
					<div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
						<h1 class="display-4 font-weight-boldest mb-10">INVOICE</h1>
						<div class="d-flex flex-column align-items-md-end px-0">
							<!--begin::Logo-->

							<!--end::Logo-->
							<span class=" d-flex flex-column align-items-md-end opacity-70">
								<span>Queen Gallery</span>
								<span>Jl. Hang Tuah Ujung No. 276B Pekanbaru - HP 0852 9476 3855</span>
							</span>
							<!-- <form>
                 <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" id="kode_produk" placeholder="Kode Produk">
                  </div>
            </form> -->

						</div>
					</div>
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
									autofocus required />
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
			

			<div class="container">
				<table class="table table-bordered">
				<tr>
					<th>Kode Produk</th>
					<th>Jumlah</th>
					<th>Harga Satuan</th>
					<th>Total Harga</th>
					<th>Aksi</th>
				</tr>
				<tbody>
				<?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as $items): ?>
                    <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
					<tr>
					<td><?=$items['kode_produk'];?></td>
					<td><?=$items['qty'];?></td>
					<td><?=$items['harga'];?></td>
					<td><?=$items['total_harga'];?></td>
						<td>Hapus</td>
					</tr>
					 
                    <?php $i++; ?>
                    <?php endforeach; ?>
				</tbody>
				</table>
			</div>

			<!-- begin: Invoice body-->
			<div class=" row justify-content-center py-8 px-8 py-md-10 ">

				<div class="col-md-12" id="isi">
					<div class="row pl-4">
						<a id="add" class="btn btn-outline-success btn-sm mr-3"><i class="flaticon2-add"></i>
							Tambah Produk</a>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">Kode Produk</div>
						<div class="col-md-1">Jumlah</div>
						<div class="col-md-3">Harga Satuan</div>
						<div class="col-md-3">Total Harga</div>
						<div class="col-md-1"></div>
					</div>
				</div>
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

<script type="text/javascript">

	$(document).ready(function () {
		//Ajax kabupaten/kota insert
		$("#kode_produk").focus();
		$("#kode_produk").on("input", function () {
			var kode_produk = {
				kode_produk: $(this).val()
			};
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('produk/get_barang/'. $penjualan->jenis);?>",
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
	});

</script>

<script>
	var i = 0;
	$(function () {
		$(".selectpicker").selectpicker('render');
	})
// 	$(document).ready(function() {
//     $('.select2kode').select2({
// 		minimumInputLength: 3 
// 	});
// });


	$(document).ready(function () {
	
		var sum = 0;
		$("#add").click(function () {
			$.ajax({
				url: "<?php echo base_url('produk/list_produk/' . $penjualan->jenis) ?>",
				type: 'GET', // added data type
				beforeSend: function (xhr, opts) {
            if (this.options.data.searchterm.length < 3)
            {
                xhr.abort ();
            }
        },
				success: function (res) {
					++i;
					$("#isi").append(
						'<div id="sub_isi"><hr><input type="hidden" value="" name="stok" id="stok"><div class="row" > <div class="col-md-4"> ' +
						res +
						'<span id="info_stok"></span> </div> <div class="col-md-1"> <input class="form-control" type="text" name="jumlah[]" id="jumlah" value="0"></div> <div class="col-md-3"> <input class="form-control" type="text" name="harga[]" id="harga" value="0" readonly> </div> <div class="col-md-3"> <input class="form-control" type="text" name="total" id="total" value="0" readonly>  </div><div class="col-md-1"> <a class="btn btn-light-danger font-weight-bold mr-2 remove-tr"><i class="flaticon2-trash"></i></a></div> </div> </div>'
					);
					$('.selectpicker').selectpicker('refresh');
					
				}
			});

		});
		$(document).off('change').on('change', '.cam_select', function (e) {
			$(e.target).closest('#sub_isi').find('#jumlah').val("1");
			var harga = $(e.target).find('option:selected').attr("harga");
			var stok = $(e.target).find('option:selected').attr("stok");

			$(e.target).closest('#sub_isi').find('#harga').val(new Intl.NumberFormat(['ban', 'id']).format(
				harga));
			$(e.target).closest('#sub_isi').find('#stok').val(stok);
			$(e.target).closest('#sub_isi').find('#info_stok').html("Jumlah Stok : " + stok);
			var jumlah = $(e.target).closest('#sub_isi').find('#jumlah').val();
			var total = parseInt(harga.replace(".", "")) * parseInt(jumlah);
			$(e.target).closest('#sub_isi').find('#total').val(new Intl.NumberFormat(['ban', 'id']).format(
				parseInt(total)));

			var values = $("input[name='total']")
				.map(function () {
					return $(this).val();
				}).get();
			var totalnya = 0;
			for (let x = 0; x < values.length; x++) {
				const element = values[x];
				totalnya += parseInt(values[x].split('.').join(""));
				console.log(element);

			}
			$("#total_akhir").html(new Intl.NumberFormat(['ban', 'id'])
				.format(
					parseInt(totalnya)));
		});

		$(document).on("keydown keyup", '#jumlah', function (e) {
			var harga = $(e.target).closest('#sub_isi').find('#harga').val();
			harga = harga.split('.').join("");
			var jumlah = parseInt($(e.target).closest('#sub_isi').find('#jumlah').val());
			var total = harga * jumlah;

			var stok = parseInt($(e.target).closest('#sub_isi').find('#stok').val());
			if (jumlah <= stok) {
				$(e.target).closest('#sub_isi').find('#total').val(new Intl.NumberFormat(['ban', 'id'])
					.format(
						parseInt(total)));
			} else {
				$(e.target).closest('#sub_isi').find('#total').val("melebih stok");
			}
			var values = $("input[name='total']")
				.map(function () {
					return $(this).val();
				}).get();
			console.log(stok);
			var totalnya = 0;
			for (let x = 0; x < values.length; x++) {
				const element = values[x];
				totalnya += parseInt(values[x].split('.').join(""));
				console.log(element);

			}
			$("#total_akhir").html(new Intl.NumberFormat(['ban', 'id'])
				.format(
					parseInt(totalnya)));


		});
		$(document).on('click', '.remove-tr', function () {

			$(this).parents('#sub_isi').remove();
			var values = $("input[name='total']")
				.map(function () {
					return $(this).val();
				}).get();
			var totalnya = 0;
			for (let x = 0; x < values.length; x++) {
				const element = values[x];
				totalnya += parseInt(values[x].split('.').join(""));
				console.log(element);

			}
			$("#total_akhir").html(new Intl.NumberFormat(['ban', 'id'])
				.format(
					parseInt(totalnya)));
		});


	});


	function calculateSum() {
		var sum = 0;
		var totalData = document.getElementById('total');
		for (var i = 0; i < totalData.length; i++) {
			var ip = inputs[i];
			console.log(ip);
			// if (ip.name && ip.name.indexOf("total") < 0) {
			//     sum += parseInt(ip.value) || 0;
			// }
		}
		//.toFixed() method will roundoff the final sum to 2 decimal places


	}

</script>
