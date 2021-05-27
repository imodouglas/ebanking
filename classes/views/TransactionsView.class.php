<?php

class TransactionsView extends Transactions{
    /** Get Transactions Data */
    public function getUserMonthTotal($acctNo, $type){
        $data = $this->userMonthTotal($acctNo, $type);
        if($data == false){
            $data = 0;
        }
        return $data;
    }

    public function getMonthTotal($type){
        $data = $this->monthTotal($type);
        return $data;
    }

    public function getYearTotal($type){
        $data = $this->yearTotal($type);
        return $data;
    }
    
    public function getUserMonthTransactions($acctNo){
        $data = $this->userMonthTransactions($acctNo);
        return $data;
    }

    public function getMonthTransactions(){
        $data = $this->monthTransactions();
        return $data;
    }

    public function getYearTransactions(){
        $data = $this->yearTransactions();
        return $data;
    }
}