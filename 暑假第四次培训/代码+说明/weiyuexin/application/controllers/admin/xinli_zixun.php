<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 文章控制器
 */
class Xinli_zixun extends MY_Controller{
    /*构造函数自动载入模型*/
    public function __construct(){
    	parent::__construct();
        $this->load->model('xinli_zixun_model');
    }

	/*查看心理咨询列表*/
    public function index(){
    	//载入分类页
    	$this->load->library('pagination');
    	$perPage = 6;

    	//配置项设置
    	$config['base_url'] = site_url('admin/xinli_zixun/index');
    	$config['total_rows'] = $this->db->count_all_results('news');
    	$config['per_page'] = $perPage;
    	$config['uri_segment'] = 4;
    	$config['first_link'] = '首页';
    	$config['prev_link'] = '上一页';
    	$config['next_link'] = '下一页';
    	$config['last_link'] = '尾页';

    	$this->pagination->initialize($config);

    	$data['links'] = $this->pagination->create_links();
    	$offset = $this->uri->segment(4);
    	$this->db->limit($perPage,$offset);

		$data['xinli_zixun'] = $this->xinli_zixun_model->check();
		$this->load->view('admin/xinli_zixun_list',$data);
    }

	/*发表文章模板显示*/
	public function send_xinli_zixun()
	{
		$this->load->helper('form');
		$this->load->view('admin/xinli_zixun');
	}

	/*发表文章动作*/
	public function send()
	{
		//载入表单验证类
		$this->load->library('form_validation');
		//设置规则
		$this->form_validation->set_rules('writer','文章作者','required|max_length[99]');

		$this->form_validation->set_rules('title','文章标题','required|max_length[99]');

		$this->form_validation->set_rules('content','文章内容','required');
		//执行验证
		$status = $this->form_validation->run();
		
		if($status){
			$data = array(
				'writer' => $this->input->post('writer') , 
				'title'  => $this->input->post('title') ,
				'content' => $this->input->post('content') ,
				'addtime' => time()
			);
			$this->xinli_zixun_model->add($data);
			success('admin/xinli_zixun/index','发布成功!');
		}else{
			$this->load->helper('form');
		    $this->load->view('admin/xinli_zixun');
		}
	}

	/*编辑文章*/
	public function edit_xinli_zixun()
	{
		$id = $this->uri->segment(4);
		$data['xinli_zixun'] = $this->xinli_zixun_model->check_id($id);
        $this->load->helper('form');
        $this->load->view('admin/edit_xinli_zixun',$data);
	}
    /*编辑文章动作*/
	public function edit()
	{
		//载入表单验证类
		$this->load->library('form_validation');
		//设置规则
		$this->form_validation->set_rules('writer','文章作者','required|min_length[5]|max_length[99]');

		$this->form_validation->set_rules('title','文章标题','required|min_length[5]|max_length[99]');

		$this->form_validation->set_rules('content','文章内容','required');
		//执行验证
		$status = $this->form_validation->run();
		
		if($status){
			$id = $this->input->post('id');
			$writer = $this->input->post('writer');
			$title = $this->input->post('title');
			$content = $this->input->post('content');
			$data = array(
				'writer' => $writer, 
				'title'  => $title,
				'content' => $content
			);
		    $data['xinli_zixun'] = $this->xinli_zixun_model->update_xinli_zixun($id,$data);
		    success('admin/xinli_zixun/index','修改成功!');
		}else{
			$this->load->helper('form');
		    $this->load->view('admin/edit_xinli_zixun');
		}
	}


	/*删除心理咨询*/
	public function del(){
		$id = $this->uri->segment(4);
		$this->xinli_zixun_model->delete_xinli_zixun($id);
		success('admin/xinli_zixun/index','删除成功!');
	}
}