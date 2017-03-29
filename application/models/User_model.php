<?php 
class User_model extends CI_Model {
	public function __construct () 
	{
		parent::__construct();
		$this->load->database();
	}
	// 插入单条数据
	public function insert ($arr)
	{
		$res = $this->db->insert('users', $arr);
		return $res;
	}
	// 获取总数
	public function total ()
	{
		return $this->db->count_all('users');
	}
	// 分页查询
	public function limit ($offset, $start)
	{
		return $this->db->limit($offset, $start)->order_by('id','DESC')->get('users')->result();
	}
}