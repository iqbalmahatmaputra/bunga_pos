<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
            <div class="col-md-4">
                <h2>Produk Detail</h2>
            </div>
            <div class="col-md-8 text-center">
                <div id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
        </div>

        <div class="card card-custom gutter-b">
    <div class="card-body">
        <div class="d-flex">
            <!--begin: Pic-->
            <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                <div class="symbol symbol-50 symbol-lg-120">
                    <img alt="Pic" src="<?php echo $foto_produk; ?>">
                </div>

                <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                    <span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
                </div>
            </div>
            <!--end: Pic-->

            <!--begin: Info-->
            <div class="flex-grow-1">
                <!--begin: Title-->
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="mr-3">
                        <!--begin::Name-->
                        <a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">
                        <?php echo $kode_produk; ?> - <?php echo $nama_produk; ?> <i class="flaticon2-correct text-success icon-md ml-2"></i>
                        </a>
                        <!--end::Name-->

                      
                    </div>
                    
                </div>
                <!--end: Title-->

                <!--begin: Content-->
                <div class="d-flex align-items-center flex-wrap justify-content-between">
                    <div class="flex-grow-1 font-weight-bold text-dark-50 py-5 py-lg-2 mr-5">
                    <?php echo $deskripsi_produk; ?>
                    </div>

                    
                </div>
                <!--end: Content-->
            </div>
            <!--end: Info-->
        </div>

        <div class="separator separator-solid my-7"></div>

        <!--begin: Items-->
        <div class="d-flex align-items-center flex-wrap">
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm">Harga Beli</span>
                    <span class="font-weight-bolder font-size-h5"><span class="text-dark-50 font-weight-bold"></span>Rp <?php echo $harga_beli_produk; ?></span>
                </div>
            </div>
            <!--end: Item-->

            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon-confetti icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm">Harga Jual</span>
                    <span class="font-weight-bolder font-size-h5"><span class="text-dark-50 font-weight-bold"></span>Rp <?php echo $harga_jual_produk; ?></span>
                </div>
            </div>
            <!--end: Item-->

            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm">Harga Jual Supplier (Reseller)</span>
                    <span class="font-weight-bolder font-size-h5"><span class="text-dark-50 font-weight-bold"></span>Rp <?php echo $harga_jual_produk_sup; ?></span>
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon-background icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm">Jenis Barang</span>
                    <span class="font-weight-bolder font-size-h5"><span class="text-dark-50 font-weight-bold"></span> <?php echo $status; ?> - <?php echo $satuan; ?></span>
                </div>
            </div>
            <!--end: Item-->


        
        </div>
        <!--begin: Items-->
    </div>
</div>

    <?php $this->load->view('templates/footer');?>