<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
	<div class="col-md-4">
		<h2>Produk <?php echo $button ?></h2>
	</div>
	<div class="col-md-8 text-center">
		<div id="message">
			<?php echo $this->session->userdata('message') != '' ? $this->session->userdata('message') : ''; ?>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<form action="<?php echo $action; ?>" method="post" enctype='multipart/form-data'>
			<div class="form-group">
				<label for="varchar">No Faktur <?php echo form_error('no_faktur') ?></label>
				<select class="form-control selectpicker" data-size="7" data-live-search="true"
									name="id_penjualan" id="id_penjualan" required>
                                    <?php if($button=="Create"){?>
									<option value="">Pilih No Faktur</option>
									<?php
$produks = $this->db->get("penjualan")->result();
foreach ($produks as $key => $value) {
    ?>
									<option value="<?php echo $value->id_penjualan; ?>
">QG-<?php echo $value->no_faktur."-".$value->id_penjualan ?></option>
									<?php
}
?>
								</select>
<?php }else{ ?>
    <option value="">Pilih No Faktur</option>
									<?php
$produks = $this->db->get("penjualan")->result();
foreach ($produks as $key => $value) {
    ?>
									<option value="<?php echo $value->id_penjualan; ?>
"
<?php if ($id_penjualan == $value->id_penjualan): ?> selected="selected"<?php endif; ?>
>QG-<?php echo $value->no_faktur."-".$value->id_penjualan ?></option>
									<?php
}
?>
								</select>
<?php } ?>
			</div>
			<div class="form-group">
				<label for="varchar">Kepada <?php echo form_error('tujuan') ?></label>
				<input type="text" class="form-control" name="tujuan" id="tujuan" placeholder="Atas Nama"
					value="<?php echo $tujuan; ?>"  />
			</div>

			<div class="form-group">
				<label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
				<!-- <input type="text" class="form-control" name="alamat" id="alamat"
            placeholder="Deskripsi Produk" value="<?php echo $alamat; ?>" /> -->
				<textarea name="alamat" class="form-control" id="alamat" cols=""
					rows="3"><?php echo $alamat; ?></textarea>
			</div>
			<div class="form-group">
        <label for="varchar">No Handphone <?php echo form_error('no_hp') ?></label>
        <input type="number" class="form-control" name="no_hp" id="no_hp" placeholder="ex. 081261151892"
            value="<?php echo $no_hp; ?>"  />
    </div>




			<input type="hidden" name="id_produk" value="<?php echo $id_kirim; ?>" />
            <input type="hidden" name="created_at" value="<?php echo date ('Y\-m\-d\ H:i:s A'); ?>">
			<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
			<a href="<?php echo site_url('pengiriman') ?>" class="btn btn-default">Cancel</a>
		</form>
	</div>
</div>
<?php $this->load->view('templates/footer');?>
