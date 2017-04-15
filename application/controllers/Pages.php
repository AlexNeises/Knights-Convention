<?php
class Pages extends CI_Controller
{
	public function view($page = 'home')
	{
		if (!file_exists(APPPATH . 'views/pages/' . $page . '.php'))
		{
			show_404();
		}

		$data['logo'] = ucfirst($page);
		$data['type'] = 'flex';
		$data['top_text'] = 'Kansas Knights Convention';
		$data['bottom_text'] = '2019';
		$data['news_item'] = $this->news_model->get_news();
		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];

		$this->load->view('templates/header', $data);
		$this->load->view('pages/' . $page, $data);
		$this->load->view('templates/footer', $data);
	}
}
?>