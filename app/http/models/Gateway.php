<?php
class Gateway extends Model{
    public function createGateway($data)
    {
        $query = $this->model->query("INSERT INTO `".DB_PREFIX."payment` (`name`,`amount`,`project_id`) VALUES (?,?,?)",array($data['name'],$data['amount'],$data['project_id']));
        if($query->num_rows > 0)
        {
            return true;
        } else 
        {
          return false;
        }
    }
    public function selectGateway($id = null)
    {
        if($id === null)
        {
            $query = $this->model->query("SELECT `project_id`, SUM(`amount`) as `amount` FROM `".DB_PREFIX. "payment` GROUP BY `project_id`");    
        }
        else
        {
            $query = $this->model->query("SELECT * FROM `".DB_PREFIX. "payment` where `project_id` = ?", array((int)$id));
        }
        return $query->rows;
    }
    public function deleteGateway($id)
    {
        $query = $this->model->query("DELETE FROM `".DB_PREFIX."payment` WHERE `project_id` = ?",array($id));
        if ($query->num_rows > 0) 
        {
            return true;
        } else
        {
            return false;
        }
    }
}
?>