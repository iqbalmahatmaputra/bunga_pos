<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Activity extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Activity_model');
        $this->load->model('Produk_model');
        $this->load->library('form_validation');

        if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('/');
        }        
	$this->load->library('datatables');
    }

    public function index()
    {
        $data['activity'] = $this->Activity_model->show_all()->result();
        $this->load->view('home', $data);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Produk_model->json();
    }
    public function get_data_json() {
        header('Content-Type: application/json');
        $nama= $this->input->get('nama_produk');
        $query = $this->Produk_model->get_nama($nama,'nama_produk');
        echo json_encode($query);

        echo $this->Produk_model->json();
    }

    public function read($id) 
    {
        $row = $this->Produk_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_produk' => $row->id_produk,
		'kode_produk' => $row->kode_produk,
		'nama_produk' => $row->nama_produk,
		'deskripsi_produk' => $row->deskripsi_produk,
		'harga_beli_produk' => $row->harga_beli_produk,
		'harga_jual_produk' => $row->harga_jual_produk,
		'status' => $row->status,
	    );
            $this->load->view('produk/produk_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('produk/create_action'),
	    'id_produk' => set_value('id_produk'),
	    'kode_produk' => set_value('kode_produk'),
	    'nama_produk' => set_value('nama_produk'),
	    'deskripsi_produk' => set_value('deskripsi_produk'),
	    'harga_beli_produk' => set_value('harga_beli_produk'),
	    'harga_jual_produk' => set_value('harga_jual_produk'),
        'status' => set_value('status'),
        'jenis' => 1,
	);
        $this->load->view('produk/produk_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        // berdasarkan 2 huruf
     $cek = $this->input->post('nama_produk',TRUE);
     $ambil2 = substr($cek,0,2);
     $cekId = $this->input->post('id_produk',TRUE);
 
     $kode = strtoupper($ambil2 . $cekId);

// berdasarkan huruf depan
$nama = $this->input->post('nama_produk',TRUE);
$pn = explode(" ", $nama);

if(empty($pn[0])){
$c1 = '';
}else{
$c1 = substr($pn[0],0,1);
}
if(empty($pn[1])){
$c2 = '';
}else{
$c2 = substr($pn[1],0,1);
}
if(empty($pn[2])){
$c3 = '';
}else{
$c3 = substr($pn[2],0,1);
}
$kode_ = strtoupper($c1.$c2.$c3.$cekId);
$kode_p = str_replace(' ', '', $kode_); 
// $this->db->select('count(kode_produk)');
// $this->db->from('produk');
// $this->db->like('kode_produk', $kode_);
// $kodee = $this->db->get();
$kodef = $this->Produk_model->get_kode($kode_p,'kode_produk');






        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_produk' => $kodef,
		'nama_produk' => $this->input->post('nama_produk',TRUE),
		'deskripsi_produk' => $this->input->post('deskripsi_produk',TRUE),
		'harga_beli_produk' => $this->input->post('harga_beli_produk',TRUE),
		'harga_jual_produk' => $this->input->post('harga_jual_produk',TRUE),
		'status' => $this->input->post('status',TRUE),
        );
        $hal = array(
            'kegiatan' => "Menambahkan produk baru dengan kode ".$kodef,

        );
            $this->Activity_model->insert($hal);
            $this->Produk_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menambahkan data baru!</div>');
            redirect(site_url('produk'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('produk/update_action'),
		'id_produk' => set_value('id_produk', $row->id_produk),
		'kode_produk' => set_value('kode_produk', $row->kode_produk),
		'nama_produk' => set_value('nama_produk', $row->nama_produk),
		'deskripsi_produk' => set_value('deskripsi_produk', $row->deskripsi_produk),
		'harga_beli_produk' => set_value('harga_beli_produk', $row->harga_beli_produk),
		'harga_jual_produk' => set_value('harga_jual_produk', $row->harga_jual_produk),
		'status' => set_value('status', $row->status),
	    );
            $this->load->view('produk/produk_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        $kode = $this->input->post('kode_produk',TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_produk', TRUE));
        } else {
            $data = array(
		'kode_produk' => $this->input->post('kode_produk',TRUE),
		'nama_produk' => $this->input->post('nama_produk',TRUE),
		'deskripsi_produk' => $this->input->post('deskripsi_produk',TRUE),
		'harga_beli_produk' => $this->input->post('harga_beli_produk',TRUE),
		'harga_jual_produk' => $this->input->post('harga_jual_produk',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );
        $hal = array(
            'kegiatan' => "Mengubah data produk dengan kode ".$kode,

        );
            $this->Activity_model->insert($hal);
            $this->Produk_model->update($this->input->post('id_produk', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil diubah !</div>');
            redirect(site_url('produk'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $this->Produk_model->delete($id);
            $hal = array(
                'kegiatan' => "Menghapus data produk dengan id ".$id,
    
            );
                $this->Activity_model->insert($hal);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil dihapus !</div>');
            redirect(site_url('produk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_produk', 'kode produk', 'trim');
	$this->form_validation->set_rules('nama_produk', 'nama produk', 'trim|required');
	$this->form_validation->set_rules('deskripsi_produk', 'deskripsi produk', 'trim|required');
	$this->form_validation->set_rules('harga_beli_produk', 'harga beli produk', 'trim|required');
	$this->form_validation->set_rules('harga_jual_produk', 'harga jual produk', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id_produk', 'id_produk', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:19 */
/* http://harviacode.com */