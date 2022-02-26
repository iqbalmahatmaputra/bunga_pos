<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produk_stok extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Produk_stok_model');
        $this->load->library('form_validation');

        if (!$this->session->userdata('logined') || $this->session->userdata('logined') != true) {
            redirect('/');
        }
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('produk_stok/produk_stok_list');
    }

    public function json()
    {

        $this->db->select('id_produk, kode_produk, nama_produk, sum(jumlah_produk_stok) jumlah_produk_stok');
        $this->db->group_by('id_produk');
        $stok = $this->db->get('v_produk_stok')->result();
        $data = [];
        foreach ($stok as $key => $value) {
            $terjual = $this->db->query("select sum(qty) qty from produk_penjualan WHERE id_produk=" . $value->id_produk . " GROUP BY id_produk")->row();
            $retur = $this->db->query("select sum(qty) qty from v_retur WHERE id_produk=" . $value->id_produk. " GROUP BY id_produk")->row();
            $returVal=0;
            if(empty($retur->qty)){
                $returVal=0;
            }else{
                $returVal=$retur->qty;
            }
            $jumTerjual = 0;
            if (empty($terjual)) {
                $stok = $value->jumlah_produk_stok - $jumTerjual +$returVal;
            } else {
                $jumTerjual = $terjual->qty;
                $stok = $value->jumlah_produk_stok - $terjual->qty +$returVal;

            }

            $status = "";
            if ($stok > 10) {
                $status = '<span><span class="label label-success label-dot mr-2"></span><span class="font-weight-bold text-success">Tersedia</span></span>';
            } else if ($stok <= 10 && $stok > 0) {
                $status = '<span><span class="label label-warning label-dot mr-2"></span><span class="font-weight-bold text-warning">Hampir Habis</span></span>';
            } else {
                $status = '<span><span class="label label-danger label-dot mr-2"></span><span class="font-weight-bold text-danger">Habis</span></span>';
            }
            $data[$key]['id_produk'] = $value->id_produk;
            $data[$key]['foto_produk'] = '';
            $data[$key]['produk'] = '
            <a class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">' . $value->nama_produk . '</a>
                            <div>
                                <span class="font-weight-bolder">Kode Produk:</span>
                                <a class="text-muted font-weight-bold text-hover-primary" href="#">' . $value->kode_produk . '</a>
                            </div>
                        </td>';
            $data[$key]['jumlah_produk_stok'] = $value->jumlah_produk_stok;
            $data[$key]['jumlah_terjual'] = $jumTerjual;
            $data[$key]['stok'] = $stok;
            $data[$key]['status'] = $status;
            $data[$key]['aksi'] = '<a href="' . base_url('produk_stok/read/' . $value->id_produk) . '" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                <span class="svg-icon svg-icon-md svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"></path>
        <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"></path>
    </g>
</svg><!--end::Svg Icon--></span>&nbsp;History Stok                            </a>';

        }
        echo json_encode($data);
    }

    public function read($id_produk)
    {
        
        $row = $this->db->query("select * from v_produk_stok where id_produk=" . $id_produk . " order by tanggal_produk_stok desc")->result();
        if ($row) {
            $produk = $this->db->query("select * from v_produk_stok where id_produk=" . $id_produk)->row();
            $produk_foto = $this->db->query("select foto_produk from produk where id_produk=" . $id_produk)->row();
            $stok = $this->db->query("select * from v_produk_stok_groupby where id_produk=" . $id_produk)->row();
            $penjualan = $this->db->query("select * from v_penjualan_produk where id_produk=" . $id_produk. " order by tanggal_penjualan desc")->result();
            $penjualanTotal = $this->db->query("select sum(qty) qty, sum(total_harga) total_harga from v_produk_penjualan where id_produk=" . $id_produk . " group by id_produk")->row();
            $retur = $this->db->query("select sum(qty) qty, tanggal_retur, no_faktur from v_retur where id_produk=" . $id_produk . " group by id_produk,no_faktur")->result();
            $returtotal = $this->db->query("select sum(qty) qty, tanggal_retur, no_faktur from v_retur where id_produk=" . $id_produk . " group by id_produk")->row();
            // $final_stok = (empty($penjualan_total->qty)) ? $stok->jumlah_produk_stok - 0 + $jum_retur : $stok->jumlah_produk_stok - $penjualan_total->qty + $jum_retur;
            $data = array(

                'stok_produk' => $row,
                'produk' => $produk,
                'stok' => $stok,
                'penjualan_total' => $penjualanTotal,
                'penjualan' => $penjualan,
                'foto'=> $produk_foto->foto_produk,
                'retur'=>$retur,
                'jum_retur'=>(empty( $returtotal->qty)) ? 0 : $returtotal->qty
            );
            $this->load->view('produk_stok/produk_stok_read', $data);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Tidak ditemukan</div>');
            redirect(site_url('produk_stok'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('produk_stok/create_action'),
            'id_produk_stok' => set_value('id_produk_stok'),
            'id_produk' => set_value('id_produk'),
            'tanggal_produk_stok' => set_value('tanggal_produk_stok'),
            'jumlah_produk_stok' => set_value('jumlah_produk_stok'),
            'keterangan' => set_value('keterangan'),
        );
        $this->load->view('produk_stok/produk_stok_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $data = array(
                'id_produk' => $this->input->post('id_produk', true),
                'tanggal_produk_stok' => $this->input->post('tanggal_produk_stok', true),
                'jumlah_produk_stok' => $this->input->post('jumlah_produk_stok', true),
                'keterangan' => $this->input->post('keterangan', true),
            );

            $this->Produk_stok_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data '.$data['id_produk'].' Berhasil dimasukkan</div>');
            redirect(site_url('produk_stok'));
        }
    }

    public function update($id)
    {
        $row = $this->Produk_stok_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('produk_stok/update_action'),
                'id_produk_stok' => set_value('id_produk_stok', $row->id_produk_stok),
                'id_produk' => set_value('id_produk', $row->id_produk),
                'tanggal_produk_stok' => set_value('tanggal_produk_stok', $row->tanggal_produk_stok),
                'jumlah_produk_stok' => set_value('jumlah_produk_stok', $row->jumlah_produk_stok),
            );
            $this->load->view('produk_stok/produk_stok_form', $data);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Tidak ditemukan</div>');
            redirect(site_url('produk_stok'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('id_produk_stok', true));
        } else {
            $data = array(
                'id_produk' => $this->input->post('id_produk', true),
                'tanggal_produk_stok' => $this->input->post('tanggal_produk_stok', true),
                'jumlah_produk_stok' => $this->input->post('jumlah_produk_stok', true),
            );

            $this->Produk_stok_model->update($this->input->post('id_produk_stok', true), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil diubah</div>');
            redirect(site_url('produk_stok'));
        }
    }

    public function delete($id)
    {
        $row = $this->Produk_stok_model->get_by_id($id);

        if ($row) {
            $this->Produk_stok_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dihapus</div>');
            redirect(site_url('produk_stok'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Tidak ditemukan</div>');
            redirect(site_url('produk_stok'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_produk', 'id produk', 'trim|required');
        $this->form_validation->set_rules('tanggal_produk_stok', 'tanggal produk stok', 'trim|required');
        $this->form_validation->set_rules('jumlah_produk_stok', 'jumlah produk stok', 'trim|required');

        $this->form_validation->set_rules('id_produk_stok', 'id_produk_stok', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Produk_stok.php */
/* Location: ./application/controllers/Produk_stok.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:23 */
/* http://harviacode.com */