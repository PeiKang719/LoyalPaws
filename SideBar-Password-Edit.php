<?php

include('Connection.php');
$id=$_POST['id'];
$old=MD5($_POST['old']);
$new1=$_POST['new1'];
$new2=$_POST['new2'];

if($new1==$new2){
    $sql = "SELECT password from admin WHERE adminID='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $oldpassword=$row["password"];
        }
        if($old==$oldpassword){
            $new1=MD5($_POST['new1']);
            $sql2 = "UPDATE admin SET password='$new1' WHERE adminID='$id'";
            $result2 = mysqli_query($conn, $sql2);
            if ($conn->query($sql2) === TRUE) {
                echo '<script type="text/javascript">';
                echo 'alert("Your password has been updated successfully.");';
                echo "window.parent.location.href = 'SideBar-Password.php?id=$id';";

                echo '</script>';
            }
             else { 
                echo '<script type="text/javascript">';
                echo 'alert("Failed to update password. Please try again.");';
                echo "window.parent.location.href = 'SideBar-Password.php?id=$id';";
                echo '</script>';
            }
        }
        else{
        echo '<script type="text/javascript">';
        echo 'alert("The old password entered is incorrect. Please verify and try again.");';
        echo "window.parent.location.href = 'SideBar-Password.php?id=$id';";

        echo '</script>';
        }
    }
    else{
        echo '<script type="text/javascript">';
        echo 'alert("Cannot find admin information");';
        echo '</script>';
    }
}
else{
    echo '<script type="text/javascript">';
    echo 'alert("The new passwords entered do not match. Please make sure you enter the same password in both fields.");';
    echo "window.parent.location.href = 'SideBar-Password.php?id=$id';";
    echo '</script>';
}


$conn->close();

?>