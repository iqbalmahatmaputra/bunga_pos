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
        <label for="varchar">Kode Produk <?php echo form_error('kode_produk') ?></label>
        <input autofocus type="text" class="form-control" name="kode_produk" id="kode_produk" placeholder="Kode Produk"
            value="<?php echo $kode_produk; ?>" />
    </div>
    <div class="form-group">
        <label for="varchar">Nama Produk <?php echo form_error('nama_produk') ?></label>
        <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk"
            value="<?php echo $nama_produk; ?>" />
    </div>
    <div class="form-group">
        <label for="varchar">Deskripsi Produk <?php echo form_error('deskripsi_produk') ?></label>
        <!-- <input type="text" class="form-control" name="deskripsi_produk" id="deskripsi_produk"
            placeholder="Deskripsi Produk" value="<?php echo $deskripsi_produk; ?>" /> -->
            <textarea name="deskripsi_produk" class="form-control" id="deskripsi_produk" cols="" rows="3"><?php echo $deskripsi_produk; ?></textarea>
    </div>
    <div class="row">
    <div class="col-4">
    <div class="form-group">
        <label for="int">Harga Beli Produk <?php echo form_error('harga_beli_produk') ?></label>
        <input type="number" class="form-control" name="harga_beli_produk" id="harga_beli_produk"
            placeholder="Harga Beli Produk" value="<?php echo $harga_beli_produk; ?>" />
    </div>
    </div>
    <div class="col-4">
    <div class="form-group">
        <label for="int">Harga Jual Produk <?php echo form_error('harga_jual_produk') ?></label>
        <input type="number" class="form-control" name="harga_jual_produk" id="harga_jual_produk"
            placeholder="Harga Jual Produk" value="<?php echo $harga_jual_produk; ?>" />
    </div>
    </div>
    <div class="col-4">
    <div class="form-group">
        <label for="int">Harga Jual Produk Supplier<?php echo form_error('harga_jual_produk_sup') ?></label>
        <input type="number" class="form-control" name="harga_jual_produk_sup" id="harga_jual_produk_sup"
            placeholder="Harga Jual Produk Supplier" value="<?php echo $harga_jual_produk_sup; ?>" />
    </div></div>
    </div>
    
    
    
    <div class="form-group">
            <label for="varchar">Foto Produk <?php echo form_error('foto_produk') ?></label>
            <div class="dropzone-panel">
            <input type="file" class="form-control dropzone-select btn btn-light-primary font-weight-bold btn-sm dz-clickable" name="foto_produk" id="foto_produk" placeholder="Foto Produk" value="<?php echo $foto_produk; ?>" />
            </div>
        </div>
        <div class="row">
        <div class="col"><div class="form-group">
        <label for="varchar">Status <?php echo form_error('status') ?></label>
        <!-- <input type="text" class="form-control" name="status" id="status" placeholder="Status"
            value="<?php echo $status; ?>" /> -->
            <?php
      $options = array("Barang Mentah", "Barang Jadi");
 ?>

 <select name="status" id="status" class="form-control">
     <?php foreach ($options as $option): ?>
         <option value="<?php echo $option; ?>"<?php if ($status == $option): ?> selected="selected"<?php endif; ?>>
             <?php echo $option; ?>
         </option>
     <?php endforeach; ?>
 </select>
    </div>
    </div>
        <div class="col">
        <div class="form-group">
        <label for="varchar">Satuan <?php echo form_error('satuan') ?></label>

            <?php
      $pilihan = array("Piece", "Pair","Set");
 ?>

 <select name="satuan" id="satuan" class="form-control">
     <?php foreach ($pilihan as $option): ?>
         <option value="<?php echo $option; ?>"<?php if ($satuan == $option): ?> selected="selected"<?php endif; ?>>
            <?php echo $option; ?>
         </option>
     <?php endforeach; ?>
 </select>
    </div>
        </div></div>
  
    <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>" />
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
    <a href="<?php echo site_url('produk') ?>" class="btn btn-default">Cancel</a>
</form>
</div></div>
<?php $this->load->view('templates/footer');?>

