<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk_foto extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('Produk_foto_model');
        $this->load->library('form_validation');

        if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('/');
        }        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('produk_foto/produk_foto_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Produk_foto_model->json();
    }

    public function read($id) 
    {
        $row = $this->Produk_foto_model->get_by_id($id);
        $menu = $this->db->query("select p.nama_produk from produk_foto as v join produk as p ON v.id_produk = p.id_produk where v.id_produk=" . $id . "")->row();
        if ($row) {
            $data = array(
                'title' => "Read",
		'id_produk_foto' => $row->id_produk_foto,
		'foto_produk' => $row->foto_produk,
        'id_produk' => $row->id_produk,
        'menu' => $menu,
	    );
            $this->load->view('produk_foto/produk_foto_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_foto'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('produk_foto/create_action'),
	    'id_produk_foto' => set_value('id_produk_foto'),
	    'foto_produk' => set_value('foto_produk'),
	    'id_produk' => set_value('id_produk'),
	);
        $this->load->view('produk_foto/produk_foto_form', $data);
    }
    
    public function create_action() 
    {
        $config['upload_path']          = './uploads/';
         $config['file_name'] = 'galeri_' . time();
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10000;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('foto_produk'))
        {
                $error = array('error' => $this->upload->display_errors());
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());
                $dataFoto=$this->upload->data();
                $data = array(
                    'foto_produk' =>base_url()."uploads/".$dataFoto['orig_name'],
                    'id_produk' => $this->input->post('id_produk',TRUE),
                    );
                    $hal = array(
                        'kegiatan' => "Menambahkan Foto baru dengan kode ".$data['id_produk'],
            
                    );
                        $this->Activity_model->insert($hal);
                        $this->Produk_foto_model->insert($data);
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menambahkan data baru!</div>');
                         redirect(site_url('produk_foto'));
        }
            
           
        
    }
    
    public function update($id) 
    {
        $row = $this->Produk_foto_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('produk_foto/update_action'),
		'id_produk_foto' => set_value('id_produk_foto', $row->id_produk_foto),
		'foto_produk' => set_value('foto_produk', $row->foto_produk),
		'id_produk' => set_value('id_produk', $row->id_produk),
	    );
            $this->load->view('produk_foto/produk_foto_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_foto'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        // if ($this->form_validation->run() == FALSE) {
        //     $this->update($this->input->post('id_produk_foto', TRUE));
        // } else {
        //     $data = array(
		// 'foto_produk' => $this->input->post('foto_produk',TRUE),
		// 'id_produk' => $this->input->post('id_produk',TRUE),
        // );
        if (!empty($_FILES["foto"]["name"])) {
            $row = $this->Galeri_model->get_by_id($this->input->post('id', true));

            if ($row->foto != "default.jpg") {
                $filename = explode(".", $row->foto)[0];
                array_map('unlink', glob(FCPATH . "uploads/$filename.*"));
            }
            $data = array(
                'foto_produk' => $this->input->post('foto_produk',TRUE),
                'id_produk' => $this->input->post('id_produk',TRUE),
                );
        } else {
            $data = array(
                'id_produk' => $this->input->post('id_produk',TRUE),

            );

        }
        $hal = array(
            'kegiatan' => "Merubah Foto dengan kode ".$data['id_produk'],

        );
            $this->Activity_model->insert($hal);
            $this->Produk_foto_model->update($this->input->post('id_produk_foto', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil diubah !</div>');
            redirect(site_url('produk_foto'));
        
    }
    
    public function delete($id) 
    {
        $row = $this->Produk_foto_model->get_by_id($id);

        // if ($row) {
        //     $this->Produk_foto_model->delete($id);
        //     $this->session->set_flashdata('message', 'Delete Record Success');
        //     redirect(site_url('produk_foto'));
        // } else {
        //     $this->session->set_flashdata('message', 'Record Not Found');
        //     redirect(site_url('produk_foto'));
        // }
        if ($row) {
            if ($row->foto != "default.jpg") {
                $filename = explode(".", $row->foto)[0];
                array_map('unlink', glob(FCPATH . "uploads/$filename.*"));
            }
            $this->Galeri_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil dihapus !</div>');
            redirect(site_url('produk_foto'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_foto'));
        }
    }
    private function _uploadImage()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = 'galeri_' . time();
        $config['overwrite'] = true;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_produk')) {
            $data = $this->upload->data();
            return $data['file_name'];
        }

        return "default_dj.jpg";
    }

    public function _rules() 
    {
    }

}

/* End of file Produk_foto.php */
/* Location: ./application/controllers/Produk_foto.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:34 */
/* http://harviacode.com */