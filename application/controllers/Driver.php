<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends CI_Controller {

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

        if ($this->session->userdata('role') == "Administrator") {
            $query = $this->Md->query("SELECT *,driver.id AS id,company.name AS company,bus.regNo AS bus,driver.name AS name FROM driver LEFT JOIN company ON driver.companyID = company.id LEFT JOIN bus ON driver.busID = bus.id");
        } else {
            $query = $this->Md->query("SELECT *,driver.id AS id,company.name AS company,bus.regNo AS bus,driver.name AS name FROM driver LEFT JOIN company ON driver.companyID = company.id LEFT JOIN bus ON driver.busID = bus.id WHERE driver.companyID='" . $this->session->userdata('companyID') . "'");
        }
        if ($query) {
            $data['clients'] = $query;
        } else {
            $data['clients'] = array();
        }
        $this->load->view('view-drivers', $data);
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
        // $clientID = $this->GUID();
        $query = $this->Md->query("SELECT * FROM driver WHERE contact='" . $this->input->post('contact') . "'");

        if (count($query) > 0) {

            $status .= '<div class="alert alert-success">  <strong>User contact already registered</strong></div>';
            $this->session->set_flashdata('msg', $status);
            redirect('driver', 'refresh');
            return;
        }
        if ($this->input->post('name') != "") {
            ///organisation image uploads
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
            if($this->session->userdata('companyID')!="" &&$this->input->post('name')!="" ) {
                $d = array('name' => $this->input->post('name'), 'companyID' => $this->session->userdata('companyID'), 'busID' => $this->input->post('busID'), 'contact' => $this->input->post('contact'), 'email' => $this->input->post('email'), 'image' => $userfile, 'created' => date('Y-m-d H:i:s'), 'active' => 'true');
                $this->Md->save($d, 'driver');


                $status .= '<div class="alert alert-success">  <strong>Information submitted</strong></div>';
                $this->session->set_flashdata('msg', $status);
                redirect('driver', 'refresh');
            } else {

                $status .= '<div class="alert alert-danger">  <strong>Information cannot be Submitted you dont belong to any bus company</strong></div>';
                $this->session->set_flashdata('msg', $status);
                redirect('driver', 'refresh');
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
                    $this->Md->update_dynamic($user_id, 'id', 'driver', $task);
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
        $query = $this->Md->query("SELECT * FROM driver");
        //$query = $this->Md->query("SELECT * FROM client");
        echo json_encode($query);
    }

    public function delete() {

        $this->load->helper(array('form', 'url'));
        $id = urldecode($this->uri->segment(3));

        $query = $this->Md->cascade($id, 'driver', 'id');

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('driver', 'refresh');
        }
    }

}
