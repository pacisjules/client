<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'croppedImage' key exists in the $_FILES array
    if (isset($_FILES['croppedImage'])) {
        // Handle file upload
        $uploadedFile = $_FILES['croppedImage'];

        // Your upload directory path
        $uploadDirectory = 'uploads/';

        // Check if the directory exists, if not, create it
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        // Generate a unique name for the file
        $fileName = uniqid() . '_' . $uploadedFile['name'];

        // Move the file to the upload directory
        move_uploaded_file($uploadedFile['tmp_name'], $uploadDirectory . $fileName);

        // Respond with the file name (you can store this in the database)
        echo $fileName;
    } else {
        // If 'croppedImage' key is not set, respond with an error message
        echo "Error: 'croppedImage' key is not set in the POST request.";
    }
} else {
    // If the request method is not POST, respond with an error message
    echo "Error: Invalid request method.";
}
?>
