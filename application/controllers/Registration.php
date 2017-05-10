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
		$data['logo'] = 'Convention Registration';
		$data['type'] = 'standard';
		$data['top_text'] = 'Register';
		$data['bottom_text'] = null;
		$data['title'] = 'Register to continue.';

		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];

		$this->load->view('templates/header', $data);
		$this->load->view('registration/index', $data);
		$this->load->view('templates/footer');
	}

	public function logout()
	{
		Users_Model::logout();
		redirect('/');
	}

	public function login()
	{
		$data['logo'] = ucfirst('home');
		$data['type'] = 'flex';
		$data['top_text'] = 'Login';
		$data['bottom_text'] = null;
		$data['title'] = 'Please login to continue';

		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if (!is_null($this->session->flashdata('server')))
		{
			$this->session->set_flashdata('server', $this->session->flashdata('server'));
		}

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('registration/login');
			$this->load->view('templates/footer');
		}
		else
		{
			if (Users_Model::login($this->input->post('username'), $this->input->post('password')))
			{
				$this->session->set_flashdata('success', 'Login successful.');
				if (!is_null($this->session->flashdata('server')))
				{
					redirect($this->session->flashdata('server'));
				}
				redirect('/');
			}
			else
			{
				$this->session->set_flashdata('alert', 'Invalid username or password.');
				$this->load->view('templates/header', $data);
				$this->load->view('registration/login');
				$this->load->view('templates/footer');
			}
		}
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
		$data['logo'] = ucfirst('home');
		$data['type'] = 'flex';
		$data['top_text'] = 'Register';
		$data['bottom_text'] = null;
		$data['title'] = 'Please login to continue';

		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];

		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('username', 'Username', 'callback_username_check');
		$this->form_validation->set_rules('email_address', 'Email Address', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'required|matches[password]');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('registration/index');
			$this->load->view('templates/footer');
		}
		else
		{
			$user = new Users_Model();
			$user->set_first_name($this->input->post('first_name'));
			$user->set_last_name($this->input->post('last_name'));
			$user->set_username($this->input->post('username'));
			$user->set_email_address($this->input->post('email_address'));
			$user->set_password($this->input->post('password'), true);
			$user->set_confirmed(0);
			$user->save();
			$this->session->set_flashdata('success', 'Please check your email to confirm your account.');
			redirect('/');
		}
	}

	public function username_check($username)
	{
		if ($username == '')
		{
			$this->form_validation->set_message('username_check', 'The Username field is required.');
        	return false;
		}
		if (!Users_Model::unique_username($username))
		{
			$this->form_validation->set_message('username_check', 'The username ' . $username . ' is already registered.');
        	return false;
        }
        return true;
	}
}
?>