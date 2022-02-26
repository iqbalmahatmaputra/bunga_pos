<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Penjualan_model extends CI_Model
{

    public $table = 'penjualan';
    public $table2 = 'v_report_produk';
    public $id2 = 'id_produk';
    public $id = 'id_penjualan';
    public $no_faktur = 'no_faktur';
    public $order = 'DESC';

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

    }

    // datatables
    public function json()
    {
        $this->datatables->select('id_penjualan,tanggal_penjualan,no_faktur,id_user,total,qty,tujuan');
        $this->datatables->from('penjualan');
        // $this->datatables->where('tujuan','pembeli');
        //add this line for join
        //$this->datatables->join('table2', 'penjualan.field = table2.field');
        $this->datatables->add_column('action',anchor(site_url('produk_retur/create/$2'), 'Retur','onclick="javasciprt: return confirm(\'Apakah anda YAKIN ingin meretur Faktur ini ?\')"') . " | " .anchor(site_url('produk_penjualan/finish/$1'), 'Print') . " | " . anchor(site_url('penjualan/read/$1'), 'Read'), 'id_penjualan,no_faktur');
        // $this->datatables->add_column('action',anchor(site_url('produk_penjualan/finish/$1'), 'Print') . " | " . anchor(site_url('penjualan/read/$1'), 'Read') . " | " . anchor(site_url('penjualan/update/$1'), 'Update') . " | " . anchor(site_url('penjualan/delete/$1'), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_penjualan');
        return $this->datatables->generate();
    }
    public function json2()
    {
        $this->datatables->select('id_penjualan,id_produk,kode_produk,nama_produk,no_faktur,tanggal_penjualan,qty,(total_harga*qty) as total_harga');
        $this->datatables->from('v_report_produk');

        return $this->datatables->generate();
    }
    public function jsonRange($tanggal_mulai,$tanggal_selesai)
    {
        // $this->db->query(' id_produk,kode_produk,tanggal_penjualan,no_faktur,qty,total_harga where tanggal_penjualan BETWEEN '.$data['tanggal_mulai'].' AND '.$data['tanggal_selesai'].'from v_report_produk');
        // $this->db->select('*');
        // $this->db->WHERE('tanggal_penjualan BETWEEN '.$data['tanggal_mulai'].' AND '.$data['tanggal_selesai']);
//         $this->db->where('tanggal_penjualan >=',$data['tanggal_mulai']);
// $this->db->where('tanggal_penjualan <=',$data['tanggal_selesai']);
        // $this->db->from('v_report_produk');
        // return $this->db->from('v_report_produk');
        
         $query = $this->db->get("SELECT * FROM v_report_produk WHERE tanggal_penjualan between '$tanggal_mulai' AND '$tanggal_selesai' ORDER BY tanggal_penjualan ASC");
         
         
        
         if ($query->num_rows() > 0) {
            return json_encode($query->result());
        } else {
            return "No data found";
        }

        // $this->db->from('v_report_produk');
        //add this line for join
        //$this->datatables->join('table2', 'penjualan.field = table2.field');
        // $this->datatables->add_column('action', anchor(site_url('penjualan/read/$1'), 'Read') . " | " . anchor(site_url('penjualan/update/$1'), 'Update') . " | " . anchor(site_url('penjualan/delete/$1'), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_penjualan');
        // return $this->db->get()->result();
        // return $this->datatables->generate();
    }
    public function get_last_data(){
        // $query = $this->db->query("SELECT no_faktur FROM penjualan ORDER BY no_faktur DESC");
        // $result = $query->result();

        $this->db->from("penjualan");
$this->db->order_by("id_penjualan", "desc");
$query = $this->db->get(); 
$cari= $query->row();
  
        // $tmp = (int($result->no_faktur)) + 1;
        $noUrut = (int) substr($cari->no_faktur, 5, 5);
        $noUrut++;
        $tgl=date('dmY');
        $nomor = $tgl. sprintf("%05s", $noUrut);
   
        return $nomor;

    }
    // get all
    public function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    public function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    public function get_by_no_faktur($no_faktur)
    {
        $this->db->where($this->no_faktur, $no_faktur);
        return $this->db->get($this->table)->row();
    }
    public function get_by_id_produk($id_produk)
    {
        $this->db->where($this->id2, $id_produk);
        // $this->db->get_where('v_report_produk',array('id_produk'=>$id_produk));
        return $this->db->get($this->table2)->row();
    }


    // get total rows
    public function total_rows($q = null)
    {
        $this->db->like('id_penjualan', $q);
        $this->db->or_like('tanggal_penjualan', $q);
        $this->db->or_like('no_faktur', $q);
        $this->db->or_like('id_user', $q);
        $this->db->or_like('total', $q);
        $this->db->or_like('qty', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    public function get_limit_data($limit, $start = 0, $q = null)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_penjualan', $q);
        $this->db->or_like('tanggal_penjualan', $q);
        $this->db->or_like('no_faktur', $q);
        $this->db->or_like('id_user', $q);
        $this->db->or_like('total', $q);
        $this->db->or_like('qty', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    public function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    public function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Penjualan_model.php */
/* Location: ./application/models/Penjualan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:12 */
/* http://harviacode.com */