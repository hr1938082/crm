<?php
class Order extends Model
{
    public function Create($data)
    {
      $query = $this->model->query("INSERT INTO `". DB_PREFIX ."order` (`paper_type`, `academic_level`, `subject`, `expected_result`, `deadline`, `style`, `paper_topic`, `number_of_pages`, `no_of_poster`, `no_of_reference`, `ppt_slides`, `ppt-slide-input`, `per-page-cost-input`, `per-poster-price-input`, `total-cost`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",array($data["paper_type"], $data["academic_level"], $data["subject"], $data["expected_result"], (int)$data["deadline"], $data["style"], $data["paper_topic"], (int)$data["number_of_pages"], (int)$data["no_of_poster"], (int)$data["no_of_reference"], (int)$data["ppt_slides"], (int)$data["ppt-slide-input"], (int)$data["per-page-cost-input"], (int)$data["per-poster-price-input"], (int)$data["total-cost"],));
      if ($query->num_rows > 0) {
      return $this->model->last_id();
      } else {
        return false;
      }
    }
    public function getOrder($data)
    {
      $query = $this->model->query("SELECT * FROM `". DB_PREFIX. "order` where `id` = ?", array((int)$data));
      return $query->rows;
    }
    public function update($data)
    {
      $query = $this->model->query("UPDATE `cm_order` SET `paper_type`=?,`academic_level`=?,`subject`=?,`expected_result`=?,`deadline`=?,`style`=?,`paper_topic`=?,`number_of_pages`=?,`no_of_poster`=?,`no_of_reference`=?,`ppt_slides`=?,`ppt-slide-input`=?,`per-page-cost-input`=?,`per-poster-price-input`=?,`total-cost`=? WHERE `id` = ?",array($data["paper_type"], $data["academic_level"], $data["subject"], $data["expected_result"], (int)$data["deadline"], $data["style"], $data["paper_topic"], (int)$data["number_of_pages"], (int)$data["no_of_poster"], (int)$data["no_of_reference"], (int)$data["ppt_slides"], (int)$data["ppt-slide-input"], (int)$data["per-page-cost-input"], (int)$data["per-poster-price-input"], (int)$data["total-cost"],(int)$data["id"]));
      if ($query->num_rows > 0) {
        return true;
      } else {
        return false;
      }
    }

    public function delete($data)
    {
      $query = $this->model->query("DELETE FROM `cm_order` WHERE `id` = ?" , array((int)$data));
      if ($query->num_rows > 0) {
        return true;
      } else {
        return false;
      }
    }
}
