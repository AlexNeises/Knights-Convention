<?php
class Registration extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
	}

	public function index()
	{
		// $data['news'] = $this->news_model->get_news();
		$data['logo'] = 'Convention Registration';
		$data['type'] = 'standard';
		$data['top_text'] = 'Convention Registration';

		$this->load->view('templates/header', $data);
		$this->load->view('registration/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($slug = NULL)
	{
		$data['news_item'] = $this->news_model->get_news($slug);

		if (empty($data['news_item']))
		{
			show_404();
		}

		$data['title'] = $data['news_item']['title'];

		$this->load->view('templates/header', $data);
		$this->load->view('news/view', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{
		$data['title'] = 'Create a news item';

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('news/create');
			$this->load->view('templates/footer');
		}
		else
		{
			$this->news_model->set_news();
			$this->load->view('news/success');
		}
	}
}
?>