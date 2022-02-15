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
    public function form_penjualan(){
        $data['data']=$this->Produk_model->tampil_barang();
        // $this->load->view('penjualan/invoice',$data);
        $this->load->view('penjualan/penjualan_form', $data);
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


    function get_autocomplete(){
      
        if (isset($_GET['term'])) {
            $result = $this->Produk_model->search_produk($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->kode_produk,
                );
                echo json_encode($arr_result);
            }
        }
    }
   
   
    function get_barang($jenis = "", $id_penjualan){
       
        $kode_produk = $this->input->post('kode_produk');
        $x['brg']=$this->db->query("SELECT * FROM produk where kode_produk like '%$kode_produk%' limit 0,20");
       
        if ($jenis != "supplier") {
            $x['supplier'] = 0;
        }else{
            $x['supplier'] = 1;
        }
        $x['id_penjualan'] = $this->uri->segment('4');
        
        $this->load->view('penjualan/v_detail_produk',$x);
        
    }

      public function list_produk2($jenis = "")
    {
        $selectData = '<input type="text" name="id_produk[]" id="id_produk" class="form-control">';
        $produks = $this->db->get("produk")->result();
        foreach ($produks as $key => $value) {
            $stok = $this->db->query("select final_stock from v_stok where id_produk=" . $value->id_produk)->row();
            $retur = $this->db->query("select sum(qty) qty from v_retur WHERE id_produk=" . $value->id_produk. " GROUP BY id_produk")->row();
            $returVal=0;
            if(empty($retur->qty)){
                $returVal=0;
            }else{
                $returVal=$retur->qty;
            }
            if (!empty($stok)) {
                if ($stok->final_stock != 0) {
                    $stok_akhir=$stok->final_stock+$returVal;
                    if ($jenis != "supplier") {
                        $selectData .= '<option harga="' . $value->harga_jual_produk . '" stok="' . $stok_akhir . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    } else {
                        $selectData .= '<option harga="' . $value->harga_jual_produk_sup . '" stok="' . $stok_akhir . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    }

                }

            } else {
                $retur = $this->db->query("select sum(qty) qty from v_retur WHERE id_produk=" . $value->id_produk. " GROUP BY id_produk")->row();
                $returVal=0;
                if(empty($retur->qty)){
                    $returVal=0;
                }else{
                    $returVal=$retur->qty;
                }
                $stok_group = $this->db->query("select * from v_produk_stok_groupby where id_produk=" . $value->id_produk)->row();
                if (isset($stok_group->jumlah_produk_stok)) {
                    $stok_akhir=$stok_group->jumlah_produk_stok-$returVal;
                    if ($jenis != "supplier") {
                        $selectData .= '<option harga="' . $value->harga_jual_produk . '" stok="' . $stok_akhir . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    } else {
                        $selectData .= '<option harga="' . $value->harga_jual_produk_sup . '" stok="' . $stok_akhir . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    }

                }

            }

        }
        $selectData .= '</select>';
        echo $selectData;
    }

    function add_to_cart(){
      
            $kobar=$this->input->post('kode_produk');
            $produk=$this->Produk_model->get_barang($kobar);
            $i=$produk->row_array();
            $data = array(
                //    'id_produk'       => $i['id_produk'],
                   'kode_produk'       => $i['kode_produk'],
                   'qty'     => $this->input->post('qty'),
                   'harga' =>$this->input->post('harga'),
                   'total_harga'	  => str_replace(",", "",($this->input->post('qty')*$this->input->post('harga')))
                );
                if(!empty($this->cart->total_items())){
                    foreach ($this->cart->contents() as $items){
                        $id=$items['id'];
                        $qtylama=$items['qty'];
                        $rowid=$items['rowid'];
                        $kobar=$this->input->post('kode_brg');
                        $qty=$this->input->post('qty');
                        if($id==$kobar){
                            $up=array(
                                'rowid'=> $rowid,
                                'qty'=>$qtylama+$qty
                                );
                            $this->cart->update($up);
                        }else{
                            $this->cart->insert($data);
                        }
                    }
                }else{
                    $this->cart->insert($data);
                }

    //  $this->cart->insert($data);
     redirect('produk/form_penjualan');
       
        }
    public function list_produk($jenis = "")
    {
        $selectData = '<select class="form-control selectpicker cam_select" data-live-search-style="startsWith"  data-size="7" data-live-search="true" name="kode_produk[]" id="id_produk"><option value="">Pilih Produk</option>';
        // $selectData = '
        // <input type="text" name="kode_produk[]" id="kode_produk" class="form-control input-sm">';
        $produks = $this->db->get("produk",20)->result();
        foreach ($produks as $key => $value) {
            $stok = $this->db->query("select final_stock from v_stok where id_produk='" . $value->kode_produk."'")->row();
            $retur = $this->db->query("select sum(qty) qty from v_retur WHERE id_produk='" . $value->kode_produk. "' GROUP BY id_produk")->row();
            $returVal=0;
            if(empty($retur->qty)){
                $returVal=0;
            }else{
                $returVal=$retur->qty;
            }
            if (!empty($stok)) {
                if ($stok->final_stock != 0) {
                    $stok_akhir=$stok->final_stock+$returVal;
                    if ($jenis != "supplier") {
                        $selectData .= '<option harga="' . $value->harga_jual_produk . '" stok="' . $stok_akhir . '" value="' . $value->kode_produk . '">' . $value->kode_produk . '</option>';
                    } else {
                        $selectData .= '<option harga="' . $value->harga_jual_produk_sup . '" stok="' . $stok_akhir . '" value="' . $value->kode_produk . '">' . $value->kode_produk . '</option>';
                    }

                }

            } else {
                $retur = $this->db->query("select sum(qty) qty from v_retur WHERE id_produk=" . $value->id_produk. " GROUP BY id_produk")->row();
                $returVal=0;
                if(empty($retur->qty)){
                    $returVal=0;
                }else{
                    $returVal=$retur->qty;
                }
                $stok_group = $this->db->query("select * from v_produk_stok_groupby where id_produk=" . $value->id_produk)->row();
                if (isset($stok_group->jumlah_produk_stok)) {
                    $stok_akhir=$stok_group->jumlah_produk_stok-$returVal;
                    if ($jenis != "supplier") {
                        $selectData .= '<option harga="' . $value->harga_jual_produk . '" stok="' . $stok_akhir . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    } else {
                        $selectData .= '<option harga="' . $value->harga_jual_produk_sup . '" stok="' . $stok_akhir . '" value="' . $value->id_produk . '">' . $value->kode_produk . '</option>';
                    }

                }

            }

        }
        $selectData .= '</select>';
        echo $selectData;
    }


    public function list_produk_retur($no_invoice="")
    {
        $penjualan = $this->db->query('select * from penjualan,user where penjualan.id_user=user.id_user and no_faktur=' . $no_invoice)->row();
        $jenis=$penjualan->jenis;
        $selectData = '<select class="form-control selectpicker cam_select" data-size="7" data-live-search="true" name="id_produk[]" id="id_produk"><option value="">Pilih Produk</option>';
        $produks = $this->db->query("select *  from produk_penjualan where id_penjualan=".$penjualan->id_penjualan)->result();
        foreach ($produks as $key => $value) {
            $produk = $this->db->query("select * from produk where id_produk=" . $value->id_produk)->row();
                    if ($jenis != "supplier") {
                        $selectData .= '<option harga="' . $produk->harga_jual_produk . '" stok="' . $value->qty . '" value="' . $produk->id_produk . '">' . $produk->kode_produk . '</option>';
                    } else {
                        $selectData .= '<option harga="' . $produk->harga_jual_produk_sup . '" stok="' . $value->qty . '" value="' . $produk->id_produk . '">' . $produk->kode_produk . '</option>';
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
    public function jsonProdukPenjualan($id_penjualan)
    {
        header('Content-Type: application/json');
        echo $this->Produk_model->jsonProdukPenjualan($id_penjualan);
    }
  
    public function load_temp($id_penjualan){
        
        echo "<div class=''>
        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>";
        $data = $this->Produk_model->show_temp($id_penjualan)->result();
        $no = 1;
        $total = 0;
        $jumlah_barang = 0;
        foreach ($data as $d) {
            echo "<tr>"
            . "<td>$no</td>"
            . "<td>$d->kode_produk</td>"
            . "<td>$d->qty</td>"
            . "<td>$d->total_harga</td>"
            . "<td><button type='button' data-id=$d->id_produk class='btn btn-danger btn-rounded btn-sm delete'>Cancel</button></td>"
            . "</tr>";
           $total += $d->total_harga * $d->qty;
           $jumlah_barang += $d->qty;
            $no++;
        }
        echo "</table>
        </div>";
   echo "<div class='table'>
        <table class='table'>
                 <thead><tr><th>Total Penjualan (Rp)</th><td><input type='number' value=" . $total . " name='total' id='total_belanja' readonly></td><td>" . Terbilang($total) . "</td></tr></thead>
                 <thead><tr><th>Total Barang </th><td><input type='number' value=" . $jumlah_barang . " name='jumlah_barang' id='jumlah_barang' readonly></td><td>" . Terbilang($jumlah_barang) . "</td></tr></thead>
                 
         </table>
         
    </div>";
    }
    function selesai(){
           
                $kd_barang=$_GET['kd_barang'];
                $id_penjualan = $_GET['id_penjualan'];
                $tujuan = $_GET['tujuan'];
                $jumlah_barang = $_GET['jumlah_barang'];
                $total = $_GET['total'];
     

        $data = array(
            'qty' => $jumlah_barang,
            'total' => $total_harga,
            'tujuan' => $tujuan
    );

        $this->db->set('tujuan', $tujuan);
$this->db->where('id_penjualan', $id_penjualan);
$this->db->update('produk_penjualan'); 

$this->db->where('id_penjualan', $id_penjualan);
$this->db->update('penjualan', $data);
    }
    
    function deleterecords()
	{
		
			$id=$this->input->post('id');
            $this->db->where('id_produk', $id);
            $this->db->delete('produk_penjualan');
			
			echo json_encode(array(
				"statusCode"=>200
			));
	 
	}
    function cancel() {
        $id = $_GET['id'];
        $this->db->where('id_produk', $id);
        $this->db->delete('produk_penjualan');
        
    }
    function kembalian() {
        $a = $_GET['jumlah_uang'];
        $b = $_GET['total_belanja'];
        $c = $a - $b;
        $data = array(
            'jumlah' => $a,
            'total_belanja' => $b,
            'hasil' => $c,
            'Terbilang' => Terbilang($c),
            'Terbilang2' => Terbilang($a),
        );
        echo json_encode($data);
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
        $config['max_size']             = 19000;
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
        $config['max_size']             = 19000;
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