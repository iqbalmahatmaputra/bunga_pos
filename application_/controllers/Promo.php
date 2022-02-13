<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Promo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Promo_model');
        $this->load->library('form_validation');

        if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('/');
        }        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('promo/promo_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        $data=json_decode($this->Promo_model->json());
        echo json_encode($data->data);
    }

    public function read($id) 
    {
        $row = $this->Promo_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_promo' => $row->id_promo,
		'nama_promo' => $row->nama_promo,
		'tanggal_mulai' => $row->tanggal_mulai,
		'tanggal_akhir' => $row->tanggal_akhir,
		'kode_promo' => $row->kode_promo,
		'status' => $row->status,
		'harga_potongan' => $row->harga_potongan,
	    );
            $this->load->view('promo/promo_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('promo'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('promo/create_action'),
	    'id_promo' => set_value('id_promo'),
	    'nama_promo' => set_value('nama_promo'),
	    'tanggal_mulai' => set_value('tanggal_mulai'),
	    'tanggal_akhir' => set_value('tanggal_akhir'),
	    'kode_promo' => set_value('kode_promo'),
	    'status' => set_value('status'),
	    'harga_potongan' => set_value('harga_potongan'),
	);
        $this->load->view('promo/promo_form', $data);
    }
    
    public function create_action() 
    {
        $tanggal=explode(' - ',str_replace("/","-",$this->input->post('tanggal',TRUE)));
        $tanggal_mulai=date_format(date_create($tanggal[0]),"Y-m-d");
        $tanggal_akhir=date_format(date_create($tanggal[0]),"Y-m-d");
        
        
            $data = array(
		'nama_promo' => $this->input->post('nama_promo',TRUE),
		'tanggal_mulai' => $tanggal_mulai,
		'tanggal_akhir' => $tanggal_akhir,
		'kode_promo' => $this->input->post('kode_promo',TRUE),
		'status' => $this->input->post('status',TRUE),
		'harga_potongan' => $this->input->post('harga_potongan',TRUE),
	    );

            $this->Promo_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('promo'));
        
    }
    
    public function update($id) 
    {
        $row = $this->Promo_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('promo/update_action'),
		'id_promo' => set_value('id_promo', $row->id_promo),
		'nama_promo' => set_value('nama_promo', $row->nama_promo),
		'tanggal_mulai' => set_value('tanggal_mulai', $row->tanggal_mulai),
		'tanggal_akhir' => set_value('tanggal_akhir', $row->tanggal_akhir),
		'kode_promo' => set_value('kode_promo', $row->kode_promo),
		'status' => set_value('status', $row->status),
		'harga_potongan' => set_value('harga_potongan', $row->harga_potongan),
	    );
            $this->load->view('promo/promo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('promo'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_promo', TRUE));
        } else {
            $data = array(
		'nama_promo' => $this->input->post('nama_promo',TRUE),
		'tanggal_mulai' => $this->input->post('tanggal_mulai',TRUE),
		'tanggal_akhir' => $this->input->post('tanggal_akhir',TRUE),
		'kode_promo' => $this->input->post('kode_promo',TRUE),
		'status' => $this->input->post('status',TRUE),
		'harga_potongan' => $this->input->post('harga_potongan',TRUE),
	    );

            $this->Promo_model->update($this->input->post('id_promo', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('promo'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Promo_model->get_by_id($id);

        if ($row) {
            $this->Promo_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('promo'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('promo'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_promo', 'nama promo', 'trim|required');
	$this->form_validation->set_rules('tanggal_mulai', 'tanggal mulai', 'trim|required');
	$this->form_validation->set_rules('tanggal_akhir', 'tanggal akhir', 'trim|required');
	$this->form_validation->set_rules('kode_promo', 'kode promo', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('harga_potongan', 'harga potongan', 'trim|required');

	$this->form_validation->set_rules('id_promo', 'id_promo', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Promo.php */
/* Location: ./application/controllers/Promo.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 02:15:57 */
/* http://harviacode.com */