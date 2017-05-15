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
		$data['title'] = 'Please register to continue';

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

		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if (!is_null($this->session->flashdata('server')))
		{
			$this->session->set_flashdata('server', $this->session->flashdata('server'));
		}

		if ($this->form_validation->run() === false)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('registration/login');
			$this->load->view('templates/footer');
		}
		else
		{
			if (Users_Model::confirmed($this->input->post('username', true)))
			{
				if (Users_Model::login($this->input->post('username', true), $this->input->post('password', true)))
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
					redirect('/login');
				}
			}
			else
			{
				$this->session->set_flashdata('alert', 'Your account has not been confirmed. Please <a href="' . base_url('/resend') . '">click here</a> to resend a confirmation email.');
				redirect('/login');
			}
		}
	}

	public function resend()
	{
		$data['logo'] = ucfirst('home');
		$data['type'] = 'flex';
		$data['top_text'] = 'Resend Confirmation';
		$data['bottom_text'] = null;
		$data['title'] = 'Please enter your information';

		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];

		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('registration/resend');
			$this->load->view('templates/footer');
		}
		else
		{
			if ($account = Users_Model::can_resend($this->input->post('username', true), $this->input->post('email', true)))
			{
				$confirmation = md5(openssl_random_pseudo_bytes(32));
				$account->set_confirmation($confirmation);
				$account->save();

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $this->config->item('mailgun_url') . '/messages');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, true);

				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $this->config->item('mailgun_api'));

				curl_setopt($ch, CURLOPT_POSTFIELDS, array(
					'from'		=> 'Kansas Convention 2019 <noreply@kansas-kofc2019.org>',
					'to'		=> $account->get_email_address(),
					'subject'	=> 'Account Confirmation',
					'html'		=> '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width"><title>Title</title></head><body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;box-sizing:border-box;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important"><style>@media only screen{html{min-height:100%;background:#f3f3f3}}@media only screen and (max-width:596px){.small-float-center{margin:0 auto!important;float:none!important;text-align:center!important}.small-text-center{text-align:center!important}.small-text-left{text-align:left!important}.small-text-right{text-align:right!important}}@media only screen and (max-width:596px){.hide-for-large{display:block!important;width:auto!important;overflow:visible!important;max-height:none!important;font-size:inherit!important;line-height:inherit!important}}@media only screen and (max-width:596px){table.body table.container .hide-for-large,table.body table.container .row.hide-for-large{display:table!important;width:100%!important}}@media only screen and (max-width:596px){table.body table.container .callout-inner.hide-for-large{display:table-cell!important;width:100%!important}}@media only screen and (max-width:596px){table.body table.container .show-for-large{display:none!important;width:0;mso-hide:all;overflow:hidden}}@media only screen and (max-width:596px){table.body img{width:auto;height:auto}table.body center{min-width:0!important}table.body .container{width:95%!important}table.body .column,table.body .columns{height:auto!important;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;padding-left:16px!important;padding-right:16px!important}table.body .column .column,table.body .column .columns,table.body .columns .column,table.body .columns .columns{padding-left:0!important;padding-right:0!important}table.body .collapse .column,table.body .collapse .columns{padding-left:0!important;padding-right:0!important}td.small-1,th.small-1{display:inline-block!important;width:8.33333%!important}td.small-2,th.small-2{display:inline-block!important;width:16.66667%!important}td.small-3,th.small-3{display:inline-block!important;width:25%!important}td.small-4,th.small-4{display:inline-block!important;width:33.33333%!important}td.small-5,th.small-5{display:inline-block!important;width:41.66667%!important}td.small-6,th.small-6{display:inline-block!important;width:50%!important}td.small-7,th.small-7{display:inline-block!important;width:58.33333%!important}td.small-8,th.small-8{display:inline-block!important;width:66.66667%!important}td.small-9,th.small-9{display:inline-block!important;width:75%!important}td.small-10,th.small-10{display:inline-block!important;width:83.33333%!important}td.small-11,th.small-11{display:inline-block!important;width:91.66667%!important}td.small-12,th.small-12{display:inline-block!important;width:100%!important}.column td.small-12,.column th.small-12,.columns td.small-12,.columns th.small-12{display:block!important;width:100%!important}table.body td.small-offset-1,table.body th.small-offset-1{margin-left:8.33333%!important;Margin-left:8.33333%!important}table.body td.small-offset-2,table.body th.small-offset-2{margin-left:16.66667%!important;Margin-left:16.66667%!important}table.body td.small-offset-3,table.body th.small-offset-3{margin-left:25%!important;Margin-left:25%!important}table.body td.small-offset-4,table.body th.small-offset-4{margin-left:33.33333%!important;Margin-left:33.33333%!important}table.body td.small-offset-5,table.body th.small-offset-5{margin-left:41.66667%!important;Margin-left:41.66667%!important}table.body td.small-offset-6,table.body th.small-offset-6{margin-left:50%!important;Margin-left:50%!important}table.body td.small-offset-7,table.body th.small-offset-7{margin-left:58.33333%!important;Margin-left:58.33333%!important}table.body td.small-offset-8,table.body th.small-offset-8{margin-left:66.66667%!important;Margin-left:66.66667%!important}table.body td.small-offset-9,table.body th.small-offset-9{margin-left:75%!important;Margin-left:75%!important}table.body td.small-offset-10,table.body th.small-offset-10{margin-left:83.33333%!important;Margin-left:83.33333%!important}table.body td.small-offset-11,table.body th.small-offset-11{margin-left:91.66667%!important;Margin-left:91.66667%!important}table.body table.columns td.expander,table.body table.columns th.expander{display:none!important}table.body .right-text-pad,table.body .text-pad-right{padding-left:10px!important}table.body .left-text-pad,table.body .text-pad-left{padding-right:10px!important}table.menu{width:100%!important}table.menu td,table.menu th{width:auto!important;display:inline-block!important}table.menu.small-vertical td,table.menu.small-vertical th,table.menu.vertical td,table.menu.vertical th{display:block!important}table.menu[align=center]{width:auto!important}table.button.small-expand,table.button.small-expanded{width:100%!important}table.button.small-expand table,table.button.small-expanded table{width:100%}table.button.small-expand table a,table.button.small-expanded table a{text-align:center!important;width:100%!important;padding-left:0!important;padding-right:0!important}table.button.small-expand center,table.button.small-expanded center{min-width:0}}</style><table class="body" data-made-with-foundation="" style="Margin:0;background:#f3f3f3;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td class="float-center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;float:none;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0 auto;padding:0;text-align:center;vertical-align:top;word-wrap:break-word"><center data-parsed="" style="min-width:580px;width:100%"><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td></tr></tbody></table><table align="center" class="container body-drip float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td></tr></tbody></table><center data-parsed="" style="min-width:580px;width:100%"><img src="http://kansas-kofc2019.org/static/images/logomedium.png" style="-ms-interpolation-mode:bicubic;Margin:0 auto;clear:both;display:block;float:none;margin:0 auto;max-width:150px;outline:0;text-align:center;text-decoration:none;width:auto" alt="" align="center" class="float-center"></center><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td></tr></tbody></table><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><h4 class="text-center" style="Margin:0;Margin-bottom:10px;color:inherit;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center;word-wrap:normal">Confirm Account</h4><p class="text-center" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">You\'re almost done!</p></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></tbody></table></th></tr></tbody></table><hr><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p class="text-center" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">Click the button below to finish creating your account. Once completed, you\'ll be able to purchase banquet and luncheon tickets, as well as register for the convention itself.</p><center data-parsed="" style="min-width:532px;width:100%"><table class="button success float-center" style="Margin:0 0 16px 0;border-collapse:collapse;border-spacing:0;float:none;margin:0 0 16px 0;padding:0;text-align:center;vertical-align:top;width:auto"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background:#3adb76;border:0 solid #3adb76;border-collapse:collapse!important;color:#fefefe;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><a href="' . base_url('/confirm/' . $confirmation) . '" style="Margin:0;border:0 solid #3adb76;border-radius:3px;color:#fefefe;display:inline-block;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:700;line-height:1.3;margin:0;padding:8px 16px 8px 16px;text-align:left;text-decoration:none">Confirm ↣</a></td></tr></tbody></table></td></tr></tbody></table></center></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></tbody></table></th></tr></tbody></table><table class="row collapsed footer" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td></tr></tbody></table><p class="text-center" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">© Knights of Columbus Council #8488. All rights reserved.</p></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></tbody></table></th></tr></tbody></table></td></tr></tbody></table></center></td></tr></tbody></table></body></html>',
					'text'		=> 'Your account is almost complete. In order to confirm your account, please click the link below or copy and paste it into your browser.\n\n' . base_url('/confirm/' . $confirmation)
				));
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				$result = curl_exec($ch);
				curl_close($ch);

				$this->session->set_flashdata('success', 'An email has been sent to ' . $account->get_email_address() . ' with further instructions. If you didn\'t receive an email, check your spam folder or send an email to <a href="mailto:help@kansas-kofc2019.org">help@kansas-kofc2019.org</a>.');
				redirect('/');
			}
			else
			{
				$this->session->set_flashdata('alert', 'There is no username associated with this email address.');
				$this->load->view('templates/header', $data);
				$this->load->view('registration/resend');
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
		$data['title'] = 'Please register to continue';

		$readme = file_get_contents('README.md');
		$secondhalf = explode('## Version ', $readme);
		$version = explode("\n\n### CHANGELOG", $secondhalf[1]);
		$data['version'] = $version[0];

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('username', 'Username', 'trim|callback_username_check|alpha_numeric');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required|matches[password]');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('registration/index');
			$this->load->view('templates/footer');
		}
		else
		{
			$recaptcha = $this->input->post('g-recaptcha-response');
			$response = $this->recaptcha->verifyResponse($recaptcha);

			if (isset($response['success']) && $response['success'] === true)
			{
				$confirmation = md5(openssl_random_pseudo_bytes(32));
				$user = new Users_Model();
				$user->set_first_name($this->input->post('first_name', true));
				$user->set_last_name($this->input->post('last_name', true));
				$user->set_username($this->input->post('username', true));
				$user->set_email_address($this->input->post('email_address', true));
				$user->set_password($this->input->post('password'), true);
				$user->set_confirmation($confirmation);
				$user->set_confirmed(0);
				$user->save();
				
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $this->config->item('mailgun_url') . '/messages');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, true);

				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $this->config->item('mailgun_api'));

				curl_setopt($ch, CURLOPT_POSTFIELDS, array(
					'from'		=> 'Kansas Convention 2019 <noreply@kansas-kofc2019.org>',
					'to'		=> $this->input->post('email_address', true),
					'subject'	=> 'Account Confirmation',
					'html'		=> '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width"><title>Title</title></head><body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;box-sizing:border-box;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important"><style>@media only screen{html{min-height:100%;background:#f3f3f3}}@media only screen and (max-width:596px){.small-float-center{margin:0 auto!important;float:none!important;text-align:center!important}.small-text-center{text-align:center!important}.small-text-left{text-align:left!important}.small-text-right{text-align:right!important}}@media only screen and (max-width:596px){.hide-for-large{display:block!important;width:auto!important;overflow:visible!important;max-height:none!important;font-size:inherit!important;line-height:inherit!important}}@media only screen and (max-width:596px){table.body table.container .hide-for-large,table.body table.container .row.hide-for-large{display:table!important;width:100%!important}}@media only screen and (max-width:596px){table.body table.container .callout-inner.hide-for-large{display:table-cell!important;width:100%!important}}@media only screen and (max-width:596px){table.body table.container .show-for-large{display:none!important;width:0;mso-hide:all;overflow:hidden}}@media only screen and (max-width:596px){table.body img{width:auto;height:auto}table.body center{min-width:0!important}table.body .container{width:95%!important}table.body .column,table.body .columns{height:auto!important;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;padding-left:16px!important;padding-right:16px!important}table.body .column .column,table.body .column .columns,table.body .columns .column,table.body .columns .columns{padding-left:0!important;padding-right:0!important}table.body .collapse .column,table.body .collapse .columns{padding-left:0!important;padding-right:0!important}td.small-1,th.small-1{display:inline-block!important;width:8.33333%!important}td.small-2,th.small-2{display:inline-block!important;width:16.66667%!important}td.small-3,th.small-3{display:inline-block!important;width:25%!important}td.small-4,th.small-4{display:inline-block!important;width:33.33333%!important}td.small-5,th.small-5{display:inline-block!important;width:41.66667%!important}td.small-6,th.small-6{display:inline-block!important;width:50%!important}td.small-7,th.small-7{display:inline-block!important;width:58.33333%!important}td.small-8,th.small-8{display:inline-block!important;width:66.66667%!important}td.small-9,th.small-9{display:inline-block!important;width:75%!important}td.small-10,th.small-10{display:inline-block!important;width:83.33333%!important}td.small-11,th.small-11{display:inline-block!important;width:91.66667%!important}td.small-12,th.small-12{display:inline-block!important;width:100%!important}.column td.small-12,.column th.small-12,.columns td.small-12,.columns th.small-12{display:block!important;width:100%!important}table.body td.small-offset-1,table.body th.small-offset-1{margin-left:8.33333%!important;Margin-left:8.33333%!important}table.body td.small-offset-2,table.body th.small-offset-2{margin-left:16.66667%!important;Margin-left:16.66667%!important}table.body td.small-offset-3,table.body th.small-offset-3{margin-left:25%!important;Margin-left:25%!important}table.body td.small-offset-4,table.body th.small-offset-4{margin-left:33.33333%!important;Margin-left:33.33333%!important}table.body td.small-offset-5,table.body th.small-offset-5{margin-left:41.66667%!important;Margin-left:41.66667%!important}table.body td.small-offset-6,table.body th.small-offset-6{margin-left:50%!important;Margin-left:50%!important}table.body td.small-offset-7,table.body th.small-offset-7{margin-left:58.33333%!important;Margin-left:58.33333%!important}table.body td.small-offset-8,table.body th.small-offset-8{margin-left:66.66667%!important;Margin-left:66.66667%!important}table.body td.small-offset-9,table.body th.small-offset-9{margin-left:75%!important;Margin-left:75%!important}table.body td.small-offset-10,table.body th.small-offset-10{margin-left:83.33333%!important;Margin-left:83.33333%!important}table.body td.small-offset-11,table.body th.small-offset-11{margin-left:91.66667%!important;Margin-left:91.66667%!important}table.body table.columns td.expander,table.body table.columns th.expander{display:none!important}table.body .right-text-pad,table.body .text-pad-right{padding-left:10px!important}table.body .left-text-pad,table.body .text-pad-left{padding-right:10px!important}table.menu{width:100%!important}table.menu td,table.menu th{width:auto!important;display:inline-block!important}table.menu.small-vertical td,table.menu.small-vertical th,table.menu.vertical td,table.menu.vertical th{display:block!important}table.menu[align=center]{width:auto!important}table.button.small-expand,table.button.small-expanded{width:100%!important}table.button.small-expand table,table.button.small-expanded table{width:100%}table.button.small-expand table a,table.button.small-expanded table a{text-align:center!important;width:100%!important;padding-left:0!important;padding-right:0!important}table.button.small-expand center,table.button.small-expanded center{min-width:0}}</style><table class="body" data-made-with-foundation="" style="Margin:0;background:#f3f3f3;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td class="float-center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;float:none;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0 auto;padding:0;text-align:center;vertical-align:top;word-wrap:break-word"><center data-parsed="" style="min-width:580px;width:100%"><table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td></tr></tbody></table><table align="center" class="container body-drip float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td></tr></tbody></table><center data-parsed="" style="min-width:580px;width:100%"><img src="http://kansas-kofc2019.org/static/images/logomedium.png" style="-ms-interpolation-mode:bicubic;Margin:0 auto;clear:both;display:block;float:none;margin:0 auto;max-width:150px;outline:0;text-align:center;text-decoration:none;width:auto" alt="" align="center" class="float-center"></center><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td></tr></tbody></table><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><h4 class="text-center" style="Margin:0;Margin-bottom:10px;color:inherit;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center;word-wrap:normal">Confirm Account</h4><p class="text-center" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">You\'re almost done!</p></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></tbody></table></th></tr></tbody></table><hr><table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><p class="text-center" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">Click the button below to finish creating your account. Once completed, you\'ll be able to purchase banquet and luncheon tickets, as well as register for the convention itself.</p><center data-parsed="" style="min-width:532px;width:100%"><table class="button success float-center" style="Margin:0 0 16px 0;border-collapse:collapse;border-spacing:0;float:none;margin:0 0 16px 0;padding:0;text-align:center;vertical-align:top;width:auto"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background:#3adb76;border:0 solid #3adb76;border-collapse:collapse!important;color:#fefefe;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><a href="' . base_url('/confirm/' . $confirmation) . '" style="Margin:0;border:0 solid #3adb76;border-radius:3px;color:#fefefe;display:inline-block;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:700;line-height:1.3;margin:0;padding:8px 16px 8px 16px;text-align:left;text-decoration:none">Confirm ↣</a></td></tr></tbody></table></td></tr></tbody></table></center></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></tbody></table></th></tr></tbody></table><table class="row collapsed footer" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"><table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td></tr></tbody></table><p class="text-center" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">© Knights of Columbus Council #8488. All rights reserved.</p></th><th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></tbody></table></th></tr></tbody></table></td></tr></tbody></table></center></td></tr></tbody></table></body></html>',
					'text'		=> 'Your account is almost complete. In order to confirm your account, please click the link below or copy and paste it into your browser.\n\n' . base_url('/confirm/' . $confirmation)
				));
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				$result = curl_exec($ch);
				curl_close($ch);

				$this->session->set_flashdata('success', 'An email has been sent to ' . $this->input->post('email_address', true) . ' with further instructions. If you didn\'t receive an email, check your spam folder or send an email to <a href="mailto:help@kansas-kofc2019.org">help@kansas-kofc2019.org</a>.');
				redirect('/');
			}
			else
			{
				$this->session->set_flashdata('alert', 'The captcha you entered is incorrect.');
				$this->load->view('templates/header', $data);
				$this->load->view('registration/index');
				$this->load->view('templates/footer');
			}
		}
	}

	public function confirm($hash = null)
	{
		if (is_null($hash))
		{
			redirect('/');
		}
		if (Users_Model::already_confirmed($hash))
		{
			$this->session->set_flashdata('success', 'Account has already been confirmed. Please log in.');
		}
		else
		{
			if (Users_Model::confirm_user($hash))
			{
				$this->session->set_flashdata('success', 'Account confirmed, please log in.');
			}
			else
			{
				$this->session->set_flashdata('alert', 'Unable to confirm account, please contact <a href="mailto:help@kansas-kofc2019.org">help@kansas-kofc2019.org</a> for assistance.');
			}
		}
		redirect('/login');
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