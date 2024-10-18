<?php
session_start();

if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'admin' && $_SESSION['user_type'] != 'user')) {
    header('Location: index.php');
    exit();
}

include_once 'db.php';

$isAdmin = ($_SESSION['user_type'] == 'admin');

$targetDirectory = "uploads/";
$targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($targetFile)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["file"]["size"] > 12400000) {
    echo "Sorry, your file is larger than 100mb.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "txt" && $imageFileType != "ppt"
    && $imageFileType != "docx") {
    echo "Sorry, only JPG, JPEG, PNG, GIF, and PDF files are allowed.";
    $uploadOk = 0;
}

// ...

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        $fileName = basename($_FILES["file"]["name"]);
        $filePath = $targetFile;

        // Insert the file with a pending status
        if(!$isAdmin)
        {
        $sql = "INSERT INTO files (file_name, file_path, uploaded_by,approval_status) VALUES ('$fileName', '$filePath','$_SESSION[user_name]', 'pending')";
        if ($conn->query($sql) === TRUE) {
            echo "The file has been uploaded and is pending approval from the admin.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        }

        else{
            $sql = "INSERT INTO files (file_name, file_path, uploaded_by,approval_status,user_type) VALUES ('$fileName', '$filePath','$_SESSION[user_name]', 'approved','$_SESSION[user_type]')";
        if ($conn->query($sql) === TRUE) {
            echo "The file has been uploaded";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// ...


$conn->close();
?>
