<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Model {

	public function get_all_items()
    {
        return $this->db->query("SELECT * FROM items")->result_array();
    }

    public function get_cart()
    {
        return $this->db->query(
            "SELECT carts.id, carts.item_id, items.item_name, SUM(carts.quantity) AS quantity, items.price
                FROM carts
                LEFT JOIN  items ON carts.item_id =  items.id
                GROUP BY carts.item_id")->result_array();
    }
   
    function find_product($id)
    {
        return $this->db->query("SELECT * FROM items WHERE id = ?", array($id))->row_array();
    }

    function count_items()
    {    
        return $this->db->query("SELECT sum(quantity) as quantity FROM carts")->row()->quantity;
    }

    public function total_items()
    {
        return $this->db->query(
            "SELECT SUM((items.price * carts.quantity)) as total_items
                FROM carts
                LEFT JOIN items ON items.id = carts.item_id")->row()->total_items;
    }

    public function insert_orders($data)
    {
        $query = "INSERT INTO carts(item_id, quantity, created_at, updated_at) VALUES (?,?,?,?)";
        $values = array($data['item_id'], $data['quantity'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
        return $this->db->query($query, $values);
    }
   
    public function delete_item($id)
    {
        return $this->db->query("DELETE FROM carts WHERE item_id = ?", $id);
    }
}





