<?php
require APPPATH . '/libraries/REST_Controller.php';

class ShareList extends \Restserver\Libraries\REST_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function shares_get()
    {
        $uuid = $this->get('uuid');
        $items = $this->WishListItemModel->getWishListShareItems($uuid);
        print_r($uuid);
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
    }
}