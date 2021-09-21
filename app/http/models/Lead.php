<?php

/**
* Lead
*/
class Lead extends Model
{
	public function getLeadswithwebclient()
	{
		$query = $this->model->query("SELECT `cm_leads`.`id`,`name`,`company`,`email`,`phone`,`site_url`,`status`,`date_of_joining` FROM `" . DB_PREFIX . "leads` JOIN `cm_web_clients` ON `cm_leads`.`id` = `cm_web_clients`.`lead_id`");
		
		return $query->rows;
	}

	public function getLeads($user = NULL, $search = NULL , $website = NULL)
	{
		if (!$user && !$search) {
			$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "leads`");
		
			 
		}elseif($search && !$user){
			$con = new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
			if($website)
			{
				$sql = "Select * From cm_leads WHERE website_id = $website AND (email LIKE '%$search%' OR firstname LIKE '%$search%' OR lastname LIKE '%$search%')";
			}
			else
			{
				$sql = "Select * From cm_leads WHERE email LIKE '%$search%' OR firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
			}
			$result = $con->query($sql);;
			return $result->fetch_all(MYSQLI_ASSOC);
		}
		 else {
			$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "leads` WHERE `user_id` = ?",array($user));
		}
		return $query->rows;
	}
	
	public function check_lead_exist($data){
	     
	    	$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "leads` WHERE `email` = ?",array($this->model->escape($data['email'])));
            if($query->num_rows > 0){
                return true;
            }else{
                
                return false;
            }
	  
	}

	public function getLead($id = NULL)
	{
	 
		if (!$id) {
		   
			$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "leads` WHERE `id` = ? ", array($id));
		 
		} else {
			$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "leads` WHERE `id` = ? ", array((int)$id));
	
		} 
		return $query->row;
	}

	public function getStaff()
	{
		$query = $this->model->query("SELECT `user_id`, concat(`firstname`, ' ', `lastname`) AS `name`, `user_name` FROM `" . DB_PREFIX . "users` WHERE user_role != ? ", array(1));
		return $query->rows;
	}
	
	public function update_assign_list($data){
	    
     $query = $this->model->query("UPDATE `" . DB_PREFIX . "leads` SET `user_id` = ? WHERE `id` = ? ", array($data['staff'], (int)$data['id']));

	    
	}

	public function updateLead($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "leads` SET `salutation` = ?, `firstname` = ?, `lastname` = ?, `company` = ?, `email` = ?, `phone` = ?, `website` = ?, `address` = ?, `country` = ?, `remark` = ?, `source` = ?, `marketing` = ?, `expire` = ?, `status` = ?, `website_id` = ?, `user_id` = ? WHERE `id` = ? ", array($this->model->escape($data['salutation']), $this->model->escape($data['firstname']), $this->model->escape($data['lastname']), $this->model->escape($data['company']), $this->model->escape($data['email']), $this->model->escape($data['phone']), $this->model->escape($data['website']), $data['address'], $this->model->escape($data['country']), $data['remark'], $data['source'], $data['marketing'], $data['expire'], $data['status'], $data['website_id'], $data['staff'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createLead($data)
	{
	  
    //   	var_dump($data);
    //   	die;
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "leads` (`salutation`, `firstname`, `lastname`, `company`, `email`, `phone`, `website`, `address`, `country`, `remark`, `source`, `marketing`, `expire`, `status`, `website_id`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->model->escape($data['salutation']), $this->model->escape($data['firstname']), $this->model->escape($data['lastname']), $this->model->escape($data['company']), $this->model->escape($data['email']), $this->model->escape($data['phone']), $this->model->escape($data['website']), $data['address'], $this->model->escape($data['country']), $data['remark'], $data['source'], $data['marketing'], $data['expire'], $data['status'], $data['website_id'], $data['staff']));
		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function convertLeadToContact($data)
	{
		$query = $this->model->query("SELECT `id` FROM `" . DB_PREFIX . "contacts` WHERE `lead_id` = ?", array((int)$data['id']));
		  
		if ($query->num_rows < 1) {
		    
	 
			$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "contacts` (`salutation`, `firstname`, `lastname`, `company`, `email`, `phone`, `website`, `address`, `country`, `remark`, `marketing`, `expire`, `lead_id`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->model->escape($data['salutation']), $this->model->escape($data['firstname']), $this->model->escape($data['lastname']), $this->model->escape($data['company']), $this->model->escape($data['email']), $this->model->escape($data['phone']), $this->model->escape($data['website']), $data['address'], $this->model->escape($data['country']), $data['remark'], $data['marketing'], $data['expire'], $data['id'], $data['user_id']));

			if ($query->num_rows > 0) {
				$id = $this->model->last_id();
				$this->model->query("UPDATE `" . DB_PREFIX . "leads` SET `contact_id` = ?, `status` = ? WHERE `id` = ? ", array($id, 6, (int)$data['id']));

				return $id;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function deleteLead($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "leads` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

}