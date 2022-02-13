<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
    <div class="col-md-4">
        <h2>Penjualan List</h2>
    </div>
    <div class="col-md-4 text-center">
        <div id="message">
            <?php echo $this->session->userdata('message') != '' ? $this->session->userdata('message') : ''; ?>
        </div>
    </div>
    <!-- <div class="col-md-4 text-right">
        <div style="margin-top:20px;">
            <?php echo anchor(site_url('penjualan/create'), 'Create', 'class="btn btn-primary"'); ?>
        </div>
    </div> -->
</div>
<div class="card-body">

    <div class="mb-12">
        <div class="row align-items-center">
            <div class="col-lg-12 col-xl-12">
                <div class="row align-items-center">
                    <div class="col-md-4 my-2 my-md-0">
                        <div class="input-icon">
                            <input type="text" class="form-control" placeholder="Search..."
                                id="kt_datatable_search_query" />
                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                        </div>
                    </div>

                    <div class="col-md-4 my-2 my-md-0">
                        <div class="d-flex align-items-center">
                            <label class="mr-3 mb-0 d-none d-md-block">Tanggal:</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 my-2 my-md-0">
                        <div class="d-flex align-items-center">
                            <label class="mr-3 mb-0 d-none d-md-block">Sampai:</label>
                            <input type="date" class="form-control">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center pt-10 pl-8">
                <div class="">
                    <a href="#" class="btn btn-light-success font-weight-bold">
                        Search
                    </a>
                </div>
            </div>

        </div>

    </div>
    <!--end::Search Form-->
    <!--end: Search Form-->
    <!--begin: Datatable-->
    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>

    <div class="row">
        <div class="col-md-12">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Tanggal Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Alexa</td>
                        <td>1</td>
                        <td>01/01/2020</td>
                    </tr>
                    <tr>
                        <td>Avram</td>
                        <td>2</td>
                        <td>05/01/2020</td>
                    </tr>
                    <tr>
                        <td>Basia</td>
                        <td>3</td>
                        <td>06/01/2020</td>
                    </tr>
                    <tr>
                        <td>Bryar</td>
                        <td>4</td>
                        <td>07/01/2020</td>
                    </tr>
                    <tr>
                        <td>Cruz</td>
                        <td>5</td>
                        <td>08/01/2020</td>
                    </tr>
                    <tr>
                        <td>Dexter</td>
                        <td>5</td>
                        <td>09/01/2020</td>
                    </tr>
                    <tr>
                        <td>Dustin</td>
                        <td>5</td>
                        <td>11/01/2020</td>
                    </tr>
                    <tr>
                        <td>Hamilton</td>
                        <td>5</td>
                        <td>15/01/2020</td>
                    </tr>
                    <tr>
                        <td>Ifeoma</td>
                        <td>5</td>
                        <td>19/01/2020</td>
                    </tr>
                    <tr>
                        <td>Indigo</td>
                        <td>5</td>
                        <td>22/01/2020</td>
                    </tr>
                    <tr>
                        <td>Ishmael</td>
                        <td>5</td>
                        <td>25/01/2020</td>
                    </tr>
                    <tr>
                        <td>Jessica</td>
                        <td>5</td>
                        <td>30/01/2020</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!--end: Datatable-->
</div>
<?php $this->load->view('templates/footer');?><script type="text/javascript">
var KTDatatableJsonRemoteDemo = function() {
    // Private functions

    // basic demo
    var demo = function() {
        var datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: BASE_URL + 'produk_penjualan/data_json',
                pageSize: 10,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            // columns definition
            columns: [

                {
                    field: 'id_penjualan',
                    title: '#',
                    sortable: false,
                    width: 20,
                    type: 'number',
                    selector: {
                        class: ''
                    },
                    textAlign: 'center',
                }, {
                    field: 'tanggal_penjualan',
                    title: 'Tanggal penjualan',
                }, {
                    field: 'no_faktur',
                    title: 'No Faktur',
                }, {
                    field: 'qty',
                    title: 'Total Barang',
                }, {
                    field: 'total_harga',
                    title: 'Total Penjualan',
                }
            ],

        });
    };

    return {
        // public functions
        init: function() {
            demo();
        }
    };
}();


$(document).ready(function() {

    KTDatatableJsonRemoteDemo.init();

});

//fungsi untuk filtering data berdasarkan tanggal
var start_date;
var end_date;
var DateFilterFunction = (function(oSettings, aData, iDataIndex) {
    var dateStart = parseDateValue(start_date);
    var dateEnd = parseDateValue(end_date);
    //Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
    //nama depan = 0
    //nama belakang = 1
    //tanggal terdaftar =2
    var evalDate = parseDateValue(aData[2]);
    if ((isNaN(dateStart) && isNaN(dateEnd)) ||
        (isNaN(dateStart) && evalDate <= dateEnd) ||
        (dateStart <= evalDate && isNaN(dateEnd)) ||
        (dateStart <= evalDate && evalDate <= dateEnd)) {
        return true;
    }
    return false;
});

// fungsi untuk converting format tanggal dd/mm/yyyy menjadi format tanggal javascript menggunakan zona aktubrowser
function parseDateValue(rawDate) {
    var dateArray = rawDate.split("/");
    var parsedDate = new Date(dateArray[2], parseInt(dateArray[1]) - 1, dateArray[
        0]); // -1 because months are from 0 to 11
    return parsedDate;
}

$(document).ready(function() {
    //konfigurasi DataTable pada tabel dengan id example dan menambahkan  div class dateseacrhbox dengan dom untuk meletakkan inputan daterangepicker
    var $dTable = $('#example').DataTable({
        "dom": "<'row'<'col-sm-4'l><'col-sm-5' <'datesearchbox'>><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>"
    });

    console.log($dTable.column(1).data().sum());

    //menambahkan daterangepicker di dalam datatables
    $("div.datesearchbox").html(
        '<div class="input-group"> <div class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </div><input type="text" class="form-control" id="datesearch" placeholder="Car Berdasrkan Range Tanggal"> </div>'
    );

    document.getElementsByClassName("datesearchbox")[0].style.textAlign = "right";

    //konfigurasi daterangepicker pada input dengan id datesearch
    $('#datesearch').daterangepicker({
        autoUpdateInput: false
    });

    //menangani proses saat apply date range
    $('#datesearch').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
            'DD/MM/YYYY'));
        start_date = picker.startDate.format('DD/MM/YYYY');
        end_date = picker.endDate.format('DD/MM/YYYY');
        $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
        $dTable.draw();
    });

    $('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        start_date = '';
        end_date = '';
        $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
        $dTable.draw();
    });
});
</script>