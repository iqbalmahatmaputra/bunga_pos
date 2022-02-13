<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk_promo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Produk_promo_model');
        $this->load->library('form_validation');

        if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('/');
        }        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('produk_promo/produk_promo_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Produk_promo_model->json();
    }

    public function read($id) 
    {
        $row = $this->Produk_promo_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_produk_promo' => $row->id_produk_promo,
		'id_produk' => $row->id_produk,
		'id_promo' => $row->id_promo,
	    );
            $this->load->view('produk_promo/produk_promo_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_promo'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('produk_promo/create_action'),
	    'id_produk_promo' => set_value('id_produk_promo'),
	    'id_produk' => set_value('id_produk'),
	    'id_promo' => set_value('id_promo'),
	);
        $this->load->view('produk_promo/produk_promo_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_produk' => $this->input->post('id_produk',TRUE),
		'id_promo' => $this->input->post('id_promo',TRUE),
	    );

            $this->Produk_promo_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('produk_promo'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Produk_promo_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('produk_promo/update_action'),
		'id_produk_promo' => set_value('id_produk_promo', $row->id_produk_promo),
		'id_produk' => set_value('id_produk', $row->id_produk),
		'id_promo' => set_value('id_promo', $row->id_promo),
	    );
            $this->load->view('produk_promo/produk_promo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_promo'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_produk_promo', TRUE));
        } else {
            $data = array(
		'id_produk' => $this->input->post('id_produk',TRUE),
		'id_promo' => $this->input->post('id_promo',TRUE),
	    );

            $this->Produk_promo_model->update($this->input->post('id_produk_promo', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('produk_promo'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Produk_promo_model->get_by_id($id);

        if ($row) {
            $this->Produk_promo_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('produk_promo'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_promo'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_produk', 'id produk', 'trim|required');
	$this->form_validation->set_rules('id_promo', 'id promo', 'trim|required');

	$this->form_validation->set_rules('id_produk_promo', 'id_produk_promo', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Produk_promo.php */
/* Location: ./application/controllers/Produk_promo.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:27 */
/* http://harviacode.com */