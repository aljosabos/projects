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
   <?php
        $query = "SELECT * FROM items";
        $select_all_items_query = mysqli_query($connection, $query);


        while($row = mysqli_fetch_assoc($select_all_items_query)){
            $title = $row['item_title'];
            $desc = $row['item_desc'];
            $img = $row['item_img'];
            $id = $row['item_id'];

            echo "<div class='item'>
            <img src='img/{$img}'> 
            <h3>{$title}</h3>
            <p>{$desc}</p>
            <form action='item.php?id={$id}' method='post'>
            <button type='submit' name='button'>See More</button>
            </form>
        </div>";   
           } 

        $num = mysqli_num_rows($select_all_items_query);
        if($num > 3 || $num > 6 || $num > 12){
            echo "<div class='break'></div>";
          }?>
    </div>

    <a class="link" href="login.php">Login as admin</a>

</body>

</html>