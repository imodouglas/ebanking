<?php

class TransactionsController extends Transactions{
    public function getMakeTransaction($acctNo, $type, $amount, $desc){
        if($type == "CR"){
            $balance = $this->creditBalance($acctNo, $amount);
        } else if($type == "DR"){
            $balance = $this->debitBalance($acctNo, $amount);
        }
        $data = $this->makeTransaction($acctNo, $type, $amount, $desc, $balance);

        return $data;
    }
}