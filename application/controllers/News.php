<?php
class News extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
	}

	public function index()
	{
		$data['news'] = News_Model::get_all();
		$data['logo'] = ucfirst('home');
		$data['type'] = 'flex';
		$data['top_text'] = 'News Archive';

		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];

		$this->load->view('templates/header', $data);
		$this->load->view('news/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($slug = NULL)
	{
		$data['logo'] = ucfirst('home');
		$data['type'] = 'flex';
		$data['bottom_text'] = null;

		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];

		$data['news_item'] = News_Model::get_by_slug($slug);

		if (empty($data['news_item']))
		{
			show_404();
		}
		
		$data['top_text'] = $data['news_item']->get_title();
		$data['title'] = $data['news_item']->get_title();

		$this->load->view('templates/header', $data);
		$this->load->view('news/view', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{
		if (!$this->session->userdata('logged_in'))
		{
			$this->session->set_flashdata('alert', 'You must be logged in to access this page.');
			$this->session->set_flashdata('server', $_SERVER['REQUEST_URI']);
			redirect('/login');
		}

		$data['logo'] = ucfirst('home');
		$data['type'] = 'flex';
		$data['top_text'] = 'Submit News';
		$data['bottom_text'] = null;
		$data['title'] = 'Submit news (markdown)';

		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('blurb', 'Blurb', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('news/create');
			$this->load->view('templates/footer');
		}
		else
		{
			$article = new News_Model();
			$article->set_title($this->input->post('title'));
			$article->set_slug(url_title($this->input->post('title'), 'dash', TRUE));
			$article->set_blurb($this->input->post('blurb'));
			$article->set_text($this->input->post('text'));
			$article->save();

			$this->load->view('templates/header', $data);
			$this->load->view('news/create');
			$this->load->view('templates/footer');
		}
	}
}
?>