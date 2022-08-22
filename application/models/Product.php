<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model {

	public function get_all_products()
    {
        return $this->db->query("SELECT * FROM items")->result_array();
    }

    public function get_cart()
    {
        return $this->db->query(
            "SELECT carts.id, carts.product_id, products.product_name, SUM(carts.quantity) AS quantity, products.price
                FROM carts
                LEFT JOIN  products ON carts.product_id =  product.id
                GROUP BY items.item_name")->result_array();
    }
   
    function find_product($id)
    {
        return $this->db->query("SELECT * FROM products WHERE id = ?", array($id))->row_array();
    }

    function count_products()
    {
        return $this->db->query("SELECT * FROM carts WHERE carts.quantity != 0")->result_array();
    }

    public function total_price()
    {
        return $this->db->query(
            "SELECT SUM((products.price * carts.quantity)) as total_price
                FROM carts
                LEFT JOIN products ON products.id = carts.product_id")->row()->total_price;
    }

    public function get_orders($data)
    {
        $query = "INSERT INTO carts(product_id, quantity, created_at, updated_at) VALUES (?,?,?,?)";
        $values = array($data['product_id'], $data['quantity'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
        return $this->db->query($query, $values);
    }
   

    public function delete_item($id )
    {
        return $this->db->query("DELETE FROM carts WHERE id = ?", $id);
    }
}
