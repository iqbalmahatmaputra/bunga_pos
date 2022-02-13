<?php $this->load->view('templates/header');?>

<div class="card card-custom overflow-hidden">
    <div class="card-body p-0">
        <form action="<?php echo base_url('produk_penjualan/selesai') ?>" method="POST">
            <input type="hidden" name="no_faktur" value="<?php echo $penjualan->no_faktur; ?>">
            <input type="hidden" name="id_penjualan" value="<?php echo $penjualan->id_penjualan; ?>">
            <!-- begin: Invoice-->
            <!-- begin: Invoice header-->
            <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                        <h1 class="display-4 font-weight-boldest mb-10">INVOICE</h1>
                        <div class="d-flex flex-column align-items-md-end px-0">
                            <!--begin::Logo-->
                           
                            <!--end::Logo-->
                            <span class=" d-flex flex-column align-items-md-end ">
                            <span>Queen Gallery</span>
                                <span>Jl. Hang Tuah Ujung No. 276B Pekanbaru - HP 0852 9476 3855</span>
                            </span>
                        </div>
                    </div>
                    <div class="border-bottom w-100"></div>
                    <div class="d-flex justify-content-between pt-6">
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">Tanggal Invoice</span>
                            <span class=""><?php echo $penjualan->tanggal_penjualan; ?></span>
                        </div>
                        <div class=" d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">No Invoice</span>
                            <span class="opacity-70">QG-<?php echo $penjualan->no_faktur."-".$penjualan->id_penjualan ?></span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">Pencatat Invoice</span>
                            <span class="">
                                <?php
$this->db->where('id_user', $penjualan->id_user);
$user = $this->db->get('user')->row();
echo $user->nama_user;
?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Invoice header-->

            <!-- begin: Invoice body-->
            <div class=" row justify-content-center py-8 px-8 py-md-10 ">

                <div class="col-md-12" id="isi">

                    <br>
                    <div class="row">
                        <div class="col-md-5">Nama Produk</div>
                        <div class="col-md-1">Jumlah</div>
                        <div class="col-md-3">Harga Satuan</div>
                        <div class="col-md-3">Total Harga</div>
                        <div class="col-md-1"></div>
                    </div>
                    <?php
$this->db->where('id_penjualan', $penjualan->id_penjualan);
$dataPenjualan = $this->db->get("v_produk_penjualan")->result();
$total = 0;
foreach ($dataPenjualan as $key => $value) {
    $total += $value->total_harga * $value->qty;
    ?>
                    <div id="sub_isi">
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><?=$value->nama_produk;?> </div>
                            <div class="col-md-1"> <input class="form-control" type="text" name="jumlah[]" id="jumlah"
                                    value="<?=$value->qty;?>" readonly> </div>
                            <div class="col-md-3"> <input class="form-control" type="text" name="harga[]" id="harga"
                                    value="<?= number_format($value->total_harga, 0, ".", ".")?>" readonly>
                            </div>
                            <div class="col-md-3"> <input class="form-control" type="text" name="total" id="total"
                                    value="<?= number_format($value->total_harga * $value->qty, 0, ".", ".");?>" readonly>
                            </div>

                        </div>
                    </div>
                    <?php
}
?>

                </div>
            </div>
            <!-- end: Invoice body-->

            <!-- begin: Invoice footer-->
            <div class="row bg-gray">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <h4>Total Penjualan : Rp. <a id="total_akhir"><?=  number_format($total, 0, ".", ".")?></a></h4>
                </div>
            </div>
            <!-- end: Invoice footer-->

            <!-- begin: Invoice action-->
            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
<!--                       
                        <button type="submit" class="btn btn-primary font-weight-bold">Print
                            Invoice</button> -->
                    </div>
                </div>
            </div>
            <!-- end: Invoice action-->
        </form> <!-- end: Invoice-->
    </div>
</div>

<?php $this->load->view('templates/footer');?>