<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produk_retur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        
        $this->load->model('Penjualan_model');
        $this->load->model('Produk_retur_model');
        $this->load->model('Produk_stok_model');

        $this->load->library('form_validation');

        if (!$this->session->userdata('logined') || $this->session->userdata('logined') != true) {
            redirect('/');
        }
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('produk_retur/produk_retur_list');
    }

    public function json()
    {
        header('Content-Type: application/json');
        $data = json_decode($this->Penjualan_model->json());
        echo json_encode($data->data);
    }

    public function read($id)
    {
        $row = $this->Penjualan_model->get_by_id($id);
 
        if ($row) {
            $data['penjualan'] = $row;
            $this->load->view('penjualan/penjualan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }
    public function readFaktur($no_faktur){
        $row = $this->Penjualan_model->get_by_no_faktur($no_faktur);

        if ($row) {
            $data['penjualan'] = $row;
            $this->load->view('penjualan/penjualan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }
    public function _create($jenis = "")
    {
            $this->db->from("penjualan");
        $this->db->order_by("id_penjualan", "desc");
        $query = $this->db->get(); 
        $cari= $query->row();
        $noUrut = (int) substr($cari->no_faktur, 5, 5);
        $noUrut++;
        $tgl=date('dmY');
        $nomor = $tgl. sprintf("%05s", $noUrut);
        $data = array(
            'button' => 'Create',
            'action' => site_url('penjualan/create_action'),
            'id_penjualan' => set_value('id_penjualan'),
            'tanggal_penjualan' => set_value('tanggal_penjualan'),
            'no_faktur' => set_value('no_faktur'),
            'id_user' => set_value('id_user'),
            'total' => set_value('total'),
            'qty' => set_value('qty'),
        );
        $date = new DateTime();

        $data = array(
            'no_faktur' => $nomor,
            'id_user' => 1,
            'total' => 0,
            'qty' => 0,
            'jenis' => $jenis,
        );
        // var_dump($data);
        // die;

        $this->Penjualan_model->insert($data);
        redirect(site_url('penjualan/invoice/' . $nomor));
        // $this->load->view('penjualan/penjualan_form', $data);

    }

    public function create($no_invoice = "")
    {
        $data['penjualan'] = $this->db->query('select * from penjualan,user where penjualan.id_user=user.id_user and no_faktur=' . $no_invoice)->row();
        $barang = $this->db->query('select * from v_penjualan_produk where no_faktur = ' . $no_invoice)->result();
        $this->db->where("no_faktur",$no_invoice);
        $brg =$this->db->get("v_penjualan_produk")->result();    

        $this->db->set('tujuan', 'Sudah di Retur');
        $this->db->where("no_faktur",$no_invoice);
        $this->db->update('penjualan');
       
        // for ($i = 0; $i < count($brg); $i++) {
        // // echo "<br>a";
        
       
        // }
        foreach ($brg as $key => $value) {
           $data = array(

                'id_penjualan' => $value->id_penjualan,
                'id_produk' => $value->id_produk,
                'qty' => $value->qty,
                'total_harga' => $value->total_harga,
            );
        //    print_r($data['id_produk']);
        //    die;
        $hal = array(
            'kegiatan' => "Melakukan RETUR pada faktur ".$no_invoice,

        );
            $this->Activity_model->insert($hal);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil melakukan RETUR</div>');
            $this->Produk_retur_model->insert($data);
            //    print_r($data2);
            //    die;
        }
        // print_r($data['penjualan']);
        // print_r(count($brg));

        redirect(site_url('penjualan'));
    //    return $this->load->view('produk_retur/produk_retur_form',$data);

    }
    public function create2($no_invoice = "")
    {
        $data['penjualan'] = $this->db->query('select * from penjualan,user where penjualan.id_user=user.id_user and no_faktur=' . $no_invoice)->row();
        $barang = $this->db->query('select * from v_penjualan_produk where no_faktur = ' . $no_invoice)->result();
        $this->db->where("no_faktur",$no_invoice);
        $brg =$this->db->get("v_penjualan_produk")->result();    
       
        for ($i = 0; $i < count($brg); $i++) {
        echo "<br>a";
        }
        // print_r($data['penjualan']);
        // print_r(count($brg));

    //    return $this->load->view('produk_retur/produk_retur_form',$data);

    }

    public function invoice($no_invoice)
    {
        $data['penjualan'] = $this->db->query('select * from penjualan where no_faktur=' . $no_invoice)->row();
        // print_r($data['penjualan']);
        // die;
        $this->load->view('penjualan/penjualan_form', $data);
    }
    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $data = array(
                'tanggal_penjualan' => $this->input->post('tanggal_penjualan', true),
                'no_faktur' => $this->input->post('no_faktur', true),
                'id_user' => $this->input->post('id_user', true),
                'total' => $this->input->post('total', true),
                'qty' => $this->input->post('qty', true),
                'tujuan' => $this->input->post('tujuan', true),
            );
            $hal = array(
                'kegiatan' => "Melakukan transaksi ".$data['no_faktur'],
    
            );
                $this->Activity_model->insert($hal);

            $this->Penjualan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('penjualan'));
        }
    }
    public function selesai()
    {
        // print_r($_REQUEST);
        $id_penjualan = $_REQUEST['id_penjualan'];
        $id_produk = $_REQUEST['id_produk'];
       
        for ($i = 0; $i < count($_REQUEST['id_produk']); $i++) {
            $data = array(
                'id_penjualan' => $this->input->post('id_penjualan', true),
                'id_produk' => $_REQUEST['id_produk'][$i],
                'qty' => $_REQUEST['jumlah'][$i],
                'total_harga' => str_replace(".", "", $_REQUEST['harga'][$i]),
            );

            $this->Produk_retur_model->insert($data);

        }
        echo '
        <style>table,p{font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;}</style>
        <table style="text-transform: capitalize;height: 59px; margin-left: auto; margin-right: auto; width: 1046px;">
<tbody>
<tr style="height: 88px;">
<td style="width: 782px; height: 88px;">
<h1><strong><a href="'.site_url('/penjualan').'">Form Retur - Queen Gallery</a></strong></h1>
<p><strong>Jl. Hang Tuah Ujung No. 276B Pekanbaru - HP 0852 9476 3855</strong></p>
<p>&nbsp;</p>
</td>
<td style="width: 248px; height: 88px;">
<p><strong>Tgl.</strong> ' . date('d-m-Y') . '</p>
<p><strong>No Faktur.&nbsp;</strong> QG-' . $_REQUEST['no_faktur'] . '</p>
<p><strong>Petugas&nbsp;</strong>    ' .$_REQUEST['nama_user']. '</p>
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
    public function update($id)
    {
        $row = $this->Penjualan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('penjualan/update_action'),
                'id_penjualan' => set_value('id_penjualan', $row->id_penjualan),
                'tanggal_penjualan' => set_value('tanggal_penjualan', $row->tanggal_penjualan),
                'no_faktur' => set_value('no_faktur', $row->no_faktur),
                'id_user' => set_value('id_user', $row->id_user),
                'total' => set_value('total', $row->total),
                'qty' => set_value('qty', $row->qty),
            );
            $this->load->view('penjualan/penjualan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('id_penjualan', true));
        } else {
            $data = array(
                'tanggal_penjualan' => $this->input->post('tanggal_penjualan', true),
                'no_faktur' => $this->input->post('no_faktur', true),
                'id_user' => $this->input->post('id_user', true),
                'total' => $this->input->post('total', true),
                'qty' => $this->input->post('qty', true),
            );
            
            $this->Penjualan_model->update($this->input->post('id_penjualan', true), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('penjualan'));
        }
    }

    public function delete($id)
    {
        $row = $this->Penjualan_model->get_by_id($id);

        if ($row) {
            $this->Penjualan_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil dihapus !</div>');
            $hal = array(
                'kegiatan' => "Menghapus invoice sebelum jadi dengan nomor QG-".$row->no_faktur."-".$row->id_penjualan,
    
            );
                $this->Activity_model->insert($hal);
            redirect(site_url('penjualan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('tanggal_penjualan', 'tanggal penjualan', 'trim|required');
        $this->form_validation->set_rules('no_faktur', 'no faktur', 'trim|required');
        $this->form_validation->set_rules('id_user', 'id user', 'trim|required');
        $this->form_validation->set_rules('total', 'total', 'trim|required');
        $this->form_validation->set_rules('qty', 'qty', 'trim|required');

        $this->form_validation->set_rules('id_penjualan', 'id_penjualan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Penjualan.php */
/* Location: ./application/controllers/Penjualan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:12 */
/* http://harviacode.com */