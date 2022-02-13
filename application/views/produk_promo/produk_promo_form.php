<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
            <div class="col-md-4">
                <h2>Produk promo <?php echo $button ?></h2>
            </div>
            <div class="col-md-8 text-center">
                <div id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
        </div>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Produk <?php echo form_error('id_produk') ?></label>
            <input type="text" class="form-control" name="id_produk" id="id_produk" placeholder="Id Produk" value="<?php echo $id_produk; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Promo <?php echo form_error('id_promo') ?></label>
            <input type="text" class="form-control" name="id_promo" id="id_promo" placeholder="Id Promo" value="<?php echo $id_promo; ?>" />
        </div>
	    <input type="hidden" name="id_produk_promo" value="<?php echo $id_produk_promo; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('produk_promo') ?>" class="btn btn-default">Cancel</a>
	</form><?php $this->load->view('templates/footer');?>