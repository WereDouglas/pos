<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {

        $this->load->view('login-page');
    }

    public function version() {

        $this->load->view('version');
    }

    public function home() {
        //  echo $this->session->userdata('role');

        if ($this->session->userdata('orgID') == "") {

            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }

        $query = $this->Md->query("SELECT * FROM billing where  orgID ='" . $this->session->userdata('orgID') . "' AND DATE(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "'");
        if ($query) {
            $data['bills'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM expense where orgID='" . $this->session->userdata('orgID') . "' AND DATE(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "'");
        if ($query) {
            $data['expenses'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM sale WHERE  orgID='" . $this->session->userdata('orgID') . "' AND DATE(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "'");
        if ($query) {
            $data['sales'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM payment WHERE  orgID='" . $this->session->userdata('orgID') . "' AND DATE(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "'");

        if ($query) {
            $data['payments_today'] = $query;
        }
        $query = $this->Md->query("SELECT SUM(AMOUNT) AS amount FROM payment where  orgID='" . $this->session->userdata('orgID') . "' AND DATE(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "' ");
        if ($query) {
            $data['sum_today'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM payment where  orgID='" . $this->session->userdata('orgID') . "' AND YEAR(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "' ");
        if ($query) {
            $data['payments_year'] = $query;
        }
        $this->load->view('home-page', $data);
    }

    public function register() {

        $this->load->view('register-page');
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect('welcome', 'refresh');
    }

    public function login() {


        $this->load->helper(array('form', 'url'));

        $get_result = $this->Md->query("SELECT *,users.id AS userID,roles.title AS role,roles.actions AS permission,organisation.name AS organisation,organisation.id as orgID,users.contact AS contact,users.email AS email,organisation.image AS orgIMG,users.image AS userIMG FROM users LEFT JOIN organisation ON organisation.id = users.orgID LEFT JOIN roles ON roles.title = users.roles WHERE (users.surname ='" . $this->input->post('name') . "' OR users.contact ='" . $this->input->post('name') . "' OR users.email = '" . $this->input->post('name') . "' ) AND users.passwords = '" . md5($this->input->post('password')) . "' ");
        // var_dump($get_result);
        // return;
        if (is_array($get_result) && count($get_result) > 0) {
            foreach ($get_result as $res) {

                $newdata = array(
                    'userID' => $res->userID,
                    'username' => $res->lastname . ' ' . $res->surname,
                    'organisation' => $res->organisation,
                    'orgID' => $res->orgID,
                    'orgIMG' => $res->orgIMG,
                    'email' => $res->email,
                    'contact' => $res->contact,
                    'userIMG' => $res->userIMG,
                    'location' => $res->location,
                    'permission' => $res->permission,
                    'views' => $res->views,
                    'role' => $res->role,
                    'active' => $res->active
                );

                $this->session->set_userdata($newdata);
                redirect('/welcome/home', 'refresh');
            }
        } else {
            echo 'F';
            $this->session->set_flashdata('msg', '<div class="alert alert-error">  <strong>  ! User does not exist</div>');
            redirect('welcome', 'refresh');
        }
    }

    public function start() {

        if ($this->session->userdata('orgID') == "") {

            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }

        $query = $this->Md->query("SELECT * FROM billing where  orgID ='" . $this->session->userdata('orgID') . "' AND DAY(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "'");
        if ($query) {
            $data['bills'] = $query;
        }
         $query = $this->Md->query("SELECT * FROM item where  orgID ='" . $this->session->userdata('orgID') . "'");
        if ($query) {
            $data['items'] = $query;
        }
        //  $sql[] = "DAY(STR_TO_DATE(expense.date,'%d-%m-%Y')) BETWEEN '$from' AND '$to' ";
        $query = $this->Md->query("SELECT * FROM expense where orgID='" . $this->session->userdata('orgID') . "' AND DAY(STR_TO_DATE(date,'%d-%m-%Y')) = '" . date('d-m-Y') . "'");
        if ($query) {
            $data['expenses'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM sale WHERE  orgID='" . $this->session->userdata('orgID') . "' AND DAY(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "'");
        if ($query) {
            $data['sales'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM payment WHERE  orgID='" . $this->session->userdata('orgID') . "' AND DAY(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "'");

        if ($query) {
            $data['payments_today'] = $query;
        }
        $query = $this->Md->query("SELECT SUM(AMOUNT) AS amount FROM payment where  orgID='" . $this->session->userdata('orgID') . "' AND DAY(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('d-m-Y') . "' ");
        if ($query) {
            $data['sum_today'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM payment where  orgID='" . $this->session->userdata('orgID') . "' AND YEAR(STR_TO_DATE(created,'%d-%m-%Y')) = '" . date('Y') . "' ");
        if ($query) {
            $data['payments_year'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM expense where  orgID='" . $this->session->userdata('orgID') . "' AND YEAR(STR_TO_DATE(date,'%d-%m-%Y')) = '" . date('Y') . "' ");
        if ($query) {
            $data['expenses_year'] = $query;
        }
        
        $this->load->view('start-page',$data);
    }

}
