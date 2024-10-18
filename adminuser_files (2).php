<!-- Add your JavaScript for sorting if needed -->
<?php
include_once 'db.php'; 

//$user = (urldecode($_GET['user']))=="Undefined array key"? "":urldecode($_GET['user']);
function getSortedFiles($conn, $sortBy, $sortOrder) {
    $user = (urldecode($_GET['user']));
    $sql = "SELECT * FROM files WHERE uploaded_by='$user' ORDER BY $sortBy $sortOrder";
    $result = $conn->query($sql);

    $files = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $files[] = $row;
        }
    }

    return array($files,$user);
}

// Determine the sorting criteria
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'file_name';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';
$newSortOrder = ($sortOrder === 'ASC') ? 'desc' : 'asc';
// Get sorted files based on the chosen criteria
list($sortedFiles,$user) = getSortedFiles($conn, $sortBy, $sortOrder);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Files - <?php echo $user; ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        h3 {
            color: #007bff;
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

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>
<a href="admin_page.php" class="btn" style="float:left;">Back</a>
<a href="logout.php" class="btn" >logout</a>

    <br><br><br><br>
<h2>User Files </h2>

<table>
    <!-- Add your table header -->
    <tr>
        <th class="sortable"><a href="?sort=file_name&order=<?php echo $newSortOrder; ?>&user=<?php echo urlencode($user); ?>" style="color: white;">File Name</a></th>
            <th class="sortable"><a href="?sort=file_path&order=<?php echo $newSortOrder; ?>&user=<?php echo urlencode($user); ?>" style="color: white;">File</a></th>
            <th >Uploaded_by</th>
            <th class="sortable"><a href="?sort=uploaded_at&order=<?php echo $newSortOrder; ?>&user=<?php echo urlencode($user); ?>" style="color: white;">Uploaded_time</a></th>
            <th>Actions</th>
            <th>Download</th>
            <th class="sortable"><a href="?sort=approval_status&order=<?php echo $newSortOrder; ?>&user=<?php echo urlencode($user); ?>" style="color: white;">FileSituation</a></th>

        </tr>
    <?php
    
    // Retrieve pending files for approval
    $user = urldecode($_GET['user']); 
    $sqlPending = "SELECT * FROM files WHERE uploaded_by='$user'";
    $resultPending = $conn->query($sqlPending);
    if ($resultPending->num_rows > 0) {
        foreach ($sortedFiles as $row) {
            echo '<tr>';
            // Add your table cells for each file
            echo '<td>' . $row['file_name'] . '</td>';
            echo '<td><a href="' . $row['file_path'] . '"  target="_blank">file</a></td>';
            echo '<td>' . $row['uploaded_by'] . '</td>';
            echo '<td>' . $row['uploaded_at'] . '</td>';
           if($row['approval_status']=="pending")
            echo '<td><a href="admin_approve.php?id=' . $row['id'] . '&action=approve">Approve</a> | <a href="admin_approve.php?id=' . $row['id'] . '&action=reject">Reject</a></td>';
            else
            echo '<td><a href="admin_approve.php?id=' . $row['id'] . '&action=reject">Delete</a></td>';
            echo '<td><a href="' .$row['file_path']. '" download="' .$row['file_name']. '">Download File</a></td>';
            echo '<td>' . $row['approval_status'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo "<tr><td colspan='5'>No files uploaded yet for $user.</td></tr>";
    }

    $conn->close();
    ?>
</table>


</body>
</html>
