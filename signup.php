<?php
require_once "connection.php";

$fullname = $contact = $address = $email = $password = $conf_password = "";
$fullname_err = $contact_err = $address_err = $email_err = $password_err = $conf_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){


  //name
  if(empty(trim($_POST["fullname"]))){
    $fullname_err = "name cannot be blank";
}
  else{
    $sql = "SELECT id FROM users WHERE fullname = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if($stmt)
    {
        mysqli_stmt_bind_param($stmt, "s", $param_fullname);

        // Set the value of param username
        $param_fullname = trim($_POST['fullname']);

        // Try to execute this statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1)
            {
                $fullname_err = "This person exist.."; 
            }
            else{
                $fullname = trim($_POST['fullname']);
            }
        }
        else{
            echo "Something went wrong";
        }
    }
}
//contact
if(empty(trim($_POST["contact"]))){
  $contact_err = "contact cannot be blank";
}
else{
  $sql = "SELECT id FROM users WHERE contact = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if($stmt)
  {
      mysqli_stmt_bind_param($stmt, "s", $param_contact);

      // Set the value of param username
      $param_contact = trim($_POST['contact']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1)
          {
              $contact_err = "This contact exist.."; 
          }
          else{
              $contact = trim($_POST['contact']);
          }
      }
      else{
          echo "Something went wrong";
      }
  }
}


//address
if(empty(trim($_POST["address"]))){
  $address_err = "address cannot be blank";
}
else{
  $sql = "SELECT id FROM users WHERE address = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if($stmt)
  {
      mysqli_stmt_bind_param($stmt, "s", $param_address);

      // Set the value of param username
      $param_address = trim($_POST['address']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1)
          {
              $address_err = "This address exist.."; 
          }
          else{
              $address = trim($_POST['address']);
          }
      }
      else{
          echo "Something went wrong";
      }
  }
}


//email

    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "email cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set the value of param username
            $param_email= trim($_POST['email']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $email_err = "This email is already taken"; 
                    array_push($email_err, "E-mail already exists");
                    echo "<div class='container'><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>E-mail</strong> already exists! Try other E-mail.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                      <span aria-hidden='true'>&times;</span>
                    </button>
                  </div></div>";
                }
                else{
                    $email = trim($_POST['email']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

  


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

//conf_password

if(empty(trim($_POST['conf_password']))){
  $conf_password_err = "conf_Password cannot be blank";
}
elseif(strlen(trim($_POST['conf_password'])) < 5){
  $conf_password_err = "conf_Password cannot be less than 5 characters";
}
else{
  $conf_password = trim($_POST['conf_password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['conf_password'])){
    $password_err = "Passwords should match";
    die('Password and Confirm password should match!');
}


// If there were no errors, go ahead and insert into the database
if(empty($email_err) && empty($password_err) && empty($conf_password_err))
{
    $sql = "INSERT INTO users (fullname,contact,address,email,password,conf_password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ssssss", $param_fullname, $param_contact, $param_address, $param_email, $param_password, $param_conf_password);

        // Set these parameters
        $param_fullname = $fullname;
        $param_contact =  $contact;
        $param_address =  $address;
        $param_email   =  $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_conf_password = password_hash($conf_password, PASSWORD_DEFAULT);
       


        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="newsignup.css">
    <title>Amigoes</title>
  </head>
  <body>
 
  
    

    
<div class="container mt-4">
<h1 style="color:rgb(241, 181, 13)">Please Register Here</h1>



     
  
<form action="" method="post">
  <div class="form-group">
    <label for="fullname">Name</label>
    <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Enter Your Name" style="width:400px;" required>
  </div>
  <div class="form-group">
    <label for="contact">Contact No</label>
    <input type="text" name="contact" class="form-control" id="contact" placeholder="Enter Your Contact no" style="width:400px;" required>
  </div>
  <div class="form-group">
    <label for="address">Address</label>
    <input type="text" name="address" class="form-control" id="address" placeholder="Enter Your address" style="width:400px;" required>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" name="email" class="form-control" id="email" placeholder="abc@someting.com" style="width:400px;" required>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" style="width:400px;" required>
  </div>
  <div class="form-group">
    <label for="conf_password">Confirm Password</label>
    <input type="password" name="conf_password" class="form-control" id="conf_password" placeholder="Re-enter your password" style="width:400px;" required>
  </div>
 
   
  
  <button type="submit" class="btn btn-warning">Register</button>
  
       
</form>

</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
