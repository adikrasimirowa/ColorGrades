<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function index()
    {   
        $is_logged = $this->session->userdata('is_logged');
        if (!(isset($is_logged) && $is_logged == TRUE))
        {
            $this->load->view('template/login_view');
        }else
        {
            redirect('dashboard');
        }
    }

    public function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Имейл', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Парола', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $this->load->model('user_model');
            if ($this->user_model->validate_login() == TRUE) {
                $data = array(
                    'is_logged' => TRUE,
                    'email' => $this->input->post('email')
                    );
                $this->session->set_userdata($data);
                redirect('dashboard');
            }else
            {
                $this->session->set_flashdata('err_login', 'Грешен имейл или парола!');
                redirect('login/index', 'refresh');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}