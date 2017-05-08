<?php
class Errors extends CI_Controller
{
	public function _404()
	{
		$data['logo'] = 'Home';
		$data['type'] = 'flex';
		$data['top_text'] = 'Error 404';
		$data['bottom_text'] = null;
		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];
		$this->load->view('templates/header', $data);
		$this->load->view('pages/404', $data);
		$this->load->view('templates/footer', $data);
	}
}
?>