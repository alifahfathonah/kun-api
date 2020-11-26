<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class Api extends REST_Controller{
	private $date;
	public function __construct() {
		parent::__construct();
		$this->load->model('classes_model');
		$this->load->model('students_model');
		$this->date = date("Y-m-d H:i:s");
	}
	
	/**
	 * Check validation
	 */ 
	private function validation($string){		
		if(trim($string)==""){
			die('Please fill all require fields.');
		}		
	}
	
	/* Class CRUD action start */
	/**
	 * Get classes data
	 */ 
	public function class_get(){
		$return = $this->classes_model->read_class();
		$this->response($return); 
	}
	
	/**
	 * Add new class data
	 */ 
	public function class_put(){
		$class_id = $this->uri->segment(3);
		$class_code = str_replace(' ', '', $this->input->get('class_code'));
		$class_name = $this->input->get('class_name');
		$maximum_students = $this->input->get('maximum_students');
		$maxnum = is_numeric($maximum_students)?$maximum_students:'';
		$status = $this->input->get('status');
		$this->validation($class_code);
		$this->validation($class_name);
		$this->validation($maxnum);
		$this->validation($status);
		$data = array('class_code' => $class_code,
					  'class_name' => $class_name,
					  'description' => $this->input->get('description'),
					  'maximum_students' => $maximum_students,
					  'update_date' => $this->date,
					  'status' => $this->input->get('status')
					);
		$return = $this->classes_model->update_class($class_id,$data);
		$this->response($return); 
	}
	
	/**
	 * Update class data
	 */ 
	public function class_post(){
		$class_code = $this->input->get('class_code');
		$class_name = $this->input->get('class_name');
		$maximum_students = $this->input->get('maximum_students');
		$maxnum = is_numeric($maximum_students)?$maximum_students:'';
		$status = $this->input->get('status');
		$this->validation($class_code);
		$this->validation($class_name);
		$this->validation($maxnum);
		$this->validation($status);
		$data = array('class_code' => str_replace(' ', '', $class_code),
					  'class_name' => $class_name,
					  'description' => $this->input->get('description'),
					  'maximum_students' => $maximum_students,
					  'add_date' => $this->date,
					  'update_date' => $this->date,
					  'status' => $status
					);
		$return = $this->classes_model->insert_class($data);
		$this->response($return); 
	}
	
	/**
	 * Delete class data
	 */ 	
	public function class_delete(){
		$class_id = $this->uri->segment(3);
		$return = $this->classes_model->delete_class($class_id);
		$this->response($return); 
	}
	
	/* Student CRUD action start */
	/**
	 * Get student all data
	 */ 
	public function student_get(){
		$return = $this->students_model->read_student();
		$this->response($return); 
	}
	
	/**
	 * Add new student data
	 */ 
	public function student_put(){
		$student_id = $this->uri->segment(3);
		$first_name = $this->input->get('first_name');
		$last_name = $this->input->get('last_name');
		$class_code = str_replace(' ', '', $this->input->get('class_code'));		
		$dob = $this->input->get('dob');
		$this->validation($first_name);
		$this->validation($last_name);
		$this->validation($class_code);
		$this->validation($dob);
		$data = array('first_name' => $first_name,
					  'last_name' => $last_name,
					  'class_code' => $class_code,
					  'dob' => date('Y-m-d',strtotime($dob)),
					  'update_date' => $this->date
					);
		$return = $this->students_model->update_student($student_id,$data);
		$this->response($return); 
	}
	
	/**
	 * update student data
	 */ 
	public function student_post(){
		$first_name = $this->input->get('first_name');
		$last_name = $this->input->get('last_name');
		$class_code = str_replace(' ', '', $this->input->get('class_code'));		
		$dob = $this->input->get('dob');
		$this->validation($first_name);
		$this->validation($last_name);
		$this->validation($class_code);
		$this->validation($dob);
		$data = array('first_name' => $first_name,
					  'last_name' => $last_name,
					  'class_code' => $class_code,					  
					  'dob' => date('Y-m-d',strtotime($dob)),
					  'add_date' => $this->date,
					  'update_date' => $this->date					  
					);
		$return = $this->students_model->insert_student($data);
		$this->response($return); 
	}
	
	/**
	 * Delete student data
	 */   
	public function student_delete(){
		$student_id = $this->uri->segment(3);
		$return = $this->students_model->delete_student($student_id);
		$this->response($return); 
	}
	
}