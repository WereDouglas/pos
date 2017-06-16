<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Taking extends CI_Controller {

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

        $query = $this->Md->query("SELECT *,item.name AS name,store.name AS store FROM taking LEFT JOIN store ON store.id = taking.storeID LEFT JOIN item ON item.id = taking.itemID LEFT JOIN users ON users.id = taking.userID WHERE  taking.orgID='" . $this->session->userdata('orgID') . "'");
        // $query = $this->Md->query("SELECT * FROM client  ");

        if ($query) {
            $data['items'] = $query;
        } else {
            $data['items'] = array();
        }
        $this->load->view('view-taking', $data);
    }

    public function report() {

        $this->load->helper(array('form', 'url'));
        $from = date('d-m-Y', strtotime($this->input->post('from')));
        $to = date('d-m-Y', strtotime($this->input->post('to')));

        unset($sql);

        if ($from != '' & $to != '') {
            $sql[] = "DAY(STR_TO_DATE(taking.date,'%d-%m-%Y')) BETWEEN '$from' AND '$to' ";
        }
        if ($this->input->post('storeID') != "") {
            $storeID = trim($this->input->post('storeID'));
            $sql[] = "taking.storeID = '" . $storeID . "' ";
        }
        $query = "SELECT *,item.name AS name,store.name AS store,item.image AS image FROM taking  LEFT JOIN store ON store.id = taking.storeID LEFT JOIN item ON item.id = taking.itemID LEFT JOIN users ON users.id = taking.userID LEFT JOIN stock ON stock.itemID = item.id";
        if (!empty($sql)) {
            $query .= ' WHERE ' . implode(' AND ', $sql);
        }
        $sql[] = "taking.orgID = '" . $this->session->userdata('orgID') . "'";
        $dailys = $this->Md->query($query);
        //var_dump($daily);
        if ($dailys) {

            echo '<div class="scroll"> 
                <table  class="scroll display table table-bordered table-striped scroll" id="dynamic-table"  border="1px" cellpadding="2px" border-width="thin"  style="font-size: 12px; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Store</th>
                                    <th>IMG</th>
                                    <th>Name</th>
                                    <th>Balance B/F</th>
                                    <th>Purchases</th>
                                    <th>Sales</th>
                                    <th>Total stock</th>
                                    <th>System stock</th>
                                    <th>Variance</th>
                                    <th>Purchase price</th>
                                    <th>Sale price</th>
                                    <th>Profit</th>
                                    <th>Physical count</th>
                                    <th>Damages</th>
                                    <th>Shrinkable</th>                                    
                                    <th>Users</th>
                                </tr>
                            </thead>
                            <tbody>';
            //var_dump($dailys);
            $sum = "0";
            $sum_tax = "0";
            $count = 1;
            if (is_array($dailys) && count($dailys)) {
                foreach ($dailys as $loop) {
                    echo '       <tr class="odd">
                                            <td>' . $count++ . '</td>
                                                 <td>' . $loop->store . '</td>
                                            <td><img height="50px" width="50px" src="data:image/jpeg;base64,' . $loop->image . '" /></td>
                                            <td>' . $loop->name . '</td>
                                            <td>' . $loop->bf . '</td>
                                            <td>' . $loop->purchases . '</td>
                                            <td>' . $loop->sales . '</td>
                                            <td>' . $loop->total_stock . '</td>
                                            <td>' . $loop->system_stock . '</td>
                                            <td>' . $loop->variance. '</td>
                                            <td>' . number_format($loop->purchase_amount) . '</td>
                                            <td>' . number_format($loop->sale_amount) . '</td>    
                                            <td>' . number_format($loop->profit) . '</td>
                                            <td>' . number_format($loop->physical_count) . '</td>
                                            <td>' . $loop->damages. '</td>
                                            <td>' . $loop->shrinkable. '</td>
                                            <td>' . $loop->surname.' '.$loop->lastname. '</td>
                                            
                                        </tr>';
                    $sum = $sum + $loop->total;
                }
            }
            echo '       <tr class="odd">
                                            <td></td>
                                            <td></td>
                                           <td></td>
                                            <td></td> 
                                             <td></td>
                                           <td></td>
                                            <td></td> 
                                            <td></td>
                                            <td></td> 
                                            <td>TOTAL </td>
                                            <td >' . number_format($sum) . '</td>td                                                                                      
                                            <td ></td> 
                                            <td></td>
                                            <td></td>
                                           <td></td>
                                            <td></td> 
                                          
                                            </tr>';
            echo '    </tbody>

                        </table></div>';
        }
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
            If ($this->input->post('qty') != "") {
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
                    $this->Md->update_dynamic($user_id, 'id', 'stock', $task);
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
        $query = $this->Md->query("SELECT *,stock.id AS id,item.id As Ids FROM item LEFT JOIN stock ON stock.itemID = item.id");

        //$query = $this->Md->query("SELECT * FROM client");
        echo json_encode($query);
    }

    public function delete() {

        $this->load->helper(array('form', 'url'));
        $id = urldecode($this->uri->segment(3));

        $query = $this->Md->cascade($id, 'stock', 'id');

        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('stock', 'refresh');
        }
    }

}
