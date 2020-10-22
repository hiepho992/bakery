<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
class Purse_model extends CI_Model{
	private $table = 'purses';
	public function __construct()
	{
		parent::__construct();
	}

	public function getPurse($id_user){
		$query = $this->db->get_where('purses', array('user_id' => $id_user));	 
		$purse = $query->result();
		$date = $purse[0]->created_date;
		$date_update = date('Y-m-d h:i:s');	
		$date_from = strtotime($date);
		$now = time();
		$count = $now - $date_from;
		$reset_total = floor($count/86400);
		// var_dump($reset_total);		
		if($reset_total == 30){
			$this->db->update('purses', array('total' => 260000, 'created_date' => $date_update));
		}

		return ['purse' => $purse];
	}
}

?>
