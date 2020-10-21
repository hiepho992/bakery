<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Page
 *
 * @author TNM Group
 */
class Bill extends MY_Controller {

	// public $menu = 'product';
	// public $page_title = 'Sản phẩm';

	public function __construct() {
		parent::__construct();
		// $this->_is_user();
		$this->menu = 'bill';
		$this->page_title = '';
		$this->load->model('admin/product_model');
		$this->load->model('admin/users_model');
		$this->load->model('admin/category_model');
		$this->load->model('admin/order_model');
		$this->load->model('admin/purse_model');
		$this->load->helper('cookie');
	}

	public function delete() {
		$id = $this->input->post('userid');
		$queryDetail = $this->db->get_where('order_detail', array('order_id' => $id));
		$price = $queryDetail->result();
		$result = $price[0]->price;
		$idUser = $this->session->userdata('user_info')['id'];
		$time = strtotime('21:00:00');
		$h = (int) date('H', $time);
		$i = (int) date('i', $time);
		$s = (int) date('s', $time);
		$timebefore = strtotime('8:00:00');
		$hb = (int) date('H', $timebefore);
		$ib = (int) date('i', $timebefore);
		$sb = (int) date('s', $timebefore);
		if ((int) $id > 0) {
			if ((int) date('H') < $hb) {
				die(json_encode(['html' => 'Bạn không thể hủy hàng trước 9 giờ sáng']));
			} else if ((int) date('H') >= $h && (int) date('i') > $i && (int) date('s') > $s) {
				die(json_encode(['html' => 'Bạn không thể hủy đơn hàng sau 21 giờ!']));
			} else {
				$this->db->delete('orders', array('order_id' => $id));
				$this->db->delete('order_detail', array('order_id' => $id));				
				$query = $this->purse_model->getPurse($idUser);
				foreach($query as $key => $value){
					$total = $value[0]->total + $result;
					$this->db->update('purses', array('total' => $total));
				}
				die(json_encode(['html' => 'Bạn đã hủy đơn hàng thành công.', 'check' => true]));
			}
			if ($this->session->userdata('check_click') != null) {
				$this->session->unset_userdata('check_click');
			}
		} else {
			if ($this->session->userdata('check_click') != null) {
				$this->session->unset_userdata('check_click');
			}
			redirect('home');
		}
	}

	public function index() {
		$this->_is_user();
		$user = $this->session->userdata('user_info');
		$data['items'] = $this->order_model->getOrderByIdUser($user['id']);
		$response = $this->_loadElement('bill/bill', $data, TRUE);
		die(json_encode(['html' => $response]));
	}
	public function addgiavi() {
		$giavi = $this->input->post('editgiavi');
		$id = $this->input->post('order_id');
		if ($id > 0) {
			$this->db->update('order_detail', array('giavi' => $giavi), array('order_id' => $id));
			$this->session->set_flashdata('check_not_img', 'thêm gia vị thành công');
			redirect('home');
		} else {
			redirect('home');
		}
	}
	// public function getBillByUser($id_user = 0) {
	// 	if ((int) $id > 0) {
	// 		$this->db->from()
	// 		$query = $this->db->get_where('order_detail', array('order_id' => $id));
	// 		return $query->row_array();
	// 	}
	// 	return null;
	// }

}
