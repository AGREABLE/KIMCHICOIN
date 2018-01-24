<?php

class connector_m extends CI_Model {

	function _required($required, $data) {
		foreach($required as $field)
			if(!isset($data[$field]))
				return false;
		return true;
	}

	function _safe($data, $required) {
		foreach($required as $field)
			if ($field == $data) 
				return true;
		return false;
	}

	function create($tableName, $options = array()) {
		$options['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert($tableName, $options);
		return $this->db->insert_id();
	}

	function truncate($tableName) {
		$this->db->truncate($tableName); 
	}

	function get($tableName, $options = array(), $opts = 'single', $is_result_array = false) {

		if(isset($options['count'])) {
			unset($options['sortBy']);
			unset($options['sortDirection']);
			unset($options['offset']);
			unset($options['limit']);
		}

		foreach($options as $key => $val) {
			if (!$this->_safe($key, array('sortBy', 'sortDirection', 'limit', 'offset', 'count', 'list_idx', 'not', 'avg_val', 'list_in', 
					'list_secret_folder', 'after_this', 'search_created_date_time', 'select', 'created_date_time_start', 'created_date_time_end', 'created_at_start', 'win_start', 
					'recordCheckCount')) ) {
				if (strpos($key,'%') !== false) {
					$this->db->like( str_replace('%', '', $key), $val, 'both');
				} else if (strpos($key,'DATE(') !== false || strpos($key,'>') !== false || strpos($key,'<') !== false) {
					$this->db->where($key, $val, false);
				} else {
					$this->db->where($key, $val);
				}
			}
		}

		if(isset($options['win_start'])) {
			$this->db->where('win >', $options['win_start']);
		}

		if(isset($options['created_at_start'])) {
			$this->db->where('created_at >=', $options['created_at_start']);
		}

		if(isset($options['created_date_time_start'])) {
			$this->db->where('created_date_time >=', $options['created_date_time_start']);
		}

		if(isset($options['created_date_time_end'])) {
			$this->db->where('created_date_time <=', $options['created_date_time_end']);
		}

		if(isset($options['search_created_date_time']))
			$this->db->like('created_date_time', $options['search_created_date_time'], 'both');

		if(isset($options['list_secret_folder']))
			$this->db->where_not_in('product_group_m_idx', $options['list_secret_folder']);


		if(isset($options['select'])) {
			$this->db->select($options['select']);
		}


		if ( isset($options['not']) ) {
			foreach($options['not'] as $key => $val) {
				$this->db->where($key . ' !=', $val);
			}
		}		

		if ( isset($options['after_this']) ) {
			$this->db->where('id >', $options['after_this'] );
		}


		if ( isset($options['list_in']) ) {
			foreach($options['list_in'] as $key => $val) {
				$this->db->where_in($key, $val);
			}
		}
		
		if( isset($options['recordCheckCount']) ) {
			$this->db->where('recordCheckCount <', $options['recordCheckCount'] );
		}

		if(isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);

		if(isset($options['list_idx']))
			$this->db->where_in('idx', $options['list_idx']);
		
		if(isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		else if(isset($options['limit'])) 
			$this->db->limit($options['limit']);

		if(isset($options['count'])) {
			
			unset($options['offset']);
			unset($options['limit']);

            $this->db->select('COUNT(*)');
			
			$query = $this->db->get($tableName);

			if (is_object($query->row(0))) {
				$cnts = get_object_vars($query->row(0));
				return $cnts['COUNT(*)'];
			} else {
				return 0;
			}
		}
		
		

		$query = $this->db->get($tableName);

		if(isset($options['count'])) 
			return $query->num_rows();

		if ($opts == 'single') {
			if ( $is_result_array ) {
				foreach ( $query->result_array() as $r )
					return $r;
			} else
				return $query->row(0);
		} else if ($opts == 'list') {
			if ( $is_result_array )
				return $query->result_array();
			else
				return $query->result();
		}
	}

	function remove($tableName, $options = array()) {
		$this->db->set('status', 'D');

		if(isset($options['idx']))
			$this->db->where('idx', $options['idx']);

		if(isset($options['list_idx']))
			$this->db->where_in('idx', $options['list_idx']);

		$this->db->update($tableName);

		return ($this->db->affected_rows() > 0) ? true : false;
	}

	function update($tableName, $options = array()) {
		$this->db->set('updated_at',date("Y-m-d H:i:s"));

		foreach($options as $key => $val) {
			if (!$this->_safe($key, array('idx', 'list_idx')) ) {
				$this->db->set($key, $val);
			}
		}

		if(isset($options['idx']))
			$this->db->where('idx', $options['idx']);

		if(isset($options['list_idx']))
			$this->db->where_in('idx', $options['list_idx']);

		$this->db->update($tableName);
		$sql = $this->db->last_query();
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	function delete($tableName, $options = array()) {
		$temp = $options;
		if ( !is_array($options) )
			$options['idx'] = $temp;
		
		if ( count( $options ) == 0 )
			return false;
		
		foreach ( $options as $key=>$option ) {
			if ( $key == "list_idx" )
				$this->db->where_in('idx', $options['list_idx']);
			else if ( strpos($key, '<') !== false || strpos($key, '>') !== false )
				$this->db->where($key, $option, false);
			else
				$this->db->where($key, $option);
		}

		$this->db->delete($tableName);

		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	function customQuery( $sql ){
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function customQuery2( $sql ){
		$query = $this->db->query($sql);
		return $query->result();
	}
	function customQuery3( $sql ) {
		return  $this->db->query($sql);
	}
}