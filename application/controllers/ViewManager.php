<?php


class ViewManager extends CI_Controller
{
    public function index()
    {
        $this->load->view('view');
        $this->load->view('template/footer');
    }
}