<?php include "includes/db.php"; ?>
<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);


    if($username !== 'admin' || $password !== 'password'){

       // header("Location: index.php");
       echo '<script language="javascript">';
       echo 'alert("Your username or password is incorrect!")';
       echo '</script>';
  }
   else {
     $_SESSION['logged_in'] = true;
     header("Location: admin.php");
   }

}?>
  <h1 style="text-align: center">Administration area</h1>
       <div id="form">
           <form action = "" method="post">
               <label for="username">Username</label>
               <input type="text" name="username">
               <label for="password">Password</label>
               <input type="password" name="password">
               <input class="link" type="submit" name="submit">

           </form>

      </div>

   </body>

</html>