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
    <div class="col-md-4 text-right">
        <div style="margin-top:20px;">
            <?php echo anchor(site_url('penjualan/create/pembeli'), 'Faktur Pembeli', 'class="btn btn-primary"'); ?>
            <?php echo anchor(site_url('penjualan/create/supplier'), 'Faktur Supplier', 'class="btn btn-success"'); ?>
        </div>

    </div>
</div>
<div class="card-body">

    <div class="mb-7">
        <div class="row align-items-center">
            <div class="col-lg-9 col-xl-8">
                <div class="row align-items-center">
                    <div class="col-md-4 my-2 my-md-0">
                        <div class="input-icon">
                            <input type="text" class="form-control" placeholder="Search..."
                                id="kt_datatable_search_query" />
                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                <a href="#" class="btn btn-light-primary px-6 font-weight-bold">
                    Search
                </a>
            </div>
        </div>
    </div>
    <!--end::Search Form-->
    <!--end: Search Form-->
    <!--begin: Datatable-->
    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
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
                source: BASE_URL + 'penjualan/json',
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
                    template: function(row){
							return 'QG-'+row.no_faktur+'-'+row.id_penjualan;
						}
                }, {
                    field: 'qty',
                    title: 'Total Barang',
                }, {
                    field: 'total',
                    title: 'Total Penjualan',
                    template: function(row) {
							return 'Rp. <span style="text-align: right;">'+ new Intl.NumberFormat(['ban', 'id']).format(row.total)+'</span>';
						}
                }, {
                    field: 'action',
                    title: 'Aksi',
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
</script>