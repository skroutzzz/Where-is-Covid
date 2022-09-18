<?php
 
 session_start();
 include "config.php";
 $tmp_new_username_err =  $empty_pass = $new_confirm_password_err ="";
 $new_password_err ="1";
 if(isset($_POST['edit_button']))
 {
    $id=$_SESSION['id'];
    $tmp_new_username=$_POST['username'];
    $tmp_new_password=$_POST['password'];
    $confirm_new_password=$_POST['confirm_password'];
    
    // Validate username 
        if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($tmp_new_username))){
            $tmp_new_username_err = "Username can only contain letters, numbers, and underscores.";
        }
         else{ 
            $sql = "SELECT user_id FROM myUSERS WHERE user_username = '$tmp_new_username'";

            if($stmt = mysqli_prepare($link, $sql)){
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $tmp_new_username_err = "This username is already taken.";
                    } else{
                        $tmp_new_username = trim($_POST["username"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later. 2";
                }
                echo $tmp_new_username_err;
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
        //Validate
        if(empty(trim($tmp_new_password))){
            $empty_pass = "";     
        } 
           elseif(strlen(trim($tmp_new_password)) < 8 ){
                $new_password_err = "Password must have at least 8 characters";
                echo $new_password_err;
       }
           elseif(!preg_match("#[a-z]+#",$tmp_new_password)){
               $new_password_err = "Password should include at least one low letter";
               echo $new_password_err;
       } 
           elseif(!preg_match("#[A-Z]+#",$tmp_new_password)){
               $new_password_err = "Password should include at least one upper letter";
               echo $new_password_err;
       }
           elseif(!preg_match("#[0-9]+#",$tmp_new_password)){
               $new_password_err = "Password should include at least one number";
               echo $new_password_err;
       }
           elseif(!preg_match('@[#$*&!]@', $tmp_new_password)){
               $new_password_err = "Password should include at least one special character";
               echo $new_password_err;
       }
       else{
            $password = trim($tmp_new_password);
        }
       
       // Validate confirm password
       if(empty(trim($new_confirm_password_err)) && empty($empty_pass) ){
           $new_confirm_password_err = "";     
       } else{
           $new_confirm_password_err = $tmp_new_password;
           if( $password != $new_confirm_password_err){
               $new_confirm_password_err = "Password did not match.";
               echo $new_confirm_password_err;
           }
       }

    $select= "SELECT * from myusers where user_id='$id'";
    $sql = mysqli_query($link,$select);
    $row = mysqli_fetch_assoc($sql);
    $res= $row['user_id'];

    if($res == $id && empty($tmp_new_username_err) && empty($new_password_err) && empty($new_confirm_password_err))
    {
        $update = "UPDATE myusers set user_username='$tmp_new_username', user_password='$tmp_new_password' where user_id='$id'";
        $sql3=mysqli_query($link,$update);
     if($sql3)
        { 
            /*Successful*/
            echo 'success change both ';
           // header('location:Dashboard.php');
           //mysqli_stmt_close($sql3);
        }
        else
        {
            /*sorry your profile is not update*/
            echo '2';
            //header('location:Profile_edit_form.php');
           // mysqli_stmt_close($sql3);
        }
    }
    
    elseif($res == $id && empty($tmp_new_username_err) && empty($empty_pass))
    {
       $update = "UPDATE myusers set user_username='$tmp_new_username' where user_id='$id'";
       $sql2=mysqli_query($link,$update);
    if($sql2)
       { 
           /*Successful*/
           echo 'success change only name';
          // header('location:Dashboard.php');
         // mysqli_stmt_close($sql2);

       }
       else
       {
           /*sorry your profile is not update*/
           echo '2';
           //header('location:Profile_edit_form.php');
          // mysqli_stmt_close($sql2);
       }
    } 
        
    elseif($res == $id  && empty($new_password_err) && !empty($empty_pass))
    {
        $update = "UPDATE myusers set  user_password='$tmp_new_password' where user_id='$id'";
        $sql4=mysqli_query($link,$update);
     if($sql4)
        { 
            /*Successful*/
            echo 'success change pass';
           // header('location:Dashboard.php');
           //mysqli_stmt_close($sql4);
        }
        else
        {
            /*sorry your profile is not update*/
            echo '2';
            //header('location:Profile_edit_form.php');
           // mysqli_stmt_close($sql4);
        }
    }
    else
    {
        /*sorry your id is not match*/
        echo 'I didnt update my DB';
        //header('location:Profile_edit_form.php');
    }
 }
?>