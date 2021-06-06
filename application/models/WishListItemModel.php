<?php


class WishListItemModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getUserWishListItems()
    {
        try {
            $userData = $this->session->get_userdata('userDetails');
            $userId = $userData['userDetails']['id'];

            $checkWishList = $this->getWishListData();
            if(!empty($checkWishList)) {

                $this->db->select('wishlistitems.id,
                wishlistitems.title,
                wishlistitems.description,
                wishlistitems.priorityid,
                wishlistitems.quantity,wishlistitems.price,wishlistitems.url,wishlistitems.userid,wishlistitems.wishlistid, priorities.name ');
                $this->db->from('wishlistitems');
                $this->db->where('userid' , $userId);
                $this->db->join('priorities', 'priorities.id = wishlistitems.priorityid');

                $query = $this->db->get();

                return $query->result();
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function getWishListItemData($itemId)
    {
        try {
            $userData = $this->session->get_userdata('userDetails');
            $userId = $userData['userDetails']['id'];

            $checkWishList = $this->getWishListData();
            if(!empty($checkWishList)) {
                $query = $this->db->get_where('wishlistitems', array('userid' => $userId, 'id' => $itemId));
                return $query->row_array();
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function insertWishListItem($listData)
    {
        try {
            $userData = $this->session->get_userdata('userDetails');
            $userId = $userData['userDetails']['id'];

            $checkWishList = $this->getWishListData();
            if(!empty($checkWishList)){
                $wishListId = $checkWishList['id'];
                $data = array('title' => $listData['title'], 'description' => $listData['description'],
                    'priorityid' => $listData['priorityid'], 'quantity' => $listData['quantity'],
                    'price' => $listData['price'], 'url' => $listData['url'], 'userid' => $userId,
                    'wishlistid' => $wishListId);
                $query = $this->db->insert('wishlistitems', $data);
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

    public function updateWishListItem($listData)
    {
        try {
            $userData = $this->session->get_userdata('userDetails');
            $userId = $userData['userDetails']['id'];
            $checkWishList = $this->getWishListData();
            if(!empty($checkWishList)) {
                $wishListId = $checkWishList['id'];
                $itemId = $listData['itemid'];
                $data = array('title' => $listData['title'], 'description' => $listData['description'],
                    'priorityid' => $listData['priorityid'], 'quantity' => $listData['quantity'],
                    'price' => $listData['price'], 'url' => $listData['url'], 'userid' => $userId,
                    'wishlistid' => $wishListId);
                $where = "id = $itemId AND userid = $userId";
                $query = $this->db->update('wishlistitems', $data, $where);
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteWishListItem($itemId)
    {
        try {
            $query = $this->db->delete('wishlistitems', array('id' => $itemId));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getWishListShareItems($uuid)
    {
        try {
            $checkWishList = $this->getSpecificWishListData($uuid);
            if(!empty($checkWishList)) {
                $wishListId = $checkWishList['id'];
                $query = $this->db->get_where('wishlistitems', array('wishlistid' => $wishListId));

                return $query->result();
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function getSpecificWishListData($uuid)
    {
        $query = $this->db->get_where('wishlists', array('uuid' => $uuid));
        return $query->row_array();
    }

    public function getWishListData()
    {
        $userData = $this->session->get_userdata('userDetails');
        $userId = $userData['userDetails']['id'];
        $query = $this->db->get_where('wishlists', array('userid' => $userId));

        return $query->row_array();
    }
}