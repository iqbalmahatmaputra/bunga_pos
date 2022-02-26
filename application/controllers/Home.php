<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Activity_model');
    }

    public function index()
    {
		if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
		{
			redirect('/');
        }
       
        
        $data['total'] =  $this->_getTotal();
        $data['totalBulan'] =  $this->Activity_model->show_untung_bulan()->result();
        $data['today'] =  $this->_getTotalDay();
        $data['jumlah'] =  $this->_getTracDay();
        $data['nama'] =  $this->_getTerlaris();
        $data['larisbulan'] =  $this->_getTerlarisBulan();
        // $data['chartz'] =  $this->_getChart();
        $data['chart_data'] =  $this->_bar_chart();
        $data['user'] = $this->db->get_where('user', ['nama_user' => $this->session->userdata('nama_user')])->row_array();
		$data['activity'] = $this->Activity_model->show_all()->result();
        $this->load->view('home', $data);

        
    } 
    public function _getTotal(){
       $cek =  $this->db->query("select * from v_penjualan_produk")->result();
       $retur =  $this->db->query("select * from v_retur")->result();
       $oe = 0;
       foreach ($cek as $key => $value) {
       $jumlah = $value->qty * $value->total_harga;
    //    $retur = $this->db->query("select sum(qty) qty from v_retur WHERE no_faktur=" . $value->no_faktur. " GROUP BY no_faktur")->row();
    //    $returVal=0;
    //         if(empty($retur->qty)){
    //             $returVal=0;
    //         }else{
    //             $returVal=$retur->qty;
    //         }
       $oe += $jumlah;

    }
    foreach ($retur as $key => $value) {
        $re = $value->qty * $value->total_harga;
        $oe += $jumlah - $re;
 
     }
    if ($oe < 1000000) {
        // Anything less than a million
        $total = number_format($oe);
    } else if ($oe < 1000000000) {
        // Anything less than a billion
        $total = number_format($oe / 1000000, 2) . 'jt';
    } else {
        // At least a billion
        $total = number_format($oe / 1000000000, 2) . 'M';
    }
    $data = array (
        'total' => $total,
        'komplit' => number_format($oe, 0, ".", "."),
    );
    return $data;
    // return $total = number_format($total, 0, ".", ".");
             
    }
    
    public function _getTotalBulan(){
        $cek =  $this->db->query("select * from v_penjualan_produk where YEAR(tanggal_penjualan) = YEAR(CURDATE()) group by MONTH(tanggal_penjualan)")->result();
        // $retur =  $this->db->query("select * from v_retur group by MONTH(tanggal_retur)")->result();
        $oe = 0;
        foreach ($cek as $key => $value) {
        $jumlah = $value->qty * $value->total_harga;
        $oe += $jumlah;
 
     }
    
     if ($oe < 1000000) {
         // Anything less than a million
         $total = number_format($oe);
     } else if ($oe < 1000000000) {
         // Anything less than a billion
         $total = number_format($oe / 1000000, 2) . 'jt';
     } else {
         // At least a billion
         $total = number_format($oe / 1000000000, 2) . 'M';
     }
     $data = array (
         'total' => $total,
         'komplit_bulan' => number_format($oe, 0, ".", "."),
         'lengkap' => $cek,
     );
     return $data;
     // return $total = number_format($total, 0, ".", ".");
              
     }
    public function _getTotalDay(){
        $cek =  $this->db->query("select * from v_penjualan_produk where tanggal_penjualan >= CURDATE()")->result();
        $retur =  $this->db->query("select * from v_retur where tanggal_penjualan >= CURDATE()")->result();
        $totalDay = 0;
        foreach ($cek as $key => $value) {
        $jumlah = $value->qty * $value->total_harga;
        $totalDay += $jumlah;
 
     }
     foreach ($retur as $key => $value) {
        $re = $value->qty * $value->total_harga;
        $totalDay += $jumlah - $re;
        
     }
     if ($totalDay < 1000000) {
        // Anything less than a million
        $today = number_format($totalDay);
    } else if ($totalDay < 1000000000) {
        // Anything less than a billion
        $today = number_format($totalDay / 1000000, 2) . 'jt';
    } else {
        // At least a billion
        $today = number_format($totalDay / 1000000000, 2) . 'M';
    }
    
     return $today;
              
     }
     public function _getTracDay(){
        $jumlah =  $this->db->query("select * from v_penjualan_produk where tanggal_penjualan >= CURDATE()")->num_rows();
        return $jumlah;
     }

     public function _getTerlaris(){
        $laris =  $this->db->query("SELECT id_produk, SUM(qty) from v_penjualan_produk group by id_produk having SUM(qty) = (select MAX(total) from (select SUM(qty) total from v_penjualan_produk group by id_produk) tab)")->row();

        $this->db->where('id_produk', $laris->id_produk);
        $produk = $this->db->get('produk')->row();
        $nama = $produk->kode_produk;
        return $nama;
        // sql 
        // SELECT DATE(FROM_UNIXTIME(tanggal_penjualan)) AS ForDate,tanggal_penjualan,count(*) FROM `v_penjualan_produk` GROUP BY DATE(tanggal_penjualan) ORDER BY ForDate
     }
     public function _getTerlarisBulan(){

        $laris =  $this->db->query("SELECT id_produk, SUM(qty) from v_penjualan_produk group by id_produk having SUM(qty) = (select MAX(total) from (select SUM(qty) total from v_penjualan_produk  group by id_produk) tab)")->result();
        // WHERE month(tanggal_penjualan) = $bulan and year(tanggal_penjualan) = $tahun 
foreach ($laris as $key => $value) {
    # code...
    $this->db->where('id_produk', $value->id_produk);
    $produk = $this->db->get('produk')->row();
    $nama = $produk->kode_produk;
    return $nama;
    
}
     
        // sql 
        // SELECT DATE(FROM_UNIXTIME(tanggal_penjualan)) AS ForDate,tanggal_penjualan,count(*) FROM `v_penjualan_produk` GROUP BY DATE(tanggal_penjualan) ORDER BY ForDate
     }

     public function _getChart(){
        // $chartz =  $this->db->query("SELECT DATE(FROM_UNIXTIME(tanggal_penjualan)) AS ForDate,tanggal_penjualan,count(*) as jumlah FROM `v_penjualan_produk` GROUP BY DATE(tanggal_penjualan) ORDER BY ForDate")->result();
        $chartz =  $this->db->query("SELECT id_produk,SUM(qty) AS stok FROM v_penjualan_produk GROUP BY id_produk")->result();
        return $chartz;
     }
     public function _bar_chart() {
        $query =  $this->db->query('SELECT DATE_FORMAT(tanggal_penjualan, "%Y-%m-%d") AS `date`, COUNT(`tanggal_penjualan`) as count FROM v_penjualan_produk WHERE `tanggal_penjualan` >= NOW() - INTERVAL 3 MONTH GROUP BY `tanggal_penjualan` ORDER BY `tanggal_penjualan` ASC');
        $records = $query->result_array();
        $data = [];
        foreach($records as $row) {
  $data[] = ['date' => date('Y-m-t',strtotime($row['date'])), 'count' =>$row['count']];
        }
        $chart_data = json_encode($data);
        return $chart_data;
      }  

     
}

/* End of file Workflows.php */
/* Location: ./application/controllers/Workflows.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-04-15 00:43:10 */
/* http://harviacode.com */