<?php 
						error_reporting(0);
						$b=$brg->row_array();
						// foreach($x as $b){ 
							$stok = $this->db->query("select final_stock from v_stok where kode_produk='" . $b['kode_produk']."'")->row_array();
				
							$retur = $this->db->query("select sum(qty) qty from v_retur WHERE kode_produk='" . $b['kode_produk']. "' GROUP BY kode_produk")->row_array();

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
					$stok_akhir=$stok_group->jumlah_produk_stok-$returVal;
				}
			}	
			 if($supplier == 0){
				$harga = $b['harga_jual_produk'];
			 }else{
				 $harga = $b['harga_jual_produk_sup'];
			 }
					
					
					?>
<input type="hidden" name="kode_produk" value="<?php echo $b['kode_produk'];?>" class="form-control input-sm"
				readonly>
<div class="row">
	<div class="col-md-2">
		<div class="form-group">
			<label for="varchar">Stok </label>
			<?php if(isset($stok_akhir)){
				
			 ?>
			<input type="text" name="stok[]" value="<?php echo $stok_akhir;?>"
				class="form-control input-sm" readonly>
			<?php }else{ ?>
					<input type="text" name="stok[]" value="0"
					class="form-control input-sm bg-warning text-white" readonly>
			<?php } ?>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
			<label for="varchar">Jumlah </label>
			
			<input type="number" name="qty[]" value="1" min="1" max="<?php echo $stok_akhir;?>"
				class="form-control input-sm" required>
		
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label for="varchar">Harga </label>
			
			<input type="text" name="harga[]" value="<?php echo $harga;?>" class="form-control input-sm"
				readonly>
			
		</div>
	</div>
	<div class="col-md-3 d-flex align-items-end">
		<div class="form-group">
			<label for="total"> Total Harga </label>
			<input class="form-control" type="text" name="total" id="total" value="0" readonly>
		
		</div>
	</div>
	
	
</div>

