<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bpjs_model extends CI_Model
{

	public function get_rows_query_binder($query2bind, $array4key_binder){
		$query = $this->db->query($query2bind, $array4key_binder);
		// echo ($this->db->last_query());
		return $query->result_array();
	}
	public function get_data_where_pagination($query)
	{
		$dbName = $query['table'];
		$array4key = ($query['condition'] == null) ? array() : $query['condition'];
		$header2return = implode($query['columns'], ",");
		$pagination = ($query['pagination'] == "all") ? array() : array(
			$query['length_per_page'],
			($query['page_target'] - 1) * $query['length_per_page']
		);

		$having4key = (isset($query['having'])) ? $query['having'] : array();
		$joinArray = (isset($query['join'])) ? $query['join'] : NULL;
		$orderBy = (isset($query['order'])) ? implode($query['order'], ",") : array();
		$groupBy = (isset($query['group'])) ? $query['group'] : array();

		$this->db->select($header2return);
		$this->db->from($dbName);
		if ($joinArray != null) {
			foreach ($joinArray as $key => $value) {
				$this->db->join($key, $value['statement'], $value['join_type']);
			}
		}

		$this->db->where($array4key);

		if (!empty($having4key)) {
			$this->db->having($having4key);
		}

		if (!empty($orderBy)) {
			$sorting = (isset($query['sorting'])) ? $query['sorting'] : 'ASC';
			$this->db->order_by($orderBy, $sorting);
		}

		if (!empty($pagination)) {
			$this->db->limit($pagination[0], $pagination[1]);
		}

		if (!empty($groupBy)) {
			$this->db->group_by($groupBy);
		}

		$query = $this->db->get();
		// echo ($this->db->last_query());
		if ($this->db->error()['code'] == 0) {
			return $query->result_array();
		} else {
			return $this->db->error();
		}
	}

	public function get_all()
	{
		return $this->db->get('bpjs_participants')->result();
	}

	public function get_one($where)
	{
		$this->db->where($where);
		return $this->db->get('bpjs_participants')->result();
	}

	public function insert($data)
	{
		return $this->db->insert('bpjs_participants', $data);
	}

	public function update($nik, $data)
	{
		return $this->db->update('bpjs_participants', $data, ['nik' => $nik]);
	}

	public function delete($nik)
	{
		return $this->db->delete('bpjs_participants', ['nik' => $nik]);
	}

	public function get_by_nik($nik)
	{
		return $this->db->get_where('bpjs_participants', ['nik' => $nik])->row_array();
	}

	public function is_unique_kpj($kpj, $nik_original)
	{
		$this->db->where('nik !=', $nik_original);
		$this->db->where('kpj', $kpj);
		$query = $this->db->get('bpjs_participants');
		return $query->num_rows() === 0;
	}
}
