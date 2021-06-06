<?php
require APPPATH . '/libraries/REST_Controller.php';

class User extends \Restserver\Libraries\REST_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function authenticateUsers_post()
    {
        $data = [
            'email' => $this->post('email'),
            'password' => $this->post('password'),
        ];
        if ($data['email'] == NULL || $data['password'] == NULL) {
            $this->response(['status' => FALSE, 'message' => 'No users were found'
            ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            // NOT_FOUND (404) being the HTTP response code
        } else {
            $isUserLoggedIn = $this->UserModel->authenticateUserLogin($data);

            if ($isUserLoggedIn == true) {
                $this->set_response($isUserLoggedIn, \Restserver\Libraries\REST_Controller::HTTP_OK);
                // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
                // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function registerUsers_post()
    {
        $data = [
            'firstname' => $this->post('firstname'),
            'lastname' => $this->post('lastname'),
            'email' => $this->post('email'),
            'password' => $this->post('password'),
        ];

        if ($data['firstname'] === NULL || $data['lastname'] === NULL || $data['email'] === NULL || $data['password'] === NULL) {
            $this->response(['status' => FALSE, 'message' => 'Data not found'
            ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            // NOT_FOUND (404) being the HTTP response code
        } else {
            $items = $this->UserModel->createUser($data);
            $message = [
                'isAdded' => $items,
                'message' => 'Added a resource'
            ];
            if ($items == true) {
                $this->set_response($message, \Restserver\Libraries\REST_Controller::HTTP_OK);
                // OK (200) being the HTTP response code
            } else {
                $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function signOutUsers_post()
    {
        $items = $this->UserModel->signOutUser();
        $message = [
            'isSignOut' => $items,
            'message' => 'Successfully sign out'
        ];
        if ($items == true) {
            $this->set_response($message, \Restserver\Libraries\REST_Controller::HTTP_OK);
            // OK (200) being the HTTP response code
        } else {
            $this->set_response(['status' => FALSE, 'message' => 'User could not be found'
            ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function loggedInUsers_get()
    {
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
                $this->set_response($isUserLoggedIn, \Restserver\Libraries\REST_Controller::HTTP_OK);
                // OK (200) being the HTTP response code
        } else {
            $this->response($isUserLoggedIn, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }


}