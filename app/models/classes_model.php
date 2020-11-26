<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CROD methods for classes table
 */
class Classes_model extends CI_Model
{
	/**
	 * Get class data
	 */
	public function read_class(){ 
		$data = array();
		$query = $this->db->query("select * from `classes`");
		$result_array = $query->result_array();
		if(!empty($result_array)){
			$data = $result_array;
		}else{
			$data = "Data not found.";
		}
		return array("status"=>"sucess","data"=>$data);;
	}
	
	/**
	 * Insert new class row
	 */
	public function insert_class($data){
		$query = $this->db->query("select COUNT(class_id) TOT from `classes` where class_code = '".$data['class_code']."'");
		$result_array = $query->result_array();
		if($result_array[0]['TOT']==0){
			$this->class_code   = $data['class_code']; 
			$this->class_name   = $data['class_name'];
			$this->description  = $data['description'];
			$this->maximum_students = $data['maximum_students'];
			$this->add_date     = $data['add_date'];
			$this->update_date  = $data['update_date'];
			$this->status       = $data['status'];
			if($this->db->insert('classes',$this)){		   
				$message = "Class inserted successfully";
				$status = "sucess";
			}else{
				$message = "Error has occured";
				$status = "error";
			}
		}else{
			$message = "Class code already exist. You can not add same class class code again.";
			$status = "error";
		}
		return array("status"=>$status,"message"=>$message);
	}
	
	/**
	 * Update class row
	 */
	public function update_class($class_id,$data){   
		$this->class_code    = $data['class_code']; 
		$this->class_name  = $data['class_name'];
		$this->description  = $data['description'];
		$this->maximum_students = $data['maximum_students'];		
		$this->update_date = $data['update_date'];
		$this->status = $data['status'];
		$result = $this->db->update('classes',$this,array('class_id' => $class_id));		
		if($result){   
			$message = "Class is updated successfully";
			$status = "sucess";
		}else{
			$message = "Error has occured";
			$status = "error";
		}
		return array("status"=>$status,"message"=>$message);
	}
	/**
	 * Delete class row
	 */
	public function delete_class($class_id){   
		$result = $this->db->query("delete from `classes` where class_id = '".$class_id."'");		
		if($result){   
			$message = "Class is deleted successfully";
			$status = "sucess";
		}else{
			$message = "Error has occured";
			$status = "error";
		}
		return array("status"=>$status,"message"=>$message);
	}
}