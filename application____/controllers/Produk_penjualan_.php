<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produk_penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Produk_penjualan_model');
        $this->load->model('Penjualan_model');

        $this->load->library('form_validation');

        if (!$this->session->userdata('logined') || $this->session->userdata('logined') != true) {
            redirect('/');
        }
        $this->load->library('datatables');
    }
    public function selesai()
    {
        // print_r($_REQUEST);
        $id = $_REQUEST['id_penjualan'];
        $id_user = $this->input->post('id_user', true);
       
        for ($i = 0; $i < count($_REQUEST['id_produk']); $i++) {
            $data = array(
                'id_penjualan' => $this->input->post('id_penjualan', true),
                'id_produk' => $_REQUEST['id_produk'][$i],
                'qty' => $_REQUEST['jumlah'][$i],
                'total_harga' => str_replace(".", "", $_REQUEST['harga'][$i]),
            );

            $this->Produk_penjualan_model->insert($data);

        }
        $this->db->where("id_user",$id_user);
        $nama=$this->db->get("user")->row();
        echo '
        <style>table,p{font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;}</style>
        <table style="text-transform: capitalize;height: 59px; margin-left: auto; margin-right: auto; width: 1046px;">
<tbody>
<tr style="height: 88px;">
<td style="width: 782px; height: 88px;">
<h1><strong><a href="'.site_url('/penjualan').'">Queen Gallery</a></strong></h1>
<p><strong>Jl. Hang Tuah Ujung No. 276B Pekanbaru - HP 0852 9476 3855</strong></p>
<p>&nbsp;</p>
</td>
<td style="width: 248px; height: 88px;">
<p><strong>Tgl.</strong> ' . date('d-m-Y') . '</p>
<p><strong>No Faktur.&nbsp;</strong> QG-' . $_REQUEST['no_faktur'] . '</p>
<p><strong>Petugas&nbsp;</strong>    ' .$nama->nama_user . '</p>
</td>
</tr>
</tbody>
</table>
<table style="height: 77px; width: 1046px;">
<tbody>
<tr style="border-bottom: 1px solid #000;border-top: 1px solid #000;">
<td style="width: 23px; text-align: center;"><strong>No</strong></td>
<td style="width: 380px; text-align: center;"><strong>Nama Barang</strong></td>
<td style="width: 87px; text-align: center;"><strong>Qty</strong></td>
<td style="width: 214px; text-align: center;"><strong>Harga</strong></td>
<td style="width: 308px; text-align: center;"><strong>Jumlah</strong></td>
</tr>
';
        $total = 0;
        for ($i = 0; $i < count($_REQUEST['id_produk']); $i++) {
            $this->db->where('id_produk', $_REQUEST['id_produk'][$i]);
            $produk = $this->db->get('produk')->row();
            $jumlah_harga = str_replace(".", "", $_REQUEST['harga'][$i]) * $_REQUEST['jumlah'][$i];
            $total += $jumlah_harga;
            echo '<tr>
<td style="width: 23px;text-align: center;">' . ($i + 1) . '</td>
<td style="width: 380px;text-align: center;"><span style="text-transform: uppercase;">'.$produk->kode_produk.'</span> | <span style="text-transform: capitalize;">' . $produk->nama_produk . '</span></td>
<td style="width: 87px;text-align: center;">' . $_REQUEST['jumlah'][$i] . '</td>
<td style="width: 214px;text-align: center;">' . number_format(str_replace(".", "", $_REQUEST['harga'][$i]), 0, ".", ".") . '</td>
<td style="width: 308px;text-align: center;">' . number_format($jumlah_harga, 0, ".", ".") . '</td>
</tr>
';

            // $this->Produk_penjualan_model->insert($data);

        }
        $data = array(
            'id_user' => $_REQUEST['id_user'],
            'total' => $total,
            'qty' => array_sum($_REQUEST['jumlah']),
        );
        // print_r($data);
        $this->Penjualan_model->update($id, $data);
        echo
        '
        <tr  style="border-bottom: 1px solid #000;">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td></tr>
    <tr>
    <td style="width: 23px;text-align: center;"></td>
    <td colspan="2" style="width: 380px;text-align: center;">Barang yang sudah dibeli tidak dapat dikembalikan / ditukar.</td>
    <td style="width: 214px;text-align: right;"><p><strong>Jumlah</strong></p></td>
    <td style="width: 308px;text-align: center;"><strong>' . number_format($total, 0, ".", ".") . '</strong></td>
    </tr>
    <tr>
    <td style="width: 23px;text-align: center;"></td>
    <td colspan="2" style="width: 380px;text-align: center;">Terima Kasih Atas Kepercayaan Anda.</td>
    <td style="width: 214px;text-align: right;"><strong>Bayar</strong></td>
    <td style="width: 308px;text-align: center;"></td>
    </tr>
    <tr>
    <td style="width: 23px;text-align: center;"></td>
    <td style="width: 380px;text-align: center;"></td>
    <td style="width: 87px;text-align: center;"></td>
    <td style="width: 214px;text-align: right;"><strong>Sisa</strong></td>
    <td style="width: 308px;text-align: center;"></td>
    </tr>
</tbody>
</table>
<table style="height: 38px;" width="1044">
<tbody>
<tr>
<td style="width: 514px; text-align: center;">
<p>Yang Menerima</p>

<p>(___________________)</p>
</td>
<td style="width: 514px;">
<p style="text-align: center;">Hormat Kami,</p>

<p style="text-align: center;">(___________________)</p>
</td>
</tr>
</tbody>
</table>
        ';
        // redirect(site_url('penjualan'));

    }
    public function finish($id_penjualan)
    {
        $this->db->where("id_penjualan",$id_penjualan);
        $penjualan=$this->db->get("penjualan")->row();
        $this->db->where("id_user",$penjualan->id_user);
        $nama=$this->db->get("user")->row();
        $this->db->where("id_penjualan",$id_penjualan);
        $produk =$this->db->get("v_penjualan_produk")->result();    
        echo '
        <style>table,p{font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;}</style>
        <table style="text-transform: capitalize;height: 59px; margin-left: auto; margin-right: auto; width: 1046px;">
<tbody>
<tr style="height: 88px;">
<td style="width: 782px; height: 88px;">
<h1><strong><a href="'.site_url('/penjualan').'">Queen Gallery</a></strong></h1>
<p><strong>Jl. Hang Tuah Ujung No. 276B Pekanbaru - HP 0852 9476 3855</strong></p>
<p>&nbsp;</p>
</td>
<td style="width: 248px; height: 88px;">
<p><strong>Tgl.</strong> ' .$penjualan->tanggal_penjualan. '</p>
<p><strong>No Faktur.&nbsp;</strong> QG-' .$penjualan->no_faktur . '</p>
<p><strong>Petugas&nbsp;</strong>    ' .$nama->nama_user . '</p>

</td>
</tr>
</tbody>
</table>
<table style="height: 77px; width: 1046px;" >
<tbody>
<tr style="border-bottom: 1px solid #000;border-top: 1px solid #000;">
<th style="width: 23px; text-align: center; "><strong>No</strong></th>
<th style="width: 380px; text-align: center; "><strong>Nama Barang</strong></th>
<th style="width: 87px; text-align: center; "><strong>Qty</strong></th>
<th style="width: 214px; text-align: center; "><strong>Harga</strong></th>
<th style="width: 308px; text-align: center; "><strong>Jumlah</strong></th>
</tr>
';
        $total = 0;
        // print_r($produk);
   foreach ($produk as $key => $value) {
       
            $this->db->where('id_produk', $value->id_produk);
            $produk = $this->db->get('produk')->row();
            $jumlah_harga = str_replace(".", "", $value->total_harga) * $value->qty;
            $total += $jumlah_harga;
            echo '<tr>
<td style="width: 23px;text-align: center;">' . ($key+ 1) . '</td>
<td style="width: 380px;text-align: center;"><span style="text-transform: uppercase;">'.$produk->kode_produk.'</span> | <span style="text-transform: capitalize;">' . $produk->nama_produk . '</span></td>
<td style="width: 87px;text-align: center;">' . $value->qty . '</td>
<td style="width: 214px;text-align: center;">' . number_format(str_replace(".", "", $value->total_harga), 0, ".", ".") . '</td>
<td style="width: 308px;text-align: center;">' . number_format($jumlah_harga, 0, ".", ".") . '</td>
</tr>
';

            // $this->Produk_penjualan_model->insert($data);

        }
      
        echo
        '
        <tr  style="border-bottom: 1px solid #000;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td></tr>
        <tr>
        <td style="width: 23px;text-align: center;"></td>
        <td colspan="2" style="width: 380px;text-align: center;">Barang yang sudah dibeli tidak dapat dikembalikan / ditukar.</td>
        <td style="width: 214px;text-align: right;"><p><strong>Jumlah</strong></p></td>
        <td style="width: 308px;text-align: center;"><strong>' . number_format($total, 0, ".", ".") . '</strong></td>
        </tr>
        <tr>
        <td style="width: 23px;text-align: center;"></td>
        <td colspan="2" style="width: 380px;text-align: center;">Terima Kasih Atas Kepercayaan Anda.</td>
        <td style="width: 214px;text-align: right;"><strong>Bayar</strong></td>
        <td style="width: 308px;text-align: center;"></td>
        </tr>
        <tr>
        <td style="width: 23px;text-align: center;"></td>
        <td style="width: 380px;text-align: center;"></td>
        <td style="width: 87px;text-align: center;"></td>
        <td style="width: 214px;text-align: right;"><strong>Sisa</strong></td>
        <td style="width: 308px;text-align: center;"></td>
        </tr>
</tbody>
</table>
&nbsp;

<table style="height: 38px;" width="1044">
<tbody>
<tr>
<td style="width: 514px; text-align: center;">
<p>Yang Menerima</p>

<p>(___________________)</p>
</td>
<td style="width: 514px;">
<p style="text-align: center;">Hormat Kami,</p>

<p style="text-align: center;">(___________________)</p>
</td>
</tr>
</tbody>
</table>
        ';
        // redirect(site_url('penjualan'));

    }
    public function index()
    {
        $this->load->view('produk_penjualan/produk_penjualan_list');
    }
    public function produk_faktur()
    {
        $this->load->view('produk_penjualan/produk_faktur');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Produk_penjualan_model->json();
    }
    public function data_json()
    {
        $produk_terjual = $this->db->query("select * from v_report_produk")->result();
            
        $data['draw'] = 0;
        $data['recordsTotal'] = count($produk_terjual);
        $data['recordsFiltered'] = count($produk_terjual);
        // print_r($produk_terjual);
        foreach ($produk_terjual as $key => $value) {
            $data['data'][$key]['tanggal_penjualan'] = $value->tanggal_penjualan;
            $data['data'][$key]['no_faktur'] = $value->no_faktur;
            $data['data'][$key]['qty'] = $value->qty;
            $data['data'][$key]['total_harga'] = $value->total_harga;

        }
        echo json_encode($data);

    }

    public function read($id)
    {
        $row = $this->Produk_penjualan_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_produk_penjualan' => $row->id_produk_penjualan,
                'id_penjualan' => $row->id_penjualan,
                'id_produk' => $row->id_produk,
                'qty' => $row->qty,
            );
            $this->load->view('produk_penjualan/produk_penjualan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_penjualan'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('produk_penjualan/create_action'),
            'id_produk_penjualan' => set_value('id_produk_penjualan'),
            'id_penjualan' => set_value('id_penjualan'),
            'id_produk' => set_value('id_produk'),
            'qty' => set_value('qty'),
        );
        $this->load->view('produk_penjualan/produk_penjualan_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $data = array(
                'id_penjualan' => $this->input->post('id_penjualan', true),
                'id_produk' => $this->input->post('id_produk', true),
                'qty' => $this->input->post('qty', true),
            );

            $this->Produk_penjualan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('produk_penjualan'));
        }
    }

    public function update($id)
    {
        $row = $this->Produk_penjualan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('produk_penjualan/update_action'),
                'id_produk_penjualan' => set_value('id_produk_penjualan', $row->id_produk_penjualan),
                'id_penjualan' => set_value('id_penjualan', $row->id_penjualan),
                'id_produk' => set_value('id_produk', $row->id_produk),
                'qty' => set_value('qty', $row->qty),
            );
            $this->load->view('produk_penjualan/produk_penjualan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_penjualan'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('id_produk_penjualan', true));
        } else {
            $data = array(
                'id_penjualan' => $this->input->post('id_penjualan', true),
                'id_produk' => $this->input->post('id_produk', true),
                'qty' => $this->input->post('qty', true),
            );

            $this->Produk_penjualan_model->update($this->input->post('id_produk_penjualan', true), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('produk_penjualan'));
        }
    }

    public function delete($id)
    {
        $row = $this->Produk_penjualan_model->get_by_id($id);

        if ($row) {
            $this->Produk_penjualan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('produk_penjualan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_penjualan'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_penjualan', 'id penjualan', 'trim|required');
        $this->form_validation->set_rules('id_produk', 'id produk', 'trim|required');
        $this->form_validation->set_rules('qty', 'qty', 'trim|required');

        $this->form_validation->set_rules('id_produk_penjualan', 'id_produk_penjualan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Produk_penjualan.php */
/* Location: ./application/controllers/Produk_penjualan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:30 */
/* http://harviacode.com */

