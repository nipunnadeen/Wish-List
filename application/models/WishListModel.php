<?php

class WishListModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function createWishList($listData)
    {
        try {
            $userData = $this->session->get_userdata('userDetails');
            $userId = $userData['userDetails']['id'];
            $checkWishList = $this->getWishListData();
            $uuId = uniqid();
            if(empty($checkWishList)){
                $data = array('uuid' => $uuId, 'name' => $listData['name'], 'description' => $listData['description'], 'owner' => $listData['owner'],
                    'userid' => $userId, 'categoryid' => $listData['categoryid']);
                $query = $this->db->insert('wishlists', $data);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function getWishListData()
    {
        $userData = $this->session->get_userdata('userDetails');
        $userId = $userData['userDetails']['id'];
        $query = $this->db->get_where('wishlists', array('userid' => $userId));

        return $query->row_array();
    }

    public function updateWishList($listData)
    {
        try {
            $userData = $this->session->get_userdata('userDetails');
            $userId = $userData['userDetails']['id'];
            $checkWishList = $this->getWishListData();
            if(!empty($checkWishList)) {
                $wishListId = $checkWishList['id'];
                $data = array('name' => $listData['name'], 'description' => $listData['description'],
                    'owner' => $listData['owner'], 'userid' => $userId, 'categoryid' => $listData['categoryid']);
                $where = "id = $wishListId AND userid = $userId";
                $query = $this->db->update('wishlists', $data, $where);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}