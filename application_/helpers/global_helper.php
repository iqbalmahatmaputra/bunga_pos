<?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");
	function generate_sidemenu()
	{
		return '
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/home').'" class="menu-link "><i
                                        class="menu-icon flaticon-home"></i><span class="menu-text">Dashboard</span></a>
							</li>
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/penjualan').'" class="menu-link "><i
                       class="menu-icon flaticon-cart"></i><span class="menu-text">Penjualan</span></a>
		</li>
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/report').'" class="menu-link "><i
                       class="menu-icon flaticon-cart"></i><span class="menu-text">Report</span></a>
		</li>
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/produk_stok').'" class="menu-link "><i
                       class="menu-icon flaticon-bag"></i><span class="menu-text">Produk Stok</span></a>
		</li>
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/produk').'" class="menu-link "><i
                       class="menu-icon flaticon-bag"></i><span class="menu-text">Produk</span></a>
		</li>
		
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/user').'" class="menu-link "><i
                       class="menu-icon flaticon-user"></i><span class="menu-text">User</span></a>
		</li>
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/pengiriman').'" class="menu-link "><i
		class="menu-icon flaticon-bag"></i><span class="menu-text">Pengiriman</span></a>
</li>

		';
	}
	function generate_sidemenu_biasa()
	{
		return '
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/home').'" class="menu-link "><i
                                        class="menu-icon flaticon-home"></i><span class="menu-text">Dashboard</span></a>
							</li>
	
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/report').'" class="menu-link "><i
                       class="menu-icon flaticon-cart"></i><span class="menu-text">Report</span></a>
		</li>
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/produk_stok').'" class="menu-link "><i
                       class="menu-icon flaticon-bag"></i><span class="menu-text">Produk Stok</span></a>
		</li>
		<li class="menu-item " aria-haspopup="true"><a href="'.site_url('/pengiriman').'" class="menu-link "><i
		class="menu-icon flaticon-bag"></i><span class="menu-text">Pengiriman</span></a>
</li>

		
		
		';
	}
