<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
            <div class="col-md-4">
                <h2>Promo <?php echo $button ?></h2>
            </div>
            <div class="col-md-8 text-center">
                <div id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
        </div>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama Promo <?php echo form_error('nama_promo') ?></label>
            <input type="text" class="form-control" name="nama_promo" id="nama_promo" placeholder="Nama Promo" value="<?php echo $nama_promo; ?>" />
        </div>
	    <div class="form-group">
            <label for="datetime">Rentang Waktu Promo<?php echo form_error('tanggal_mulai') ?></label>
            <input type="text" class="form-control" id="kt_daterangepicker_1" name="tanggal" readonly="" placeholder="Select time">
            
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
            <label for="varchar">Kode Promo <?php echo form_error('kode_promo') ?></label>
            <input type="text" class="form-control" name="kode_promo" id="kode_promo" placeholder="Kode Promo" value="<?php echo $kode_promo; ?>" />
        </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
            <label for="int">Harga Potongan <?php echo form_error('harga_potongan') ?></label>
            <input type="text" class="form-control" name="harga_potongan" id="harga_potongan" placeholder="Harga Potongan" value="<?php echo $harga_potongan; ?>" />
        </div>
            </div>
        </div>
	   <input type="hidden" class="form-control" name="status" id="status" placeholder="Status" value="Aktif" />
	    
	    <input type="hidden" name="id_promo" value="<?php echo $id_promo; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('promo') ?>" class="btn btn-default">Cancel</a>
	</form><?php $this->load->view('templates/footer');?>