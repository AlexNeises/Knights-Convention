<?php
class Pages extends CI_Controller
{
	public function view($page = 'home')
	{
		if (!file_exists(APPPATH . 'views/pages/' . $page . '.php'))
		{
			show_404('errors/_404');
		}

		$data['logo'] = ucfirst($page);
		$data['type'] = 'flex';
		$data['top_text'] = 'Kansas Knights Convention';
		$data['bottom_text'] = '--logo--';
		// var_dump(News_Model::get_by_slug('test-1'));
		$data['news_item'] = News_Model::get_all();
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