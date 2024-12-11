<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Bpjs extends CI_Controller
{

	private $secret_key = "test_bpjs";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Bpjs_model');

		$this->load->library('form_validation');
	}

	private function output_response($status, $message, $data = null, $code)
	{
		$response = [
			'status' => $status,
			'code' => $code,
			'message' => $message,
		];
		if ($data) {
			$response['data'] = $data;
		}
		set_status_header($code);
		header("Content-type: application/json");
		echo json_encode($response);
	}

	private function authenticate()
	{
		$headers = $this->input->get_request_header('Authorization');
		if (!$headers) {
			$this->output_response(false, "Access Denied", null, 401);
			exit;
		}
		try {
			$token = str_replace('Bearer ', '', $headers);
			$decoded = JWT::decode($token, new Key($this->secret_key, 'HS256'));
			return $decoded->data;
		} catch (\Firebase\JWT\ExpiredException $e) {
			$this->output_response(false, "Token Expired", null, 401);
			exit;
		} catch (\Firebase\JWT\SignatureInvalidException $e) {
			$this->output_response(false, "Invalid Signature", null, 401);
			exit;
		} catch (Exception $e) {
			$this->output_response(false, "Invalid Token", null, 401);
			exit;
		}
	}

	private function is_post_request()
	{
		return $this->input->method() === 'post';
	}

	public function index()
	{
		$this->authenticate();
		$data = json_decode(file_get_contents('php://input'), true);
		if ($this->input->server('REQUEST_METHOD') === 'GET') {
			$data['page_target'] = $this->input->get('page_target') ? $this->input->get('page_target') : 1;
			$data['length_per_page'] = $this->input->get('length_per_page') ? $this->input->get('length_per_page') : 100;
			$data['pagination'] = $this->input->get('pagination') == 'all' ? 'all' : 'page';
			$data['nik'] = $this->input->get('nik') ? $this->input->get('nik') : NULL;
			$data['kpj'] = $this->input->get('cust_id') ? strtolower($this->input->get('cust_id')) : NULL;
			$data['first_name'] = $this->input->get('first_name') ? strtolower($this->input->get('first_name')) : NULL;
			$data['last_name'] = $this->input->get('last_name') ? $this->input->get('last_name') : NULL;
			$data['phone_number'] = $this->input->get('phone_number') ? $this->input->get('phone_number') : NULL;
			$data['email'] = $this->input->get('email') ? $this->input->get('email') : NULL;
			$data['birth_date'] = $this->input->get('birth_date') ? $this->input->get('birth_date') : NULL;
			$data['birth_place'] = $this->input->get('birth_place') ? $this->input->get('birth_place') : NULL;
			$data['address'] = $this->input->get('address') ? $this->input->get('address') : NULL;
			$data['search_criteria'] = $this->input->get('search_criteria') ? $this->input->get('search_criteria') : NULL;
			$data['search_query'] = $this->input->get('search_query') ? $this->input->get('search_query') : NULL;
		}
		$data['pagination'] = isset($data['pagination']) ? $data['pagination'] : 'page';
		$data['page_target'] = isset($data['page_target']) ? $data['page_target'] : 1;
		$data['length_per_page'] = isset($data['length_per_page']) ? $data['length_per_page'] : 100;

		$cond = array();
		if ($data['search_criteria']) {
			if ($data['search_criteria'] != 'search') {
				$criteria = $data['search_criteria'];
				$cond["$criteria = '" . $data['search_query'] . "'"] = NULL;
			} else if ($data['search_criteria']) {
				$cond["nik LIKE  '%" . $data['search_query'] . "%' 
				OR kpj LIKE  '%" . $data['search_query'] . "%' 
				OR first_name LIKE  '%" . $data['search_query'] . "%' 
				OR last_name LIKE  '%" . $data['search_query'] . "%' 
				OR phone_number LIKE  '%" . $data['search_query'] . "%' 
				OR email LIKE  '%" . $data['search_query'] . "%' 
				OR birth_date LIKE  '%" . $data['search_query'] . "%' 
				OR birth_place LIKE  '%" . $data['search_query'] . "%' 
				OR address LIKE  '%" . $data['search_query'] . "%' "] = NULL;
			}
		}
		// if ($data['nik'] != NULL) {
		// 	$cond["nik = '" . $data['nik'] . "'"] = NULL;
		// }
		// if ($data['kpj'] != NULL) {
		// 	$cond["kpj = '" . $data['kpj'] . "'"] = NULL;
		// }
		// if ($data['first_name'] != NULL) {
		// 	$cond["first_name = '" . $data['first_name'] . "'"] = NULL;
		// }
		// if ($data['last_name'] != NULL) {
		// 	$cond["last_name = '" . $data['last_name'] . "'"] = NULL;
		// }
		// if ($data['phone_number'] != NULL) {
		// 	$cond["phone_number = '" . $data['phone_number'] . "'"] = NULL;
		// }
		// if ($data['email'] != NULL) {
		// 	$cond["email = '" . $data['email'] . "'"] = NULL;
		// }
		// if ($data['birth_date'] != NULL) {
		// 	$cond["birth_date = '" . $data['birth_date'] . "'"] = NULL;
		// }
		// if ($data['birth_place'] != NULL) {
		// 	$cond["birth_place = '" . $data['birth_place'] . "'"] = NULL;
		// }
		// if ($data['address'] != NULL) {
		// 	$cond["address = '" . $data['address'] . "'"] = NULL;
		// }
		// if ($data['search'] != NULL) {
		// 	$cond["nik LIKE  '%" . $data['search'] . "%' 
		// 	OR kpj LIKE  '%" . $data['search'] . "%' 
		// 	OR first_name LIKE  '%" . $data['search'] . "%' 
		// 	OR last_name LIKE  '%" . $data['search'] . "%' 
		// 	OR phone_number LIKE  '%" . $data['search'] . "%' 
		// 	OR email LIKE  '%" . $data['search'] . "%' 
		// 	OR birth_date LIKE  '%" . $data['search'] . "%' 
		// 	OR birth_place LIKE  '%" . $data['search'] . "%' 
		// 	OR address LIKE  '%" . $data['search'] . "%' "] = NULL;
		// }
		$raw_data = $this->Bpjs_model->get_data_where_pagination(
			array(
				"table" => "bpjs_participants",
				"columns" => array(
					'*',
				),
				"join" => array(),
				"pagination" => $data['pagination'],
				"page_target" => $data['page_target'],
				"length_per_page" => $data['length_per_page'],
				"condition" => $cond,
				"order" => array(),
			)
		);



		$all = $this->Bpjs_model->get_data_where_pagination(
			array(
				"table" => "bpjs_participants",
				"columns" => array(
					'nik'
				),
				"join" => array(),
				"pagination" => 'all',
				"page_target" => $data['page_target'],
				"length_per_page" => $data['length_per_page'],
				"condition" => array(),
				"order" => array(),
			)
		);
		$total_items = $this->Bpjs_model->get_rows_query_binder("SELECT FOUND_ROWS() as total_rows", array())[0]['total_rows'] + 0;
		$page_total = ($data['pagination'] == "all") ? "all" : ceil($total_items / $data['length_per_page']);
		if (($data['pagination'] == "page") && ($page_total < $data['page_target']) &&  ($page_total != 0)) {
			$error[] = array(
				'id' => "out_of_length",
				'message' => "Target page is bigger than available total page"
			);

			$result = array(
				'code' => 400,
				'status' => 'BAD_REQUEST',
				'errors' => $error
			);

			$this->output_response(false, "NOK", $result, 403);
			// set_status_header(403);
			// header("Content-type: application/json");
			// echo json_encode($result);
			exit;
		} else {
			$page_length = ($data['pagination'] == "all") ? $total_items : $data['length_per_page'];
			$page_current_id = ($data['pagination'] == "all") ? "all" : $data['page_target'];
			$page_next = ($data['pagination'] == "all") ? "all" : $data['page_target'] + 1;
			$raw_data_total = count($raw_data);
			if (!empty($raw_data)) {
				$result = array(
					// 'code' => 200,
					// 'status' => 'OK',
					'result' => array(
						'total_items' => $total_items,
						'raw_data_total' => $raw_data_total,
						'raw_data' => $raw_data,
						'page_total' => $page_total,
						'page_next' => $page_next > $page_total ? $page_total : $page_next,
						'page_length' => $page_length > $page_total ? $page_total : $page_length,
						'page_current_id' => $page_current_id,
					)
				);
				set_status_header(200);
			} else {
				$error[] = array(
					'id' => "data_not_found",
					'message' => "Data Not Found"
				);
				$result = array(
					'code' => 404,
					'status' => 'NOT_FOUND',
					'erros' => $error
				);

				$this->output_response(false, "Data not found", $error, 404);
				// set_status_header(400);
				// header("Content-type: application/json");
				// echo json_encode($result);
				exit;
			}
		}
		$this->output_response(true, "OK", $result, 200);
		// set_status_header(200);
		// header("Content-type: application/json");
		// echo json_encode($result);
		exit;

		$data = $this->Bpjs_model->get_all();
		$this->output_response(true, "Get data successfully", $data, 200);
	}

	public function create()
	{
		if (!$this->is_post_request()) {
			$this->output_response(false, "Method not allowed", null, 405);
			return;
		}
		$this->authenticate();
		$this->form_validation->set_rules('nik', 'nik', 'required|numeric|is_unique[bpjs_participants.nik]|min_length[16]|max_length[16]');
		$this->form_validation->set_rules('kpj', 'kpj', 'required|numeric|is_unique[bpjs_participants.kpj]|min_length[11]|max_length[11]');
		$this->form_validation->set_rules('first_name', 'first_name', 'required|min_length[5]');
		$this->form_validation->set_rules('last_name', 'last_name', 'min_length[5]');
		$this->form_validation->set_rules('phone_number', 'phone_number', 'required|numeric|min_length[5]');
		$this->form_validation->set_rules('email', 'email', 'is_unique[bpjs_participants.email]|min_length[6]');
		$this->form_validation->set_rules('birth_date', 'birth_date', 'required|callback_validate_birth_date');
		$this->form_validation->set_rules('birth_place', 'birth_place', 'required|min_length[6]');
		$this->form_validation->set_rules('address', 'address', 'required|min_length[6]');

		// Cek Validasi
		if ($this->form_validation->run() == FALSE) {
			$this->output_response(false, "Validation Error", $this->form_validation->error_array(), 400);
			return;
		}

		$data = [
			'nik' => $this->input->post('nik'),
			'kpj' => $this->input->post('kpj'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'phone_number' => $this->input->post('phone_number'),
			'email' => $this->input->post('email'),
			'birth_date' => $this->input->post('birth_date'),
			'birth_place' => $this->input->post('birth_place'),
			'address' => $this->input->post('address'),
		];

		$this->Bpjs_model->insert($data);
		$this->output_response(true, "Participant created", $data, 200);
	}

	public function update($nik)
	{
		if ($this->input->method() !== 'put') {
			$this->output_response(false, "Method not allowed", null, 405);
			return;
		}
		$this->authenticate();
		$data = json_decode(file_get_contents('php://input'), true);
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules('kpj', 'kpj', 'numeric|min_length[11]|max_length[11]');
		$this->form_validation->set_rules('first_name', 'first_name', 'min_length[5]');
		$this->form_validation->set_rules('last_name', 'last_name', 'min_length[5]');
		$this->form_validation->set_rules('phone_number', 'phone_number', 'numeric|min_length[5]');
		$this->form_validation->set_rules('email', 'email', 'min_length[6]');
		$this->form_validation->set_rules('birth_date', 'birth_date', 'callback_validate_birth_date');
		$this->form_validation->set_rules('birth_place', 'birth_place', 'min_length[6]');
		$this->form_validation->set_rules('address', 'address', 'min_length[6]');

		// Cek Validasi
		if ($this->form_validation->run() == FALSE) {
			$this->output_response(false, "Validation Error", $this->form_validation->error_array(), 400);
			return;
		}

		$participant = $this->Bpjs_model->get_by_nik($nik);
		if (!$participant) {
			$this->output_response(false, "Participant not found", null, 404);
			return;
		}

		$data2update = [];
		if (isset($data['kpj'])) {
			$data2update['kpj'] = $data['kpj'];
		}
		if (isset($data['first_name'])) {
			$data2update['first_name'] = $data['first_name'];
		}
		if (isset($data['last_name'])) {
			$data2update['last_name'] = $data['last_name'];
		}
		if (isset($data['phone_number'])) {
			$data2update['phone_number'] = $data['phone_number'];
		}
		if (isset($data['email'])) {
			$data2update['email'] = $data['email'];
		}
		if (isset($data['birth_date'])) {
			$data2update['birth_date'] = $data['birth_date'];
		}
		if (isset($data['birth_place'])) {
			$data2update['birth_place'] = $data['birth_place'];
		}
		if (isset($data['address'])) {
			$data2update['address'] = $data['address'];
		}
		$update = $this->Bpjs_model->update($nik, $data2update);
		if ($update) {
			$this->output_response(true, "Participant updated successfully", $data2update, 200);
		} else {
			$this->output_response(false, "Failed to update participant", $update, 500);
		}
	}

	public function check_unique_kpj($kpj_input, $nik_original)
	{
		if ($this->Bpjs_model->is_unique_kpj($kpj_input, $nik_original)) {
			return TRUE;
		}
		$this->form_validation->set_message('check_unique_kpj', 'The {field} is already taken.');
		return FALSE;
	}

	public function delete($nik)
	{
		// Autentikasi JWT
		$this->authenticate();

		// Validasi hanya menerima metode DELETE
		if ($this->input->server('REQUEST_METHOD') !== 'DELETE') {
			$this->output_response(false, "Invalid method", null, 405); // 405 Method Not Allowed
			return;
		}

		// Cek apakah peserta dengan NIK yang diberikan ada
		$participant = $this->Bpjs_model->get_by_nik($nik);
		if (!$participant) {
			$this->output_response(false, "Participant not found", null, 404);
			return;
		}

		// Hapus peserta
		if ($this->Bpjs_model->delete($nik)) {
			$this->output_response(true, "Participant deleted successfully", null, 200);
		} else {
			$this->output_response(false, "Failed to delete participant", null, 500);
		}
	}
	public function view($nik)
	{
		if ($this->input->server('REQUEST_METHOD') !== 'GET') {
			$this->output_response(false, "Invalid method", null, 405); // 405 Method Not Allowed
			return;
		}
		$this->authenticate();
		$data = $this->Bpjs_model->get_one(array(
			'nik' => $nik
		));

		if (isset($data[0])) {
			$this->output_response(true, "Get data successfully", $data[0], 200);
		} else {
			$this->output_response(false, "Data not found", $data, 404);
		}
	}

	public function validate_birth_date($birth_date)
	{
		if ($birth_date == null) {
			return true;
		}
		$format = 'Y-m-d';

		// Cek Format Tanggal
		$d = DateTime::createFromFormat($format, $birth_date);

		if ($d && $d->format($format) === $birth_date) {
			return TRUE;
		} else {
			$this->form_validation->set_message('validate_birth_date', 'The {field} field must be in YYYY-MM-DD format.');
			return FALSE;
		}
	}
}
