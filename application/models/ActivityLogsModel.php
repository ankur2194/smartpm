<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ActivityLogsModel extends CI_Model
{
	private $table = 'activity_logs';

	// private static $module = [
	// 	0 => 'lead_client'
	// ];

	// private static $type = [
	// 	0 => 'new',
	// 	1 => 'new_note',
	// 	2 => 'new_photos',
	// 	3 => 'new_documents',
	// 	4 => 'change_status'
	// ];

	public function getLast50()
	{
		$this->db->select("
            activity_logs.*,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname,
            CONCAT(client.firstname, ' ', client.lastname) as client_name
        ");
		$this->db->from($this->table);
		$this->db->join('users as users_created_by', 'activity_logs.created_by=users_created_by.id', 'left');
		$this->db->join('jobs as client', 'activity_logs.module_id=client.id', 'left');
		$this->db->where('activity_logs.is_deleted', FALSE);
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result();
	}

	public function insert($data)
	{
		$data['created_by'] = $this->session->id;
		$insert = $this->db->insert($this->table, $data);
		return $insert ? $this->db->insert_id() : $insert;
	}

	/**
	 * Static Methods
	 */
	// public static function typeToStr($id)
	// {
	// 	return isset(self::$type[$id]) ? self::$type[$id] : $id;
	// }

	// public static function getType()
	// {
	// 	return self::$type;
	// }

	public static function stringifyLog($log)
	{
		if ($log->module == 0) {
			if ($log->type == 0) {
				return $log->created_user_fullname . ' - Added new Client: <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 1) {
				$activity_data = json_decode($log->activity_data);
				return $log->created_user_fullname . ' - Added a Note to <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at . '<br />"' . $activity_data->note . '"';
			} else if ($log->type == 2) {
				return $log->created_user_fullname . ' - Added new Photo to <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 3) {
				return $log->created_user_fullname . ' - Added new Document to <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 4) {
				$activity_data = json_decode($log->activity_data);
				return $log->created_user_fullname . ' - Updated Client <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> status to "' . LeadModel::statusToStr($activity_data->status) . '" - ' . $log->created_at;
			}
		}

		return '-';
	}
}