<?php
class MY_Exceptions extends CI_Exceptions {

    public function __construct()
    {
        parent::__construct();
        $this->ci =& get_instance();
    }

    public function show_404($page = '', $log_error = TRUE){

        header("HTTP/1.1 404 Not Found");

        $data['logo'] = 'Home';
        $data['type'] = 'flex';
        $data['top_text'] = 'Error 404';
        $data['bottom_text'] = null;
        $readme = file_get_contents('README.md');
        $secondhalf = explode('## Version ', $readme);
        $version = explode("\n\n### CHANGELOG", $secondhalf[1]);
        $data['version'] = $version[0];
        echo $this->ci->load->view('templates/header', $data, true);
        echo $this->ci->load->view('pages/404', $data, true);
        echo $this->ci->load->view('templates/footer', $data, true);
        exit(4);
    }
}
?>