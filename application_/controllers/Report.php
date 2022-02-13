<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Penjualan_model');
        $this->load->library('form_validation');

        if (!$this->session->userdata('logined') || $this->session->userdata('logined') != true) {
            redirect('/');
        }
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('report/penjualan_list');
    }

    public function json()
    {
        header('Content-Type: application/json');
        $data = json_decode($this->Penjualan_model->json());
        echo json_encode($data->data);
    }
    public function report(){
        header('Content-Type: application/json');
        $data = json_decode($this->Penjualan_model->json2());
        echo json_encode($data->data);
    }
    public function cek(){
        if($this->input->get('search')){
            $this->cariTanggalJson();
        }else{
            $this->cetak();
        }
    }
    public function cariTanggalJson(){

            $tanggal_mulai = $this->input->get('tanggal_mulai', true);
            $tanggal_selesai = $this->input->get('tanggal_selesai', true);
            $kode = $this->input->get('kode', true);

            $kode = $this->input->get('kode', true);
            $this->db->where("kode_produk",$kode);
            $produk=$this->db->get("produk")->num_rows();
            $this->db->where("no_faktur",$kode);
            $penjualan=$this->db->get("penjualan")->num_rows();
            echo $penjualan;
            if ($produk==1) {
                $data['cek'] =  $this->db->query("select * from v_report_produk where kode_produk='".$kode."' and tanggal_penjualan BETWEEN '".$tanggal_mulai."' AND '".$tanggal_selesai."'")->result();
            }else if($penjualan==1){
                $data['cek'] =  $this->db->query("select * from v_report_produk where no_faktur = '".$kode."' and tanggal_penjualan BETWEEN '".$tanggal_mulai."' AND '".$tanggal_selesai."'")->result();
            }else{
                $data['cek'] =  $this->db->query("select * from v_report_produk where tanggal_penjualan BETWEEN '".$tanggal_mulai."' AND '".$tanggal_selesai."'")->result();
            }
         
        
          $data['tanggal_mulai'] = $tanggal_mulai;
          $data['tanggal_selesai'] = $tanggal_selesai;
        
           $this->load->view('report/rekap',$data);
        }
      
      public function cetak(){
        $tanggal_mulai = $this->input->get('tanggal_mulai', true);
        $tanggal_selesai = $this->input->get('tanggal_selesai', true);
        $kode = $this->input->get('kode', true);
        $kode = $this->input->get('kode', true);
            $this->db->where("kode_produk",$kode);
            $produk=$this->db->get("produk")->num_rows();
            $this->db->where("no_faktur",$kode);
            $penjualan=$this->db->get("penjualan")->num_rows();
            echo $penjualan;
            if ($produk==1) {
                $data['cek'] =  $this->db->query("select * from v_report_produk where kode_produk='".$kode."' and tanggal_penjualan BETWEEN '".$tanggal_mulai."' AND '".$tanggal_selesai."'")->result();
            }else if($penjualan==1){
                $data['cek'] =  $this->db->query("select * from v_report_produk where no_faktur = '".$kode."' and tanggal_penjualan BETWEEN '".$tanggal_mulai."' AND '".$tanggal_selesai."'")->result();
            }else{
                $data['cek'] =  $this->db->query("select * from v_report_produk where tanggal_penjualan BETWEEN '".$tanggal_mulai."' AND '".$tanggal_selesai."'")->result();
            }

            
            $data =  array ( 'dataku' =>'
        
            <style>table,p{font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;}</style>
            
    <table>
    <thead>
										<tr>
											<th>Kode Produk</th>
											<th>Nama</th>
											<th>Tanggal Penjualan</th>
											<th>No Faktur</th>
											<th>Total Barang</th>
											<th>Total Harga</th>
											

										</tr>
                                    </thead>
                                    <tbody>
                                    '.	
                                    $total_barang=0;
                                    $total_harga=0;
                    foreach($cek as $u){ 
                        $total_barang += $u->qty;
                        $total_harga += $u->total_harga* $u->qty;.'
                    <tr>
											<td>
                                            '.$u->kode_produk.'
												
                                            </td>
											<td>'.$u->nama_produk.'</td>
											<td><?php echo $u->tanggal_penjualan ?></td>
											<td>
                                          
                                            
													'.$u->no_faktur.' 
												
                                            </td>
											<td>'.$u->qty.'</td>
											<td style="text-align: right;">'.number_format($u->total_harga* $u->qty, 0, ".", ".").'</td>
											
										</tr>
										'.}.'

									</tbody>
									<tfoot>
										<tr>
											<th colspan="4">Total</th>
											<th>'.number_format($total_barang , 0, ".", ".").'</th>
											<th style="text-align: right;">'.number_format($total_harga, 0, ".", ".").'</th>
											<th></th>

										</tr>
									</tfoot>
                                    </tbody>
    </table>
    
    
    
            ');
            $this->load->library('pdf');
            
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "Pengiriman.pdf";
        $this->pdf->set_option('isRemoteEnabled', TRUE);
    
        $this->pdf->load_view('pengiriman/pengiriman_pdf', $data);
      
        
      }
      

    public function cekDetail($id_produk){
        $row = $this->Penjualan_model->get_by_id_produk($id_produk);
        $this->db->select('id_produk, kode_produk, nama_produk, sum(jumlah_produk_stok) jumlah_produk_stok');
        $this->db->group_by('id_produk');
        $stok = $this->db->get('v_produk_stok')->result();

        foreach ($stok as $key => $value) {
            $terjual = $this->db->query("select sum(qty) qty from produk_penjualan WHERE id_produk=" . $value->id_produk . " GROUP BY id_produk")->row();
            $jumTerjual = 0;
            if (empty($terjual)) {
                $stok = $value->jumlah_produk_stok - $jumTerjual;
            } else {
                $jumTerjual = $terjual->qty;
                $stok = $value->jumlah_produk_stok - $terjual->qty;
            }
        
        }

        if ($row) {
            $data['produk'] = $row;
            $data['jumTerjual'] = $jumTerjual;
           
            $this->load->view('report/detail', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('report'));
        }
    }

    public function read($id)
    {
        $row = $this->Penjualan_model->get_by_id($id);
        if ($row) {
            $data['penjualan'] = $row;
            $this->load->view('report/penjualan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
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
        redirect(site_url('report/invoice/' . $date->getTimestamp()));
        // $this->load->view('penjualan/penjualan_form', $data);

    }
    public function invoice($no_invoice)
    {
        $data['penjualan'] = $this->db->query('select * from penjualan where no_faktur=' . $no_invoice)->row();
        $this->load->view('report/penjualan_form', $data);
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
            );

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
            $this->load->view('report/penjualan_form', $data);
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
            $this->session->set_flashdata('message', 'Delete Record Success');
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
//    foreach ($dapat as $key => $value) {
        //     $data = [];
        //     $data[$key]['id_produk'] = $value->id_produk;
        //     $data[$key]['kode_produk'] = $value->kode_produk;
        //     $data[$key]['nama_produk'] = $value->nama_produk;
        //     $data[$key]['no_faktur'] = $value->no_faktur;
        //     $data[$key]['tanggal_penjualan'] = $value->tanggal_penjualan;
        //     $data[$key]['qty'] = $value->qty;
        //     $data[$key]['total_harga'] = $value->total_harga;

        //    }
        // echo json_encode($data);
