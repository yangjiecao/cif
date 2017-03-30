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
	// 下载
	public function download () {
		$this->load->helper('download');
		force_download('default.jpg', NULL);
	}
	// 目录
	public function dir () {
		$this->load->helper('directory');
		$map = directory_map('./', FALSE, TRUE);
		// var_dump($map);
		echo "<pre>";
		print_r($map);
		echo "</pre>";
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
	public function upload () {
        //上传配置  
        $config['upload_path']      = './uploads/';  
        $config['allowed_types']    = 'gif|jpg|png'; 
        // $config['file_name']		= time(); 
        $config['max_size']     = 100000;
        //加载上传类  
        $this->load->library('upload', $config);  
        //执行上传任务  
        if($this->upload->do_upload('file')){
        	echo $this->upload->data('file_name');
            // echo '上传成功';  //如果上传成功返回成功信息  
        }  
        else{  
            echo '上传失败，请重试'; //如果上传失败返回错误信息  
        }          		
	}
	public function captcha () {
		$this->load->helper('captcha');
		$this->load->helper('cookie');
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$vals = array(
			'img_path'		=>	'./captcha/',
			'img_url'		=>	'http://cif.mvc/captcha/',
			'word_length'	=>	8,
		);
		$cap = create_captcha($vals);
		$this->cache->save(md5($cap['time']), $cap['word'], 3600);
		set_cookie(md5($cap['time']), $cap['word'], 3600);
		return $cap;
	}
	public function captcha_test () {
		$data['image'] 		=	$this->captcha();
		$data['cookie_key']	=	md5($data['image']['time']);
		$data['csrf_name'] = $this->security->get_csrf_token_name();
		$data['csrf_hash'] = $this->security->get_csrf_hash();		
		$this->load->view('captcha',$data);
	}
	public function captcha_check () {
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$cookie_key	=	$this->input->post('cookie_key');
		$captcha 	=	$this->input->post('captcha');
		$cookie_val	=	$this->input->cookie($cookie_key);
		$cache_val	=	$this->cache->get($cookie_key);
		echo strtolower($captcha).'<br>'.strtolower($cookie_val).'<br>'.strtolower($cache_val);
	}
}

