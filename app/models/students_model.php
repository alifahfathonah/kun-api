<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CROD methods for students table
 */
class Students_model extends CI_Model
{
	/**
	 * Get students list data
	 */
	public function read_student(){ 
		$data = array();
		$query = $this->db->query("select * from `students`");
		$result_array = $query->result_array();
		if(!empty($result_array)){
			$data = $result_array;
		}else{
			$data = "Data not found.";
		}
		return array("status"=>"sucess","data"=>$data);;
	}
	
	/**
	 * Add new student row
	 */
	public function insert_student($data=array()){	   
		$query = $this->db->query("select COUNT(s.student_id) TOT, c.maximum_students from `classes` as c left join students as s on c.class_code=s.class_code where c.class_code = '".$data['class_code']."'");
		$result_array = $query->result_array();
		if($result_array[0]['TOT']<$result_array[0]['maximum_students']){
			$this->first_name  = $data['first_name']; 
			$this->last_name   = $data['last_name'];
			$this->class_code  = $data['class_code'];
			$this->date_of_birth = $data['dob'];
			$this->add_date = $data['add_date'];
			$this->update_date = $data['update_date'];
			if($this->db->insert('students',$this)){		   
				$message = "Student inserted successfully";
				$status = "sucess";
			}else{
				$message = "Error has occured";
				$status = "error";
			}
		}else{
			$message = "Maximum students limit are ".$result_array[0]['maximum_students'].". We can not add more student.";
			$status = "error";
		}
		return array("status"=>$status,"message"=>$message);
	}
	
	/**
	 * Update student row
	 */
	public function update_student($student_id,$data){   
		$this->first_name  = $data['first_name']; 
		$this->last_name   = $data['last_name'];
		$this->class_code  = $data['class_code'];
		$this->date_of_birth = $data['dob'];
		$result = $this->db->update('students',$this,array('student_id' => $student_id));		
		if($result){   
			$message = "Student updated successfully";
			$status = "sucess";
		}else{
			$message = "Error has occured";
			$status = "error";
		}
		return array("status"=>$status,"message"=>$message);
	}
	
	/**
	 * Delete student row
	 */
	public function delete_student($student_id){   
		$result = $this->db->query("delete from `students` where student_id = '".$student_id."'");		
		if($result){   
			$message = "Student deleted successfully";
			$status = "sucess";
		}else{
			$message = "Error has occured";
			$status = "error";
		}
		return array("status"=>$status,"message"=>$message);
	}
}