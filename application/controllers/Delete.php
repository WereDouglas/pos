<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
    }

    public function users() {

        $orgid = urldecode($this->uri->segment(3));
        $app = urldecode($this->uri->segment(4));
        $result = $this->Md->query("SELECT * FROM sync_data WHERE org ='" . $orgid . "' AND client ='" . $app . "'");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function user() {
        $this->load->helper(array('form', 'url'));
        
        $query = $this->Md->cascade($this->input->post('userID'), 'user', 'userID');
        if ($this->db->affected_rows() > 0) {
            echo "Record deleted";
        }
        return;
    }
     public function expense() {
         
        $this->load->helper(array('form', 'url'));
      
        $query = $this->Md->cascade($this->input->post('id'), 'expense', 'expenseID');
        if ($this->db->affected_rows() > 0) {            
            echo "Expense record deleted";
        }
        else{
            echo "No data Changes Occured";
        }
        return;
    }
    public function rent() {
         
        $this->load->helper(array('form', 'url'));
      
        $query = $this->Md->cascade($this->input->post('rentID'), 'rent', 'rentID');
        if ($this->db->affected_rows() > 0) {            
            echo "Rent record deleted";
        }
        else{
            echo "No data Changes Occured";
        }
        return;
    }
    public function damage() {
         
        $this->load->helper(array('form', 'url'));
      
        $query = $this->Md->cascade($this->input->post('id'), 'damage', 'id');
        if ($this->db->affected_rows() > 0) {            
            echo "Damage record deleted";
        }
        else{
            echo "No data Changes Occured";
        }
        return;
    }
    public function utility() {
         
        $this->load->helper(array('form', 'url'));
      
        $query = $this->Md->cascade($this->input->post('id'), 'utility', 'id');
        if ($this->db->affected_rows() > 0) {            
            echo "Utility record deleted";
        }
        else{
            echo "No data Changes Occured";
        }
        return;
    }
     public function estate() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        $query = $this->Md->cascade($this->input->post('uid'), 'estate', 'eid');
        if ($this->db->affected_rows() > 0) {
            echo "Record deleted";
        }
        return;
    }
    public function reminder() {
        $this->load->helper(array('form', 'url'));
        $query = $this->Md->cascade($this->input->post('rid'), 'reminder', 'rid');
        if ($this->db->affected_rows() > 0) {
            echo "Record deleted";
        }
        return;
    }
     public function transaction() {
         
        $this->load->helper(array('form', 'url'));
      
        $query = $this->Md->cascade($this->input->post('tid'), 'transactions', 'tid');
        if ($this->db->affected_rows() > 0) {            
            echo "Record deleted";
        }
        else{
            echo "No data Changes Occured";
        }
        return;
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function delete() {
        $this->load->helper(array('form', 'url'));
        $app = urldecode($this->uri->segment(3));
        //cascade($id,$table,$field)
        $query = $this->Md->cascade($app, 'sync_data', 'client');
        if ($this->db->affected_rows() > 0) {
            echo "Pending records deleted";
        }
    }

    public function upload() {
        // echo 'File '. $_FILES['file']['name'] .' uploaded successfully.' ;
        $file_element_name = 'userfile';
        $config['upload_path'] = 'uploads/';
        // $config['upload_path'] = '/uploads/';
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
            echo "file uploaded";
        }
        //   move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);

        echo "done";
    }

}
