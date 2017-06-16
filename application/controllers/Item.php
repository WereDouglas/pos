<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

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

        $query = $this->Md->query("SELECT * FROM item LEFT JOIN stock ON stock.itemID = item.id WHERE  item.orgID='" . $this->session->userdata('orgID') . "'");
        // $query = $this->Md->query("SELECT * FROM client  ");

        if ($query) {
            $data['items'] = $query;
        } else {
            $data['items'] = array();
        }
        $this->load->view('view-item', $data);
    }

    public function update_image() {

        $this->load->helper(array('form', 'url'));
        //user information

        $userID = $this->input->post('userID');
        $namer = $this->input->post('namer');

        $fileUrl = $this->Md->query_cell("SELECT image FROM company WHERE id ='" . $userID . "'", 'image');

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
            redirect('/company/profile/' . $userID, 'refresh');

            return;
        }
        $data = $this->upload->data();
        $userfile = $data['file_name'];
        $user = array('image' => $userfile);
        $this->Md->update_dynamic($userID, 'id', 'company', $user);

        $this->session->set_flashdata('msg', '<div class="alert alert-success">  <strong>Image updated saved</strong></div>');

        redirect('/company/profile/' . $userID, 'refresh');
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
        $query = $this->Md->query("SELECT * FROM item WHERE name='" . $this->input->post('name') . "'");

        if (count($query) > 0) {

            $status .= '<div class="alert alert-success">  <strong>Company already registered</strong></div>';
            $this->session->set_flashdata('msg', $status);
            redirect('item', 'refresh');
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
            $itemID = $this->GUID();
            $item = array('id' => $itemID, 'name' => $this->input->post('name'), 'code' => $this->input->post('code'), 'image' => $userfile, 'created' => date('Y-m-d H:i:s'), 'description' => $this->input->post('description'), 'manufacturer' => $this->input->post('manufacturer'), 'country' => $this->input->post('country'), 'batch' => $this->input->post('batch'), 'purchase_price' => $this->input->post('purchase_price'), 'sale_price' => $this->input->post('sale_price'), 'composition' => $this->input->post('composition'), 'expires' => $this->input->post('expires'), 'category' => $this->input->post('categoryID'), 'barcode' => $this->input->post('barcode'), 'date_manufactured' => $this->input->post('date_manufactured'));
           $this->Md->save($item, 'item');
            If ($this->input->post('qty')!="") {
                $id = $this->GUID();
                $total_value = $this->input->post('purchase_price') * $this->input->post('qty');
                $stock = array('id' => $id, 'itemID' => $itemID, 'qty' => $this->input->post('qty'), 'created' => date('Y-m-d H:i:s'), 'sale_price' => $this->input->post('sale_price'), 'purchase_price' => $this->input->post('purchase_price'), 'previous_price' => $this->input->post('purchase_price'), 'total_value' => $total_value);
                $this->Md->save($stock, 'stock');
            }
           
            $status .= '<div class="alert alert-success">  <strong>Information submitted</strong></div>';
            $this->session->set_flashdata('msg', $status);
            redirect('item', 'refresh');
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
                    $this->Md->update_dynamic($user_id, 'id', 'item', $task);
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
        $query = $this->Md->query("SELECT * FROM item");
        //$query = $this->Md->query("SELECT * FROM client");
        echo json_encode($query);
    }

    public function delete() {

        $this->load->helper(array('form', 'url'));
        $id = urldecode($this->uri->segment(3));

        $query = $this->Md->cascade($id, 'item', 'id');

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('item', 'refresh');
        }
    }

}
