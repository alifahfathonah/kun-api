<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Video_model extends CI_Model {
    private $dir_path;
	private $is_file_error;
	private $type;
	private $message;
	private $table;
	public function __construct(){       
        $this->dir_path = FCPATH.'uploads/videos/';
		$this->is_file_error = FALSE;
		$this->type = '';
		$this->message = '';
		$this->table = 'videos';
    }
	
	private function delete_file($file_name){
		unlink($this->dir_path.$file_name);
	}
	
    public function list_video($limit,$start){
		//echo $limit.'  '.$start; die;
		
		$this->db->order_by('id', 'DESC');
		$this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        $result_array = $query->result();		
		if(!empty($result_array)){
			$data = $result_array;
		}else{
			$data = "Data not found.";
		}
		return array("status"=>"sucess","data"=>$data);		
    }
	
	public function video_count(){		
        return $this->db->count_all($this->table);       
    }
     
    public function get_video_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row();
    }
     
    public function create_or_update($id='',$type=''){ 
		//$this->load->helper('url');
		$config['upload_path'] = $this->dir_path;
		//allowed file types. * means all types
		$config['allowed_types'] = 'wmv|mp4|avi|mov|flv';
		//allowed max file size. 0 means unlimited file size
		$config['max_size'] = '0';		
		$config['max_filename'] = '255';		
		$config['encrypt_name'] = TRUE;
		//store video info once uploaded
		$video_data = array();		
		$file_name = $this->input->post('old_file_name');
		$file_type = $this->input->post('video_file_type');
		//check if file was selected for upload
		
		//echo '<pre>'; print_r($_FILES); echo '</pre>'; die;		
		$upload_file_name = $_FILES['video_file_name']['name'];
		if ($upload_file_name=="" && $type == 'add') {
			$this->is_file_error = TRUE;
			$this->type = 'error';
			$this->message = 'Select a video file.';			
		}else if($upload_file_name=="" && $type == 'edit') {
			$this->is_file_error = TRUE;
		}
		
		//if file was selected then proceed to upload
		if ($this->is_file_error==FALSE) {
			//load the preferences
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			//check file successfully uploaded. 'video_name' is the name of the input
			if (!$this->upload->do_upload('video_file_name')) {				
				$this->is_file_error = TRUE;
				$this->type = 'error';
				//if file upload failed then catch the errors				
				$this->message = $this->upload->display_errors();
			} else {
				$this->type = 'success';
				$this->message = 'Video successfully uploaded.';
				$video_data = $this->upload->data();								
				$this->is_file_error = FALSE;
				$file_name = $video_data['file_name'];
				$file_type = $video_data['file_type'];
				if(isset($id)){					
					$video_array = $this->get_video_by_id($id);			
					$old_file_name = $video_array->video_file_name;
					$this->delete_file($old_file_name);	
				}else if($this->input->post('old_file_name')){
					$this->delete_file($this->input->post('old_file_name'));					
				}
			}
		}		
		
		if($this->is_file_error==FALSE || $type == 'edit'){
			$date = date('Y-m-d H:i:s');
			if(empty($id)){
				$data = array(
					'video_title' => $this->input->post('video_title'),
					'video_file_name' => $file_name,
					'video_file_type' => $file_type,
					'add_date' => $date,
					'update_date' => $date,
					'status' => 1
				);
				$this->db->insert($this->table, $data);
				$this->type = 'success';
				$this->message = 'Record successfully added.';
			}else{
				$data = array(
					'video_title' => $this->input->post('video_title'),
					'video_file_name' => $file_name,
					'video_file_type' => $file_type,
					'update_date' => $date
				);
				$this->db->where('id', $id);
				$this->db->update($this->table, $data);
				$this->type = 'success';
				$this->message = 'Record successfully updated.';
			}
		}
		return array('type'=>$this->type, 'message'=>$this->message);
    }
     
    public function delete_video($id){
		$video_file_name = $this->input->post('video_file_name');
		if(!$video_file_name){
			$video_array = $this->get_video_by_id($id);			
			$video_file_name = $video_array->video_file_name;
		}	
        $this->db->where('id', $id);
        $this->db->delete($this->table);			
		$this->delete_file($video_file_name);
		return array('type'=>'success', 'message'=>'Record successfully deleted.');
    }
	
	
}