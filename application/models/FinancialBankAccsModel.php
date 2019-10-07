<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinancialBankAccsModel extends CI_Model
{
    private $table = 'financial_bank_accs';

    public function allBankAccs()
    {
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
        return $update;
    }
}
