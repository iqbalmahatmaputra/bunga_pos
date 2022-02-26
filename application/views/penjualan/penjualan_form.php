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
		
		<!-- end: Invoice header-->


		<form action="<?php echo base_url('produk_penjualan/siap') ?>" method="POST">
		<!-- begin: Invoice body-->
		<div class=" row justify-content-center py-8 px-8 py-md-10 ml-5">

			<div id="list" class="col-md-12 ">

			</div>

		</div>
		<!-- end: Invoice body-->
		<div class="row justify-content-center py-8 px-8 py-md-10">
			<div class="col-md-12">
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
									name="nama_user" id="nama_user" required>
									<option value="">Pilih Petugas</option>
									<?php
$produks = $this->db->get("user")->result();
foreach ($produks as $key => $value) {
    ?>
									<option value="<?php echo $value->nama_user; ?>
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
	var i = 0;
	var sum = 0;
	$(document).ready(function () {
		setInterval(load_data_temp, 1000);
// 		function cancel(id) {
//     $.ajax({
//         type: 'GET',
//         url: '<?php echo base_url() ?>Produk/cancel',
//         data: 'id=' + id,
//         success: function (html) {
//             swal("good job", "Berhasil di batalkan", "success");
// 			load_data_temp();
            
//         }
//     });
// }
$(document).on("click", ".delete", function() { 
	//alert("Success");
		var $ele = $(this).parent().parent();
		$.ajax({
			url: "<?php echo base_url("Produk/deleterecords");?>",
			type: "POST",
			cache: false,
			data:{
				type: 2,
				id: $(this).attr("data-id")
			},
			success: function(dataResult){
			
				var dataResult = JSON.parse(dataResult);
				if(dataResult.statusCode==200){
					$ele.fadeOut().remove();
				}
				load_data_temp();
			}
		});
	});
function load_data_temp() {

    $.ajax({
        type: 'GET',
        url: '<?php echo base_url() ?>/Produk/load_temp/<?= $penjualan->id_penjualan ?>',
        data: '',
        success: function (html) {
            $("#list").html(html);
        }
    });
}

function jumlah_uang() {
    var total_belanja = $("#total_belanja").val();
    var jumlah_uang = $("#jumlah_uang").val();
    $.ajax({
        url: '<?php echo base_url() ?>Produk/kembalian',
        type: 'GET',
        data: 'total_belanja=' + total_belanja + '&jumlah_uang=' + jumlah_uang + '&kembalian',
        success: function (data) {
            var json = data,
                obj = JSON.parse(json);
            $("#kembalian").val(obj.hasil);
            $("#Terbilang").val(obj.Terbilang);
            $("#Terbilang2").val(obj.Terbilang2);
        }
    });
}
		$("#kode_produk").autocomplete({
			autoFill: true,
			source: "<?php echo site_url('produk/get_autocomplete/?');?>"
		});

		$("#kode_produk").focus();
		$("#kode_produk").on('blur keyup change click', function () {
			
			var kode_produk = {
				kode_produk: $(this).val()
			};
			var id_penjualan = <?= $penjualan->id_penjualan; ?> ;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('produk/get_barang/'. $penjualan->jenis.'/'. $penjualan->id_penjualan);?>",
				data: kode_produk,
				success: function (msg) {
					$('#detail_barang').html(msg);
					load_data_temp();

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
