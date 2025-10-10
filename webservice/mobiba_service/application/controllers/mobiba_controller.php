<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mobiba_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mobiba_model');
        ini_set('display_errors', '0');
        error_reporting(0);
    }

    public function index() {

        
       $this->load->view('home');
    }
    
    public function deposit(){
        $this->load->view('update_balance');
    }
    
    public function new_account(){
        $this->load->view('register');
    }

    /**
     * 
     * @param type $email
     * @param type $password
     * @param type $balance
     * @param type $fname
     * @param type $lname
     * @return type account number if successful else false
     */
    public function register() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $balance = $_POST['balance'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        
        if (!isset($email) || strlen(trim($email)) < 1)
            return false;
        if (!isset($password) || strlen(trim($password)) < 1)
            return false;
        if (!isset($balance))
            return false;
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "Invalid Email! Please enter a valid email address to continue.";
            return false;
        }

        if (!isset($fname))
            $fname = '';
        if (!isset($lname))
            $lname = '';

        if (!$this->mobiba_model->isUsernameAvailable($email)) {
            echo "Sorry, this username Already Taken <br>";
            return FALSE;
        } else {
            $account_no;
            $max_acc_no = $this->mobiba_model->getMaxAccountNumber();
            if (!isset($max_acc_no))
                $account_no = 1000000;else
                $account_no = $max_acc_no + 1;
            $params = array(
                'email' => $email,
                'password' => $password,
                'balance' => $balance,
                'fname' => $fname,
                'lname' => $lname,
                'account_no' => $account_no
            );
            if ($this->mobiba_model->registerUser($params)) {
                Echo "Registration Successful. Your New Account Number is $account_no ";
                return $account_no;
            } else {
                Echo "Failed To register this time. Please review your details and try again.";
                return FALSE;
            }
        }
    }

    public function updateBalance() {

        $account_no = $_POST['account_no'];
        $amount = $_POST['balance'];
       
        $result = $this->mobiba_model->updateBalance($account_no, $amount);
        if ($result) {
          
            echo "Congratulations, your balance has been updated to $result";
        }else{
            echo "Sorry, we couldnt update the balance right now. <br>Please check whether the account number you entered is correct and try again";
   
            }
          
    }

    /*     * This function should always be called so as to avoid accidental 
     * use of someone else account . The account number returned by this 
     * function should be used for all purpose.
     * 
     * @param type $email
     * @param type $password
     * @return type account_no if successful else false;
     */

    private function getAccountNumber($email, $password) {
        $account_no = $this->mobiba_model->isValid($email, $password);
        if (isset($account_no)) {
            return $account_no;
        }else
            return FALSE;
    }

    public function login() {
        $email = base64_decode($_POST['email']);
        $password = base64_decode($_POST['password']);
        $result = $this->mobiba_model->getUserDetails($email, $password);
        if ($result) {
            $datas['status'] = 'success';
            $datas['message'] = $result;
            echo base64_encode(json_encode($datas));
        }else
            echo $this->getFailureJsonResponse();
    }

    public function transfer_amount() {
        $email = base64_decode($_POST['email']);
        $password = base64_decode($_POST['password']);
        $toAccount =base64_decode($_POST['toAccount']);
        $amount = base64_decode($_POST['amount']);

        $fromAccount = $this->getAccountNumber($email, $password);
        if ($fromAccount) {
            if ($this->mobiba_model->hasAmount($fromAccount, $amount)) {
                $result = $this->mobiba_model->transfer($fromAccount, $toAccount, $amount);
                if ($result) {
                    $datas['status'] = 'success';
                }else
                    $datas['status'] = 'failure';
                echo base64_encode(json_encode($datas));
            }else
                echo $this->getFailureJsonResponse();
        }else
            echo $this->getFailureJsonResponse();
    }

    public function get_balance() {
        $email = base64_decode($_POST['email']);
        $password = base64_decode($_POST['password']);

        $account_no = $this->getAccountNumber($email, $password);
        if ($account_no) {
            $balance = $this->mobiba_model->getAvailableBalance($account_no);
            $datas['status'] = 'success';
            $data['balance'] = $balance;
            $datas['message'] = $data;
            echo base64_encode(json_encode($datas));

            // return $balance;
        } else {
            echo $this->getFailureJsonResponse();
            //return false;
        }
    }

    public function get_transaction_logs() {
        $email = base64_decode($_POST['email']);
        $password = base64_decode($_POST['password']);

        $account_no = $this->getAccountNumber($email, $password);
        if (!$account_no) {
            echo $this->getFailureJsonResponse();
            return;
        }

        $depositLogs = $this->mobiba_model->getDepositLogs($account_no);
        $transferToLogs = $this->mobiba_model->getTransfertoLogs($account_no);
        $transferfromLogs = $this->mobiba_model->getTransferFromLogs($account_no);

        $datas['status'] = 'success';

        $data['deposit'] = $depositLogs;
        $data['transfer_to'] = $transferToLogs;
        $data['transfer_from'] = $transferfromLogs;
        $datas['message'] = $data;
        echo base64_encode(json_encode($datas));
    }

    private function getFailureJsonResponse() {
        $datas['status'] = 'failure';
        return base64_encode(json_encode($datas));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
