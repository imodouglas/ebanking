<?php

class UserView extends User {

    /** Get Users and Accounts Data */
    public function getUser($acctNo){
        $data = $this->userData($acctNo);
        return $data;
    }

    public function getTotalUsers(){
        $data = $this->totalUsers();
        return $data;
    }

    public function getAllUsers(){
        $data = $this->allUsers();
        return $data;
    }

    public function getAccount($acctNo){
        $data = $this->account($acctNo);
        return $data;
    }

}