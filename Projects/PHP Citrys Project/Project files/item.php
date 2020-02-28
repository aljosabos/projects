<?php include "includes/db.php"?>

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
    <div class="container">
        <div class="item-description">

        <?php
         
          if(isset($_GET['id'])){
              $id = $_GET['id'];

              $query = "SELECT * FROM items WHERE item_id = {$id}";
              $select_item = mysqli_query($connection, $query);

              while($row = mysqli_fetch_assoc($select_item)){
                $title = $row['item_title'];
                $desc = $row['item_desc'];
                $img = $row['item_img'];
                
                echo "<h2>{$title}</h2>
                <img src='img/{$img}'>
                <p>{$desc}</p>";   
               } 
            }?>

<a style="margin-left: 7rem" href="index.php">Go to the main page</a>
      
<div class="comments">
   
            <!-- displaying comments -->
    <?php
        $id =  $_GET['id'];
        $query = "SELECT * FROM comments WHERE comment_item_id = {$id} AND comment_status = 'approved' ORDER BY comment_id DESC ";
        $select_comment_query = mysqli_query($connection, $query);
           if(!$select_comment_query){
            die('Query Failed' . mysqli_error($connection));
          }

        while($row = mysqli_fetch_array($select_comment_query)){
            $comment_title = $row['comment_title'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_date = $row['comment_date'];
        
            echo "
             <div class='comment'>
             <h3>{$comment_title}</h3>
             <em>Posted by ${comment_email} at {$comment_date}</em>
             <p>${comment_content}</p>
            </div>";
          } ?>
               
            <!-- Comments Form  -->
                
                <div class="form">
                    <form action="" method="POST">
                        <label for="title">Title</label>
                        <input type="text" name="comment_title" id="title">
                        <label for="email">Email</label>
                        <input type="email" name="comment_email" id="email">
                        <label for="content">Write Comment</label>
                        <textarea name="comment_content" id="content" cols="70" rows="10"></textarea>
                        <button type="submit" name="create_comment">Add Comment</button>
                    </form>

                    <?php
                     if(isset($_POST['create_comment'])){
                        $id = $_GET['id'];
                     $comment_title = $_POST['comment_title'];
                     $comment_email = $_POST['comment_email'];
                     $comment_content = $_POST['comment_content'];

                     $query = "INSERT INTO comments (comment_item_id, comment_title, comment_email, comment_content, comment_date, comment_status)";

                     $query .= " VALUES ($id, '{$comment_title}', '{$comment_email}', '{$comment_content}', now(), 'unapproved') ";

                     $create_comment_query = mysqli_query($connection, $query);

                     if(!$create_comment_query){
                         die("Query failed" . mysqli_error($connection));
                        }
                    
                     } ?>  

                </div>
            </div>

        </div>

    </div>


</body>

</html>