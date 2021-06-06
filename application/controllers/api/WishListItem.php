<?php
require APPPATH . '/libraries/REST_Controller.php';

class WishListItem extends \Restserver\Libraries\REST_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function items_get()
    {
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
                $items = $this->WishListItemModel->getUserWishListItems();
                if ($items != null || empty($items)) {
                    $this->set_response($items, \Restserver\Libraries\REST_Controller::HTTP_OK);
                    // OK (200) being the HTTP response code
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'items could not be found'
                    ], \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    // INTERNAL_SERVER_ERROR (500) being the HTTP response code
                }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function specificitems_get($id)
    {
        $itemId = $id;
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
            if ($itemId === NULL) {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'items could not be found'
                    ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
                    // NOT_FOUND (404) being the HTTP response code

            } else {
                if ($itemId <= 0) {
                    $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
                    // BAD_REQUEST (400) being the HTTP response code
                }
                $items = $this->WishListItemModel->getWishListItemData($itemId);

                if ($items != null) {
                    $this->set_response($items, \Restserver\Libraries\REST_Controller::HTTP_OK);
                    // OK (200) being the HTTP response code
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'User could not be found'
                    ], \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    // INTERNAL_SERVER_ERROR (500) being the HTTP response code
                }
            }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function items_post()
    {
        $data = [
            'title' => $this->post('title'),
            'description' => $this->post('description'),
            'priorityid' => $this->post('priorityid'),
            'quantity' => $this->post('quantity'),
            'price' => $this->post('price'),
            'url' => $this->post('url'),
        ];
        print_r($data);
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
            if ($data['title'] === NULL || $data['description'] === NULL || $data['priorityid'] === NULL ||
                $data['quantity'] === NULL || $data['price'] === NULL || $data['url'] === NULL ||
                is_numeric($data['quantity']) != 1 || is_numeric($data['price']) != 1) {
                $this->response(['status' => FALSE, 'message' => 'Data not found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
                // NOT_FOUND (404) being the HTTP response code
            } else {
                $item = $this->WishListItemModel->insertWishListItem($data);

                if ($item == true) {
                    $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
                    // CREATED (201) being the HTTP response code
                } else {
                    $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function deleteItems_delete($id)
    {
        $itemId = $id;
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
            // Validate the id.
            if ($itemId <= 0) {
                // Set the response and exit
                $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
                // BAD_REQUEST (400) being the HTTP response code
            }

            $responseData = $this->WishListItemModel->deleteWishListItem($itemId);
            $message = [
                'id' => $itemId,
                'message' => 'Deleted the resource',
                'response' => $responseData
            ];

            if ($responseData == true) {
                $this->set_response($message, \Restserver\Libraries\REST_Controller::HTTP_OK);
                // OK (200) being the HTTP response code
            } else {
                $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function items_put()
    {
        $data = [
            'itemid' => $this->put('itemid'),
            'title' => $this->put('title'),
            'description' => $this->put('description'),
            'priorityid' => $this->put('priorityid'),
            'quantity' => $this->put('quantity'),
            'price' => $this->put('price'),
            'url' => $this->put('url'),
        ];
        $isUserLoggedIn = $this->UserAuthenticateModel->checkUserLoggedIn();
        if($isUserLoggedIn == true) {
            if ($data['itemid'] === NULL || $data['title'] === NULL || $data['description'] === NULL || $data['priorityid'] === NULL ||
                $data['quantity'] === NULL || $data['price'] === NULL || $data['url'] === NULL ||
                is_numeric($data['quantity']) != 1 || is_numeric($data['price']) != 1) {
                $this->response(['status' => FALSE, 'message' => 'Data not found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
                // NOT_FOUND (404) being the HTTP response code
            } else {
                $list = $this->WishListItemModel->updateWishListItem($data);

                if ($list == true) {
                    $this->set_response($list, \Restserver\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                } else {
                    $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }
}