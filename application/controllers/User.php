<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model','user');
	}
	public function success () {
		$data['title'] = 'Success!';
		$this->load->view('user/success',$data);
	}
	public function page ($id=1) {
		$this->load->library('pagination');
		$config['base_url'] = 'http://cif.mvc/user/page';
		$config['total_rows'] = $this->user->total();
		$config['per_page'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = '&gt;';
		$config['prev_link'] = '&lt;';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '<p>';
		$this->pagination->initialize($config);
		$start = ($id-1)*$config['per_page'];
		$result = $this->user->limit($config['per_page'], $start);
		$data['title'] = 'Page';
		$data['results'] = $result;
		$this->load->view('user/page',$data);
	}
	public function create () {
		$data['csrf_name'] = $this->security->get_csrf_token_name();
		$data['csrf_hash'] = $this->security->get_csrf_hash();
		$data['title'] = 'Add User';
		return $this->load->view('user/create',$data);
	}
	public function add () {
		$this->load->library('form_validation');
	    $this->form_validation->set_rules('name', 'Name', 'required', array('required'=>'You must provide a %s.'));
	    $this->form_validation->set_rules('age', 'Age', 'required', array('required'=>'You must provide a %s.'));
	    $this->form_validation->set_rules('introduction', 'Introduction', 'required', array('required'=>'You must provide a %s.'));
	    if ($this->form_validation->run() === FALSE)
	    {
			return $this->output->set_content_type('application/json')->set_output(json_encode(['errCode'=>1,'msg'=>validation_errors()]));
	    }else{
	    	$data = array(
	    		'name'=>$this->input->post('name'),
	    		'age'=>$this->input->post('age'),
	    		'introduction'=>$this->input->post('introduction')
	    	);
	    	$res = $this->user->insert($data);
	    	if($res)
	    	{
	    		return $this->output->set_content_type('application/json')->set_output(json_encode(['errCode'=>0,'msg'=>'数据添加成功']));
	    	}else{
				return $this->output->set_content_type('application/json')->set_output(json_encode(['errCode'=>1,'msg'=>'数据添加失败']));
	    	}
	    }
	}
}

