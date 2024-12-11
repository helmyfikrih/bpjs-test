<?php
class User_model extends CI_Model {
	public function __construct()
	{
		$this->load->library('uuid');
	}


    public function create_user($data) {
        $data['id'] = $this->uuid->v4();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('users', $data);
    }

    public function get_user($username) {
        return $this->db->get_where('users', ['username' => $username])->row();
    }
}
