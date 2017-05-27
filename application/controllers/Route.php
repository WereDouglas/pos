<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Route extends CI_Controller {

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
            $query = $this->Md->query("SELECT *,route.name AS name,route.id AS id,company.name AS company,company.id AS compID FROM route LEFT JOIN company ON company.id = route.company ");
        } else {

            $query = $this->Md->query("SELECT * FROM route WHERE company='" . $this->session->userdata('companyID') . "'");
        }
      //  var_dump($query);
        if ($query) {
            $data['clients'] = $query;
        } else {
            $data['clients'] = array();
        }
        $this->load->view('view-routes', $data);
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
        $name = $this->input->post('name');
        if ($name != "") {
            $route = array('name' => $this->input->post('name'), 'startp' => $this->input->post('startp'), 'endp' => $this->input->post('endp'), 'company' => $this->session->userdata('companyID'), 'cost' => $this->input->post('cost'), 'startcoord' => $this->input->post('endcoord'), 'start_time' => $this->input->post('start_time'), 'end_time' => $this->input->post('end_time'), 'distance' => $this->input->post('distance'), 'created' => date('d-m-Y'));
            $this->Md->save($route, 'route');
            $status .= '<div class="alert alert-success">  <strong>Information submitted</strong></div>';
            $this->session->set_flashdata('msg', $status);
            redirect('route', 'refresh');
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
                    $this->Md->update_dynamic($user_id, 'id', 'route', $task);
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
        $query = $this->Md->query("SELECT * FROM route WHERE company='".$this->session->userdata('companyID')."'");
        //$query = $this->Md->query("SELECT * FROM client");
        echo json_encode($query);
    }

    public function arraylist() {
        //$query = $this->Md->query("SELECT * FROM route");
        //$query = $this->Md->query("SELECT * FROM client");
        $companyID = urldecode($this->uri->segment(3));
        $date = urldecode($this->uri->segment(4));
        $query = $this->Md->query("SELECT *,route.name AS name,bus.name AS bus,route.id AS routeID,bus.id AS busID FROM route LEFT JOIN bus ON bus.routeID = route.id WHERE  route.company='" . $companyID . "'");
        if ($query) {

            $routes = array();
            $r = array();

            foreach ($query as $res) {
                $payments = $this->Md->query("SELECT * FROM payment WHERE bus = '" . $res->regNo . "' AND STR_TO_DATE( created,  '%d-%m-%Y' ) = STR_TO_DATE(  '$date',  '%d-%m-%Y' ) ");
                // var_dump($get_result);
                $bus_no = $res->regNo;
                $busID = $res->busID;
                $seats = $res->seat;

                $bal_seats = ($seats - count($payments));
                $your_seat = (($seats) - ($seats - count($payments)) + 1);

                $b["id"] = $res->id;
                $b["name"] = $res->name;
                $b["cost"] = $res->cost;
                $b["seat"] = $bal_seats;
                $b["start"] = $res->startp;
                $b["stop"] = $res->endp;
                $b["distance"] = $res->distance;
                $b["start_time"] = $res->start_time;
                $b["end_time"] = $res->end_time;

                $routes[] = $b;
            }
            $r["routes"] = $routes;
            echo json_encode($r);
        }
    }

    public function delete() {

        $this->load->helper(array('form', 'url'));
        $id = urldecode($this->uri->segment(3));

        $query = $this->Md->cascade($id, 'route', 'id');

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('route', 'refresh');
        }
    }

}
