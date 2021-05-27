<?php session_start();

  //Constant Details
  $companyName = "Sample Savings & Loans";
  $companyPhone = "08012345678";
  $companyEmail = "info@ascoscalabar.com.ng";
  $minWithdrawal = 1000; 

  // If Admin is Set
  if(isset($_SESSION['ascosUser'], $_SESSION['ascosPriv']) && $_SESSION['ascosPriv'] == "Administrator"){
    //Statistics
    $allDataq = $conn->prepare("SELECT * FROM accounts a JOIN users b USING(acctNo)");
    $allDataq->execute();
    $allCount = $allDataq->rowCount();

    // Transaction History for the month
    // Total Credit
    $adminmCreditq = $conn->prepare("SELECT sum(transAmount) as sumCredit FROM transactions WHERE transType = ? AND MONTH(FROM_UNIXTIME(transDate)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE())");
    $adminmCreditq->execute(array("CR"));
    $adminmCredit = $adminmCreditq->fetch(PDO::FETCH_ASSOC);

    // Total Debit
    $adminmDebitq = $conn->prepare("SELECT sum(transAmount) as sumDebit FROM transactions WHERE transType = ? AND MONTH(FROM_UNIXTIME(transDate)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE())");
    $adminmDebitq->execute(array("DR"));
    $adminmDebit = $adminmDebitq->fetch(PDO::FETCH_ASSOC);

    //Add New Account
    if(isset($_POST['addAccount'])){
      $pword = rand(11111,99999);
      $actno = "00115".$pword;
      $adduser = $conn->prepare("INSERT INTO users (acctNo, pword, regtime, designation, status) VALUES (?,?,?,?,?)");
      $adduser->execute(array($actno, md5($pword), time(), "member", "active"));
      $addacct = $conn->prepare("INSERT INTO accounts (acctNo, fname, mname, lname, address, phone, email, cdate, acctStatus) VALUES (?,?,?,?,?,?,?,?,?)");
      $addacct->execute(array($actno, $_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['address'], $_POST['phone'], $_POST['email'], time(), "active"));
      $addbalance = $conn->prepare("INSERT INTO balances (acctNo, acctBalance) VALUES (?,?)");
      $addbalance->execute(array($actno, "0"));

      if($addacct && $adduser && $addbalance){
        $syssuccess = "Member was added successfully password = ".$pword;
      }
    }

    // Quick Credit Account
    if(isset($_POST['acctCreditq'])){
      $acctCreditq = $conn->prepare("INSERT INTO transactions(acctNo,transMedium,transType,transAmount,transDate,transDesc,transStatus) VALUES (?,?,?,?,?,?,?)");
      $acctCreditq->execute(array($_POST['acctNo'],"admin","CR",$_POST['transAmount'],time(),$_POST['transDesc'],"complete"));
      $upBalance = $conn->prepare("UPDATE balances SET acctBalance = acctBalance+? WHERE acctNo = ?");
      $upBalance->execute(array($_POST['transAmount'], $_POST['acctNo']));
      if($acctCreditq && $upBalance){ echo "<script> alert('Account credited successfully'); window.location = 'admin-transact.php'; </script>"; } else { echo "<script>alert('Account credit error');</script>"; }
    }

    // Quick Debit Account
    if(isset($_POST['acctDebitq'])){
      $checkBalq = $conn->prepare("SELECT * FROM balances WHERE acctNo = ?");
      $checkBalq->execute(array($_POST['acctNo']));
      $checkBal = $checkBalq->fetch(PDO::FETCH_ASSOC);
      if($checkBal['acctBalance'] >= $_POST['transAmount']){
        $acctDebitq = $conn->prepare("INSERT INTO transactions(acctNo,transMedium,transType,transAmount,transDate,transDesc,transStatus) VALUES (?,?,?,?,?,?,?)");
        $acctDebitq->execute(array($_POST['acctNo'],"admin","DR",$_POST['transAmount'],time(),$_POST['transDesc'],"complete"));
        $upBalance = $conn->prepare("UPDATE balances SET acctBalance = acctBalance-? WHERE acctNo = ?");
        $upBalance->execute(array($_POST['transAmount'], $_POST['acctNo']));
        if($acctDebitq && $upBalance){ echo "<script> alert('Account debited successfully'); window.location = 'admin-transact.php'; </script>"; } else { echo "<script>alert('Account debit error');</script>"; }
      } else {
        echo "<script> alert('Insufficient funds. Current balance is N".number_format($checkBal['acctBalance'],2)."'); window.location = 'admin-transact.php'; </script>";
      }
    }

    // Switch Transaction Status to Pending
    if(isset($_POST['transPend'])){
      $upTrans = $conn->prepare("UPDATE transactions SET transStatus = ? WHERE transID = ?");
      $upTrans->execute(array("pending", $_POST['transID']));
      if($upTrans){ echo "<script> alert('Update successful'); window.location = 'admin-transactions.php'; </script>";  }
    }

    // Switch Transaction Status to Complete
    if(isset($_POST['transComplete'])){
      $upTrans = $conn->prepare("UPDATE transactions SET transStatus = ? WHERE transID = ?");
      $upTrans->execute(array("complete", $_POST['transID']));
      if($upTrans){ echo "<script> alert('Update successful'); window.location = 'admin-transactions.php'; </script>";  }
    }

    // Add loan Record
    if(isset($_POST['addLoan'])){
      $addLoan = $conn->prepare("INSERT INTO loans (acctNo,loanAmount,loanPurpose,repayRate,loanDuration,interestRate,loanDate,loanStatus) VALUES (?,?,?,?,?,?,?,?)");
      $addLoan->execute(array($_POST['acctNo'],$_POST['loanAmount'],$_POST['loanPurpose'],$_POST['repayRate'],$_POST['loanDuration'],$_POST['interestRate'], time(), "pending"));
      if($addLoan){ echo "<script> alert('Loan application successful'); window.location = 'admin-loans.php'; </script>"; }
    }

    // Accept Loan Request
    if(isset($_POST['loanApprove'])){
      $getLoanDetailq = $conn->prepare("SELECT * FROM loans WHERE loanID = ?");
      $getLoanDetailq->execute(array($_POST['loanID']));
      $getLoanDetail = $getLoanDetailq->fetch(PDO::FETCH_ASSOC);

        $acctCreditq = $conn->prepare("INSERT INTO transactions(acctNo,transMedium,transType,transAmount,transDate,transDesc,transStatus) VALUES (?,?,?,?,?,?,?)");
        $acctCreditq->execute(array($getLoanDetail['acctNo'],"admin","CR",$getLoanDetail['loanAmount'],time(),"Loan Credit","complete"));
        $upBalance = $conn->prepare("UPDATE balances SET acctBalance = acctBalance+? WHERE acctNo = ?");
        $upBalance->execute(array($getLoanDetail['loanAmount'], $getLoanDetail['acctNo']));
        $upLoan = $conn->prepare("UPDATE loans SET loanStatus = ? WHERE loanID = ?");
        $upLoan->execute(array("approved", $_POST['loanID']));
        if($acctCreditq && $upBalance && $upLoan){
          echo "<script> alert('Loan request has been approved and account credited'); window.location = 'admin-loans.php'; </script>";
        }
      }

      // Deny Loan Request
      if(isset($_POST['loanDeny'])){
        $upLoan = $conn->prepare("UPDATE loans SET loanStatus = ? WHERE loanID = ?");
        $upLoan->execute(array("denied", $_POST['loanID']));
        if($upLoan){
          echo "<script> alert('Loan request has been denied'); window.location = 'admin-loans.php'; </script>";
        }
      }

      // Repay Loan Function
      if(isset($_POST['repayLoan'])){
        $getLoanDetailq = $conn->prepare("SELECT * FROM loans a JOIN balances b USING (acctNo) WHERE a.loanID = ?");
        $getLoanDetailq->execute(array($_POST['loanID']));
        $getLoanDetail = $getLoanDetailq->fetch(PDO::FETCH_ASSOC);

        if($_POST['repayMethod'] == "direct" && $getLoanDetail['loanStatus'] == "approved"){
          if($getLoanDetail['acctBalance'] >= $_POST['repayAmount']){
            $acctDebitq = $conn->prepare("INSERT INTO transactions(acctNo,transMedium,transType,transAmount,transDate,transDesc,transStatus) VALUES (?,?,?,?,?,?,?)");
            $acctDebitq->execute(array($getLoanDetail['acctNo'],"admin","DR",$_POST['repayAmount'],time(),"Loan Repayment","complete"));
            $upBalance = $conn->prepare("UPDATE balances SET acctBalance = acctBalance-? WHERE acctNo = ?");
            $upBalance->execute(array($_POST['repayAmount'], $getLoanDetail['acctNo']));
            $addRepay = $conn->prepare("INSERT INTO repayments (acctNo,loanID,repayAmount,repayDate,repayStatus) VALUES (?,?,?,?,?)");
            $addRepay->execute(array($getLoanDetail['acctNo'], $_POST['loanID'], $_POST['repayAmount'], time(), "complete"));
            if($acctDebitq && $upBalance && $addRepay){
              echo "<script> alert('Loan repayment successful'); window.location = 'admin-loans.php'; </script>";
            }
          } else { echo "<script> alert('insufficient funds in the account'); </script>"; }
        } else if($_POST['repayMethod'] == "credit-debit" && $getLoanDetail['loanStatus'] == "approved"){
          $acctCreditq = $conn->prepare("INSERT INTO transactions(acctNo,transMedium,transType,transAmount,transDate,transDesc,transStatus) VALUES (?,?,?,?,?,?,?)");
          $acctCreditq->execute(array($getLoanDetail['acctNo'],"admin","CR",$_POST['repayAmount'],time(),"Credit for Loan Repayment","complete"));
          $acctDebitq = $conn->prepare("INSERT INTO transactions(acctNo,transMedium,transType,transAmount,transDate,transDesc,transStatus) VALUES (?,?,?,?,?,?,?)");
          $acctDebitq->execute(array($getLoanDetail['acctNo'],"admin","DR",$_POST['repayAmount'],time(),"Loan Repayment","complete"));
          $addRepay = $conn->prepare("INSERT INTO repayments (acctNo,loanID,repayAmount,repayDate,repayStatus) VALUES (?,?,?,?,?)");
          $addRepay->execute(array($getLoanDetail['acctNo'], $_POST['loanID'], $_POST['repayAmount'], time(), "complete"));
          if($acctCreditq && $acctDebitq && $addRepay){
            echo "<script> alert('Loan repayment successful'); window.location = 'admin-loans.php'; </script>";
          }
        } else { echo "<script> alert('Loan does not exist or is not approved'); </script>";  }
      }
  }

  // If user is set
  if(isset($_SESSION['ascosUser'])){
    // User Data
    $userDataq = $conn->prepare("SELECT * FROM users a JOIN accounts b USING(acctNo) JOIN balances c USING (acctNo) WHERE a.acctNo = ?");
    $userDataq->execute(array($_SESSION['ascosUser']));
    $userData = $userDataq->fetch(PDO::FETCH_ASSOC);

    // Transaction History for the month
    // Total Credit 
    $getmCreditq = $conn->prepare("SELECT sum(transAmount) as sumCredit FROM transactions WHERE acctNo = ? AND transType = ? AND MONTH(FROM_UNIXTIME(transDate)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE())");
    $getmCreditq->execute(array($_SESSION['ascosUser'], "CR"));
    $getmCredit = $getmCreditq->fetch(PDO::FETCH_ASSOC);

    // Total Debit
    $getmDebitq = $conn->prepare("SELECT sum(transAmount) as sumDebit FROM transactions WHERE acctNo = ? AND transType = ? AND MONTH(FROM_UNIXTIME(transDate)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE())");
    $getmDebitq->execute(array($_SESSION['ascosUser'], "DR"));
    $getmDebit = $getmDebitq->fetch(PDO::FETCH_ASSOC);

    // View Beneficiaries
    $getBenq = $conn->prepare("SELECT * FROM beneficiaries WHERE acctNo = ?");
    $getBenq->execute(array($_SESSION['ascosUser']));
    $getBenct = $getBenq->rowCount();
    $getBenAll = $getBenq->fetchAll();

    //Banks Array
    $banksary = array("Access Bank", "Citibank", "Diamond Bank", "Ecobank Nigeria", "Enterprise Bank Limited", "Fidelity Bank Nigeria", "First Bank of Nigeria", "First City Monument Bank", "Guaranty Trust Bank", "Heritage Bank Plc", "Keystone Bank Limited", "Mainstreet Bank Limited", "Savannah Bank", "Skye Bank", "Stanbic IBTC Bank Nigeria Limited", "Standard Chartered Bank", "Sterling Bank", "Union Bank of Nigeria", "United Bank for Africa", "Unity Bank Plc", "Wema Bank", "Zenith Bank");

    // Add Beneficiary
    if(isset($_POST['addBen'])){
      $addBenq = $conn->prepare("INSERT INTO beneficiaries(acctNo, benAcctName, benAcctNo, benBank, benDate) VALUES (?,?,?,?,?)");
      $addBenq->execute(array($_SESSION['ascosUser'], $_POST['benAcctName'], $_POST['benAcctNo'], $_POST['benBank'], time()));
      if($addBenq){
        echo "<script> alert('Beneficiary added successfully'); window.location = 'myaccount.php'; </script>"; } else { echo "<script>alert('Error adding beneficiary');</script>";
      }
    }

    // User Withdrawal
    if(isset($_POST['transConfirm'])){
      $checkBalq = $conn->prepare("SELECT * FROM balances WHERE acctNo = ?");
      $checkBalq->execute(array($_SESSION['ascosUser']));
      $checkBal = $checkBalq->fetch(PDO::FETCH_ASSOC);
      if($checkBal['acctBalance'] >= $_POST['transAmount']){
        $acctDebitq = $conn->prepare("INSERT INTO transactions(acctNo,transMedium,transType,transAmount,transDate,transDesc,transStatus) VALUES (?,?,?,?,?,?,?)");
        $acctDebitq->execute(array($_SESSION['ascosUser'],"Self service","DR",$_POST['transAmount'],time(),$_POST['transDesc'],"pending"));
        $upBalance = $conn->prepare("UPDATE balances SET acctBalance = acctBalance-? WHERE acctNo = ?");
        $upBalance->execute(array($_POST['transAmount'], $_SESSION['ascosUser']));
        if($acctDebitq && $upBalance){ echo "<script> alert('Account debited successfully'); window.location = 'admin-transact.php'; </script>"; } else { echo "<script>alert('Account debit error');</script>"; }
      } else {
        echo "<script> alert('Insufficient funds. Current balance is N".number_format($checkBal['acctBalance'],2)."'); window.location = 'make-withdrawal.php'; </script>";
      }
    }
  }

  //User and Admin Login
  if(isset($_POST['ulogin'],$_POST['acctno'],$_POST['pword'])){
    $uDataq = $conn->prepare("SELECT * FROM users WHERE acctNo = ? AND pword = ?");
    $uDataq->execute(array($_POST['acctno'],md5($_POST['pword'])));
    $uData = $uDataq->fetch(PDO::FETCH_ASSOC);
    if($uData['status'] !== "" && $uData['status'] == "active"){
      $_SESSION['ascosUser'] = $_POST['acctno'];
      $_SESSION['ascosPriv'] = $uData['designation'];
      if($uData['acctNo'] == "admin"){ header("Location: admin-home.php"); }
      else{ header("Location: home.php"); }
    } else { $sysfailure = "Sorry we did not find an account with those login details."; }
  }

  //User Signout
  if(isset($_GET['logout']) && $_GET['logout'] == "yes"){
    include 'signout.php';
  }
?>
