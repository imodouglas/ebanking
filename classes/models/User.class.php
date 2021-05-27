<?php 

class User extends Config {

    /** Login Model */
    protected function login($uname, $pword){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE acctNo = ? AND password = ?");
        $query->execute(array($uname, md5($pword)));
        $data = $this->singleResult($query);
        return $data;
    }

    /** Create User  Model */
    protected function createUser($password, $firstName, $middleName, $lastName, $address, $phone, $email){
        $pword = rand(111111,999999);
        $acctno = "0011".$pword;
        $query = $this->conn()->prepare("INSERT INTO users (acctNo, password, fname, mname, lname, address, phone, email, cdate, acctStatus) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $query->execute([$acctno, md5($password), $firstName, $middleName, $lastName, $address, $phone, $email, time(), 'pending']);
        if($query){
            return $acctno;
        } else {
            return false;
        }
    }

    /** Update User Model */
    protected function updateUser($acctNo, $firstName, $middleName, $lastName, $address, $phone, $email){
        $query = $this->conn()->prepare("UPDATE users SET fname=?, mname=?, lname=?, address=?, phone=?, email=? WHERE acctNo = ?");
        $query->execute([$firstName, $middleName, $lastName, $address, $phone, $email, $acctNo]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Create Account Model */
    protected function createAccount($acctNo){
        $query = $this->conn()->prepare("INSERT INTO accounts (acctNo) VALUES (?)");
        $query->execute([$acctNo]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Get A User Data by Acct No Model */
    protected function userData($data){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE acctNo = ?");
        $query->execute([$data]);
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get A User Data by Id Model */
    protected function userById($id){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE id = ?");
        $query->execute([$id]);
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get Total Number of Users Model */
    protected function totalUsers(){
        $query = $this->conn()->prepare("SELECT * FROM users a JOIN accounts b USING (acctNo)");
        $query->execute();
        $data = $query->rowCount();
        return $data;
    }

    /** Get All Users Model */
    protected function allUsers(){
        $query = $this->conn()->prepare("SELECT * FROM users a JOIN accounts b USING (acctNo)");
        $query->execute();
        $data = $this->allResults($query);
        return $data;
    }

    /** Check User Password */
    protected function checkPassword($acctNo, $password){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE acctNo = ? AND password = ?");
        $query->execute([$acctNo, $password]);
        if($query->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    /** Change User Password */
    protected function changePassword($acctNo, $password){
        $query = $this->conn()->prepare("UPDATE users SET password = ? WHERE acctNo = ?");
        $query->execute([$password, $acctNo]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Get A User Account Model */
    protected function account($data){
        $query = $this->conn()->prepare("SELECT * FROM accounts WHERE acctNo = ?");
        $query->execute([$data]);
        $data = $this->singleResult($query);
        return $data;
    }


    /** Update User Status Model */
    protected function updateStatus($data, $status){
        $query = $this->conn()->prepare("UPDATE users SET acctStatus = ? WHERE acctNo = ?");
        $query->execute([$status, $data]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Flush User Transactions */
    protected function flushTransactions($acctNo){
        $query = $this->conn()->prepare("DELETE FROM transactions WHERE acctNo = ?");
        $query->execute([$acctNo]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

     /** Flush User Documents */
     protected function flushDocuments($id){
        $query = $this->conn()->prepare("DELETE FROM documents WHERE user_id = ?");
        $query->execute([$id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Delete User */
    protected function deleteUser($acctNo){
        $query = $this->conn()->prepare("DELETE a, b FROM users a JOIN accounts b USING (acctNo) WHERE a.acctNo = ? ");
        $query->execute([$acctNo]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Get User's Documents */
    protected function userDocuments($user){
        $query = $this->conn()->prepare("SELECT * FROM documents WHERE user_id = ?");
        $query->execute([$user]);
        $data = $this->allResults($query);
        return $data;
    }

    /** Get Total of User's Documents */
    protected function userDocumentsTotal($user){
        $query = $this->conn()->prepare("SELECT * FROM documents WHERE user_id = ?");
        $query->execute([$user]);
        return $query->rowCount();
    }

    /** Add Document Model */
    protected function addDocument($user, $type, $fileName){
        $query = $this->conn()->prepare("INSERT INTO documents (user_id, type, file_name, time_stamp) VALUES (?,?,?,?)");
        $query->execute([$user, $type, $fileName, time()]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Update Document Model */
    protected function updateDocument($user, $type, $fileName){
        $query = $this->conn()->prepare("UPDATE documents SET type = ?, file_name = ?, time_stamp = ? WHERE user_id = ?) VALUES (?,?,?,?)");
        $query->execute([$type, $fileName, time(), $user]);
        if($query){
            return true;
        } else {
            return false;
        }
    }



}