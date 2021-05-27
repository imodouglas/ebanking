<?php

class UserController extends User {

    public function doLogin($uname, $pword){
        $data = $this->login($uname, $pword);
        return $data;
    }

    public function doCreateUser($password, $firstName, $middleName, $lastName, $address, $phone, $email){
        $result = $this->createUser($password, $firstName, $middleName, $lastName, $address, $phone, $email);
        if($result == false){
            return $result;
        } else {
            $this->createAccount($result);
            return $result;
        }
    }

    public function doDeleteUser($acctNo){
        $result = $this->deleteUser($acctNo);
        return $result;
    }

    public function doUpdateUser($acctNo, $firstName, $middleName, $lastName, $address, $phone, $email){
        return $this->updateUser($acctNo, $firstName, $middleName, $lastName, $address, $phone, $email);
    }

    public function doFlushTransactions($acctNo){
        return $this->flushTransactions($acctNo);
    }

    public function doFlushDocuments($id){
        return $this->flushDocuments($id);
    }

    public function getChangePassword($acctNo, $password){
        return $this->changePassword($acctNo, md5($password));
    }

    public function getCheckPassword($acctNo, $password){
        return $this->checkPassword($acctNo, md5($password));
    }

    public function getUpdateStatus($acctNo, $status){
        $data = $this->updateStatus($acctNo, $status);
        return $data;
    }

    public function getUserDocuments($user){
        $data = $this->userDocuments($user);
        return $data;
    }

    public function getUserDocumentsTotal($user){
        $data = $this->userDocumentsTotal($user);
        return $data;
    }

    public function doAddDocument($user, $type, $fileName){
        $data = $this->addDocument($user, $type, $fileName);
        return $data;
    }

    public function doUpdateDocument($user, $type, $fileName){
        $data = $this->updateDocument($user, $type, $fileName);
        return $data;
    }

    public function uploadFile($file, $tmp, $newname){
        $temp = explode(".", $_FILES["file"]["name"]);
        // $newfilename = round(microtime(true)) . '.' . end($temp);
        $newfilename = $newname. '.' . end($temp);
        $result = move_uploaded_file($_FILES["file"]["tmp_name"], "/assets/images/documents" . $newfilename);
        if($result){
            return true;
        } else {
            return false;
        }
    }

}