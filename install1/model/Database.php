<?php

/**
* Model Database
*/
class Database
{
    private $hostname;
	private $username;
	private $password;
	private $database;
	
    /**
    * Check database exists or not
    */
    public function check_db($data)
    {
        $this->hostname = $data['db_hostname'];
        $this->username = $data['db_username'];
        $this->password = $data['db_password'];
        $this->database = $data['db_name'];
        $this->port = '3306';
        
        $db = new mysqli($this->hostname, $this->username, $this->password, $this->database, $this->port);
        if($db->connect_errno) {
            return $db->connect_error;
        }
        else {
            if ($db->select_db($this->database) === false) {
                return $db->connect_error;
            }
            else {
                return true;
            }
        }
    }
    /**
    * Setup Database and insert admin in user table
    */
    public function setup_db($data) 
    {
        $this->hostname = $data['db_hostname'];
        $this->username = $data['db_username'];
        $this->password = $data['db_password'];
        $this->database = $data['db_name'];
        
        $db = new mysqli($this->hostname, $this->username, $this->password);
        if($db->connect_errno) {
            return $db->connect_error;
        }
        else {
            if ($db->select_db($this->database) === false) {
                return $db->connect_error;
            }
        }
        
        $file = 'libs/client_manager.sql';

        if (!file_exists($file)) {
            return 'Could not load sql file: ' . $file;
        }

        $lines = file($file);

        if ($lines) {
            $sql = '';
            foreach ($lines as $line) {
                if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
                    $sql .= $line;

                    if (preg_match('/;\s*$/', $line)) {
                        $sql = str_replace("DROP TABLE IF EXISTS `kk_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $sql);
                       $sql = str_replace("CREATE TABLE IF NOT EXISTS `kk_", "CREATE TABLE IF NOT EXISTS `" . $data['db_prefix'], $sql);
						$sql = str_replace("INSERT INTO `kk_", "INSERT INTO `" . $data['db_prefix'], $sql);

                        $db->query($sql);

                        $sql = '';
                    }
                }
            }
        }
        
        
        $id = 1;
        $this->passwordhash = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE `" . $data['db_prefix'] . "users` SET user_name = ?, firstname = ?, email = ?, password = ? WHERE user_id = ?";
		$statement = $db->stmt_init();
		if ($statement->prepare($sql)) {
			$statement->bind_param('ssssi', $data['username'], $data['name'], $data['email'], $this->passwordhash , $id);
			$statement->execute();
			$affected_rows = $db->affected_rows;
			if ($affected_rows <= '0') {
				$error = $db->error;
			}
			$statement->close();
		}
		
		if ($affected_rows <= '0') {
			return $error;
		}
        $this->url = HTTP_KLINIKAL;
		$sql = "UPDATE `" . $data['db_prefix'] . "info` SET url = ?, name = ?, email = ? WHERE id = ?";
            $statement = $db->stmt_init();
            if ($statement->prepare($sql)) {
                $statement->bind_param('sssi', $this->url, $data['name'], $data['email'], $id);
                $statement->execute();
                $affected_rows = $db->affected_rows;
                if ($affected_rows <= '0') {
                    $error = $db->error;
                }
                $statement->close();
            }
        $db->close();
        if ($affected_rows <= '0') {
            return $error;
        }
        else {
            return $affected_rows;
        }
    }
}