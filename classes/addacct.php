<?php include('classes/alert.php'); ?>

<form method="post" action="" name="add-account">
  <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> ADD NEW ACCOUNT </div>
  <div style="color:#333; border:#333 thin solid; padding:10px">
    <div class="row" align="center">
      <div class="col-sm-4"> First Name: <br /><input type="text" name="fname" class="form-control" required="" placeholder="Enter your first name" /> </div>
      <div class="col-sm-4"> Middle Name: <br /><input type="text" name="mname" class="form-control" required="" placeholder="Enter your middle name" /> </div>
      <div class="col-sm-4"> Last Name: <br /><input type="text" name="lname" class="form-control" required="" placeholder="Enter your last name" /> </div>
    </div>
    <div class="row" align="center" style="margin-top:20px">
      <div class="col-sm-4"> Address: <br /><input type="text" name="address" class="form-control" required="" placeholder="Enter your address" /> </div>
      <div class="col-sm-4"> Phone No: <br /><input type="number" name="phone" class="form-control" required="" placeholder="Enter your phone no." /> </div>
      <div class="col-sm-4"> Email: <br /><input type="email" name="email" class="form-control" required="" placeholder="Enter your email" style="border-radius:5px !important" /> </div>
    </div>
    <div class="row" style="margin-top:20px">
      <div class="col-sm-12" align="center"> <input type="submit" name="addAccount" value="Add Account" class="btn btn-primary" /> </div>
    </div>
  </div>
</form>
