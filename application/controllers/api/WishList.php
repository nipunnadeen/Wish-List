<?php

require APPPATH . '/libraries/REST_Controller.php';

class WishList extends \Restserver\Libraries\REST_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function lists_get()
    {
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
            $items = $this->WishListModel->getWishListData();
            if (!empty($items)) {
                $this->set_response($items, \Restserver\Libraries\REST_Controller::HTTP_OK);
                // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Wish list could not be found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
                // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function lists_post()
    {
        $data = [
            'name' => $this->post('name'),
            'description' => $this->post('description'),
            'owner' => $this->post('owner'),
            'categoryid' => $this->post('categoryid'),
        ];

        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
            if ($data['name'] === NULL || $data['description'] === NULL || $data['owner'] === NULL ||
                $data['categoryid'] === NULL) {
                $this->response(['status' => FALSE, 'message' => 'Data not found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
                // NOT_FOUND (404) being the HTTP response code
            } else {
                $list = $this->WishListModel->createWishList($data);

                $message = [
                    'message' => 'Server error',
                    'response' => $list
                ];
                if ($list == true) {
                    $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                } else {
                    $this->response($message, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function lists_put()
    {
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
            $data = [
                'name' => $this->put('name'),
                'description' => $this->put('description'),
                'owner' => $this->put('owner'),
                'categoryid' => $this->put('categoryid'),
            ];

            print_r($data);

            if ($data['name'] === NULL || $data['description'] === NULL || $data['owner'] === NULL ||
                $data['categoryid'] === NULL) {
                $this->response(['status' => FALSE, 'message' => 'Data not found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
                // NOT_FOUND (404) being the HTTP response code
            } else {
                $list = $this->WishListModel->updateWishList($data);
                $message = [
                    'message' => 'Server error',
                    'response' => $list
                ];
                if ($list == true) {
                    $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                } else {
                    $this->response($message, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
                }
            }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function categories_get()
    {
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
            $items = $this->CategoryModel->getCategories();

            if (!empty($items)) {
                $this->set_response($items, \Restserver\Libraries\REST_Controller::HTTP_OK);
                // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Categories could not be found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
                // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function priorities_get()
    {
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
            $items = $this->PriorityModel->getPriorities();

            if (!empty($items)) {
                $this->set_response($items, \Restserver\Libraries\REST_Controller::HTTP_OK);
                // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Categories could not be found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
                // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }
}