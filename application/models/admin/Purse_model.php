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
		// $day = $purse[0]->created_date;
		// $date = date_format($day,"d");
		// var_dump($date);
		$day = getdate();
		$date = $day['mday'];
		foreach($purse as $value){
			if($date - 26 == 0){
				$value->total += 260000;
			}			
		}		

		return ['purse' => $purse];
	}
}

?>
