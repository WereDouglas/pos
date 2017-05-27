<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
    }

    public function index() {

        if ($this->session->userdata('orgID') == "") {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">  <strong>  Session has expired</div>');

            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
            return;
        }
        $query = $this->Md->query("SELECT * FROM client WHERE orgID = '" . $this->session->userdata('orgID') . "' ");

        if ($query) {
            $data['clients'] = $query;
        } else {
            $data['clients'] = array();
        }
        $query = $this->Md->query("SELECT * FROM estate where orgID = '" . $this->session->userdata('orgID') . "' ");


        if ($query) {
            $data['estates'] = $query;
        } else {
            $data['estates'] = array();
        }
        $query = $this->Md->query("SELECT * FROM tenant where orgID = '" . $this->session->userdata('orgID') . "' AND DATE(created) = CURRENT_DATE  ");

        if ($query) {
            $data['tenants'] = $query;
        } else {
            $data['tenants'] = array();
        }    
        $query = $this->Md->query("SELECT * FROM client where orgID = '" . $this->session->userdata('orgID') . "' AND DATE(created) = CURRENT_DATE  ");

        if ($query) {
            $data['clients'] = $query;
        } else {
            $data['clients'] = array();
        }        

        $this->load->view('home-page', $data);
    }

    public function start() {
        
            $query = $this->Md->query("SELECT * FROM route where  company='" . $this->session->userdata('companyID') . "'");
            if ($query) {
                $data['routes'] = $query;
            }
            $query = $this->Md->query("SELECT * FROM driver where  companyID='" . $this->session->userdata('companyID') . "'");
            if ($query) {
                $data['drivers'] = $query;
            }
            $query = $this->Md->query("SELECT * FROM bus where companyID='" . $this->session->userdata('companyID') . "'");
            if ($query) {
                $data['buses'] = $query;
            }
            $query = $this->Md->query("SELECT * FROM payment where companyID='" . $this->session->userdata('companyID') . "' AND date LIKE '%" . date('d-m-Y') . "%' ");

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
        
        $this->load->view('start-page', $data);
    }

}
