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
        
        if ($this->session->userdata('name') != "") {

            if ($this->session->userdata('role') == "Administrator") {

                $query = $this->Md->query("SELECT * FROM route");
                if ($query) {
                    $data['routes'] = $query;
                }
                $query = $this->Md->query("SELECT * FROM driver");
                if ($query) {
                    $data['drivers'] = $query;
                }
                $query = $this->Md->query("SELECT * FROM bus");
                if ($query) {
                    $data['buses'] = $query;
                }
                $query = $this->Md->query("SELECT * FROM payment WHERE date LIKE '%" . date('d-m-Y') . "%' ");

                if ($query) {
                    $data['payments_today'] = $query;
                }
                $query = $this->Md->query("SELECT SUM(COST) AS cost FROM payment WHERE date LIKE '%" . date('d-m-Y') . "%' ");
                if ($query) {
                    $data['sum_today'] = $query;
                }
                $query = $this->Md->query("SELECT * FROM payment WHERE YEAR(STR_TO_DATE(date,'%d-%m-%Y')) = '" . date('Y') . "' ");
                if ($query) {
                    $data['payments_year'] = $query;
                }
            } else {

                $query = $this->Md->query("SELECT * FROM route where  company='" . $this->session->userdata('companyID') . "'");
                if ($query) {
                    $data['routes'] = $query;
                }
                $query = $this->Md->query("SELECT * FROM driver where  companyID='" . $this->session->userdata('companyID') . "'");
                if ($query) {
                    $data['drivers'] = $query;
                }
                $query = $this->Md->query("SELECT * FROM bus where  companyID='" . $this->session->userdata('companyID') . "'");
                if ($query) {
                    $data['buses'] = $query;
                }
                $query = $this->Md->query("SELECT * FROM payment where  companyID='" . $this->session->userdata('companyID') . "' AND date LIKE '%" . date('d-m-Y') . "%' ");

                if ($query) {
                    $data['payments_today'] = $query;
                }
                $query = $this->Md->query("SELECT SUM(COST) AS cost FROM payment where  companyID='" . $this->session->userdata('companyID') . "' AND date LIKE '%" . date('d-m-Y') . "%' ");
                if ($query) {
                    $data['sum_today'] = $query;
                }
                $query = $this->Md->query("SELECT * FROM payment where  companyID='" . $this->session->userdata('companyID') . "' AND YEAR(STR_TO_DATE(date,'%d-%m-%Y')) = '" . date('Y') . "' ");
                if ($query) {
                    $data['payments_year'] = $query;
                }
            }

            $this->load->view('home-page', $data);
        } else {

            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }
    }  

    public function register() {

        $this->load->view('register-page');
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect('welcome', 'refresh');
    }

    public function login() {
          $this->load->view('home-page', $data);
        return;

        $this->load->helper(array('form', 'url'));

        $get_result = $this->Md->query("SELECT *,user.id AS userID,roles.name AS role,roles.actions AS permission,user.name AS name,company.name AS company,company.id as companyID,user.contact AS contact,user.email AS email,company.image AS companyImage FROM user LEFT JOIN company ON user.company = company.id LEFT JOIN roles ON roles.id = user.role WHERE (user.name ='" . $this->input->post('name') . "' OR user.contact ='" . $this->input->post('name') . "' OR user.email = '" . $this->input->post('name') . "' ) AND user.password = '" . md5($this->input->post('password')) . "' ");
        // var_dump($get_result);
        // return;
        if (is_array($get_result) && count($get_result) > 0) {
            foreach ($get_result as $res) {

                $newdata = array(
                    'userID' => $res->userID,
                    'name' => $res->name,
                    'company' => $res->company,
                    'companyID' => $res->companyID,
                    'companyImage' => $res->companyImage,
                    'email' => $res->email,
                    'contact' => $res->contact,
                    'image' => $res->image,
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
            
        $this->load->view('start-page');
    }

}
