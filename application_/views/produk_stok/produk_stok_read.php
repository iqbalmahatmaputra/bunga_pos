<?php $this->load->view('templates/header');?>
<div class="row">
    <div class="col-lg-4">
        <!--begin::Mixed Widget 14-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">

                <div class="d-flex align-items-center">
                    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                        <div class="symbol-label" style="background-image:url('<?= $foto ?>')"></div>
                        <i class="symbol-badge bg-success"></i>
                    </div>
                    <div>
                        <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">
                            <?=$produk->nama_produk;?>
                        </a>
                        <div class="text-muted">
                            <?=$produk->deskripsi_produk;?>
                        </div>


                    </div>

                </div>
                <div class="py-9">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="font-weight-bold mr-2">Harga Jual:</span>
                        <a href="#" class="text-muted text-hover-primary">Rp.<?=$produk->harga_jual_produk;?></a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="font-weight-bold mr-2">Harga Beli:</span>
                        <span class="text-muted">Rp.<?=$produk->harga_beli_produk;?></span>
                    </div>
                </div>

            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body d-flex flex-column">
                <div class="navi navi-bold navi-hover navi-active navi-link-rounded">

                    <div class="navi-item mb-2">
                        <a href="custom/apps/profile/profile-1/change-password.html" class="navi-link py-4 ">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Shopping\Box3.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M20.4061385,6.73606154 C20.7672665,6.89656288 21,7.25468437 21,7.64987309 L21,16.4115967 C21,16.7747638 20.8031081,17.1093844 20.4856429,17.2857539 L12.4856429,21.7301984 C12.1836204,21.8979887 11.8163796,21.8979887 11.5143571,21.7301984 L3.51435707,17.2857539 C3.19689188,17.1093844 3,16.7747638 3,16.4115967 L3,7.64987309 C3,7.25468437 3.23273352,6.89656288 3.59386153,6.73606154 L11.5938615,3.18050598 C11.8524269,3.06558805 12.1475731,3.06558805 12.4061385,3.18050598 L20.4061385,6.73606154 Z"
                                                fill="#000000" opacity="0.3" />
                                            <polygon fill="#000000"
                                                points="14.9671522 4.22441676 7.5999999 8.31727912 7.5999999 12.9056825 9.5999999 13.9056825 9.5999999 9.49408582 17.25507 5.24126912" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon--></span>
                            </span>
                            <span class="navi-text font-size-lg">
                                Total Seluruh Stok
                            </span>
                            <span class="navi-label">
                                <span
                                    class="label label-light-primary label-rounded"><?=$stok->jumlah_produk_stok?></span>
                            </span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="custom/apps/profile/profile-1/change-password.html" class="navi-link py-4 ">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Shopping\Cart1.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M18.1446364,11.84388 L17.4471627,16.0287218 C17.4463569,16.0335568 17.4455155,16.0383857 17.4446387,16.0432083 C17.345843,16.5865846 16.8252597,16.9469884 16.2818833,16.8481927 L4.91303792,14.7811299 C4.53842737,14.7130189 4.23500006,14.4380834 4.13039941,14.0719812 L2.30560137,7.68518803 C2.28007524,7.59584656 2.26712532,7.50338343 2.26712532,7.4104669 C2.26712532,6.85818215 2.71484057,6.4104669 3.26712532,6.4104669 L16.9929851,6.4104669 L17.606173,3.78251876 C17.7307772,3.24850086 18.2068633,2.87071314 18.7552257,2.87071314 L20.8200821,2.87071314 C21.4717328,2.87071314 22,3.39898039 22,4.05063106 C22,4.70228173 21.4717328,5.23054898 20.8200821,5.23054898 L19.6915238,5.23054898 L18.1446364,11.84388 Z"
                                                fill="#000000" opacity="0.3" />
                                            <path
                                                d="M6.5,21 C5.67157288,21 5,20.3284271 5,19.5 C5,18.6715729 5.67157288,18 6.5,18 C7.32842712,18 8,18.6715729 8,19.5 C8,20.3284271 7.32842712,21 6.5,21 Z M15.5,21 C14.6715729,21 14,20.3284271 14,19.5 C14,18.6715729 14.6715729,18 15.5,18 C16.3284271,18 17,18.6715729 17,19.5 C17,20.3284271 16.3284271,21 15.5,21 Z"
                                                fill="#000000" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon--></span>
                            </span>
                            <span class="navi-text font-size-lg">
                                Jumlah Item Terjual
                            </span>
                            <span class="navi-label">
                                <span
                                    class="label label-light-primary label-rounded"><?=(empty($penjualan_total->qty)) ? "0" : $penjualan_total->qty?></span>
                            </span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="custom/apps/profile/profile-1/change-password.html" class="navi-link py-4 ">
                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Shopping\Bag2.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M5.94290508,4 L18.0570949,4 C18.5865712,4 19.0242774,4.41271535 19.0553693,4.94127798 L19.8754445,18.882556 C19.940307,19.9852194 19.0990032,20.9316862 17.9963398,20.9965487 C17.957234,20.9988491 17.9180691,21 17.8788957,21 L6.12110428,21 C5.01653478,21 4.12110428,20.1045695 4.12110428,19 C4.12110428,18.9608266 4.12225519,18.9216617 4.12455553,18.882556 L4.94463071,4.94127798 C4.97572263,4.41271535 5.41342877,4 5.94290508,4 Z"
                                            fill="#000000" opacity="0.3" />
                                        <path
                                            d="M7,7 L9,7 C9,8.65685425 10.3431458,10 12,10 C13.6568542,10 15,8.65685425 15,7 L17,7 C17,9.76142375 14.7614237,12 12,12 C9.23857625,12 7,9.76142375 7,7 Z"
                                            fill="#000000" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon--></span>
                            <span class="navi-text font-size-lg">
                                Stok Tersedia
                            </span>
                            <span class="navi-label">
                                <span class="label label-light-success label-rounded font-weight-bold"><?=
(empty($penjualan_total->qty)) ? $stok->jumlah_produk_stok - 0 : $stok->jumlah_produk_stok - $penjualan_total->qty
?></span>
                            </span>
                        </a>
                    </div>

                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Mixed Widget 14-->
    </div>
    <div class="col-lg-8">
        <!--begin::Advance Table Widget 4-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">History Stok Produk</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">Jumlah History Stok
                        <?=count($stok_produk)?></span>
                </h3>

            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">

                <div class="tab-content">
                    <!--begin::Table-->

                    <div class="table-responsive">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah Stok</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
foreach ($stok_produk as $key => $value) {
    ?>
                                <tr>

                                    <td> <?=date('d F Y', strtotime($value->tanggal_produk_stok));
    ?></td>
                                    <td> <?=$value->jumlah_produk_stok?></td>

                                </tr>

                                <?php }?>
                            </tbody>

                        </table>
                    </div>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">History Penjualan Produk</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">Jumlah History Stok
                        <?=count($stok_produk)?></span>
                </h3>

            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">

                <div class="tab-content">
                    <!--begin::Table-->

                    <div class="table-responsive">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah Stok</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
foreach ($penjualan as $key => $value) {
    ?>
                                <tr>

                                    <td> <?=date('d F Y h:m:s', strtotime($value->tanggal_penjualan));
    ?></td>
                                    <td> <?=$value->qty?></td>

                                </tr>

                                <?php }?>
                            </tbody>

                        </table>
                    </div>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Advance Table Widget 4-->

    </div>
</div><?php $this->load->view('templates/footer');?>