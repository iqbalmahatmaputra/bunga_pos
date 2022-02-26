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
                            <a href="#" class="mb-5">
                                <img src="assets/media/logos/logo-dark.png" alt="">
                            </a>
                            <!--end::Logo-->
                            <span class=" d-flex flex-column align-items-md-end opacity-70">
                                <span>Toko Bunga</span>
                                <span>Jalan Bunga nO 1 Pekanbaru No HP : 0812892348</span>
                            </span>
                        </div>
                    </div>
                    <div class="border-bottom w-100"></div>
                    <div class="d-flex justify-content-between pt-6">
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">Tanggal Invoice</span>
                            <span class="opacity-70"><?php echo date("d-m-Y"); ?></span>
                        </div>
                        <div class=" d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">No Invoice</span>
                            <span class="opacity-70">GS <?php echo $penjualan->no_faktur; ?></span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">Pencatat Invoice</span>
                            <span class="opacity-70">
                                <select class="form-control selectpicker" data-size="7" data-live-search="true"
                                    name="id_user" id="id_user">
                                    <option value="">Pilih Petugas</option>
                                    <?php
$produks = $this->db->get("user")->result();
foreach ($produks as $key => $value) {
    ?>
                                    <option value="<?php echo $value->id_user; ?>
"><?php echo $value->nama_user; ?></option>
                                    <?php
}
?>
                                </select>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Invoice header-->

            <!-- begin: Invoice body-->
            <div class=" row justify-content-center py-8 px-8 py-md-10 ">

                <div class="col-md-12" id="isi">
                    <div class="row pl-4">
                        <a id="add" class="btn btn-outline-success btn-sm mr-3"><i class="flaticon2-add"></i>
                            Tambah Produk</a>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">Nama Produk</div>
                        <div class="col-md-1">Jumlah</div>
                        <div class="col-md-3">Harga Satuan</div>
                        <div class="col-md-3">Total Harga</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
            <!-- end: Invoice body-->

            <!-- begin: Invoice footer-->
            <div class="row bg-gray">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <h4>Total Penjualan : <a id="total_akhir"></a></h4>
                </div>
            </div>
            <!-- end: Invoice footer-->

            <!-- begin: Invoice action-->
            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            onclick="window.print();">Download
                            Invoice</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Print
                            Invoice</button>
                    </div>
                </div>
            </div>
            <!-- end: Invoice action-->
        </form> <!-- end: Invoice-->
    </div>
</div>
<?php
$selectData = '<select class="form-control selectpicker cam_select" data-size="7" data-live-search="true" name="id_produk[]" id="id_produk"><option value="">Pilih Produk</option>';
$produks = $this->db->get("produk")->result();
foreach ($produks as $key => $value) {
    $stok = $this->db->query("select * from v_produk_stok_groupby where id_produk=" . $value->id_produk)->row();
    $selectData .= '<option harga="' . $value->harga_jual_produk . '" stok="' . $stok->jumlah_produk_stok . '" value="' . $value->id_produk . '">' . $value->nama_produk . '</option>';

}
$selectData .= '</select>';

?>
<?php $this->load->view('templates/footer');?>
<script>
var i = 0;

var select =
    '<?php echo $selectData; ?>
';



$(document).ready(function() {

    var sum = 0;
    $("#add").click(function() {
        $.ajax({
            url: "<?php echo base_url('produk/list_produk/' . $penjualan->jenis) ?>",
            type: 'GET', // added data type
            success: function(res) {
                ++i;
                $("#isi").append(
                    '<div id="sub_isi"><hr><input type="hidden" value="" name="stok" id="stok"><div class="row" > <div class="col-md-4"> ' +
                    res +
                    '<span id="info_stok"></span> </div> <div class="col-md-1"> <input class="form-control" type="text" name="jumlah[]" id="jumlah" value="0"></div> <div class="col-md-3"> <input class="form-control" type="text" name="harga[]" id="harga" value="0" readonly> </div> <div class="col-md-3"> <input class="form-control" type="text" name="total" id="total" value="0" readonly>  </div><div class="col-md-1"> <a class="btn btn-light-danger font-weight-bold mr-2 remove-tr"><i class="flaticon2-trash"></i></a></div> </div> </div>'
                );
                $('.selectpicker').selectpicker('refresh');
            }
        });

    });
    $(document).off('change').on('change', '.cam_select', function(e) {
        $(e.target).closest('#sub_isi').find('#jumlah').val("1");
        var harga = $(e.target).find('option:selected').attr("harga");
        var stok = $(e.target).find('option:selected').attr("stok");
        $(e.target).closest('#sub_isi').find('#harga').val(harga);
        $(e.target).closest('#sub_isi').find('#stok').val(stok);
        $(e.target).closest('#sub_isi').find('#info_stok').html("Jumlah Stok : " + stok);
        var jumlah = $(e.target).closest('#sub_isi').find('#jumlah').val();
        $(e.target).closest('#sub_isi').find('#total').val(harga * jumlah);

        var values = $("input[name='total']")
            .map(function() {
                return $(this).val();
            }).get();
        var totalnya = 0;
        for (let x = 0; x < values.length; x++) {
            const element = values[x];
            totalnya += parseInt(values[x]);
            console.log(element);

        }
        $("#total_akhir").html(totalnya);
    });

    $(document).on("keydown keyup", '#jumlah', function(e) {
        var harga = $(e.target).closest('#sub_isi').find('#harga').val();
        var jumlah = parseInt($(e.target).closest('#sub_isi').find('#jumlah').val());

        var stok = parseInt($(e.target).closest('#sub_isi').find('#stok').val());
        if (jumlah <= stok) {
            $(e.target).closest('#sub_isi').find('#total').val(harga * jumlah);
        } else {
            $(e.target).closest('#sub_isi').find('#total').val("melebih stok");
        }
        var values = $("input[name='total']")
            .map(function() {
                return $(this).val();
            }).get();
        console.log(stok);
        var totalnya = 0;
        for (let x = 0; x < values.length; x++) {
            const element = values[x];
            totalnya += parseInt(values[x]);
            console.log(element);

        }
        $("#total_akhir").html(totalnya);


    });
    $(document).on('click', '.remove-tr', function() {

        $(this).parents('#sub_isi').remove();
        var values = $("input[name='total']")
            .map(function() {
                return $(this).val();
            }).get();
        var totalnya = 0;
        for (let x = 0; x < values.length; x++) {
            const element = values[x];
            totalnya += parseInt(values[x]);
            console.log(element);

        }
        $("#total_akhir").html(totalnya);
    });


});


function calculateSum() {
    var sum = 0;
    var totalData = document.getElementById('total');
    for (var i = 0; i < totalData.length; i++) {
        var ip = inputs[i];
        console.log(ip);
        // if (ip.name && ip.name.indexOf("total") < 0) {
        //     sum += parseInt(ip.value) || 0;
        // }
    }
    //.toFixed() method will roundoff the final sum to 2 decimal places


}
</script>