<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header('Location: index.php');
    exit();
}

include_once 'db.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $fileId = $_GET['id'];
    $action = $_GET['action'];/////////////////action field is required in files table
    //and it should be updated by admin when file is requeted to upload

    if ($action == 'approve')
     {
        // Update approval status to 'approved'
        $sqlUpdate = "UPDATE files SET approval_status = 'approved' WHERE id = $fileId";
        $message = "File approval status updated successfully.";
    } elseif ($action == 'reject') {
        // Update approval status to 'rejected'
            
        
        $sqlUpdate = "UPDATE files SET approval_status = 'rejected' WHERE id = $fileId";
        $message = "File has rejected and deleted";
        

        if (isset($_GET['id'])) {
            $fileId = $_GET['id'];
            
            $sql = "SELECT * FROM files WHERE id = $fileId";
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            $filePath = $row['file_path'];
        
                // Delete record from the database
                $sqlDelete = "DELETE FROM files WHERE id = $fileId";
                if ($conn->query($sqlDelete) === TRUE) {
                    // Delete the file from the server
                    unlink($filePath);
                } else {
                    echo "Error deleting file: " . $conn->error;
                }



            }
        }
    } else {
        echo "Invalid action.";
        exit();
    }

    if ($conn->query($sqlUpdate) === TRUE) {
        echo $message;
    } else {
        echo "Error updating file approval status: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
