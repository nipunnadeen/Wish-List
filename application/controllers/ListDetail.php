<?php


class ListDetail extends CI_controller
{
    public function index()
    {
        $this->load->view('template/userHeader');
        $this->load->view('createWishList');
        $this->load->view('template/footer');
    }

    public function updateWishList()
    {
        $this->load->view('template/userHeader');
        $this->load->view('updateWishList');
        $this->load->view('template/footer');
    }
}