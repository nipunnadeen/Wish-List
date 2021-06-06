<?php

class UserAuthenticateModel extends CI_Model
{
    public function checkUserLoggedIn()
    {
        $userDetails = $this->session->get_userdata('userDetails');
        if(!empty($userDetails['userDetails'])) {
            return true;
        } else {
            return false;
        }
    }
}