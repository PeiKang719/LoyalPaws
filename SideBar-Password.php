<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
  <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="AdminStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style type="text/css">
  body{
    overflow-y: hidden;
    background-color: white;
  }
  input{
    width: 93%;
    margin-top: 15px;
    background-color: whitesmoke;
  }
  .submit-button{
    background-color: #29a329;
    width: 40%;
    height: 50px;
    font-size: 25px;
    border-radius: 15px;
    border: 0;
    color: white;
    box-shadow: 0 0px 8px 0 rgba(0,0,0,0.2);
    margin-left: 1%;
    margin-right: 1%;
    cursor: pointer;
  }
</style>
</head>
<body>
  <?php include'AdminHeader.php'; ?>
  <div class="content" style="display: flex;justify-content: center;font-size: 27px;">
    <iframe name="hiddenFrame" class="hide"></iframe>
    <form class="passwordForm" id="passwordForm" action="SideBar-Password-Edit.php" method="post" target="hiddenFrame" enctype="multipart/form-data" style="margin-top:100px;width:50%">
      <input type="hidden" name="id" value="<?php echo $adminID ?>">
      <table border="0">
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">key</span></td>
          <td  style="width: 36%;"><label>Current Password</label></td>
          <td>:</td>
          <td style="width:55%"><input type="password" oninput="this.className = ''" name="old" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">lock</span></td>
          <td><label>New Password</label></td>
          <td>:</td>
          <td><input type="password" oninput="this.className = ''" name="new1" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">lock</span></td>
          <td><label>Confirm Password</label></td>
          <td>:</td>
          <td><input type="password" oninput="this.className = ''" name="new2" required></td>
        </tr>
      </table>
      <br>
      <div class="submit-button-container" style="display: flex;align-items: center;justify-content: center;">
      <button class="submit-button" id="submitbtn1" type="submit">Submit</button>
    </div>
    </form>
  </div>
</body>
</html>