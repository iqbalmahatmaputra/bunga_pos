<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
            <div class="col-md-4">
                <h2>User <?php echo $button ?></h2>
            </div>
            <div class="col-md-8 text-center">
                <div id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
        </div>
        <div class="card">
        <div class="card-body">
        
        
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama User <?php echo form_error('nama_user') ?></label>
            <input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Nama User" value="<?php echo $nama_user; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Password <?php echo form_error('password') ?></label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
        </div>
	    <!-- <div class="form-group">
            <label for="varchar">Foto <?php echo form_error('foto') ?></label>
            <div class="dropzone-panel">
            <input type="file" class="form-control dropzone-select btn btn-light-primary font-weight-bold btn-sm dz-clickable" name="foto" id="foto" placeholder="Foto User" value="<?php echo $foto; ?>" />
            </div>
        </div> -->
	    <div class="form-group">
            <label for="varchar">Telfon <?php echo form_error('telfon') ?></label>
            <input type="number" class="form-control" name="telfon" id="telfon" placeholder="Telfon" value="<?php echo $telfon; ?>" />
        </div>
<!-- 	    
	    <div class="form-group">
            <label for="int">Is Active <?php echo form_error('is_active') ?></label>
            <input type="text" class="form-control" name="is_active" id="is_active" placeholder="Is Active" value="<?php echo $is_active; ?>" />
        </div> -->
	    <div class="form-group">
            <label for="enum">Status <?php echo form_error('status') ?></label>
             <!-- <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" /> -->
            <?php
      $options = array("Penjaga","Admin", "Kasir");
 ?>

 <select name="status" id="status" class="form-control">
     <?php foreach ($options as $option): ?>
         <option value="<?php echo $option; ?>"<?php if ($status == $option): ?> selected="selected"<?php endif; ?>>
             <?php echo $option; ?>
         </option>
     <?php endforeach; ?>
 </select>
        </div>
        <?php date_default_timezone_set("Asia/Jakarta"); 
        if($button == "Create"){ 
        ?>

                <input type="hidden" name="created_at" id="created_at" value="<?php echo date ('Y\-m\-d\ H:i:s A'); ?>">
                
                    <input type="hidden" class="form-control" name="is_active" id="is_active" value="1" >
            <?php 
        }else{ ?>
            	    
	    <div class="form-group">
            <label for="int">Is Active <?php echo form_error('is_active') ?></label>
            <select name="is_active" id="is_active" class="form-control">
            <?php if($is_active == 1){ ?>
            <option value="1" selected>Aktif</option>
            <option value="0">Pasif</option>
            <?php }else{ ?>
                <option value="1" >Aktif</option>
            <option value="0" selected>Pasif</option>
            <?php 
            }
                ?>
            </select>
        </div> 
       <?php  }
            ?>
	    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('user') ?>" class="btn btn-default">Cancel</a>
	</form>
    </div></div>
    <?php $this->load->view('templates/footer');?>