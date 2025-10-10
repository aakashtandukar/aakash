<?php

class Mobiba_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function isUsernameAvailable($email) {
        $sql = "SELECT email from users where email = '$email'";
        $result = $this->db->query($sql)->result_array();
        if (count($result) > 0) {
            return FALSE;
        }else
            return TRUE;
    }

    public function getUserDetails($email, $password) {
        if (!$this->isValid($email, $password))
            return FALSE;

        $sql = "SELECT email, account_no, balance, fname,lname from users where email = '$email'";
        $result = $this->db->query($sql)->result_array();
        if (count($result) < 0) {
            return FALSE;
        }else
            return $result;
    }

    /**
     * 
     * @param type $params
     * @return type true if successful else false
     */
    public function registerUser($params) {
        $insert_query = $this->db->insert_string('users', $params);

        $this->db->trans_begin();
        $result = $this->db->query($insert_query);
        $this->mobiba_model->depositLog($params['account_no'], $params['balance']);
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            $this->db->trans_commit();
            return $result;
        } else {
            $this->db->trans_rollback();
            return FALSE;
        }
    }

    public function getMaxAccountNumber() {
        $sql = "SELECT MAX(account_no) as num from users";
        $result = $this->db->query($sql)->result_array();

        if (isset($result[0]['num'])) {
            return $result[0]['num'];
        }else
            return false;
    }

    public function getAvailableBalance($account_no) {
        $sql = "SELECT balance  FROM users WHERE account_no = $account_no";
        $result = $this->db->query($sql)->result_array();
        if (isset($result[0]['balance'])) {
            return $result[0]['balance'];
        }else
            return false;
    }

    /**
     * 
     * @param type $account_no
     * @param type $balance
     * @return type 
     */
    private function depositLog($account_no, $balance) {
        $users_id = $this->get_users_id_from_account_no($account_no);

        $params = array(
            'users_id' => $users_id,
            'amount' => $balance
        );

        $insert_query = $this->db->insert_string('deposit', $params);

        $result = $this->db->query($insert_query);


        return $result;
    }

    public function get_users_id_from_account_no($account_no) {
        $sql = "SELECT id from users where account_no=$account_no";
        $result = $this->db->query($sql)->result_array();
        if (isset($result[0]['id']))
            return $result[0]['id']; else
            return FALSE;
    }

    /**
     * 
     * @param type $email
     * @param type $password
     * @return type account number if valid else false;
     */
    public function isValid($email, $password) {
        $sql = "SELECT account_no from users where email='$email' and password = '$password'";
        $result = $this->db->query($sql)->result_array();
        if (isset($result[0]['account_no'])) {
            return $result[0]['account_no'];
        }else
            return FALSE;
    }

    public function hasAmount($account, $amount) {
        $sql = "SELECT balance from users where  account_no = $account and balance >=$amount";
        $result = $this->db->query($sql)->result_array();
        if (isset($result[0]['balance'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $fromAccount
     * @param type $toAccount
     * @param type $amount
     * @return type true if successful false if failed
     */
    public function transfer($fromAccount, $toAccount, $amount) {
        $this->db->trans_begin();
        if ($this->decreaseAmount($fromAccount, $amount)) {
            if ($this->increaseAmount($toAccount, $amount)) {

                if ($this->updateTransferLog($fromAccount, $toAccount, $amount)) {
                    $this->db->trans_commit();
                    return $this->db->trans_status();
                }
            }
        }
        $this->db->trans_rollback();
        return $this->db->trans_status();
    }

    private function decreaseAmount($fromAccount, $amount) {
        $sql = "UPDATE users set balance = balance -$amount where account_no = $fromAccount";
       return $this->db->query($sql);
    }

    private function increaseAmount($toAccount, $amount) {
        $sql = "UPDATE users set balance = balance +$amount where account_no = $toAccount";
       return $this->db->query($sql);
    }

    public function updateBalance($account_no, $amount) {
        $this->db->trans_begin();

        $sql = "UPDATE users set balance = balance +$amount where account_no = $account_no";
       
        if ($this->db->query($sql)) {

            $sql = "SELECT balance from users where  account_no = $account_no and balance >=$amount";
            $result = $this->db->query($sql)->result_array();
            if (isset($result[0]['balance'])) {
                $this->depositLog($account_no, $amount);
                $this->db->trans_commit();

                return $result[0]['balance'];
            } else {
                $this->db->trans_rollback();
                
                return FALSE;
            }
        } else {
           
            $this->db->trans_rollback();
            return FALSE;
        }
    }

    private function updateTransferLog($fromAccount, $toAccount, $amount) {
        $from_users_id = $this->get_users_id_from_account_no($fromAccount);

        $from_params = array(
            'users_id' => $from_users_id,
            'account_no' => $toAccount,
            'amount' => $amount
        );

        $insert_from_query = $this->db->insert_string('transfer_from', $from_params);
        $this->db->query($insert_from_query);

        $to_users_id = $this->get_users_id_from_account_no($toAccount);

        $to_params = array(
            'users_id' => $to_users_id,
            'account_no' => $fromAccount,
            'amount' => $amount
        );
        $insert_to_query = $this->db->insert_string('transfer_to', $to_params);
       return $this->db->query($insert_to_query);
    }

    public function getDepositLogs($account_no) {
        $userId = $this->get_users_id_from_account_no($account_no);
        $sql = "SELECT amount , created_at  from deposit where users_id = $userId";
        return $this->db->query($sql)->result_array();
    }

    public function getTransfertoLogs($account_no) {
        $userId = $this->get_users_id_from_account_no($account_no);
        $sql = "SELECT account_no, amount , created_at  from transfer_to where users_id = $userId";
        return $this->db->query($sql)->result_array();
    }

    public function getTransferFromLogs($account_no) {
        $userId = $this->get_users_id_from_account_no($account_no);
        $sql = "SELECT account_no, amount , created_at  from transfer_from where users_id = $userId";
        return $this->db->query($sql)->result_array();
    }

}

?>
