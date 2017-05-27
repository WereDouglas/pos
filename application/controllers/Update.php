<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
    }

    public function user() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('userID'), 'userID', 'user', $data);
        echo "User information updated";
        return;
    }

    public function edit() {
        
        $this->load->helper(array('form', 'url'));

        $user = array('name' => $this->input->post('name'), 'account' => $this->input->post('account'), 'contact' => $this->input->post('contact'), 'email' => $this->input->post('email'), 'kin' => $this->input->post('kin'), 'kincontact' => $this->input->post('kincontact'), 'start' => $this->input->post('start'), 'end' => $this->input->post('end'), 'address' => $this->input->post('address'), 'contract' => $this->input->post('contract'), 'image' => $this->input->post('image'), 'created' => date('Y-m-d H:i:s'), 'active' => 'true', 'bank' => $this->input->post('bank'), 'department' => $this->input->post('department'), 'designation' => $this->input->post('designation'));
        $this->Md->update_dynamic($this->input->post('userID'), 'userID', 'user', $user);
        if (strlen($this->input->post('password'))>4) {
            $data = array('password' => md5($this->input->post('password')));
            $this->Md->update_dynamic($this->input->post('userID'), 'userID', 'user', $data);
        }

        echo "User Infomation Updated";
        return;
    }

    public function occupancy() {
        $data = array('Occupied' => $this->input->post('Occupied'), 'start' => $this->input->post('start'), 'year' => $this->input->post('year'), 'end' => $this->input->post('end'), 'tenantID' => $this->input->post('tenantID'));
        $this->Md->update_dynamic($this->input->post('roomID'), 'roomID', 'room', $data);

        $data = array('start' => $this->input->post('start'), 'end' => $this->input->post('end'), 'year' => $this->input->post('year'), 'month' => $this->input->post('month'));
        $this->Md->update_dynamic($this->input->post('tenantID'), 'tenantID', 'tenant', $data);


        return;
    }

    public function security() {

        $data = array('security' => $this->input->post('security'));
        $this->Md->update_dynamic($this->input->post('tenantID'), 'tenantID', 'tenant', $data);
        return;
    }

    public function offset() {

        $data = array('offset' => $this->input->post('offset'));
        $this->Md->update_dynamic($this->input->post('rentID'), 'rentID', 'rent', $data);
        return;
    }

    public function expense_offset() {

        $data = array('offset' => $this->input->post('offset'));
        $this->Md->update_dynamic($this->input->post('expenseID'), 'expenseID', 'expense', $data);
        return;
    }

    public function security_request() {

        $data = array('security_request' => $this->input->post('request'));
        $this->Md->update_dynamic($this->input->post('tenantID'), 'tenantID', 'tenant', $data);
        echo 'Security requisition made';
        return;
    }

    public function activate() {

        $data = array('active' => $this->input->post('active'));
        $this->Md->update_dynamic($this->input->post('tenantID'), 'tenantID', 'tenant', $data);
        echo 'Tenant ' . $this->input->post('active');
        return;
    }

    public function expense_approve() {

        $data = array('approved' => $this->input->post('approve'), 'signed' => $this->input->post('signed'));
        $this->Md->update_dynamic($this->input->post('expenseID'), 'expenseID', 'expense', $data);
        return;
    }

    public function damage_repaired() {

        $data = array('repaired' => $this->input->post('repaired'));
        $this->Md->update_dynamic($this->input->post('id'), 'id', 'damage', $data);
        return;
    }

    public function damage_paid() {

        $data = array('paid' => $this->input->post('paid'));
        $this->Md->update_dynamic($this->input->post('id'), 'id', 'damage', $data);
        return;
    }

    public function security_approve() {

        $data = array('security_approved' => $this->input->post('approve'), 'approved_by' => $this->input->post('user'));
        $this->Md->update_dynamic($this->input->post('tenantID'), 'tenantID', 'tenant', $data);
        echo 'Security refund approved';
        return;
    }

    public function security_paid() {
        $data = array('offset' => $this->input->post('offset'));
        $this->Md->update_dynamic($this->input->post('tenantID'), 'tenantID', 'tenant', $data);
        echo 'Security refund paid';
        return;
    }

    public function utility_paid() {

        $data = array('paid' => $this->input->post('paid'));
        $this->Md->update_dynamic($this->input->post('id'), 'id', 'utility', $data);
        return;
    }
     public function rent_paid() {
         
        $balance = $this->Md->query_cell("SELECT balance FROM rent WHERE rentID ='" .$this->input->post('rentID'). "'", 'balance');
        $bank = $this->Md->query_cell("SELECT bank FROM rent WHERE rentID ='" .$this->input->post('rentID'). "'", 'bank');
         $newbank =  $balance +  $bank;
        $data = array('balance' => '0','bank'=>$newbank);
        $this->Md->update_dynamic($this->input->post('rentID'), 'rentID', 'rent', $data);
        return;
    }

    public function utility_balance() {

        $data = array('balance' => "0", 'paid' => $this->input->post('paid'), 'amountPaid' => $this->input->post('amountPaid'));
        $this->Md->update_dynamic($this->input->post('id'), 'id', 'utility', $data);

        return;
    }

    public function penalty_paid() {

        $data = array('paid' => $this->input->post('paid'));
        $this->Md->update_dynamic($this->input->post('id'), 'id', 'penalty', $data);
        return;
    }

    public function expense_paid() {

        $data = array('offset' => $this->input->post('offset'), 'received_by' => $this->input->post('recieved_by'), 'paid_by' => $this->input->post('paid_by'));
        $this->Md->update_dynamic($this->input->post('expenseID'), 'expenseID', 'expense', $data);
        echo 'Expense information updated';
        return;
    }

    public function user_room() {
        $this->load->helper(array('form', 'url'));
        $data = array('clientID' => $this->input->post('clientID'), 'estateID' => $this->input->post('estateID'), 'year' => $this->input->post('year'), 'month' => $this->input->post('month'), 'commission' => $this->input->post('commission'));

        $this->Md->update_dynamic($this->input->post('tenantID'), 'tenantID', 'tenant', $data);
        echo "User information updated";
        return;
    }

    public function tenant() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('tenantID'), 'tenantID', 'tenant', $data);
        echo "Information Updated";
        return;
    }

    public function client() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('clientID'), 'clientID', 'client', $data);
        echo "Information Updated";
        return;
    }

    public function property() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('propertyID'), 'estateID', 'estate', $data);
        echo "Information Updated";
        return;
    }

    public function bank() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));

        $this->Md->update_dynamic($this->input->post('bankID'), 'bankID', 'bank', $data);
        echo "Information Updated";
        return;
    }

    public function bank_approve() {
        $data = array('approved' => $this->input->post('approved'), 'approved_by' => $this->input->post('approved_by'), 'signed' => $this->input->post('signed'));
        $this->Md->update_dynamic($this->input->post('bankID'), 'bankID', 'bank', $data);
        echo 'Banking approved';
        return;
    }

    public function bank_paid() {
        $data = array('offset' => $this->input->post('offset'), 'deposited_by' => $this->input->post('deposited_by'));
        $this->Md->update_dynamic($this->input->post('bankID'), 'bankID', 'bank', $data);
        echo 'Banking offset and updated';
        return;
    }

    public function confiscate() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));

        $this->Md->update_dynamic($this->input->post('confiscateID'), 'confiscateID', 'confiscate', $data);

        echo "Information Updated";
        return;
    }

    public function requisition() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));

        $this->Md->update_dynamic($this->input->post('qid'), 'qid', 'requisition', $data);
        echo "Information Updated";
        return;
    }

    public function cost() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('costID'), 'costID', 'cost', $data);
        echo "Information Updated";
        return;
    }

    public function expense() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('expenseID'), 'expenseID', 'expense', $data);
        echo "Information Updated";
        return;
    }

    public function partial() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('partialID'), 'partialID', 'partial', $data);
        echo "Information Updated";
        return;
    }

    public function rent() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('rentID'), 'rentID', 'rent', $data);
        echo "Information Updated";
        return;
    }

    public function room() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('roomID'), 'roomID', 'room', $data);
        echo "Information Updated";
        return;
    }

    public function util() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('utilID'), 'utilID', 'util', $data);
        echo "Utility information updated";
        return;
    }

    public function utility() {
        $this->load->helper(array('form', 'url'));
        $data = array($this->input->post('column') => $this->input->post('value'));
        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('utilityID'), 'utilityID', 'utility', $data);
        echo "Information Updated";
        return;
    }

    public function userInformation() {
        $this->load->helper(array('form', 'url'));

        $data = array('name' => $this->input->post('name'), 'account' => $this->input->post('account'), 'gender' => $this->input->post('gender'), 'contact' => $this->input->post('contact'), 'email' => $this->input->post('email'), 'starting' => $this->input->post('starting'), 'ending' => $this->input->post('ending'), 'address' => $this->input->post('address'), 'image' => $this->input->post('image'), 'created' => date('Y-m-d H:i:s'), 'status' => 'Active', 'unit' => $this->input->post('unit'));

        // $this->Md->update($this->input->post('uid'), $data, 'users');
        $this->Md->update_dynamic($this->input->post('userID'), 'userID', 'user', $data);
        echo "Information Updated";
        return;
    }

    public function password() {
        $this->load->helper(array('form', 'url'));
        //  $data = array($this->input->post('column') => $this->input->post('value'));

        $data = array('password' => md5($this->input->post('password')));
        $this->Md->update_dynamic($this->input->post('userID'), 'userID', 'user', $data);
        echo "Password Updated /Reset  ";
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
