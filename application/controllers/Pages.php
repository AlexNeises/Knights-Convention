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

		$this->load->view('templates/header', $data);
		$this->load->view('pages/' . $page, $data);
		$this->load->view('templates/footer', $data);
	}
}
?>