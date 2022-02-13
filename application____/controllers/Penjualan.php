<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');


        $this->load->model('Penjualan_model');
        $this->load->library('form_validation');

        if (!$this->session->userdata('logined') || $this->session->userdata('logined') != true) {
            redirect('/');
        }
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('penjualan/penjualan_list');
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

    public function create($jenis = "")
    {
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
            'no_faktur' => $date->getTimestamp(),
            'id_user' => 1,
            'total' => 0,
            'qty' => 0,
            'jenis' => $jenis,
        );

        $this->Penjualan_model->insert($data);
        redirect(site_url('penjualan/invoice/' . $date->getTimestamp()));
        // $this->load->view('penjualan/penjualan_form', $data);

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