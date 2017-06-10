<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
        $this->load->library('excel');
        $this->load->library('email');
    }

    public function index() {
     
            $query = $this->Md->query("SELECT *,users.id AS id,users.image AS image FROM users");
      
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }
       
            $query = $this->Md->query("SELECT * FROM roles");
        
        if ($query) {
            $data['roles'] = $query;
        }
        $this->load->view('view-users', $data);
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
        // $userID = $this->GUID();
        $name = $this->input->post('name');
        $query = $this->Md->query("SELECT * FROM user WHERE contact='" . $this->input->post('contact') . "'");

        if (count($query) > 0) {

            $status .= '<div class="alert alert-success">  <strong>User contact already registered</strong></div>';
            $this->session->set_flashdata('msg', $status);
            redirect('user', 'refresh');
            return;
        }

        if ($name != "") {
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

            if ($this->session->userdata('companyID') != "") {

                $companyID = $this->session->userdata('companyID');
            } else {
                $companyID = $this->input->post('companyID');
            }

            $data = $this->upload->data();
            $userfile = $data['file_name'];

            $user = array('name' => $this->input->post('name'),'route' => $this->input->post('route'), 'role' => $this->input->post('role'), 'company' => $companyID, 'contact' => $this->input->post('contact'), 'email' => $this->input->post('email'), 'password' => md5($this->input->post('password')), 'image' => $userfile, 'created' => date('Y-m-d H:i:s'), 'active' => 'true','bus'=>  $this->input->post('bus'));
            $this->Md->save($user, 'user');



            $status .= '<div class="alert alert-success">  <strong>Information submitted</strong></div>';
            $this->session->set_flashdata('msg', $status);
            redirect('user', 'refresh');
        }
    }

    public function profile() {

        $this->load->helper(array('form', 'url'));
        $name = urldecode($this->uri->segment(3));
        $query = $this->Md->query("SELECT * FROM user where id ='" . $name . "'");

        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }

        $this->load->view('user-profile', $data);
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
                    $this->Md->update_dynamic($user_id, 'id', 'user', $task);
                    echo "Updated";
                } else {
                    echo "Invalid Requests";
                }
            }
        } else {
            echo "Invalid Requests";
        }
    }

    public function updating() {

        $this->load->helper(array('form', 'url'));
        $id = $this->input->post('id');
        $role = $this->input->post('role');
        $user = array('role' => $role);
        $this->Md->update($id, $user, 'user');
    }

    public function reset() {
        $password = $this->generateRandomString();

        $userID = trim($this->input->post('id'));
        // $userid = 'CB501C98-74B4-4480-BFBE-6447CF3BBB18';
        //query_cell($string, $cell)
        $email = $this->Md->query_cell("SELECT * FROM user where id= '" . $userID . "'", 'email');
        if ($email == "") {
            echo 'No email specified';
            return;
        }
        $key = $email;
        $password_new = $this->encrypt->encode($password, $key);
        $newer = $password;

        $user = array('password' => $password_new);
        $this->Md->update($userID, $user, 'user');
        echo 'New Password is reset please check mail( SPAM MAIL ESPECIALLY ) ' . $password;

        $reciever = $this->Md->query_cell("SELECT email FROM users WHERE id ='$userID' ", 'email');
        $body = $reciever . ' Your Password has been changed to  <b>' . $newer . '</b> for Estate professional login panel';
        $subject = 'Password reset,changed password Online Property Professional Account ';

        //$mail = array('message' => $message, 'subject' => $subject, 'schedule' => date('d-m-Y'), 'reciever' => $email, 'created' => date('Y-m-d H:i:s'), 'org' => "", 'sent' => 'false', 'guid' => '');
        //$this->Md->save($mail, 'emails');

        $from = "noreply@estateprofessional.pro";
        // $subject = " ";
        if ($email != "") {

            $this->email->from($from, 'Estate professionl');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($body);
            $this->email->send();
            echo $this->email->print_debugger();
            echo "email has been sent";
            //return;
        }
    }

    public function update_profile() {
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
                    $this->Md->update_dynamic($user_id, 'id', 'user', $task);
                    echo "Updated";
                } else {
                    echo "Invalid Requests";
                }
            }
        } else {
            echo "Invalid Requests";
        }
    }

    public function update_password() {

        $this->load->helper(array('form', 'url'));
        //user information
        $this->load->library('email');
        $password = $this->input->post('password');
        //$password = '123456';
        $this->load->helper(array('form', 'url'));
        $id = $this->input->post('userID');
        $email = $this->Md->query_cell("SELECT email FROM user WHERE userID ='" . $id . "'", 'email');
        $name = $this->Md->query_cell("SELECT name FROM user WHERE userID='" . $id . "'", 'name');

        $new_password = md5($password);

        $info = array('password' => $new_password);
        $this->Md->update_dynamic($id, 'userID', 'user', $info);

        $body = $name . '  ' . ' Your password has been reset to ' . $password . " Please click the link below to access your Case Professional account: caseprofessional.org";

        $from = "noreply@estateprofessional.pro";
        $subject = "Password reset ";
        if ($email != "") {

            $this->email->from($from, 'Estate professionl');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($body);
            $this->email->send();
            echo $this->email->print_debugger();
            echo "email has been sent";
            //return;
        }

        echo 'INFORMATION UPDATED';
        $this->session->set_flashdata('msg', '<div class="alert alert-success">  <strong>USER PASSWORD CHANGED</strong></div>');

        redirect('/user/profile/' . $name, 'refresh');
    }

    public function update_image() {

        $this->load->helper(array('form', 'url'));
        //user information

        $userID = $this->input->post('userID');
        $namer = $this->input->post('namer');

        $fileUrl = $this->Md->query_cell("SELECT image FROM user WHERE id ='" . $userID . "'", 'image');

        $this->Md->file_remove($fileUrl, 'uploads');
        $file_element_name = 'userfile';
        // $new_name = $userID;
        $config['file_name'] = $userID;
        $config['upload_path'] = 'uploads/';
        $config['encrypt_name'] = FALSE;
        $config['allowed_types'] = 'jpg';
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
            $status = 'error';
            $msg = $this->upload->display_errors('', '');
            $this->session->set_flashdata('msg', '<div class="alert alert-error"> <strong>' . $msg . '</strong></div>');
            redirect('/user/profile/' . $userID, 'refresh');

            return;
        }
        $data = $this->upload->data();
        $userfile = $data['file_name'];
        $user = array('image' => $userfile);
        $this->Md->update_dynamic($userID, 'id', 'user', $user);

        $this->session->set_flashdata('msg', '<div class="alert alert-success">  <strong>Image updated saved</strong></div>');

        redirect('/user/profile/' . $userID, 'refresh');
    }

    public function users() {
        //  $query = $this->Md->query("SELECT * FROM user WHERE  orgID='" . $this->session->userdata('orgID') . "'");
        $query = $this->Md->query("SELECT * FROM user");

        echo json_encode($query);
    }

    public function lists() {
        //  $query = $this->Md->query("SELECT * FROM client WHERE  orgID='" . $this->session->userdata('orgID') . "'");
        $query = $this->Md->query("SELECT * FROM user");
        echo json_encode($query);
    }

    public function delete() {

        $this->load->helper(array('form', 'url'));
        $id = urldecode($this->uri->segment(3));
        $query = $this->Md->delete($id, 'user');
        //cascade($id,$table,$field)
        //$query = $this->Md->cascade($id, 'user', 'id');
        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('user', 'refresh');
        }
    }

    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

?>