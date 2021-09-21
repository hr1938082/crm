<?php

/**
* Role
*/
class Role extends Model
{
		
	public function hasPermission($uri = 'contacts',  $id = 2)
	{
		$query = $this->model->query("SELECT `permission` FROM `" . DB_PREFIX . "user_role` WHERE `id` = ? LIMIT 1", array((int)$id));
		
		$role = json_decode($query->row['permission'], true);
		return $role;
	}
}