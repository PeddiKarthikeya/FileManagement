<?php
session_start();

if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'admin' && $_SESSION['user_type'] != 'user')) {
    header('Location: index.php');
    exit();
}

include_once 'db.php';

if (isset($_GET['id'])) {
    $fileId = $_GET['id'];
    
    $sql = "SELECT * FROM files WHERE id = $fileId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the user has permission to delete the file
      // ...

if ($_SESSION['user_type'] == 'admin' || ($_SESSION['user_type'] == 'user' && $row['uploaded_by'] == $_SESSION['user_name'])) {

    // Check if the file is pending approval
     
        $filePath = $row['file_path'];

        // Delete record from the database
        $sqlDelete = "DELETE FROM files WHERE id = $fileId";
        if ($conn->query($sqlDelete) === TRUE) {
            // Delete the file from the server
            unlink($filePath);
            echo "File deleted successfully.";
        } else {
            echo "Error deleting file: " . $conn->error;
        }
    
} else {
    echo "You don't have permission to delete this file.";
}

// ...


    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
