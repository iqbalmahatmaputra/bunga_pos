<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

        $this->load->model('User_model');
        $this->load->library('form_validation');
	}
	

    public function index()
    {
		$this->form_validation->set_rules('nama_user', 'Name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if($this->form_validation->run() == false){
		$this->load->view('login');

		}else{
			$this->_login();

		}
		// if($this->session->userdata('logined') && $this->session->userdata('logined') == true)
		// {
		// 	redirect('home');
		// }
		
		// if(!$this->input->post())
		// {
			
		// }
		// else
		// {
		
        
	} 
	private function _login(){
		$nama_user = $this->input->post('nama_user');
		$password = $this->input->post('password');
		
	
		$user = $this->db->get_where('user', ['nama_user' => $nama_user])->row_array();
		if($user){
			// user aktif
			if($user['is_active'] == 1){
				// cek password
				if(($password == $user['password'])){
					$data = [
						'nama_user' => $user['nama_user'],
						'status' => $user['status'],
						'is_active' => $user['is_active'],
						'logined' => TRUE
					];
					// $this->session->set_userdata($data);
					$this->session->set_userdata($data);
					// redirect('masalah'); klo mau nge gas
					if ($user['is_active'] == 1){
						$hal = array(
							'kegiatan' => $user['nama_user']." berhasil melakukan login ",
				
						);
							$this->Activity_model->insert($hal);
						redirect('home');
					}
					else {
						redirect('/');
					}
				} else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Salah!</div> ');
			redirect('/');
				}
			} else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun Belum Pernah Terdaftar!</div> ');
			redirect('/');
			}
	
		} else {
			// error
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun Belum Pernah Terdaftar!</div> ');
			redirect('/');
	
		}
	}
	
	public function logout()
    {
		$nama_user = $this->session->userdata("nama_user");
		$hal = array(
			'kegiatan' => $nama_user." telah melakukan logout ",

		);
			$this->Activity_model->insert($hal);
		$this->session->unset_userdata('logined');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun anda sudah Logout! Sampai jumpa ya, ' .$nama_user.'!</div> ');
		redirect("/");
    } 
}

/* End of file Workflows.php */
/* Location: ./application/controllers/Workflows.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-04-15 00:43:10 */
/* http://harviacode.com */