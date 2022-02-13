<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
            <div class="col-md-4">
                <h2>Produk foto <?php echo $button ?></h2>
            </div>
            <div class="col-md-8 text-center">
                <div id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
        </div>
        <form action="<?php echo $action; ?>" method="post" enctype='multipart/form-data'>
	    <div class="form-group">
            <label for="varchar">Foto Produk <?php echo form_error('foto_produk') ?></label>
            <div class="dropzone-panel">
            <input type="file" class="form-control dropzone-select btn btn-light-primary font-weight-bold btn-sm dz-clickable" name="foto_produk" id="foto_produk" placeholder="Foto Produk" value="<?php echo $foto_produk; ?>" />
            </div>
        </div>
	    <div class="form-group">
            <label for="int">Id Produk <?php echo form_error('id_produk') ?></label>
            <!-- <input type="text" class="form-control" name="id_produk" id="id_produk" placeholder="Id Produk" value="<?php echo $id_produk; ?>" /> -->

            <select class="form-control selectpicker" data-size="7" data-live-search="true" name="id_produk"
                    id="id_produk">
                    <option value="">Pilih Produk</option>
                    <?php
$produks = $this->db->get("produk")->result();
foreach ($produks as $key => $value) {
    ?>
                    <option value="<?php echo $value->id_produk; ?>
" <?php
if ($id_produk == $value->id_produk) {
        echo "selected";
    }
    ?>><?php echo $value->kode_produk; ?> | <?php echo $value->nama_produk; ?></option>
                    <?php
}
?>
                </select>

        </div>

	    <input type="hidden" name="id_produk_foto" value="<?php echo $id_produk_foto; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('produk_foto') ?>" class="btn btn-default">Cancel</a>
	</form><?php $this->load->view('templates/footer');?>