<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        // $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {
        $pass = urldecode($this->uri->segment(3));
        if ($pass != "123456") {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">  <strong> You are a cheat like Andrew</div>');
            redirect('welcome', 'refresh');
            return;
        }

        $data['users'] = array();
        $data['orgs'] = array();
        $query = $this->Md->query("SELECT * FROM users");
        if ($query)
            $data['users'] = $query;

        $query = $this->Md->query("SELECT * FROM organisation");
        if ($query)
            $data['orgs'] = $query;

        $this->load->view('org-page', $data);
    }
     public function routes() {
       
        $companyID = $this->input->post('companyID');        
        $g = new stdClass();
        $count = 1;
        $query2 = $this->Md->query("select * from route");// WHERE company='" . $companyID . "'");      
        $results = $query2;
        foreach ($results as $res) {
            $r = new stdClass();
            $r->count = $count++;
            $r->name = $res->name;
            $r->cost = $res->cost;           
            $r->start = $res->start_time;
            $r->end = $res->end_time;
            $g->routes[] = $r;
        }
        header('Content-Type: application/json');
        echo json_encode($g);
    }
    public function bus() {
       
        $companyID = $this->input->post('companyID');        
        $g = new stdClass();
        $count = 1;
        $query2 = $this->Md->query("select * from bus"); // WHERE companyID='" . $companyID . "'");      
        $results = $query2;
        foreach ($results as $res) {
            $r = new stdClass();
            $r->count = $count++;
            $r->name = $res->name;
            $r->noPlate= $res->regNo;           
            $r->seat = $res->seat;           
            $g->buses[] = $r;
        }
        header('Content-Type: application/json');
        echo json_encode($g);
    }

    public function login() {

        $this->load->helper(array('form', 'url'));

        $contact = $this->input->post('contact');
        $password = $this->input->post('password');
       // $contact = '0752336721';
        //$password = '123456';
        $query = $this->Md->query("SELECT *,user.active AS active,bus.seat AS MAX_SEAT,user.name AS name,company.name AS company,user.id AS id,company.id AS companyID,user.image AS image,company.image AS logo FROM user LEFT JOIN company ON company.id = user.company LEFT JOIN bus ON bus.regNo= user.bus WHERE user.contact='" . $contact . "'");
        if ($query) {            
            foreach ($query as $res) {

                if ($res->password == md5($password)) {
                    if ($res->active != 'true') {
                        $b["info"] = "Inactive accout please contact administration ";
                        $b["status"] = "false";
                        echo json_encode($b);
                        return;
                    }
                    $b["info"] = "login successfull";
                    $b["status"] = "true";
                    $b["name"] = $res->name;
                    $b["email"] = $res->email;
                    $b["image"] = $res->image;
                    $b["logo"] = $res->logo;
                    $b["companyID"] = $res->companyID;
                    $b["company"] = $res->company;
                    $b["userID"] = $res->id;
                    $b["bus"] = $res->bus;
                    $b["seats"] = $res->MAX_SEAT;
                    $b["route"] = $res->route;
                    $b["contact"] = $res->name;
                    echo json_encode($b);
                    return;
                } else {
                    $b["info"] = "Invalid password";
                    $b["status"] = "false";
                    echo json_encode($b);
                    return;
                }
            }
        } else {
            $b["info"] = "No such contact!";
            $b["status"] = "false";
            echo json_encode($b);
            return;
        }
    }



    public function update() {

        if ($this->session->userdata('level') == 1) {

            $this->load->helper(array('form', 'url'));
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $code = $this->input->post('code');

            $org = array('id' => $id, 'name' => $name, 'address' => $address, 'code' => $code);

            $content = json_encode($org);
            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'org', 'contents' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->Md->update($id, $org, 'organisation');
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You may need to re-login for these changes to be carried out' . '	</strong>									
						</div>');
            redirect('welcome/info', 'refresh');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action ' . '	</strong>									
						</div>');
            redirect('welcome/info', 'refresh');
        }
    }

    public function api() {

        $orgname = urldecode($this->uri->segment(3));
        $verification = urldecode($this->uri->segment(4));
        if ($orgname != "" || $verification != "") {
            $query = $this->Md->query("SELECT * FROM organisation WHERE  name ='" . $orgname . "' AND `keys` = '" . $verification . "'");
            if ($query) {
                foreach ($query as $res) {
                    $clientname = $res->code . "-DESKTOP" . date('y') . "-" . date('m') . (int) date('d') . (int) date('H') . (int) date('i') . (int) date('s');
                    $orgid = $res->id;
                }
                $client = array('org' => $orgid, 'active' => 'T', 'name' => $clientname, 'created' => date('Y-m-d H:i:s'));
                $this->Md->save($client, 'client');
                $temp = json_encode($query);  //$json={"var1":"value1","var2":"value2"}   
                $temp = substr($temp, 0, -2);
                $temp.=',"oid":"' . $clientname . '"}]';
                echo $temp;
            }
        } else {
            echo "";
        }
    }




    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function generate_key_string() {

        $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $segment_chars = 5;
        $num_segments = 4;
        $key_string = '';

        for ($i = 0; $i < $num_segments; $i++) {

            $segment = '';

            for ($j = 0; $j < $segment_chars; $j++) {
                $segment .= $tokens[rand(0, 35)];
            }

            $key_string .= $segment;

            if ($i < ($num_segments - 1)) {
                $key_string .= '-';
            }
        }

        return $key_string;
    }   
    public function logout() {

        $this->session->sess_destroy();
        redirect('welcome/logout', 'refresh');
    }

    public function student() {
        $this->load->view('private');
    }

   
}
