<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carts extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cart');
	}

	public function index()
	{
		$data['products'] = array(			
			'cart' => $this->Cart->count_items(),
			'items' => $this->Cart->get_all_items(),
		);
		$this->load->view('carts', $data);
	}

	public function add_to_cart()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric|is_natural_no_zero|less_than_equal_to[30]');
		$this->form_validation->set_rules('item','Item', 'callback_item_exist');
		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('error', validation_errors('<p class="error">', '</p>'));
			redirect('/');
		}
		else
		{
			$items = $this->Cart->find_product($this->input->post('item', TRUE));
			$data = array(
				'item_id' => $items['id'],
				'quantity' => $this->security->xss_clean($this->input->post('quantity', TRUE))
			);
			$this->session->set_flashdata('success', 'Item has been added.');
			$this->Cart->insert_orders($data);
			redirect('/');
		}
			
	}

	public function checkout()
	{
		$data['products'] = array(
			'items' =>$this->Cart->get_cart(),
			'total_price' => $this->Cart->total_items()
		);
		$this->load->view('checkout', $data);
	}

	public function remove_item($id)
	{
		$this->Cart->delete_item($id);
		$this->session->set_flashdata('remove', 'Item/s removed successfuly');
		redirect('carts/checkout');
	}

	public function item_exist($id)
	{
		if(!$this->Cart->find_product($id))
		{
			$this->form_validation->set_message('item_exist', 'Item does not exist');
			return FALSE;
		}
	}
}
