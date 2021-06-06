<?php


class WishListManager extends CI_Controller
{
    public function index()
    {
        $this->load->view('template/userHeader');
        $this->load->view('wishlist');
        $this->load->view('template/footer');
    }
}