<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Folders</title>
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
      width:100%;
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
  
  table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
  }
  
  th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
  }
  
  th {
      background-color: #007bff;
      color: #fff;
  }
  a.folder-link {
    display: inline-block;
    background-color: #f0f0f0; /* Background color of the folder */
    padding: 10px 15px; /* Adjust padding as needed */
    border: 1px solid #ccc; /* Border color */
    border-radius: 5px; /* Rounded corners */
    text-decoration: none; /* Remove default underline */
    color: #333; /* Text color */
    font-weight: bold;
}

a.folder-link:hover {
    background-color: #e0e0e0; /* Background color on hover */
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
      border: 5;
      height: 1px;
      background-color: #ccc;
  }
table, th, td {
  border:1px solid black;
}


th.sortable {
            cursor: pointer;
            text-decoration: underline;
            color: #007bff;
        }

th.sortable:hover {
            text-decoration: none;
            color: #0056b3;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h2>Welcome, <?php echo $_SESSION['user_name']; ?> (Admin)!</h2><!--admin_name-->
    <!--<a href="index.php">Go to File Upload</a>-->
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select File to Upload:
        <input type="file" name="file" id="file">
        <input type="submit" value="Upload File" name="submit">
    </form>
    <a href="admin_pagewel.php" class="btn" style="float:left">Back</a>
    <a href="logout.php" class="btn" style="text-align: right;">logout</a>


    <br><br>
<h2>User Folders</h2>
<ul>
    <?php
    include_once 'db.php';

    // Get distinct user names
    $userSql = "SELECT DISTINCT name FROM user_form ORDER BY name ASC";
    $userResult = $conn->query($userSql);

    $users = [];
    if ($userResult->num_rows > 0) {
        while ($userRow = $userResult->fetch_assoc()) {
            $users[] = $userRow['name'];
        }
    }

    foreach ($users as $user) :?>
        <li><a href="adminuser_files.php?user=<?php echo urlencode($user); ?>" class="folder-link"><?php echo $user; ?></a></li>
    <?php endforeach; ?>
</ul>

</body>
</html>
