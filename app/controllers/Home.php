<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	protected $per_page;
	public function __construct()
    { 
        parent::__construct();
        $this->load->model('video_model');
        $this->load->helper(array('url_helper','form', 'url'));        
        $this->load->library(array('form_validation','session','pagination'));
		$this->per_page = $this->config->item( 'per_page' );
		///$this->load->library('session');
		//$this->load->library('pagination');
    }	
	
	public function index()
	{ 
		$data_header['title'] = 'Video List';
		$data['title'] = "All Videos";
		
		$config = array();
        $config["base_url"] = base_url() . "home";
        $config["total_rows"] = $this->video_model->video_count();
        $config["per_page"] = $this->per_page;
        $config["uri_segment"] = 2;
		$config['attributes'] = array('class' => 'page-link');
		
		
		
		 // custom paging configuration
		$config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		 
		$config['full_tag_open'] = '<ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul>';
		 
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		 
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		 
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';		
		
        $this->pagination->initialize($config);
		$limit = $this->uri->segment(2);        
		$per_page = $this->per_page;
		$page = ($limit<2)?0:(($limit-1)*$per_page);
		
        $data["links"] = $this->pagination->create_links();
		$result_array = $this->video_model->list_video($per_page,$page);
		$data['videos'] = (is_array($result_array['data']))?$result_array['data']:array();        
		$this->load->view('common/header', $data_header);
        $this->load->view('video/list', $data);
		$this->load->view('common/footer');
	}
	
	public function create(){		
		$data_header['title'] = 'Add video';
		$data['title'] = 'Add Video File';
		$this->load->view('common/header', $data_header);  
		if($this->input->post('submit')=="Submit"){ 
			$this->form_validation->set_rules('video_title', 'Title', 'required');
			//$this->form_validation->set_rules('description', 'Description', 'required');	 
			if ($this->form_validation->run() === FALSE){ 			
					redirect( base_url('home/create') ); 				
			}else{
				$return = $this->video_model->create_or_update('','add');
				if($return['type']=="error"){
					$this->session->set_flashdata('error_view',$return['message']);
				}else{
					$this->session->set_flashdata('success_view',$return['message']);
					redirect( base_url('/') ); 
				}				
				
			}
		}			    
		$this->load->view('video/create', $data);		
		$this->load->view('common/footer');
    }
      
    public function edit($id){
        $id = $this->uri->segment(3);        
        if (empty($id)){ 
			redirect( base_url('/') );
        }else{		
			$data_header['title'] = 'Edit video';
			$data['title'] = 'Update Video File';
			$this->load->view('common/header', $data_header);  
			if($this->input->post('submit')=="Submit"){ 
				$this->form_validation->set_rules('video_title', 'Title', 'required');			 
				if ($this->form_validation->run() === FALSE){ 			
					redirect( base_url('video/edit/'.$id) ); 				
				}else{
					$return = $this->video_model->create_or_update($id,'edit');
					if($return['type']=="error"){
						$this->session->set_flashdata('error_view',$return['message']);
					}else{
						$this->session->set_flashdata('success_view',$return['message']);
						redirect( base_url('/') ); 
					}				
				}
			}
			$data['video'] = $this->video_model->get_video_by_id($id);
			$this->load->view('video/edit', $data);		
			$this->load->view('common/footer');
		}
    }
     
    public function delete($id){
        $id = $this->uri->segment(3);         
        if (empty($id)){
            redirect( base_url('/') );
        }else{                 
			$return = $this->video_model->delete_video($id);
			$this->session->set_flashdata('success_view',$return['message']);
			redirect( base_url('/') );
		}
    }
}
