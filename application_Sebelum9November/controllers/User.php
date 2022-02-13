<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('User_model');
        $this->load->library('form_validation');

        if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('/');
        }        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('user/user_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->User_model->json();
    }

    public function read($id) 
    {
        $row = $this->User_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_user' => $row->id_user,
		'nama_user' => $row->nama_user,
		'password' => $row->password,
		// 'foto' => $row->foto,
		'telfon' => $row->telfon,
		'created_at' => $row->created_at,
		'is_active' => $row->is_active,
		'status' => $row->status,
	    );
            $this->load->view('user/user_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('user/create_action'),
	    'id_user' => set_value('id_user'),
	    'nama_user' => set_value('nama_user'),
	    'password' => set_value('password'),
	    // 'foto' => set_value('foto'),
	    'telfon' => set_value('telfon'),
	    'created_at' => set_value('created_at'),
	    'is_active' => set_value('is_active'),
	    'status' => set_value('status'),
	);
        $this->load->view('user/user_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_user' => $this->input->post('nama_user',TRUE),
		'password' => $this->input->post('password',TRUE),
		// 'foto' => $this->input->post('foto',TRUE),
		'telfon' => $this->input->post('telfon',TRUE),
		'created_at' => $this->input->post('created_at',TRUE),
		'is_active' => $this->input->post('is_active',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );
        $hal = array(
            'kegiatan' => "Menambahkan User baru dengan nama ".$data['nama_user'],

        );
            $this->Activity_model->insert($hal);
            $this->User_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dimasukkan</div>');
            redirect(site_url('user'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('user/update_action'),
		'id_user' => set_value('id_user', $row->id_user),
		'nama_user' => set_value('nama_user', $row->nama_user),
		'password' => set_value('password', $row->password),
		// 'foto' => set_value('foto', $row->foto),
		'telfon' => set_value('telfon', $row->telfon),
		// 'created_at' => set_value('created_at', $row->created_at),
		'is_active' => set_value('is_active', $row->is_active),
		'status' => set_value('status', $row->status),
	    );
            $this->load->view('user/user_form', $data);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Tidak ditemukan</div>
            ');
            redirect(site_url('user'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_user', TRUE));
        } else {
            $data = array(
		'nama_user' => $this->input->post('nama_user',TRUE),
		'password' => $this->input->post('password',TRUE),
		// 'foto' => $this->input->post('foto',TRUE),
		'telfon' => $this->input->post('telfon',TRUE),
		// 'created_at' => $this->input->post('created_at',TRUE),
		'is_active' => $this->input->post('is_active',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );
        $hal = array(
            'kegiatan' => "Mengubah data user ".$data['nama_user'],

        );
            $this->Activity_model->insert($hal);
            $this->User_model->update($this->input->post('id_user', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil diubah</div>');
            redirect(site_url('user'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            $this->User_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dihapus</div>');
            redirect(site_url('user'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Tidak ditemukan</div>');
            redirect(site_url('user'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_user', 'nama user', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');
	// $this->form_validation->set_rules('foto', 'foto', 'trim|required');
	$this->form_validation->set_rules('telfon', 'telfon', 'trim|required');
	// $this->form_validation->set_rules('created_at', 'created at', 'trim|required');
	$this->form_validation->set_rules('is_active', 'is active', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id_user', 'id_user', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:39 */
/* http://harviacode.com */