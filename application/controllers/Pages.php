<?php
class Pages extends CI_Controller
{
	public function view($page = 'home')
	{
		if (!file_exists(APPPATH . 'views/pages/' . $page . '.php'))
		{
			show_404('errors/_404');
		}

		$this->email->from('noreply@kansas-kofc2019.org', 'Kansas Convention 2019');
		$this->email->to('alex@neis.es');

		$this->email->subject('Account Confirmation');
		$this->email->message('Testing the email class.');

		$this->email->send();

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