<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->database();
		$this->load->model('Product');
	}

	public function index()
	{
		$data['product'] = array(			
			'cart' => count($this->Product->count_products()),
			'items' => $this->Product->get_all_products(),
		);
		
		$this->load->view('carts', $data);
	}

	public function add_to_cart()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric|is_natural_no_zero|less_than_equal_to[50]');
		$this->form_validation->set_rules('item','Item', 'callback_item_exist');
		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('error', validation_errors('<p class="error">', '</p>'));
			redirect('/');
		}
		else
		{
			$items = $this->Product->find_item($this->input->post('item', TRUE));
			$data = array(
				'item_id' => $items['id'],
				'quantity' => $this->input->post('quantity', TRUE)
			);
			$this->session->set_flashdata('success', 'Item has been added.');
			$this->Product->get_orders($data);
			redirect('/');
		}
			
	}

	public function checkout()
	{
		$data['product'] = array(
			'items' =>$this->Product->get_cart(),
			'total_price' => $this->Product->total_price()
		);
		$this->load->view('checkout', $data);
	}

	public function remove_item($id)
	{
		$this->Product->delete_item($id);
		$this->session->set_flashdata('remove', 'Item has been removed');
		redirect('carts/checkout');
	}

	public function item_exist($id)
	{
		if(!$this->Product->find_product($id))
		{
			$this->form_validation->set_message('item_exist', 'Item does not exist');
			return FALSE;
		}
	}
}
