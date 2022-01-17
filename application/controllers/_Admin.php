<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation'); 
        $this->load->library('upload'); 
        $this->load->library('session');
        $this->load->model('Portfolio_model'); 
	}
    
	public function home(){
        if(!empty($this->session->userdata('user'))){  
            $this->load->view('admin/home'); // 
        }
        else{
            redirect('Login','refresh');
        }
    }
    // show
    public function portfolio()
    {
        if(!empty($this->session->userdata('user'))){

            $data['portfolios'] = $this->Portfolio_model->fetchAll();
            $this->load->view('admin/list_portfolio', $data); //    
        }
        else{
            redirect('Login','refresh');
        }
    }

    public function form_portfolio()
    {
        if(!empty($this->session->userdata('user'))){
            
            $this->load->view('admin/form_portfolio'); 
        }
        else{
            redirect('Login','refresh');
        }
    }

    // get data by id
    public function edit_portfolio()
    {
        // check is session login 
        // session exp 24 hr.
        if(!empty($this->session->userdata('user'))){
            /* segment()
                controller/function/paramiter
                ex Admin/edit_portfolio/1
            */ 
            // get parameter
            // ex. https://brickhouse-test.com/burapha-demo/Admin/edit_portfolio/1
            $id = $this->uri->segment(3); // get parameter
            echo '$id='.$id;
        
            $result['details'] = $this->Portfolio_model->getDetail($id);  // call model to queries data by id send by 1 paramiter 

            $this->load->view('admin/form_portfolio_edit',$result);  // render to view file
        }
        else{
            redirect('Login','refresh');
        }
    }

    // update record
    public function updatePortfolio()
    {
        if(!empty($this->session->userdata('user'))){
            $name = $this->security->xss_clean($this->input->post('name', TRUE));  // get post $_POST['name']
            $id = $this->security->xss_clean($this->input->post('p_id', TRUE));

            // update text 
            $response = $this->Portfolio_model->update($name,$id);  // pass 2 paramiters to update record by id=$id
            // true=1 false=0
            // upload file is image
            if(!empty($_FILES['covImg']['name'])){
                $config['upload_path'] = './assets/images/portfolio/';
                $config['file_name']        = $_FILES['covImg']['name'];
                $config['allowed_types']    = 'jpg|png|jpeg|JPG|PNG|JPEG';
                $config['file_ext_tolower'] = TRUE; 
                $config['overwrite']        = TRUE; 
                $config['max_size']         = '0';  
                $config['max_width']        = '0';  
                $config['max_height']       = '0'; 
                $config['max_filename']     = '0'; 
                $config['remove_spaces']    = TRUE; 
                $config['detect_mime']      = TRUE;
                $config['encrypt_name']     = TRUE;
    
                $this->upload->initialize($config);    
                $this->upload->do_upload('covImg'); 
                    
                $file_upload=$this->upload->data('file_name');  
                if($this->upload->display_errors()){ 
                    echo $this->upload->display_errors();  
                }else{  
                    $image_type=$this->upload->data('image_type');
                    $file_size=$this->upload->data('file_size');
                    $file_path=$this->upload->data('file_path');
    
                    $dataArr = array(
                        'image_cover'   => $file_upload,
                        'port_id'         => $id
                    );
                    // update image_cover where last id
                    $res = $this->Portfolio_model->updatefileUpload($dataArr);
                }
            }  
            // check result
            if($res > 0 || $response > 0){
                // success
                echo "<script>
                    alert('Success!');
                    window.location.href='".base_url("Admin/portfolio")."';
                </script>";
            } else {
                // error
                echo "<script>
                    alert('failed!');
                    window.location.href='".base_url("Admin/portfolio")."';
                </script>";
            } 
            // end
        }
        else{
            redirect('Login','refresh');
        }
    }
    public function changeProductStatus()
    {
        if(!empty($this->session->userdata('user'))){
            
            $this->security->get_csrf_token_name(); 
            $this->security->get_csrf_hash();
            $p_id = $this->security->xss_clean($this->input->post('id', TRUE));
            $p_st = $this->security->xss_clean($this->input->post('st', TRUE));
            $p_action = $this->security->xss_clean($this->input->post('action', TRUE));
            
            if(!empty($p_id) && $p_action =='changeStatus'){
                $response = $this->Portfolio_model->update_isactive($p_id,$p_st);
                
                if($response == 1){
                    echo 'true';
                } else {
                    echo 'false';
                }

            } else{
                echo 'false';
            }
        }
        else{
            redirect('Login','refresh');
        }
    }
}

