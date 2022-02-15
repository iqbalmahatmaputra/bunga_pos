function cancel(id) {
    $.ajax({
        type: 'GET',
        url: '<?php echo base_url() ?>/Produk/cancel',
        data: 'id_penjualan=' + id,
        success: function (html) {
            swal("good job", "Berhasil di batalkan", "success");
            
        }
    });
}

function load_data_temp() {

    $.ajax({
        type: 'GET',
        url: '<?php echo base_url() ?>/Produk/load_temp/<?= $penjualan->id_penjualan ?>',
        data: '',
        success: function (html) {
            $("#list").html(html);
        }
    });
}

function jumlah_uang() {
    var total_belanja = $("#total_belanja").val();
    var jumlah_uang = $("#jumlah_uang").val();
    $.ajax({
        url: '<?php echo base_url() ?>Produk/kembalian',
        type: 'GET',
        data: 'total_belanja=' + total_belanja + '&jumlah_uang=' + jumlah_uang + '&kembalian',
        success: function (data) {
            var json = data,
                obj = JSON.parse(json);
            $("#kembalian").val(obj.hasil);
            $("#Terbilang").val(obj.Terbilang);
            $("#Terbilang2").val(obj.Terbilang2);
        }
    });
}

function jumlah_uang() {
    var total_belanja = $("#total_belanja").val();
    var jumlah_uang = $("#jumlah_uang").val();
    $.ajax({
        url: '<?php echo base_url() ?>index.php/Penjualan/kembalian',
        type: 'GET',
        data: 'total_belanja=' + total_belanja + '&jumlah_uang=' + jumlah_uang + '&kembalian',
        success: function (data) {
            var json = data,
                obj = JSON.parse(json);
            $("#kembalian").val(obj.hasil);
            $("#Terbilang").val(obj.Terbilang);
            $("#Terbilang2").val(obj.Terbilang2);
        }
    });
}