<?php 
						error_reporting(0);
						$b=$brg->row_array();
						// foreach($x as $b){ 
							$stok = $this->db->query("select final_stock from v_stok where kode_produk='" . $b['kode_produk']."'")->row_array();
				
							$retur = $this->db->query("select sum(qty) qty from v_retur WHERE kode_produk='" . $b['kode_produk']. "' GROUP BY kode_produk")->row_array();
							$produk_stok = $this->db->query("select kode_produk , jumlah_produk_stok from v_produk_stok_groupby WHERE kode_produk='" . $b['kode_produk']. "' GROUP BY kode_produk")->row_array();
							$iniDia = $this->db->query("SELECT vs.kode_produk, vs.jumlah_produk_stok as jumlah_produk_stok , vs.stock_terjual as stok_terjual , vsr.qty_retur as qty_retur FROM `v_stok` as vs JOIN v_stok_retur as vsr ON vs.id_produk = vsr.id_produk where vs.kode_produk = '" . $b['kode_produk']."'")->row_array();
						$returan = $this->db->query("SELECT p.kode_produk as kode_produk ,sum(pr.qty) as jumretur FROM `produk_retur` as pr join produk as p on pr.id_produk = p.id_produk where kode_produk='". $b['kode_produk']."' GROUP BY kode_produk ")->row_array();
							// Baru
						
						// End
							if($iniDia){

								if($returan['jumretur'] == NULL){
								$akhir = $iniDia['jumlah_produk_stok'] - $iniDia['stok_terjual'];
							}else{
								$akhir = $iniDia['jumlah_produk_stok'] - $iniDia['stok_terjual'] + $returan['jumretur'];
							}
							}
							else{
								$akhir = $produk_stok['jumlah_produk_stok'];
							}
							            $returVal=0;
            if(empty($retur->qty)){
                $returVal=0;
            }else{
                $returVal=$retur->qty;
            }
			if(!empty($stok)){
				if ( $stok['final_stock'] != 0) {
					$stok_akhir=$stok['final_stock']+$returVal;
				}
			}	else{
				$retur = $this->db->query("select sum(qty) qty from v_retur WHERE kode_produk='" . $b['kode_produk']."' GROUP BY id_produk")->row_array();
                $returVal=0;
                if(empty($retur->qty)){
                    $returVal=0;
                }else{
                    $returVal=$retur->qty;
                }
				$stok_group = $this->db->query("select * from v_produk_stok_groupby where kode_produk='" . $b['kode_produk']."'")->row_array();
				if (isset($stok_group->jumlah_produk_stok)) {
					$stok_akhir=$stok_group->jumlah_produk_stok+$returVal;
				}
			}	
			 if($supplier == 0){
				$harga = $b['harga_jual_produk'];
			 }else{
				 $harga = $b['harga_jual_produk_sup'];
			 }
					
					
					?>
					<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	</div>
<input type="hidden" name="id_produk" value="<?php echo  $b['id_produk']?>" class="form-control input-sm">
<input type="hidden" name="id_penjualan" value="<?php echo $id_penjualan;?>" class="form-control input-sm" readonly>


<div class="row">
	<div class="col-md-2">
		<div class="form-group">
			<label for="varchar">Stok </label>
			<?php
				if($akhir == 0 ){
					?>
					<input type="text" name="stok" value="<?php echo $akhir;?>" class="form-control input-sm bg-warning text-white" readonly>
					<?php
				}else{
					?>
<input type="text" name="stok" value="<?php echo $akhir;?>" class="form-control input-sm" readonly>
					<?php
				}
			 ?>
			
			
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label for="varchar">Jumlah </label>

			<input type="number" id="qty" name="qty" value="0" min="0" max="<?php echo $akhir;?>"
				class="form-control input-sm" required>

		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
			<label for="varchar">Harga </label>
			<input type="text" name="harga" id="harga" value="<?php echo $harga;?>" class="form-control input-sm"
				>
		</div>
	</div>
	<div class="col-md-3 d-flex align-items-end">
		<div class="form-group">
			<label for="total"> Total Harga </label>
			<input class="form-control" type="text" name="total" id="total">
		</div>
	</div>
	<?php 
	if($akhir == 0){
		?>
<div class="col-md-3 d-flex align-items-end">
		<div class="form-group">
			<label for="butsave"> Aksi </label><br>
			<button type="submit" class="btn btn-warning" id="butsave" disabled>Tidak Ada Stok</button>
		</div>
	</div>
		<?php
	}else{
		?>
<div class="col-md-3 d-flex align-items-end">
		<div class="form-group">
			<label for="butsave"> Aksi </label><br>
			<button type="submit" class="btn btn-primary" id="butsave">Masukkan</button>
		</div>
	</div>
		<?php
	}
	?>
	


</div>
<script type="text/javascript">
	$(document).ready(function () {
		const formatRupiah = (money) => {
			return new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR',
				minimumFractionDigits: 0
			}).format(money);
		}
		$("#harga,#qty").bind("keyup mouseup change click", function () {

			$('#total').val($('#harga').val() * $('#qty').val());
			// $('#total').val(formatRupiah($('#harga').val() * $('#qty').val()));



		});
		// Save

		$('#butsave').on('click', function() {
		var id_produk = <?php echo  $b['id_produk']?>;
		var id_penjualan = <?php echo  $id_penjualan?>;
		var stok = $('#stok').val();
		var qty = $('#qty').val();
		var harga = $('#harga').val();
		var total = $('#total').val();
		
			$("#butsave").attr("disabled", "disabled");
			$.ajax({
				url: "<?php echo base_url("produk_penjualan/oke");?>",
				type: "POST",
				data: {
					id_produk: id_produk,
					id_penjualan: id_penjualan,
					stok: stok,
					qty: qty,
					harga: harga,
					total: total
				},
			
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
						$("#butsave").removeAttr("disabled");
						$('#fupForm').find('input:text').val('');
						$("#success").show();
						$('#success').html('Berhasil dimasukkan !'); 
													
					}
					else if(dataResult.statusCode==201){
					   alert("Error occured !");
					}
					
				}
			});
		
	});
	});

</script>

