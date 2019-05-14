<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model(['LeadModel','StatusTagModel','LeadStatusModel']);
       		$this->load->library(['pagination', 'form_validation']);

        	$this->lead = new LeadModel();
        	$this->status_tags = new StatusTagModel();
        	$this->status = new LeadStatusModel();
	    }
 
	    public function index(){
        	$limit = 10;
	    	$pagiConfig = [
            'base_url' => base_url('leads'),
            'total_rows' => $this->lead->getCount(),
            'per_page' => $limit
        	];
        	$this->pagination->initialize($pagiConfig);

			$leads = $this->lead->getAllJob('open');
			$this->load->view('header',['title' => 'Leads']);
			$this->load->view('leads/index',['leads' => $leads,'pagiLinks' => $this->pagination->create_links()]);
			$this->load->view('footer');
	    }

	    public function new(){
        	$this->load->view('header',['title' => 'Add New Leads']);
			$this->load->view('leads/new');
			$this->load->view('footer');
	    }

	    public function view(){
	    	$jobid = $this->uri->segment(2);
			$leads = $this->lead->get_all_where('jobs',['id' => $jobid]);
			$add_info = $this->lead->get_all_where( 'job_add_party', ['job_id' => $jobid] );

			$leadstatus = $this->status->get_all_where(['jobid' => $jobid]);
			$this->load->view('header',['title' => 'Lead Detail']);
			$this->load->view('leads/view',['leadstatus' => $leadstatus,'leads' => $leads,'add_info' => $add_info,'jobid' => $this->uri->segment(2)]);
			$this->load->view('footer');
	    }


	    public function edit(){
			$leads = $this->lead->get_all_where('jobs',['id' => $this->uri->segment(2)]);
			$add_info = $this->lead->get_all_where( 'job_add_party', ['job_id' => $this->uri->segment(2)] );
			$job_type_tags = $this->status_tags->getall('job_type');
			$lead_status_tags = $this->status_tags->getall('lead_status');
			$contract_status_tags = $this->status_tags->getall('contract_status');

			$leadstatus = $this->status->get_all_where(['jobid' => $this->uri->segment(2)]);
			
			$this->load->view('header',['title' => 'Lead Update']);
			$this->load->view('leads/edit',['job_type_tags' => $job_type_tags,'lead_status_tags' => $lead_status_tags,'contract_status_tags' => $contract_status_tags,'leads' => $leads,'leadstatus'=>$leadstatus,'add_info' => $add_info,'jobid' => $this->uri->segment(2)]);
			$this->load->view('footer');
	    }


	    public function store()
		{
		
		if( isset($_POST) && count($_POST) > 0 ) 
		{
			
			$this->form_validation->set_rules('jobname','Job Name','trim|required');
			$this->form_validation->set_rules('firstname','First Name','trim|required');
			$this->form_validation->set_rules('lastname','Last Name','trim|required');
			$this->form_validation->set_rules('address','Address','trim|required');
			$this->form_validation->set_rules('city','City','trim|required');
			$this->form_validation->set_rules('country','State','trim|required');
			$this->form_validation->set_rules('zip','Postal Code','trim|required');
			$this->form_validation->set_rules('phone1','Cell Phone','trim|required');
			$this->form_validation->set_rules('phone2','Home Phone','trim');
			$this->form_validation->set_rules('email','Email','trim');
			if( $this->form_validation->run() == TRUE ) {
				
				$getjob=$this->db->query('SELECT * FROM jobs');
				$total=$getjob->num_rows();
				$total++;

				$posts = $this->input->post();
				$params['job_name'] 		= $posts['jobname'];
				$params['status'] 		='open';
				$params['firstname'] 		= $posts['firstname'];
				$params['lastname'] 		= $posts['lastname'];
				$params['address'] 		= $posts['address'];
				$params['city'] 		= $posts['city'];
				$params['state'] 		= $posts['country'];
				$params['zip'] 		= $posts['zip'];
				$params['phone1'] 		= $posts['phone1'];
				$params['phone2'] 		= $posts['phone2'];
				$params['email'] 		= $posts['email'];			
				$params['entry_date'] 			= date('Y-m-d h:i:s');
				$params['is_active'] 			= TRUE;
				$params['job_number'] 		= 'RJOB'.$total;
				

				$query = $this->lead->add_record( $params );
				$this->status->add_record([
                    'jobid' => $query,
                    'lead' => 'open',
                    'contract' => 'unsigned'
                ]);
			 
				if( $query ) {
					$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
					$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Saved Successfully!</strong>';
					$message .= '</div>';
					$this->session->set_flashdata('message',$message);
					redirect('leads/');
				} else {
					$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
					$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Job Not Saved Successfully!</strong>';
					$message .= '</div>';
					$this->session->set_flashdata('message',$message);
					
				}
			}
			else{
			
					
					$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
					$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>'.validation_errors().' </strong>';
					$errors .= '</div>';
           			$this->session->set_flashdata('message', $errors);
					$this->load->view('header',['title' => 'Add New Leads']);
					$this->load->view('leads/new');
					$this->load->view('footer');
			}
		}
		
	}


		public function update(){
	    	
			if( isset($_POST) && count($_POST) > 0 ) {
			$posts = $this->input->post();

			$this->form_validation->set_rules('jobname','Job Name','trim|required');
			$this->form_validation->set_rules('firstname','First Name','trim|required');
			$this->form_validation->set_rules('lastname','Last Name','trim|required');
			$this->form_validation->set_rules('address','Address','trim|required');
			$this->form_validation->set_rules('city','City','trim|required');
			$this->form_validation->set_rules('country','State','trim|required');
			$this->form_validation->set_rules('zip','Postal Code','trim|required');
			$this->form_validation->set_rules('phone1','Phone 1','trim|required');
			$this->form_validation->set_rules('phone2','Phone 2','trim');
			$this->form_validation->set_rules('email','Email','trim');
			if( $this->form_validation->run() == FALSE ) {
					
					$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
					$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>'.validation_errors().'</strong>';
					$errors .= '</div>';
           			$this->session->set_flashdata('message', $errors);
					redirect('lead/'.$posts['id'].'/edit');
				
			} else {
				
				$params = array();
				$params['job_name'] 		= $posts['jobname'];
				$params['firstname'] 		= $posts['firstname'];
				$params['lastname'] 		= $posts['lastname'];
				$params['address'] 		= $posts['address'];
				$params['city'] 		= $posts['city'];
				$params['state'] 		= $posts['country'];
				$params['zip'] 		= $posts['zip'];
				$params['phone1'] 		= $posts['phone1'];
				$params['phone2'] 		= $posts['phone2'];
				$params['email'] 		= $posts['email'];	

				$this->lead->update_record($params,['id' =>$posts['id']]);
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Saved Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('lead/'.$posts['id'].'/edit');

			}

			}else{

					redirect('lead/');
			}
			
	    }



	    public function updatestatus(){
	   
			$posts = $this->input->post();
			if($posts['status']=='job'){
				$this->db->query("UPDATE jobs_status SET ".$posts['status']."='".$posts['value']."' ,lead='pre-production' WHERE jobid='".$posts['id']."'");
				return true;
			}else{
				$this->db->query("UPDATE jobs_status SET ".$posts['status']."='".$posts['value']."' WHERE jobid='".$posts['id']."'");
				return true;
			}
			
		}


		

	     
}