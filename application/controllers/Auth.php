<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function index()
    {
        $this->load->view('login_view');
    }

    public function login()
    {
        $recaptcha_secret = '6LeATB8rAAAAAJgA5yct6It2E_N4tyBB999P6Lm9';
        $recaptcha_response = $this->input->post('g-recaptcha-response');

        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
        $response = json_decode($verify);

        if (!$response->success) {
            $this->session->set_flashdata('error', 'reCAPTCHA failed.');
            redirect('auth');
            exit;
        }

        $name = $this->input->post('name');
        $password = $this->input->post('password');

        $user = $this->Auth_model->getUserByName($name);

        if ($user && password_verify($password, $user->Password)) {
            $this->session->set_userdata('user', $user->Name);
            log_message('debug', 'User logged in successfully. Redirecting...');
            redirect('StudentController');
            exit;
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password.');
            redirect('auth');
            exit;
        }
    }

    public function logout()
{
    $this->session->unset_userdata('user');
    redirect('auth');
}

}