<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('Produk_model');
        $this->load->library('form_validation');

        if (!$this->session->userdata('logined') || $this->session->userdata('logined') != true) {
            redirect('/');
        }
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('produk/produk_list');
    }
    // public function list_produk($jenis = "")
    // {
    //     $selectData = '<select class="form-control selectpicker cam_select" data-size="7" data-live-search="true" name="id_produk[]" id="id_produk"><option value="">Pilih Produk</option>';
    //     $produks = $this->db->get("produk")->result();
    //     foreach ($produks as $key => $value) {
    //         $stok = $this->db->query("select * from v_stok where id_produk=" . $value->id_produk)->row();
    //         if (!empty($stok)) {
    //             if ($stok->final_stock != 0) {
    //                 if ($jenis != "supplier") {
    //                     $selectData .= '<option harga="' . $value->harga_jual_produk . '" stok="' . $stok->final_stock . '" value="' . $value->id_produk . '">' . $value->nama_produk . '</option>';
    //                 } else {
    //                     $selectData .= '<option harga="' . $value->harga_jual_produk_sup . '" stok="' . $stok->final_stock . '" value="' . $value->id_produk . '">' . $value->nama_produk . '</option>';
    //                 }

    //             }

    //         } else {
    //             $stok = $this->db->query("select * from v_produk_stok_groupby where id_produk=" . $value->id_produk)->row();
    //             if ($stok->jumlah_produk_stok != 0) {
    //                 if ($jenis != "supplier") {
    //                     $selectData .= '<option harga="' . $value->harga_jual_produk . '" stok="' . $stok->jumlah_produk_stok . '" value="' . $value->id_produk . '">' . $value->nama_produk . '</option>';
    //                 } else {
    //                     $selectData .= '<option harga="' . $value->harga_jual_produk_sup . '" stok="' . $stok->jumlah_produk_stok . '" value="' . $value->id_produk . '">' . $value->nama_produk . '</option>';
    //                 }

    //             }

    //         }

    //     }
    //     $selectData .= '</select>';
    //     echo $selectData;
    // }
      public function list_produk($jenis = "")
    {
        $selectData = '<select class="form-control selectpicker cam_select" data-size="7" data-live-search="true" name="id_produk[]" id="id_produk"><option value="">Pilih Produk</option>';
        $produks = $this->db->get("produk")->result();
        foreach ($produks as $key => $value) {
            $stok = $this->db->query("select * from v_stok where id_produk=" . $value->id_produk)->row();
            if (!empty($stok)) {
                if ($stok->final_stock != 0) {
                    if ($jenis != "supplier") {
                        $selectData .= '<option harga="' . $value->harga_jual_produk . '" stok="' . $stok->final_stock . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    } else {
                        $selectData .= '<option harga="' . $value->harga_jual_produk_sup . '" stok="' . $stok->final_stock . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    }

                }

            } else {
                $stok_group = $this->db->query("select * from v_produk_stok_groupby where id_produk=" . $value->id_produk)->row();
                if (isset($stok_group->jumlah_produk_stok)) {
                    if ($jenis != "supplier") {
                        $selectData .= '<option harga="' . $value->harga_jual_produk . '" stok="' . $stok_group->jumlah_produk_stok . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    } else {
                        $selectData .= '<option harga="' . $value->harga_jual_produk_sup . '" stok="' . $stok_group->jumlah_produk_stok . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    }

                }

            }

        }
        $selectData .= '</select>';
        echo $selectData;
    }
    public function json()
    {
        header('Content-Type: application/json');
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
                'satuan' => $row->satuan,
                'foto_produk' => $row->foto_produk,
                'harga_jual_produk_sup' => $row->harga_jual_produk_sup,
                'status' => $row->status,
            );
            $this->load->view('produk/produk_read', $data);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dihapus</div>');
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
            'satuan' => set_value('satuan'),
            'harga_beli_produk' => set_value('harga_beli_produk'),
            'harga_jual_produk' => set_value('harga_jual_produk'),
            'harga_jual_produk_sup' => set_value('harga_jual_produk_sup'),
	    'foto_produk' => set_value('foto_produk'),

            'status' => set_value('status'),
        );
        $this->load->view('produk/produk_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('kode_produk', 'kode produk', 'trim|required|is_unique[produk.kode_produk]', [
            'is_unique' => 'Kode Produk ini sudah terdaftar'
            ]);

            $config['upload_path']          = './uploads/';
         $config['file_name'] = 'galeri_' . time();
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10000;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('foto_produk'))
        {
            $data = array('upload_data' => $this->upload->data());
            $dataFoto=$this->upload->data();

            $data = array(
                'kode_produk' => $this->input->post('kode_produk', true),
                'nama_produk' => $this->input->post('nama_produk', true),
                'deskripsi_produk' => $this->input->post('deskripsi_produk', true),
                'harga_beli_produk' => $this->input->post('harga_beli_produk', true),
                'harga_jual_produk' => $this->input->post('harga_jual_produk', true),
                'satuan' => $this->input->post('satuan', true),
                'harga_jual_produk_sup' => $this->input->post('harga_jual_produk_sup', true),
                'foto_produk' =>base_url()."uploads/default.jpg",
                'status' => $this->input->post('status', true),
            );
            $this->Produk_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dimasukkan</div>');
            redirect(site_url('produk'));
        }
        else
        {
        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $data = array('upload_data' => $this->upload->data());
            $dataFoto=$this->upload->data();

            $data = array(
                'kode_produk' => $this->input->post('kode_produk', true),
                'nama_produk' => $this->input->post('nama_produk', true),
                'deskripsi_produk' => $this->input->post('deskripsi_produk', true),
                'harga_beli_produk' => $this->input->post('harga_beli_produk', true),
                'harga_jual_produk' => $this->input->post('harga_jual_produk', true),
                'satuan' => $this->input->post('satuan', true),
                'harga_jual_produk_sup' => $this->input->post('harga_jual_produk_sup', true),
                'foto_produk' =>base_url()."uploads/".$dataFoto['orig_name'],
                'status' => $this->input->post('status', true),
            );
            $hal = array(
                'kegiatan' => "Menambahkan Produk dengan kode ".$data['kode_produk'],
    
            );
                $this->Activity_model->insert($hal);

            $this->Produk_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dimasukkan</div>');
            redirect(site_url('produk'));
        }
    }
    }
    public function update($id)
    {
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('produk/ubah_action'),
                'id_produk' => set_value('id_produk', $row->id_produk),
                'kode_produk' => set_value('kode_produk', $row->kode_produk),
                'nama_produk' => set_value('nama_produk', $row->nama_produk),
                'satuan' => set_value('satuan', $row->satuan),
                'deskripsi_produk' => set_value('deskripsi_produk', $row->deskripsi_produk),
                'harga_beli_produk' => set_value('harga_beli_produk', $row->harga_beli_produk),
                'harga_jual_produk' => set_value('harga_jual_produk', $row->harga_jual_produk),
                'harga_jual_produk_sup' => set_value('harga_jual_produk_sup', $row->harga_jual_produk_sup),
                'foto_produk' => set_value('foto_produk', $row->foto_produk),
                'status' => set_value('status', $row->status),
            );
            $this->load->view('produk/produk_form', $data);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dihapus</div>');
            redirect(site_url('produk'));
        }
    }
    public function ubah_action(){
        if (!empty($_FILES["foto_produk"]["name"])) {
            $row = $this->Produk_model->get_by_id($this->input->post('id_produk', true));

            if ($row->foto_produk != "default.jpg") {
                $filename = explode(".", $row->foto_produk)[0];
                array_map('unlink', glob(FCPATH . "assets/dj/$filename.*"));
            }
            $data = array(
                'kode_produk' => $this->input->post('kode_produk', true),
                'nama_produk' => $this->input->post('nama_produk', true),
                'deskripsi_produk' => $this->input->post('deskripsi_produk', true),
                'satuan' => $this->input->post('satuan', true),
                'harga_beli_produk' => $this->input->post('harga_beli_produk', true),
                'harga_jual_produk' => $this->input->post('harga_jual_produk', true),
                'harga_jual_produk_sup' => $this->input->post('harga_jual_produk_sup', true),
                'foto_produk' => base_url()."uploads/".$this->_uploadImage(),
                'status' => $this->input->post('status', true),
            );

        } else {
            $data = array(
                'kode_produk' => $this->input->post('kode_produk', true),
                'nama_produk' => $this->input->post('nama_produk', true),
                'deskripsi_produk' => $this->input->post('deskripsi_produk', true),
                'satuan' => $this->input->post('satuan', true),
                'harga_beli_produk' => $this->input->post('harga_beli_produk', true),
                'harga_jual_produk' => $this->input->post('harga_jual_produk', true),
                'harga_jual_produk_sup' => $this->input->post('harga_jual_produk_sup', true),
                'status' => $this->input->post('status', true),
            );
        }
        $hal = array(
            'kegiatan' => "Merubah Data Produk dengan kode ".$data['kode_produk'],

        );
            $this->Activity_model->insert($hal);
        $this->Produk_model->update($this->input->post('id_produk', true), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil diubah</div>');
            redirect(site_url('produk'));
    }

    public function update_action()
    {
        $this->_rules();
       
        $id_produk = $this->input->post('id_produk');
        $this->db->where("id_produk",$id_produk);
        $row=$this->db->get("produk")->row();
        $config['upload_path']          = './uploads/';
        $config['file_name'] = 'galeri_' . time();
       $config['allowed_types']        = 'gif|jpg|png';
       $config['max_size']             = 10000;
       $this->load->library('upload', $config);
       $file = $this->upload->data();
       $foto_produk = base_url().$file['file_name'];
      
        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('id_produk', true));
       
        } else {
            if (empty($foto_produk)) {
         
                $row = $this->Produk_model->get_by_id($this->input->post('id_produk', true));
                
                if ($row->foto_produk != "default.jpg") {
                    $filename = explode(".", $row->foto_produk)[0];
                    array_map('unlink', glob(FCPATH . "uploads/$filename.*"));
                    
                }
                // $file = $this->upload->data();
                // $foto_produk = $file['file_name'];
            $data = array(
                'kode_produk' => $this->input->post('kode_produk', true),
                'nama_produk' => $this->input->post('nama_produk', true),
                'deskripsi_produk' => $this->input->post('deskripsi_produk', true),
                'satuan' => $this->input->post('satuan', true),
                'harga_beli_produk' => $this->input->post('harga_beli_produk', true),
                'harga_jual_produk' => $this->input->post('harga_jual_produk', true),
                'harga_jual_produk_sup' => $this->input->post('harga_jual_produk_sup', true),
                'foto_produk' => $foto_produk,
                
                'status' => $this->input->post('status', true),
            );
            
            // $this->Produk_model->update($this->input->post('id_produk', true), $data);
        } 
        else {
            $data = array(
                'id_produk' => $this->input->post('id_produk',TRUE),
                'kode_produk' => $this->input->post('kode_produk', true),
                'nama_produk' => $this->input->post('nama_produk', true),
                'deskripsi_produk' => $this->input->post('deskripsi_produk', true),
                'satuan' => $this->input->post('satuan', true),
                'harga_beli_produk' => $this->input->post('harga_beli_produk', true),
                'harga_jual_produk' => $this->input->post('harga_jual_produk', true),
                'harga_jual_produk_sup' => $this->input->post('harga_jual_produk_sup', true),
                // 'foto_produk' => $this->input->post('foto_produk', true),
                'status' => $this->input->post('status', true),
            );
            $hal = array(
                'kegiatan' => "Merubah Data Produk dengan kode ".$data['kode_produk'],
    
            );
                $this->Activity_model->insert($hal);
            $this->Produk_model->update($this->input->post('id_produk', true), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil diubah</div>');
            redirect(site_url('produk'));
        }
    }
    }
    public function delete($id)
    {
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            if ($row->foto_produk != "default.jpg") {
                $filename = explode(".", $row->foto_produk)[0];
                array_map('unlink', glob(FCPATH . "uploads/$filename.*"));
            }
            $this->Produk_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dihapus</div>');
            redirect(site_url('produk'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Tidak ditemukan</div>');
            redirect(site_url('produk'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('kode_produk', 'kode produk', 'trim|required');
        $this->form_validation->set_rules('nama_produk', 'nama produk', 'trim|required');
        $this->form_validation->set_rules('deskripsi_produk', 'deskripsi produk', 'trim|required');
        $this->form_validation->set_rules('harga_beli_produk', 'harga beli produk', 'trim|required');
        $this->form_validation->set_rules('harga_jual_produk', 'harga jual produk', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('id_produk', 'id_produk', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
    private function _uploadImage()
    {
        $config['upload_path']          = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = 'galeri_' . time();
        $config['overwrite'] = true;
        $config['max_size']             = 10000;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_produk')) {
            $data = $this->upload->data();
            return $data['file_name'];
        }

        return "default.jpg";
    }
}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 11:20:19 */
/* http://harviacode.com */