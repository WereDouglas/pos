<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

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

        $query = $this->Md->query("SELECT * FROM sale WHERE  orgID='" . $this->session->userdata('orgID') . "' ");
        // $query = $this->Md->query("SELECT * FROM client  ");

        if ($query) {
            $data['bills'] = $query;
        } else {
            $data['bills'] = array();
        }
        $this->load->view('view-all-sales', $data);
    }

    public function sale() {

        $this->load->view('view-sales');
    }

    public function payment() {

        $this->load->view('view-payments');
    }

    public function expense() {

        $this->load->view('view-expenses');
    }

    public function periodic() {

        $this->load->helper(array('form', 'url'));
        $from = date('d-m-Y', strtotime($this->input->post('from')));
        $to = date('d-m-Y', strtotime($this->input->post('to')));

        unset($sql);

        if ($from != '' & $to != '') {
            $sql[] = "DAY(STR_TO_DATE(sale.created,'%d-%m-%Y')) BETWEEN '$from' AND '$to' ";
        }

        if ($this->input->post('storeID') != "") {
            $storeID = trim($this->input->post('storeID'));
            $sql[] = "sale.storeID = '" . $storeID . "' ";
        }
        if ($this->input->post('type') != "") {
            $type = trim($this->input->post('type'));
            $sql[] = "sale.type = '" . $type . " '";
        }
        $sql[] = "sale.orgID = '" . $this->session->userdata('orgID') . "'";

        $query = "SELECT *,users.surname AS user,item.name AS item,sale.tax AS tax,store.name as store FROM sale LEFT JOIN item ON item.id = sale.itemID LEFT JOIN store on store.id=sale.storeID LEFT JOIN users ON users.id = sale.userID";
        if (!empty($sql)) {
            $query .= ' WHERE ' . implode(' AND ', $sql);
        }

        $dailys = $this->Md->query($query);
        //var_dump($daily);
        if ($dailys) {

            echo '<div class="scroll"> 
                <table  class="scroll display table table-bordered table-striped scroll" id="dynamic-table"  border="1px" cellpadding="2px" border-width="thin"  style="font-size: 12px; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>DATE</th>
                                    <th>Ref No.</th>
                                    <th>Particular</th>
                                     <th>Unit Cost</th>
                                    <th>Quantity</th>
                                    <th>Total</th>                                   
                                    <th>Tax(V.A.T)</th> 
                                    <th>Store</th>
                                    <th>By</th>
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
                                            <td> ' . $count++ . ' </td>
                                            <td> ' . $loop->created . ' </td>
                                            <td> ' . $loop->no . ' </td>
                                            <td >' . $loop->item . ' </td>
                                            <td> ' . number_format($loop->price) . '</td>
                                            <td> ' . $loop->qty . ' </td>
                                            <td> ' . number_format($loop->total) . ' </td>
                                            <td > ' . number_format($loop->tax) . '</td>
                                            <td > ' . $loop->store . '</td> 
                                            <td > ' . $loop->user . '</td>
                                            

                                        </tr>';
                    $sum = $sum + $loop->total;
                    $sum_tax = $sum_tax + $loop->tax;
                }
            }

            echo '       <tr class="odd">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>TOTAL </td>
                                            <td >' . number_format($sum) . '</td>
                                            <td>' . number_format($sum_tax) . '</td>
                                            <td></td>                                            
                                            <td ></td> 
                                            <td ></td> 
                                            </tr>';
            echo '    </tbody>

                        </table></div>';
        }
    }

    public function payment_report() {

        $this->load->helper(array('form', 'url'));
        $from = date('d-m-Y', strtotime($this->input->post('from')));
        $to = date('d-m-Y', strtotime($this->input->post('to')));

        unset($sql);

        if ($from != '' & $to != '') {
            $sql[] = "DAY(STR_TO_DATE(payment.created,'%d-%m-%Y')) BETWEEN '$from' AND '$to' ";
        }
        if ($this->input->post('storeID') != "") {
            $storeID = trim($this->input->post('storeID'));
            $sql[] = "payment.storeID = '" . $storeID . "' ";
        }
        if ($this->input->post('type') != "") {
            $type = trim($this->input->post('type'));
            $sql[] = "payment.type = '" . $type . " '";
        }
        $query = "SELECT *,users.surname AS user,store.name as store FROM payment LEFT JOIN store on store.id=payment.storeID LEFT JOIN users ON users.id = payment.userID";
        if (!empty($sql)) {
            $query .= ' WHERE ' . implode(' AND ', $sql);
        }
        $sql[] = "payment.orgID = '" . $this->session->userdata('orgID') . "'";
        $dailys = $this->Md->query($query);
        //var_dump($daily);
        if ($dailys) {

            echo '<div class="scroll"> 
                <table  class="scroll display table table-bordered table-striped scroll" id="dynamic-table"  border="1px" cellpadding="2px" border-width="thin"  style="font-size: 12px; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Ref No.</th>
                                    <th>Amount</th>
                                     <th>Method</th>
                                    <th>Paid by</th>
                                    <th>Received by</th>
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
                                            <td>' . $loop->created . '</td>
                                            <td>' . $loop->no . '</td>
                                            <td>' . number_format($loop->amount) . '</td>
                                            <td>' . $loop->method . '</td>
                                            <td>' . $loop->by . '</td>
                                            <td >' . $loop->user . '</td>
                                        </tr>';
                    $sum = $sum + $loop->amount;
                }
            }
            echo '       <tr class="odd">
                                            <td></td>
                                            <td></td>
                                           
                                            <td>TOTAL </td>
                                            <td >' . number_format($sum) . '</td>
                                            <td></td>
                                            <td></td>                                            
                                            <td ></td> 
                                          
                                            </tr>';
            echo '    </tbody>

                        </table></div>';
        }
    }

    public function expense_report() {

        $this->load->helper(array('form', 'url'));
        $from = date('d-m-Y', strtotime($this->input->post('from')));
        $to = date('d-m-Y', strtotime($this->input->post('to')));

        unset($sql);

        if ($from != '' & $to != '') {
            $sql[] = "DAY(STR_TO_DATE(expense.date,'%d-%m-%Y')) BETWEEN '$from' AND '$to' ";
        }
        if ($this->input->post('storeID') != "") {
            $storeID = trim($this->input->post('storeID'));
            $sql[] = "expense.storeID = '" . $storeID . "' ";
        }
        if ($this->input->post('type') != "") {
            $type = trim($this->input->post('type'));
            $sql[] = "expense.type = '" . $type . " '";
        }
        $query = "SELECT *,users.surname AS user,store.name as store FROM expense LEFT JOIN store on store.id=expense.storeID LEFT JOIN users ON users.id = expense.userID";
        if (!empty($sql)) {
            $query .= ' WHERE ' . implode(' AND ', $sql);
        }
        $sql[] = "expense.orgID = '" . $this->session->userdata('orgID') . "'";
        $dailys = $this->Md->query($query);
        //var_dump($daily);
        if ($dailys) {

            echo '<div class="scroll"> 
                <table  class="scroll display table table-bordered table-striped scroll" id="dynamic-table"  border="1px" cellpadding="2px" border-width="thin"  style="font-size: 12px; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Particulars</th>
                                    <th>Quantity</th>
                                     <th>Unit Cost</th>
                                    <th>Total</th>
                                   
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
                                            <td>' . $loop->date . '</td>
                                            <td>' . $loop->itemid . '</td>
                                            <td>' . $loop->qty . '</td>
                                            <td>' . number_format($loop->price) . '</td>
                                            <td>' . number_format($loop->total) . '</td>
                                            
                                        </tr>';
                    $sum = $sum + $loop->total;
                }
            }
            echo '       <tr class="odd">
                                            <td></td>
                                            <td></td>
                                           <td></td>
                                            <td></td>  
                                            <td>TOTAL </td>
                                            <td >' . number_format($sum) . '</td>td                                                                                      
                                           
                                          
                                            </tr>';
            echo '    </tbody>

                        </table></div>';
        }
    }

    public function bill_report() {

        $this->load->helper(array('form', 'url'));
        $from = date('d-m-Y', strtotime($this->input->post('from')));
        $to = date('d-m-Y', strtotime($this->input->post('to')));

        unset($sql);

        if ($from != '' & $to != '') {
            $sql[] = "DAY(STR_TO_DATE(billing.created,'%d-%m-%Y')) BETWEEN '$from' AND '$to' ";
        }
        if ($this->input->post('storeID') != "") {
            $storeID = trim($this->input->post('storeID'));
            $sql[] = "billing.storeID = '" . $storeID . "' ";
        }
        if ($this->input->post('type') != "") {
            $type = trim($this->input->post('type'));
            $sql[] = "billing.type = '" . $type . " '";
        }
        $query = "SELECT *,users.surname AS user,store.name as store,billing.total AS total FROM billing LEFT JOIN store on store.id=billing.storeID LEFT JOIN users ON users.id = billing.userID";
        if (!empty($sql)) {
            $query .= ' WHERE ' . implode(' AND ', $sql);
        }
        $sql[] = "billing.orgID = '" . $this->session->userdata('orgID') . "'";
        $dailys = $this->Md->query($query);
        //var_dump($daily);
        if ($dailys) {

            echo '<div class="scroll"> 
                <table  class="scroll display table table-bordered table-striped scroll" id="dynamic-table"  border="1px" cellpadding="2px" border-width="thin"  style="font-size: 12px; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>DATE</th>
                                    <th>Ref No.</th>                                   
                                    <th>Total</th>
                                    <th>Amount paid</th>                                   
                                    <th>Method</th> 
                                    <th>Balance</th>
                                    <th>Bank</th>
                                    <th>Client/Customer</th>
                                    <th>Account</th>
                                    <th>Type</th>
                                    <th>Tax</th>
                                    <th>Store</th>
                                    <th>By</th>
                                    </tr>
                            </thead>
                            <tbody>';
            //var_dump($dailys);
            $sum = "0";
            $sum_bal = "0";
            $sum_paid = "0";
            $count = 1;
            if (is_array($dailys) && count($dailys)) {
                foreach ($dailys as $loop) {
                    echo '       <tr class="odd">
                                            <td>' . $count++ . '</td>
                                            <td>' . $loop->created . '</td>
                                            <td>' . $loop->no . '</td>
                                            <td>' . $loop->total . '</td>
                                            <td>' . number_format($loop->paid) . '</td>
                                            <td>' . $loop->method . '</td>
                                            <td>' . $loop->balance . '</td>
                                            <td>' . $loop->bank . '</td>
                                            <td>' . $loop->transactorID . '</td>
                                            <td>' . $loop->account . '</td>
                                            <td>' . $loop->type . '</td>
                                            <td>' . $loop->tax . '</td>
                                            <td>' . $loop->storeID . '</td>
                                            <td >' . $loop->user . '</td>
                                        </tr>';
                    $sum = $sum + $loop->total;
                    $sum_bal = $sum_bal + $loop->balance;
                    $sum_paid = $sum_paid + $loop->paid;
                }
            }

            echo '       <tr class="odd">
                                            <td></td>
                                            <td></td>
                                           
                                            <td>TOTAL </td>
                                            <td >' . number_format($sum) . '</td>
                                            <td>' . number_format($sum_paid) . '</td>
                                            <td></td>                                            
                                            <td >' . number_format($sum_bal) . '</td> 
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                             <td></td>                                          
                                            </tr>';
            echo '    </tbody>

                        </table></div>';
        }
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


        echo $this->input->post('name');
        return;
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
