<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct()
	{
		parent::__construct();	
		$this->load->model('m_login');
	}
	
	public function index()
	{
		//$this->load->view('welcome_message');
		$this->load->helper('url');
		$this->load->view('login.php');
	}
	
	function action_login(){	
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$cek = $this->m_login->cek_login($username,$password);
		if($cek->num_rows() == 1){
			foreach($cek->result() as $data){
				$session_data['id'] = $data->id;
				$session_data['username'] = $data->username;
				$session_data['status'] = 1;
				$this->session->set_userdata($session_data);
			}
			redirect(base_url('index.php/admin'));
		}else{
			$this->session->set_flashdata('pesan','Maaf, kombinasi username dan password salah');
			redirect(base_url('index.php/login'));
		}
		
		/*$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => $password
		);
		$cek = $this->m_login->cek_login("tb_user",$where)->num_rows();
		if($cek > 0){
			$data_session = array(
				'nama' => $username,
				'status' => "login"
			);
			
			$this->session->set_userdata($data_session);
			redirect(base_url("admin"));
		}else{
			echo "Username atau password salah";
		}*/		
	}
	
	function action_logout(){		
		$this->session->sess_destroy();
		$session_data['status'] = 0;
		redirect(base_url('index.php/login'));
	}
}
