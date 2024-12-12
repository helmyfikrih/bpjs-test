<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Firebase\JWT\JWT;

class Auth extends CI_Controller
{

	private $secret_key = "test_bpjs";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');

		$this->load->library('form_validation');
	}

	private function output_response($status, $message, $data = null, $code)
	{
		$response = [
			'status' => $status,
			'code' => $code,
			'message' => $message,
		];
		if($data) {
			$response['data'] = $data;
		}
		set_status_header($code);
		header("Content-type: application/json");
		echo json_encode($response);
	}

	private function is_post_request() {
        return $this->input->method() === 'post';
    }

	public function index()
	{
	}

	public function register()
	{
		if (!$this->is_post_request()) {
            $this->output_response(false, "Method not allowed", null, 405);
            return;
        }
		
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]|min_length[5]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

		// Cek Validasi
		if ($this->form_validation->run() == FALSE) {
			$this->output_response(false, "Validation Error", $this->form_validation->error_array(), 400);
			return;
		}

		$data = [
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
		];

		$create_user = $this->User_model->create_user($data);
		if ($create_user) {
			$this->output_response(true, "Registration successful", array(
                "username" => $this->input->post('username')
			), 200);
		} else {
			$this->output_response(false, "Registration failed", $create_user, 500);
		}
	}

	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = $this->User_model->get_user($username);
		if ($user && password_verify($password, $user->password)) {
			$payload = [
				"iss" => "localhost",
				"aud" => "localhost",
				"iat" => time(),
				"exp" => time() + 3600,
				"data" => [
					"id" => $user->id,
					"username" => $user->username
				]
			];

			$token = JWT::encode($payload, $this->secret_key, 'HS256');
			$this->output_response(true, "Login Success", array(
                "token" => $token
			), 200);
		} else {
			$this->output_response(true, "Invalid credentials", null, 400);
		}
	}
}
