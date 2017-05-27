<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
    }
 public function uploading() {

        $this->load->helper(array('form', 'url'));
        $save = $this->input->post('save');
        $delete = $this->input->post('delete');

        $this->Md->queries($delete);
        $id = $this->Md->queries($save);

        if ($id) {
            echo 'true';
        } else {
            echo 'False';
        }
    }
     public function request() {

        $this->load->helper(array('form', 'url'));
       $query = $this->input->post('query');
        $query = "SELECT * FROM sale";
        $result = $this->Md->query($query);
        if ($result) {
            echo json_encode($result);
        } else {
            echo 'false';
        }
    }     


    public function client() {

        $result = $this->Md->query("SELECT * FROM client");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function tenant() {
        $estateID = $this->input->post('estateID');
        $tenantID = $this->input->post('tenantID');
        $sql[] = NULL;
        unset($sql);
        if (strlen($estateID) > 4) {
            $sql[] = "tenant.estateID = '$estateID' ";
        }
        if (strlen($tenantID) > 4) {
            $sql[] = "tenant.tenantID = '$tenantID' ";
        }
        $query = "SELECT *,room.name AS Room,tenant.name AS name,tenant.tenantID AS tenantID,tenant.commission AS commission FROM tenant  JOIN room ON tenant.RoomID = room.RoomID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);


        if ($result) {
            echo json_encode($result);
        }
    }

    public function security() {

        $result = $this->Md->query("SELECT *,tenant.name AS name,client.name AS client ,SUM(utility.total) AS utility ,SUM(damage.amount) AS damage FROM tenant LEFT JOIN client ON tenant.clientID = client.clientID JOIN utility on tenant.tenantID = utility.tenantID JOIN damage on tenant.tenantID = damage.tenantID  WHERE utility.paid='false' AND damage.paid='false'  ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function user() {

        $result = $this->Md->query("SELECT * FROM user");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function category() {

        $result = $this->Md->query("SELECT DISTINCT(category) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function method() {

        $result = $this->Md->query("SELECT DISTINCT(method) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function detail() {

        $result = $this->Md->query("SELECT DISTINCT(details) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function bank() {

        $result = $this->Md->query("SELECT DISTINCT(bank) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function account() {

        $result = $this->Md->query("SELECT DISTINCT(account) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function utility() {

        $result = $this->Md->query("SELECT *,utility.name AS name FROM utility INNER JOIN tenant ON utility.tenantID = tenant.tenantID ORDER BY id desc ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function estate_utility() {


        $result = $this->Md->query("SELECT *,estate_utility.name AS name FROM estate_utility INNER JOIN estate ON estate_utility.estateID = estate.estateID ORDER BY id desc ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function remote() {

        $this->load->helper(array('form', 'url'));
        $email = $this->input->post('name');
        $password_now = md5($this->input->post('password'));

        if ($email == "Admin" && $this->input->post('password') == "Admin") {
            echo 'T';
            return;
        }
        $get_result = $this->Md->check($email, 'name', 'user');
        if (!$get_result) {
            $result = $this->Md->get('name', $email, 'user');
            foreach ($result as $res) {
                if ($password_now == $res->password) {
                    echo 'T|' . $res->department . '|' . $res->designation . '|' . $res->image . '|' . $res->userID;
                } else {
                    echo 'F';
                }
            }
        } else {
            echo 'F';
        }
    }

    public function users() {

        $result = $this->Md->query("SELECT * FROM user");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function reminders() {

        $result = $this->Md->query("SELECT *,users.name AS cid FROM reminder INNER JOIN users ON reminder.cid=users.uid");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function util() {
        $uid = urldecode($this->uri->segment(3));
        if ($uid) {

            $result = $this->Md->query("SELECT *,util.name AS name,room.name AS roomName,util.cost AS cost FROM util INNER JOIN room ON util.roomID=room.roomID WHERE util.roomID='" . $uid . "' ");

            if ($result) {
                echo json_encode($result);
                return;
            }
        }
        $result = $this->Md->query("SELECT *,util.name AS name,room.name AS roomName FROM util INNER JOIN room ON util.roomID=room.roomID ");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function roomutil() {
        $uid = urldecode($this->uri->segment(3));


        $result = $this->Md->query("SELECT *,util.name AS name,room.name AS roomName,util.cost AS cost FROM util INNER JOIN room ON util.roomID=room.roomID WHERE util.roomID='" . $uid . "' ");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function client_tenant() {

        $clientID = urldecode($this->uri->segment(3));

        $room = $this->Md->query("SELECT *,tenant.name AS name,room.name AS room,tenant.tenantID AS tenantID,estate.Name AS estate FROM tenant  LEFT JOIN room ON tenant.tenantID = room.tenantID INNER JOIN estate ON room.estateID = estate.estateID AND tenant.clientID='" . $clientID . "'");

        if ($room) {
            echo json_encode($room);
        }
    }

    //Sending.genUrl + "api/transaction/" + userid+"/"+startdate+"/"+enddate;
    public function userreport() {

        $userid = urldecode($this->uri->segment(3));
        $start = urldecode($this->uri->segment(4));
        $end = urldecode($this->uri->segment(5));
        $method = urldecode($this->uri->segment(6));

        if ($userid != "") {
            $result = $this->Md->query("SELECT * FROM transactions WHERE cid='" . $userid . "' AND DATE(created) BETWEEN '$start' AND '$end'");

            if ($result) {
                echo json_encode($result);
                return;
            }
        }
    }

    public function expense() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "expense.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS cid,property.name AS propert,user.name AS client,expense.details AS details FROM expense LEFT JOIN property ON expense.propertyID= property.propertyID LEFT JOIN user ON user.clientID = property.clientID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function rent() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "rent.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS tenantID,room.name AS roomID,rent.commission AS commission,rent.date AS date,rent.start AS start,rent.end AS end FROM rent LEFT JOIN room ON rent.roomID= room.roomID  LEFT JOIN user ON rent.tenantID = user.tenantID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function payments() {

        $clientID = $this->input->post('clientID');
        //"aeec78c2-a5ee-47fe-8a9f-ea9fa639c32c";//
        $tenantID = $this->input->post('tenantID');
        $end = $this->input->post('startDate');
        $start = $this->input->post('endDate');
        $method = $this->input->post('method');
        $paymentID = $this->input->post('paymentID');
        $balance = $this->input->post('balance');
        $sql[] = NULL;
        unset($sql);

        if ($balance == 'false') {
            $sql[] = "payment.balance = '0' ";
        }
        if (strlen($clientID) > 4) {

            $sql[] = "payment.clientID = '$clientID' ";
        }
        if (strlen($tenantID) > 4) {

            $sql[] = "payment.tenantID = '$tenantID' ";
        }
        if (strlen($paymentID) > 4) {

            $sql[] = "payment.paymentID='$paymentID' ";
        }
//        if (strlen($start) > 4 && $start != "01-01-1970") {
//
//            $sql[] = "STR_TO_DATE( payment.date,  '%d-%m-%Y' ) > STR_TO_DATE(  '$start',  '%d-%m-%Y' ) ";
//        }
//        if (strlen($end) > 4 && $end != "01-01-1970") {
//
//            $sql[] = "STR_TO_DATE( payment.date,  '%d-%m-%Y' ) < STR_TO_DATE(  '$end',  '%d-%m-%Y' )  ";
//        }
//        if (strlen($start) < 4 || $start == "01-01-1970" || strlen($end) < 4) {
//
//            $sql[] = "MONTH(STR_TO_DATE( payment.date,  '%d-%m-%Y' )) = MONTH(CURDATE()) ";
//        }

        $query = "SELECT *,tenant.name AS tenant,estate.name AS estate,room.name AS room,client.name AS client FROM payment JOIN tenant ON payment.tenantID = tenant.tenantID JOIN estate ON payment.estateID = estate.estateID JOIN room ON payment.roomID = room.roomID JOIN client ON payment.clientID = client.clientID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }
        // echo $query;
        $result = $this->Md->query($query);

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function banked() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "bank.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS clientID FROM bank LEFT JOIN user ON bank.clientID= user.clientID ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function bank_client() {

        $client = urldecode($this->uri->segment(3));


        $sql[] = NULL;
        unset($sql);


        if ($client) {
            $sql[] = "bank.clientID = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "bank.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,client.name AS clientID,bank.name As name FROM bank LEFT JOIN client ON bank.clientID= client.clientID  ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function expense_client() {

        $client = urldecode($this->uri->segment(3));


        $sql[] = NULL;
        unset($sql);

        $sql[] = "expense.offset = 'true' ";
        $sql[] = "expense.approved = 'true' ";
        if ($client) {
            $sql[] = "expense.clientID = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "expense.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,client.name AS clientID FROM expense LEFT JOIN client ON expense.clientID= client.clientID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function partial() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "partial.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS tenantID FROM partial LEFT JOIN user ON partial.tenantID= user.tenantID ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function confiscate() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "confiscate.day BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS tenantID,room.name AS roomID FROM confiscate LEFT JOIN room ON confiscate.roomID= room.roomID  LEFT JOIN user ON confiscate.tenantID = user.tenantID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function confiscate_tenant() {

        $tenant = urldecode($this->uri->segment(3));

        $sql[] = NULL;
        unset($sql);


        if ($tenant) {
            $sql[] = "confiscate.tenantID = '$tenant' ";
        }

        $query = "SELECT *,tenant.name AS tenantID,room.name AS roomID,confiscate.cost AS cost FROM confiscate LEFT JOIN room ON confiscate.roomID= room.roomID  LEFT JOIN tenant ON confiscate.tenantID = tenant.tenantID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function cost() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));

        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "cost.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS tenantID,room.name AS roomID FROM cost LEFT JOIN room ON cost.roomID= room.roomID  LEFT JOIN user ON cost.tenantID = user.tenantID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function tenant_cost() {


        $client = urldecode($this->uri->segment(3));

        $sql[] = NULL;
        unset($sql);


        if ($client) {
            $sql[] = "damage.tenantID = '$client' ";
        }

        $query = "SELECT * FROM damage ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function pending_damage() {


        $client = urldecode($this->uri->segment(3));

        $sql[] = NULL;
        unset($sql);


        if ($client) {
            $sql[] = "damage.tenantID = '$client' ";
        }
        $sql[] = "damage.paid = 'false' ";
        $query = "SELECT * FROM damage ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function tenant_utility() {


        $client = urldecode($this->uri->segment(3));
        $tenantID = $this->input->post('tenantID');
        $year = $this->input->post('year');
        $month = $this->input->post('month');

        $sql[] = NULL;
        unset($sql);
        $sql[] = "utility.tenantID = '$tenantID' ";

        if ($year) {
            $sql[] = "utility.year = '$year' ";
        }
        if ($month) {
            $sql[] = "utility.month = '$month' ";
        }

        $query = "SELECT * FROM utility ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function pending_utility() {


        $client = urldecode($this->uri->segment(3));

        $sql[] = NULL;
        unset($sql);


        if ($client) {
            $sql[] = "utility.tenantID = '$client' ";
        }
        $sql[] = "utility.paid = 'false' ";
        $query = "SELECT * FROM utility ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function tenant_partial() {


        $client = urldecode($this->uri->segment(3));

        $sql[] = NULL;
        unset($sql);


        if ($client) {
            $sql[] = "partial.tenantID = '$client' ";
        }

        $query = "SELECT * FROM partial ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function penalty_tenant() {


        $client = urldecode($this->uri->segment(3));

        $sql[] = NULL;
        unset($sql);


        if ($client) {
            $sql[] = "penalty.tenantID = '$client' ";
        }

        $query = "SELECT * FROM penalty JOIN rent ON penalty.rentID=rent.rentID ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }
        // echo $query;
        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function report() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "transactions.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "transactions.created BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,users.name AS cid,transactions.tenant AS tenant,users.name AS cid,estate.name AS eid,unit.name as uid,transactions.category AS category,transactions.commission AS commission FROM transactions LEFT JOIN users ON transactions.cid= users.uid  LEFT JOIN estate ON transactions.eid = estate.eid LEFT JOIN unit ON transactions.uid = unit.uid";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function advanced() {
        // string url = Sending.genUrl + "api/advanced/" + clientID + "/"+ tenantID + "/" + MethodComboBox.Text + "/" + DetailComboBox.Text+"/" + BankComboBox.Text+"/" +AccountComboBox.Text + "/" +startdate+ "/" + enddate;
        $client = urldecode($this->uri->segment(3));
        $tenant = urldecode($this->uri->segment(4));
        $method = urldecode($this->uri->segment(5));
        $detail = urldecode($this->uri->segment(6));
        $bank = urldecode($this->uri->segment(7));
        $account = urldecode($this->uri->segment(8));
        $start = date("d-m-Y", strtotime($this->uri->segment(9)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(10))));
        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            if ($client == "none") {
                
            } else {
                $sql[] = "transactions.cid = '$client' ";
            }
        }
        if ($tenant) {
            if ($tenant == "none") {
                
            } else {
                $sql[] = "transactions.tenant = '$tenant' ";
            }
        }
        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "transactions.method = '$method' ";
            }
        }
        if ($detail) {
            if ($detail == "none") {
                
            } else {
                $sql[] = "transactions.details = '$detail' ";
            }
        }
        if ($bank) {
            if ($bank == "none") {
                
            } else {
                $sql[] = "transactions.bank = '$bank' ";
            }
        }
        if ($start != "" && $end != "") {
            $sql[] = "transactions.created BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,users.name AS cid,transactions.tenant AS tenant,users.name AS cid,estate.name AS eid,unit.name as uid,transactions.category AS category,transactions.commission AS commission FROM transactions LEFT JOIN users ON transactions.cid= users.uid  LEFT JOIN estate ON transactions.eid = estate.eid LEFT JOIN unit ON transactions.uid = unit.uid";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function reciept() {

        $tid = $this->uri->segment(3);

        $sql[] = NULL;
        unset($sql);

        if ($tid) {
            $sql[] = "tid = '$tid'";
        }

        $query = "SELECT *,users.name AS cid,transactions.tenant AS tenant,users.name AS cid,estate.name AS eid,unit.name as uid,transactions.category AS category,transactions.commission AS commission FROM transactions LEFT JOIN users ON transactions.cid= users.uid  LEFT JOIN estate ON transactions.eid = estate.eid LEFT JOIN unit ON transactions.uid = unit.uid";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function requisition() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            $sql[] = "method = '$method' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "created BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT * FROM requisition ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function transaction() {

        $userid = urldecode($this->uri->segment(3));
        $start = date("d-m-Y", strtotime($this->uri->segment(4)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(5))));
        $method = urldecode($this->uri->segment(6));

        if ($userid != "") {

            $sql[] = NULL;
            unset($sql);

            if ($method) {
                $sql[] = "method = '$method' ";
            }
            if ($userid) {
                $sql[] = "cid = '$userid' ";
            }
            if ($start != "" && $end != "") {
                $sql[] = "created BETWEEN '$start' AND '$end' ";
            }

            $query = "SELECT * FROM transactions ";

            if (!empty($sql)) {
                $query .= ' WHERE  ' . implode(' AND ', $sql);
            }

            $result = $this->Md->query($query);

            if ($result) {
                echo json_encode($result);
                return;
            }
        } else {
            $start = date("d-m-Y", strtotime($this->uri->segment(3)));
            $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));

            $sql[] = NULL;
            unset($sql);
            if ($start != "" && $end != "") {
                $sql[] = "created BETWEEN '$start' AND '$end' ";
            }

            $query = "SELECT * FROM transactions ";

            if (!empty($sql)) {
                $query .= ' WHERE  ' . implode(' AND ', $sql);
            }

            $result = $this->Md->query($query);

            if ($result) {
                echo json_encode($result);
                return;
            }
        }
    }

    public function property() {

        $result = $this->Md->query("SELECT *,estate.name AS name,client.name AS client FROM estate INNER JOIN client ON estate.clientID= client.clientID ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function client_property() {
        $clientID = urldecode($this->uri->segment(3));

        $result = $this->Md->query("SELECT * FROM estate WHERE estate.clientID='" . $clientID . "' ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function estate() {

        $result = $this->Md->query("SELECT *,client.name AS client,estate.name AS name FROM estate JOIN client ON estate.clientID =client.clientID");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function EstateStatement() {
        $userid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT *,estate.name AS name,user.name AS Client FROM estate INNER JOIN users ON estate.cid= users.uid WHERE estate.cid='" . $userid . "' ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function rentstatement() {
        $start = date("d-m-Y", strtotime($this->uri->segment(4)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(5))));
        $userid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT *,user.name AS tenant,room.name AS room,property.name AS property FROM user LEFT JOIN property ON user.clientID= property.clientID LEFT JOIN room ON property.propertyID = room.propertyID INNER JOIN rent ON room.roomID = rent.roomID WHERE user.clientID='" . $userid . "'AND rent.date BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function expensestatement() {
        $start = date("d-m-Y", strtotime($this->uri->segment(4)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(5))));
        $userid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT *,property.name AS propert,room.name AS room FROM user LEFT JOIN property ON user.clientID= property.clientID LEFT JOIN room ON property.propertyID = room.propertyID LEFT JOIN expense ON expense.propertyID = property.propertyID WHERE user.clientID='" . $userid . "' AND expense.date BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function UnitStatement() {
        $estateid = urldecode($this->uri->segment(3));

        $result = $this->Md->query("SELECT *,unit.name AS name,estate.name AS estate,users.name AS username FROM unit INNER JOIN estate ON unit.eid = estate.eid INNER JOIN users ON unit.uid = users.unit WHERE unit.eid='" . $estateid . "'");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function room() {

        $result = $this->Md->query("SELECT *  FROM room  ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function roomer() {

        $tenantID = $this->input->post('tenantID');


        $result = $this->Md->query("SELECT *  FROM room WHERE room.tenantID='$tenantID'  ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function prop_room() {
        $propID = urldecode($this->uri->segment(3));

        $result = $this->Md->query("SELECT *,tenant.name AS tenant  FROM room LEFT JOIN tenant ON room.tenantID = tenant.tenantID  WHERE room.estateID='" . $propID . "' ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function graph() {

        $this->load->view('view-graph');
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
