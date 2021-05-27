<?php

class Transactions extends Config {
    protected function userMonthTransactions($acctNo){
        $query = $this->conn()->prepare("SELECT * FROM transactions WHERE acctNo = ? AND MONTH(FROM_UNIXTIME(transDate)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE())  ORDER BY transDate DESC");
        $query->execute([$acctNo]);
        $data = $this->allResults($query);
        return $data;
    }

    /** Get An Account Total Transaction for the month by Type */
    protected function userMonthTotal($user, $type){
        $query = $this->conn()->prepare("SELECT sum(transAmount) as totalSum FROM transactions WHERE acctNo = ? AND transType = ? AND MONTH(FROM_UNIXTIME(transDate)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE())");
        $query->execute(array($user, $type));
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get The Total Transaction for the month by Type */
    protected function monthTotal($type){
        $query = $this->conn()->prepare("SELECT sum(transAmount) as totalSum FROM transactions WHERE transType = ? AND MONTH(FROM_UNIXTIME(transDate)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE())");
        $query->execute(array($type));
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get The Total Transaction for the month by Type */
    protected function yearTotal($type){
        $query = $this->conn()->prepare("SELECT sum(transAmount) as totalSum FROM transactions WHERE transType = ? AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE())");
        $query->execute(array($type));
        $data = $this->singleResult($query);
        return $data;
    }

    protected function monthTransactions(){
        $query = $this->conn()->prepare("SELECT * FROM transactions WHERE MONTH(FROM_UNIXTIME(transDate)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE()) ORDER BY transDate ASC");
        $query->execute();
        $data = $this->allResults($query);
        return $data;
    }

    protected function yearTransactions(){
        $query = $this->conn()->prepare("SELECT * FROM transactions WHERE YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE()) ORDER BY transDate ASC");
        $query->execute();
        $data = $this->allResults($query);
        return $data;
    }

    /** Make Transaction */
    protected function getAccountData($acctNo){
        $query = $this->conn()->prepare("SELECT * FROM accounts WHERE acctNo = ?");
        $query->execute([$acctNo]);
        $data = $this->singleResult($query);
        return $data;
    }

    protected function debitBalance($acctNo, $amount){
        $query = $this->conn()->prepare("UPDATE accounts SET balance = balance - ? WHERE acctNo = ?");
        $query->execute([$amount, $acctNo]);
        if($query){
            return $data = $this->getAccountData($acctNo)['balance'];
        } else {
            return false;
        }
    }

    protected function creditBalance($acctNo, $amount){
        $query = $this->conn()->prepare("UPDATE accounts SET balance = balance + ? WHERE acctNo = ?");
        $query->execute([$amount, $acctNo]);
        if($query){
            return $data = $this->getAccountData($acctNo)['balance'];
        } else {
            return false;
        }
    }

    protected function makeTransaction($acctNo, $type, $amount, $desc, $balance){
        $query = $this->conn()->prepare("INSERT INTO transactions (acctNo, transType, transAmount, transDate, transDesc, acctBalance) VALUES (?,?,?,?,?,?)");
        $query->execute(array($acctNo, $type, $amount, time(), $desc, $balance));
        if($query){
            return true;
        } else {
            return false;
        }
    }
}