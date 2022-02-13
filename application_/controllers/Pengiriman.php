<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pengiriman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('Pengiriman_model');
        $this->load->library('form_validation');

        if (!$this->session->userdata('logined') || $this->session->userdata('logined') != true) {
            redirect('/');
        }
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('pengiriman/kirim_list');
    }
    public function json()
    {
        header('Content-Type: application/json');
        
        echo $this->Pengiriman_model->json();
    }
    
    public function reads($id)
    {
        $row = $this->Pengiriman_model->get_by_id($id);
        if ($row) {
            $data = array(
                'tanggal_penjualan' => $row->tanggal_penjualan,
                'tanggal_kirim' => $row->tanggal_kirim,
                'no_faktur' => $row->no_faktur,
                'tujuan' => $row->tujuan,
                'alamat' => $row->alamat,
                'no_hp' => $row->no_hp   ,
                'petugas' => $row->petugas,
            );
            $this->load->view('pengiriman/pengiriman_read', $data);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Tidak Ditemukan</div>');
            redirect(site_url('pengiriman'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('pengiriman/create_action'),
            'id_kirim' => set_value('id_kirim'),
            'created_at' => set_value('created_at'),
            'no_faktur' => set_value('no_faktur'),
            'tujuan' => set_value('tujuan'),
            'alamat' => set_value('alamat'),
            'no_hp' => set_value('no_hp'),
            'id_user' => set_value('id_user'),
        );
        $this->load->view('pengiriman/kirim_form', $data);
    }
    public function create_action()
    {
        $this->_rules();
        $user =  $this->session->userdata("nama_user");
   // print_r($data);
            // die;
       
        // if ($this->form_validation->run() == false) {
        //     $this->create();
        // } else {
            $data = array(
                'created_at' => $this->input->post('created_at', true),
                'id_penjualan' => $this->input->post('id_penjualan', true),
                'id_user' => $user,
                'tujuan' => $this->input->post('tujuan', true),
                'alamat' => $this->input->post('alamat', true),
                'no_hp' => $this->input->post('no_hp', true),
            );
            // print_r($data);
            // die;
       
            $this->Pengiriman_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dimasukkan</div>');
            redirect(site_url('pengiriman'));
        // }
    }
    public function read($id)
    {
        $row = $this->Pengiriman_model->get_by_id_v($id);
        if ($row) {
            $data = array(
                'id_penjualan' => $row->id_penjualan,
                'tanggal_penjualan' => $row->tanggal_penjualan,
                'no_faktur' => $row->no_faktur,
                'tujuan' => $row->tujuan,
                'alamat' => $row->alamat,
                'no_hp' => $row->no_hp,
                'tanggal_kirim' => $row->tanggal_kirim,
                'petugas' => $row->petugas,
            );
            $this->load->view('pengiriman/kirim_read', $data);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Tidak Ditemukan!</div>');
            redirect(site_url('pengiriman'));
        }
    }
    public function update($id)
    {
        $row = $this->Pengiriman_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pengiriman/update_action'),
                'id_penjualan' => set_value('id_penjualan', $row->id_penjualan),
                // 'tanggal_penjualan' => set_value('tanggal_penjualan', $row->tanggal_penjualan),
                'alamat' => set_value('alamat', $row->alamat),
                'tujuan' => set_value('tujuan', $row->tujuan),
                'no_hp' => set_value('no_hp', $row->no_hp),
                'id_kirim' => set_value('id_kirim', $row->no_hp),
          
            );
            $this->load->view('pengiriman/kirim_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengiriman'));
        }
    }

    public function update_action()
    {
      
            $data = array(
               'id_kirim' => $this->input->post('id_kirim', true),
               'id_penjualan' => $this->input->post('id_penjualan', true),
               'tujuan' => $this->input->post('tujuan', true),
               'alamat' => $this->input->post('alamat', true),
               'no_hp' => $this->input->post('no_hp', true),
            );
            
            $this->Pengiriman_model->update($this->input->post('id_kirim', true), $data);
        
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil diubah !</div>');
            redirect(site_url('pengiriman'));
        
    }
    public function delete($id)
    {
        $row = $this->Pengiriman_model->get_by_id($id);

        if ($row) {
            $this->Pengiriman_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil dihapus !</div>');
            $hal = array(
                'kegiatan' => "Menghapus invoice sebelum jadi dengan nomor QG-".$row->id_penjualan,
    
            );
                $this->Activity_model->insert($hal);
            redirect(site_url('pengiriman'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengiriman'));
        }
    }
    public function finish($id_kirim)
    {
    
        $this->db->where("id_kirim",$id_kirim);
        $pengiriman =$this->db->get("v_kirim_jual")->row();    
       
        $data =  array ( 'dataku' =>'
        
        <style>table,p{font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;}</style>
        
<table>
<tr>
<td style="width:300px;">
<img src="'.base_url().'assets/img/queen_logo.jpg" style="height:auto;width:200px;"/></td>
<td>
<table>
<tbody>
<tr>
<td>Nama</td>
<td>:' .$pengiriman->tujuan.'</td>
</tr>
<tr>
<td>No Faktur</td>
<td>: QG-' .$pengiriman->no_faktur.'-'.$pengiriman->id_penjualan.'</td>
</tr>
<tr>
<td>No Handphone</td>
<td>: ' .$pengiriman->no_hp.'</td>
</tr>
<tr>
<td>Alamat</td>
<td>: ' .$pengiriman->alamat.'</td>
</tr>

</tbody>
</table>
</td>
</tr></table>



        ');
        $this->load->library('pdf');
        
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Pengiriman.pdf";
    $this->pdf->set_option('isRemoteEnabled', TRUE);

    $this->pdf->load_view('pengiriman/pengiriman_pdf', $data);
        // redirect(site_url('penjualan'));

    }

    public function _rules()
    {
        $this->form_validation->set_rules('no_hp', 'np hp', 'trim|required');
        $this->form_validation->set_rules('id_user', 'id user', 'trim|required');
        $this->form_validation->set_rules('tujuan', 'tujuan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


}
?>