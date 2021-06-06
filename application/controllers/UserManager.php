<?php


class UserManager extends CI_Controller
{
    public function index()
    {
        $this->load->view('template/header');
        $this->load->view('login');
        $this->load->view('template/footer');
    }

    public function register()
    {
        $this->load->view('template/header');
        $this->load->view('register');
        $this->load->view('template/footer');
    }
}