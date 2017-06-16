<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
        $this->load->library('excel');
    }

    public function index() {

        $query = $this->Md->query("SELECT * FROM category");

        if ($query) {
            $data['cats'] = $query;
        } else {
            $data['cats'] = array();
        }
        $this->load->view('view-category', $data);
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function create() {
        $this->load->helper(array('form', 'url'));
        //user information
        $id = $this->GUID();
        $name = $this->input->post('name');

        $query = $this->Md->query("SELECT * FROM category WHERE name='" . $this->input->post('name') . "'");
        if (count($query)) {

            $status .= '<div class="alert alert-success">  <strong>Category already registered</strong></div>';
            $this->session->set_flashdata('msg', $status);
            redirect('category', 'refresh');
            return;
        }
        $file_element_name = 'userfile';
        $config['file_name'] = $this->input->post('name');
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
            $status = 'errors';
            $msg = $this->upload->display_errors('', '');
            $status .= '<div class="alert alert-error"> <strong>' . $msg . '</strong></div>';
        }
        $data = $this->upload->data();
        
        $userfile = $data['file_name'];  
        $path = 'uploads/'.$userfile;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 =  base64_encode($data);

        $b = array('id' => $id, 'name' => $this->input->post('name'), 'description' => $this->input->post('description'), 'created' => date('d-m-Y H:i:s'), 'image' =>  $base64);
        $this->Md->save($b, 'category');
        $status .= '<div class="alert alert-success">  <strong>Information submitted</strong></div>';
        $this->session->set_flashdata('msg', $status);
        redirect('category', 'refresh');
    }

    public function details() {

        $this->load->helper(array('form', 'url'));
        $role = trim($this->input->post('categoryID'));

        $get_result = $this->Md->query("SELECT * FROM category WHERE name ='" . $role . "'");
        // var_dump($get_result);
        if (!$get_result) {
            echo '<span style="color:#f00"> No information in the database </strong> does not exist in our database</span>';
        } else {
            foreach ($get_result as $res) {

                echo '<font class="red">DESCRIPTION:</font>  <div class="alert alert-info">' . $res->description . '</div>';
            }
        }
    }

    public function update() {

        $this->load->helper(array('form', 'url'));

        if (!empty($_POST)) {

            foreach ($_POST as $field_name => $val) {
                //clean post values
                $field_id = strip_tags(trim($field_name));
                $val = strip_tags(trim($val));
                //from the fieldname:user_id we need to get user_id
                $split_data = explode(':', $field_id);
                $user_id = $split_data[1];
                $field_name = $split_data[0];
                if (!empty($user_id) && !empty($field_name) && !empty($val)) {
                    //update the values
                    $task = array($field_name => $val);
                    // $this->Md->update($user_id, $task, 'tasks');
                    $this->Md->update_dynamic($user_id, 'id', 'category', $task);
                    echo "Updated";
                } else {
                    echo "Invalid Requests";
                }
            }
        } else {
            echo "Invalid Requests";
        }
    }

    public function lists() {

        $query = $this->Md->query("SELECT * FROM category");
        //$query = $this->Md->query("SELECT * FROM client");
        echo json_encode($query);
    }

    public function delete() {

        $this->load->helper(array('form', 'url'));
        $id = urldecode($this->uri->segment(3));

        $query = $this->Md->cascade($id, 'category', 'id');

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('category', 'refresh');
        }
        $status .= '<div class="alert alert-success">  <strong>Information deleted</strong></div>';
        $this->session->set_flashdata('msg', $status);
        redirect('category', 'refresh');
    }

}
