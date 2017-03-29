<?php 
class Blog extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('test_model','test');
	}

	public function index () 
	{
		echo 'Blog!';
	}
	public function news ($arg1='arg1',$arg2='arg2') 
	{
		// echo 'Blog News!'.'<br>'.$arg1.'<br>'.$arg2;
		$output = $this->output
    	->set_content_type('application/json','UTF-8')
    	->set_output(json_encode(array('arg1' => $arg1, 'arg2' => $arg2)));
		return $output;
	}
	public function photo () 
	{
		$output = $this->output
		->set_content_type('jpeg')
		->set_output(file_get_contents('meinv.jpg'));
		return $output;
	}
	public function view ($test,$id=null)
	{
		$data['title'] = 'Test';
		if(is_numeric($id))
		{
			$data['tests'] = $this->test->get_by_id($id,['id','name','degree']);
			if(empty($data['tests']))
			{
				show_404();
				return false;
			}
		}else{
			$data['tests'] = $this->test->get_all_test();
		}			
		$this->load->view('template/header', $data);
		$this->load->view('test/'.$test, $data);
		$this->load->view('template/footer');
		return false;
	}
	public function create ()
	{
	    $this->load->helper('form');
	    $this->load->library('form_validation');

	    $data['title'] = 'Add';

	    $this->form_validation->set_rules('name', 'Name', 'required');
	    $this->form_validation->set_rules('degree', 'Degree', 'required');
	    if ($this->form_validation->run() === FALSE)
	    {
	        $this->load->view('template/header', $data);
	        $this->load->view('test/create');
	        $this->load->view('template/footer');

	    }
	    else
	    {
	        $this->test->set_news();
	        $this->load->view('test/success');
	    }
	}
	public function db () 
	{
		// $this->load->model('test_model','test');
		$res = $this->test->get_all_test();
		// $res = $this->test->get_by_id(2,['name']);
		$output = $this->output
		->set_content_type('application/json')
		->set_output(json_encode($res));
		return $output;
	}
	public function insert ($arr = array())
	{
		//向数据库插入一条数据
		// $arr = ['name'=>'redis'];
		// $res = $this->test->insert($arr);
		//批量插入多条记录
		$arr = array(['name'=>'memcache'],['name'=>'mysql']);
		$res = $this->test->insert_batch($arr);
		return $res;
	}
	public function set ($num)
	{
		$res = $this->test->set($num);
		return $res;
	}
	public function del ($id)
	{
		$res = $this->test->del($id);
		return $res;
	}
}