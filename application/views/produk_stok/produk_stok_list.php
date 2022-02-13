<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
    <div class="col-md-4">
        <h2>Produk Stok List</h2>
    </div>
    <div class="col-md-4 text-center">
        <div id="message">
            <?php echo $this->session->userdata('message') != '' ? $this->session->userdata('message') : ''; ?>
        </div>
    </div>
    <div class="col-md-4 text-right">
        <div style="margin-top:20px;">
            <?php echo anchor(site_url('produk_stok/create'), 'Create', 'class="btn btn-primary"'); ?>
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
    <!--begin: Datatable-->
    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
    <!--end: Datatable-->
</div>
<!--end::Card-->
<?php $this->load->view('templates/footer');?><script type="text/javascript">
var KTDatatableJsonRemoteDemo = function() {
    // Private functions

    // basic demo
    var demo = function() {
        var datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: BASE_URL + 'produk_stok/json',
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
            columns: [{
                field: 'id_promo',
                title: '#',
                sortable: false,
                width: 20,
                type: 'number',
                selector: {
                    class: ''
                },
                textAlign: 'center',
            }, {
                field: 'produk',
                title: 'Nama Produk',
            }, {
                field: 'stok',
                title: 'Jumlah Stok',
            }, {
                field: 'status',
                title: 'Status Stok',
            }, {
                field: 'aksi',
                title: 'Aksi',
            }],

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