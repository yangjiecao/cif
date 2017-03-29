<?php 
class Test_model extends CI_Model {
	public function __construct () 
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_all_test ()
	{
		$query = $this->db->get('test');
		return $query->result();
	}
	public function get_by_id ($id, $array=array())
	{
		$str = implode(',', $array);
		$this->db->select($str);
		$query = $this->db->get_where('test',['id'=>$id]);
		return $query->result();
	}
	// 插入单条数据
	public function insert ($arr=array())
	{
		$this->db->insert('test', $arr);
	}
	// 多条数据批量插入
	public function insert_batch ($arr=array())
	{
		$this->db->insert_batch('test',$arr);
	}
	// 批量增加
	public function set ($num=0)
	{
		$this->db->set('degree','degree+'.$num,FALSE);
		$this->db->update('test');
	}
	//删除数据
	public function del ($id)
	{
		$this->db->delete('test', array('id'=>$id));
	}
	public function set_news ()
	{
		$data = array(
			'name'	=>	$this->input->post('name'),
			'degree'=>	$this->input->post('degree')
		);
		return $this->db->insert('test',$data);
	}
}