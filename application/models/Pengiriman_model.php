<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pengiriman_model extends CI_Model
{

    public $table = 'pengiriman';
    public $table2 = 'v_kirim_jual';
    public $id = 'id_kirim';
    public $order = 'DESC';

    public function __construct()
    {
        parent::__construct();
    }

    // datatables
    public function json()
    {
        $this->datatables->select('id_kirim, tanggal_penjualan, tanggal_kirim, no_faktur, tujuan, alamat, no_hp, petugas ');
        $this->datatables->from('v_kirim_jual');
        //add this line for join
        // $this->datatables->join('produk', 'produk_stok.id_pengiriman = produk.id_produk');
        $this->datatables->add_column('action', anchor(site_url('pengiriman/read/$1'), 'Read') . " | " . anchor(site_url('pengiriman/finish/$1'), 'Cetak') . " | " . anchor(site_url('pengiriman/delete/$1'), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_kirim');
        return $this->datatables->generate();
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
    public function get_by_id_v($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table2)->row();
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

/* End of file Produk_stok_model.php */
/* Location: ./application/models/Produk_stok_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:23 */
/* http://harviacode.com */