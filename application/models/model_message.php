<?php
class Model_Message extends CI_Model {
	
	function __construct() {
		 parent::__construct();	
	}
	
	function saveValues($tblName, $arrData, $arrWhere = array()) {
		
		if(count($arrWhere)) {
				
			foreach($arrWhere as $key => $value) {
				if(strpos($key, ' in ')) {
					$this->db->where($key, $arrWhere[$key], false);
					unset($arrWhere[$key]);
				}
			}
			
			foreach($arrWhere as $strKey => $strVal) {
				if(strpos($strKey, '.')) {
					$arrWhere[substr($strKey, (strpos($strKey, '.') + 1))] = $strVal;
					unset($arrWhere[$strKey]);
				}
			}
			
			$this->db->update($tblName, $arrData, $arrWhere);
			return ($this->db->affected_rows() > 0);
		} else {
			$this->db->insert($tblName, $arrData);
			return $this->db->insert_id();
		}
		
	}
	
	function validateUserLimit($userIP) {
		
		$this->db->select('msg_timestamp');
		$this->db->where('msg_user_ip', $userIP);
		$this->db->order_by('msg_timestamp', 'DESC');
		$this->db->limit(1);
		$objResult = $this->db->get(TABLE_MESSAGES);
		$arrResult = $objResult->result_array();
		$objResult->free_result();
		
		return (int)(strtotime('now') - (int)$arrResult[0]['msg_timestamp']);
	}
	
	function getMessages() {
		
		$this->db->order_by('msg_timestamp', 'DESC');
		$this->db->limit(10);
		
		$objResult = $this->db->get(TABLE_MESSAGES);
		$arrResult = $objResult->result_array();
		$objResult->free_result();
		
		return $arrResult;
	}
	
	function updateCountryStat($countryCode) {
		if(!empty($countryCode)) {
			$this->db->set('countries_msg_count', 'countries_msg_count + 1', FALSE);
			$this->db->where('countries_iso_code_2', $countryCode);
			$this->db->update(TABLE_COUNTRIES); 
		}
	}
	
	function getCountryStat() {
		
		$this->db->select(' countries_name, countries_msg_count ');
		$this->db->where('countries_msg_count > ', 0);
		$this->db->order_by('countries_msg_count', 'DESC');
		$this->db->limit(10);
		
		$objResult = $this->db->get(TABLE_COUNTRIES);
		$arrResult = $objResult->result_array();
		$objResult->free_result();
		
		return $arrResult;
	}
}
?>