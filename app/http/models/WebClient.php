<?php

class WebClient extends Model{
    public function createWebClient($data)
    {
        $query = $this->model->query("INSERT INTO `".DB_PREFIX."web_clients` (`name`,`site_url`) VALUES(?,?)",array($data['site_name'],$data['site_url']));
        if($query->num_rows > 0)
        {
            return $this->model->last_id();
        }
        else
        {
            return false;
        }
    }
    public function selectWebClient($id = null)
    {
        if($id != null)
        {
            $query = $this->model->query("SELECT * from `".DB_PREFIX."web_clients` WHERE `id`=?",array((int)$id));
        }
        else
        {
            $query = $this->model->query("SELECT * from `".DB_PREFIX."web_clients`");
        }
        return $query->rows;
    }
    public function updateWebClient($data)
    {
        $query = $this->model->query("UPDATE `".DB_PREFIX."web_clients` SET `name`=?, `site_url`=? WHERE `id`=?",array($data['site_name'],$data['site_url'],$data['id']));
    }
    public function deleteWebClient($id)
    {   
        $query = $this->model->query("DELETE FROM `".DB_PREFIX."web_clients` WHERE `id`=?",array((int)$id));
    }

}
?>