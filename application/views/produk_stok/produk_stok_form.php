<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
    <div class="col-md-4">
        <h2>Produk stok <?php echo $button ?></h2>
    </div>
    <div class="col-md-8 text-center">
        <div id="message">
            <?php echo $this->session->userdata('message') != '' ? $this->session->userdata('message') : ''; ?>
        </div>
    </div>
</div>
<form action="<?php echo $action; ?>" method="post">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="int">Kode Produk <?php echo form_error('id_produk') ?></label>

                <select class="form-control selectpicker" data-size="7" data-live-search="true" name="id_produk"
                    id="id_produk">
                    <option value="">Pilih Kode Produk</option>
                    <?php
$produks = $this->db->get("produk")->result();
foreach ($produks as $key => $value) {
    ?>
                    <option value="<?php echo $value->id_produk; ?>
" <?php
if ($id_produk == $value->id_produk) {
        echo "selected";
    }
    ?>><?php echo $value->id_produk; ?> | <?php echo $value->kode_produk; ?></option>
                    <?php
}
?>
                </select> </div>
        </div>
        <div class="col-md-6">
            <div class=" form-group">
                <label for="date">Date In <?php echo form_error('tanggal_produk_stok') ?></label>
                <input type="date" class="form-control" name="tanggal_produk_stok" id="tanggal_produk_stok"
                    placeholder="Tanggal Produk Stok" value="<?php echo date("Y-m-d"); ?>" />
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-6">
    <div class="form-group">
        <label for="int">Quantity<?php echo form_error('jumlah_produk_stok') ?></label>
        <input type="number" class="form-control" name="jumlah_produk_stok" id="jumlah_produk_stok"
            placeholder="Quantity"  autofocus value="<?php echo $jumlah_produk_stok; ?>" />
    </div>
</div>
    <div class="col-md-6">
    <div class="form-group">
        <label for="int">Keterangan<?php echo form_error('keterangan') ?></label>
        <input type="text" class="form-control" name="keterangan" id="keterangan"
            placeholder="Keterangan Stok Produk"  autofocus value="<?php echo $keterangan; ?>" />
    </div>
    </div>
</div>
    
    <input type="hidden" name="id_produk_stok" value="<?php echo $id_produk_stok; ?>" />
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
    <a href="<?php echo site_url('produk_stok') ?>" class="btn btn-default">Cancel</a>
</form><?php $this->load->view('templates/footer');?>