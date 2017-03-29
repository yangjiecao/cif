<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function view($test='home')
	{
		if ( ! file_exists(APPPATH.'views/test/'.$test.'.php'))
		{
		    // Whoops, we don't have a page for that!
		    show_404();
		}

		$data['title'] = ucfirst($test); // Capitalize the first letter

		$this->load->view('template/header', $data);
		$this->load->view('test/'.$test, $data);
		$this->load->view('template/footer', $data);	
	}
}