<?php


class UserModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function authenticateUserLogin($userData)
    {
        try {
            $checkUserData = $this->authenticateUserEmail($userData['email']);

            if ($checkUserData != null) {
                $userPassword = $checkUserData['password'];
                $isPasswordExists = $this->authenticateUserPassword($userData['password'], $userPassword);
                if($isPasswordExists == true){
                    $this->session->set_userdata('userDetails', $checkUserData);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function authenticateUserEmail($userEmail)
    {
        try {
            $query = $this->db->get_where('users', array('email' => $userEmail));
            return $query->row_array();
        } catch (Exception $e) {
            return null;
        }
    }

    public function authenticateUserPassword($userInputPassword, $userPassword)
    {
        $hashedPassword = password_verify($userInputPassword, $userPassword);

        if ($hashedPassword == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function createUser($userData)
    {
        try {
            $checkUserData = $this->authenticateUserEmail($userData['email']);
            $password = password_hash($userData['password'], PASSWORD_DEFAULT);
            if ($checkUserData == null) {
                $data = array('firstname' => $userData['firstname'], 'lastname' => $userData['lastname'],
                    'email' => $userData['email'], 'password' => $password);
                $query = $this->db->insert('users', $data);
                if($query == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function signOutUser()
    {
        $userDetails = $this->session->get_userdata('userDetails');
        $loggedIn = $userDetails['userDetails'];
        if(count($loggedIn) != 0) {
            $this->session->unset_userdata('userDetails');
            session_destroy();
            return true;
        } else {
            return false;
        }
    }
}