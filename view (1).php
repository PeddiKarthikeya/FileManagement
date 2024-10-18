<?php
include_once 'db.php';

// ...
if($_SESSION['user_type']=='user')
$sql = "SELECT * FROM files WHERE (approval_status = 'approved' OR approval_status = 'pending') AND (uploaded_by = '$_SESSION[user_name]' or user_type='admin')  ORDER BY uploaded_at DESC";
else
$sql = "SELECT * FROM files WHERE approval_status = 'approved'  ORDER BY uploaded_at DESC";
// ...

$result = $conn->query($sql);

function getSortFiles($conn, $sortBy, $sortOrder) {
    if($_SESSION['user_type']=='user')
    $sqli = "SELECT * FROM files WHERE (approval_status = 'approved' OR approval_status = 'pending') AND (uploaded_by = '$_SESSION[user_name]' or user_type='admin') ORDER BY $sortBy $sortOrder";
    else
    $sqli = "SELECT * FROM files WHERE approval_status = 'approved' ORDER BY  $sortBy $sortOrder";
    $result = $conn->query($sqli);

    $files = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $files[] = $row;
        }
    }

    return $files;
}

// Determine the sorting criteria
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'file_name';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

$newSortOrder = ($sortOrder === 'ASC') ? 'desc' : 'asc';
// Get sorted files based on the chosen criteria
$sortedFiles = getSortFiles($conn, $sortBy, $sortOrder);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <style>
         th, td {
    padding: 10px;
    text-align: center;
        }
        
        table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
  }
table, th, td {
  border:1px solid black;
  color: #333;
  
}
th{
    background-color: #007bff;
    color:white;
}
 
th.sortable {
            cursor: pointer;
            
            color: #007bff;
        }

th.sortable:hover {
            text-decoration: none;
            color: #0056b3;
        }
        </style>
</head>
<body>

<table>
        <tr >
        <th class="sortable"><a href="?sort=file_name&order=<?php echo $newSortOrder; ?>"style="color: white;">File Name</a></th>
            <th>Delete Option</th>
            <th class="sortable"><a href="?sort=uploaded_by&order=<?php echo $newSortOrder; ?>"style="color: white;" >Uploaded_by</a></th>
            <th class="sortable"><a href="?sort=uploaded_at&order=<?php echo $newSortOrder; ?>"style="color: white;" >Uploaded_time</a></th>
            <th>Download</th>
    </tr>
        <?php
if ($result->num_rows > 0) {
    foreach ($sortedFiles as $row) {
        
        echo '<tr>';
        echo '<td><a href="' . $row['file_path'] . '" target="_blank">' . $row['file_name'] . '</a>';
        if ($_SESSION['user_type'] == 'admin' || ($_SESSION['user_type'] == 'user' )){//&& $row['uploaded_by'] == $_SESSION['user_name'])) {
            echo ' <td>- <a href="#" onclick="confirmDelete(' . $row['id'] . ')">Delete</a>';
        }
        echo  '<td>'.$row['uploaded_by'];
        echo  '<td>'.$row['uploaded_at'];
        echo '<td><a href="' .$row['file_path']. '" download="' .$row['file_name']. '">Download File</a>';
        echo '</tr>';
    }
} else {
    echo "No files uploaded yet.";
}

$conn->close();
?>

<script>
function confirmDelete(fileId) {
    var confirmDelete = confirm("Are you sure you want to delete this file?");

    if (confirmDelete) {
        // If the user clicks "OK" in the confirmation dialog, redirect to the delete.php with the fileId
        window.location.href = 'delete.php?id=' + fileId;
    } else {
        // If the user clicks "Cancel" in the confirmation dialog, do nothing
    }
}
</script>
