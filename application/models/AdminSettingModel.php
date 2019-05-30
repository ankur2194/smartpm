<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminSettingModel extends CI_Model
{
    private $table = 'admin_setting';

    public function insert($data)
	{
		$insert = $this->db->insert($this->table, $data);
		return $insert ? $this->db->insert_id() : $insert;
	}
}
