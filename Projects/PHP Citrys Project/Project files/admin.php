<?php include "includes/db.php"?>
<?php session_start(); ?>

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

 if(isset($_SESSION['logged_in'])){

  // checking if there is any comments in database
  $query = "SELECT * FROM comments ";
  $check_query = mysqli_query($connection, $query);
  if(mysqli_num_rows($check_query) > 0){

?>
   <h1 style="margin: 1rem;">Item comments</h1>
    <table>
      <tr>
        <th>Comment title</th>
        <th>Comment email</th>
        <th>Comment content</th>
        <th>In relation to</th>
        <th>Comment date</th>
        <th>Comment status</th>
        <th>Approve</th>
        <th>Unapprove</th>
        <th>Delete</th>
     </tr>

    <?php

      $query = "SELECT * FROM comments";
      $display_comments = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($display_comments)){
         $comment_id = $row['comment_id'];
         $item_id = $row['comment_item_id'];
         $comment_title = $row['comment_title'];
         $comment_email = $row['comment_email'];
         $comment_content = $row['comment_content'];
         $comment_date = $row['comment_date'];
         $comment_status = $row['comment_status'];
   
    echo "
        <tr>
           <td>{$comment_title}</td>
           <td>{$comment_email}</td>
           <td>{$comment_content}</td>";
    
         // relating comments to items
           $query = "SELECT * FROM items WHERE item_id = {$item_id} ";
           $select_post_id_query = mysqli_query($connection, $query);
           
           while($row = mysqli_fetch_assoc($select_post_id_query)){
               $item_id = $row['item_id'];
               $item_title = $row['item_title'];

               echo "<td><a href='item.php?id={$item_id}'>$item_title</a></td>";
            }

              echo "   
                    <td>{$comment_date}</td>
                    <td>{$comment_status}</td>
                    <td><a href='admin.php?approve={$comment_id}'>Approve</a></td>
                    <td><a href='admin.php?unapprove={$comment_id}'>Unapprove</a></td>";
    
               echo "<td><a href='admin.php?delete={$comment_id}'>Delete</td>";
          
               // deleting comments query

  
                 if(isset($_GET['delete'])){

                  $the_comment_id = $_GET['delete'];
                  $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
                  $delete_query = mysqli_query($connection, $query);
                  header("Location: admin.php");  
  
                 }

           }

  } else {

    echo "<h1> There are no comments!</h1>";
  }

 
    if(isset($_GET['approve'])){
      
      $comment_id = $_GET['approve'];
    
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $comment_id ";
    $approve_comment = mysqli_query($connection, $query);
    if(!$approve_comment){
      die("Status cannot be updated");
    }

    header("Location: admin.php");


  }

    if(isset($_GET['unapprove'])){
      
      $comment_id = $_GET['unapprove'];
    
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $comment_id ";
    $unapprove_comment = mysqli_query($connection, $query);
    if(!$unapprove_comment){
      die("Status cannot be updated");
    }
    header("Location: admin.php");

  }?>
        </tr>
 </table>
<form method="post">
<input type="submit" name="logout" value="logout">
</form>
<a href="index.php">Go back to home page</a>
<?php
  if(isset($_POST['logout'])){
    $_SESSION['logged_in'] = null;
     header("Location:index.php");
  }

}
else { ?>

  <h1>You dont have permission to visit this page! </h1>
  <a href="login.php">Go back to login page</a>
 
<?php } ?>

   </body>

</html>