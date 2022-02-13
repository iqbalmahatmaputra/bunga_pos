<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
            <div class="col-md-4">
                <h2>Promo Read</h2>
            </div>
            <div class="col-md-8 text-center">
                <div id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
        </div>
        <table class="table">
	    <tr><td>Nama Promo</td><td><?php echo $nama_promo; ?></td></tr>
	    <tr><td>Tanggal Mulai</td><td><?php echo $tanggal_mulai; ?></td></tr>
	    <tr><td>Tanggal Akhir</td><td><?php echo $tanggal_akhir; ?></td></tr>
	    <tr><td>Kode Promo</td><td><?php echo $kode_promo; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
	    <tr><td>Harga Potongan</td><td><?php echo $harga_potongan; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('promo') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table><?php $this->load->view('templates/footer');?>