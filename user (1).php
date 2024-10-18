<?php
session_start();

if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'admin' && $_SESSION['user_type'] != 'user')) {
    header('Location: index.php');
    exit();
}

$isAdmin = ($_SESSION['user_type'] == 'admin');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>

    <style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 20px;
    background-color: #f4f4f4;
    color: #333;
}

h2 {
    color: #007bff;
    margin-bottom: 15px;
}

form {
    margin-top: 20px;
    border: 2px solid #ccc;
    padding: 20px;
    border-radius: 8px;
    background-color: #fff;
}

input[type="file"] {
    margin-top: 10px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.btn {
    display: inline-block;
      padding: 10px 15px;
      background-color: tomato;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      float:right;
      margin-top:10px;
      margin-right: 10px;
      margin-bottom: 10px;
      transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

a {
      text-decoration: none;
      color: #007bff;
  }
  
  a:hover {
      text-decoration: underline;
      color: #0056b3;
  }

hr {
    margin-top: 20px;
    border: 0;
    height: 1px;
    background-color: #ccc;
}

        </style>
</head>
<body> 

    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select File to Upload:
        <input type="file" name="file" id="file">
        <input type="submit" value="Upload File" name="submit">
    </form>
    <a href="userwel.php" class="btn" style="float:left">Back</a>
    <a href="logout.php" class="btn" style="text-align: right;">logout</a>
    <br><br>
    <hr>
    <h2>Uploaded Files</h2>
    <?php
        include_once 'view.php';
    ?>
</body>
</html>
