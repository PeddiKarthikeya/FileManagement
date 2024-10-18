<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_POST['file_name']; // Retrieve the file name from the form
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    // Set appropriate headers
    header('Content-Description: File Transfer');
    if ($imageFileType == ("jpeg" || "jpg"))
    header('Content-Type: application/jpeg');
    else if ($imageFileType == "pdf")
    header('Content-Type: application/pdf');
    else if ($imageFileType == "gif")
    header('Content-Type: application/gif');
    else if ($imageFileType == "png")
    header('Content-Type: application/png');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    // Output the file
    readfile($file);
    exit;
} else {
    echo 'Download not allowed.';
}
?>
