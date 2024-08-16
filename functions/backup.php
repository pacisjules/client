<?php

require_once 'connection.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function transferInventoryToHistory($conn) {
    // Fetch data from inventory table (without id and last_updated)
    $sqlFetch = "SELECT `product_id`, `quantity`, `alert_quantity`, `company_ID`, `spt_id` FROM `inventory`";
    $result = $conn->query($sqlFetch);

    // Check if there is data to insert
    if ($result->num_rows > 0) {
        // Loop through each record
        while($row = $result->fetch_assoc()) {
            // Prepare insert statement for inventoryhistory table
            $sqlInsert = "INSERT INTO `inventoryhistory` (`product_id`, `quantity`, `alert_quantity`, `company_ID`, `spt_id`) 
                          VALUES (?, ?, ?, ?, ?)";
            
            // Prepare and bind the parameters
            $stmt = $conn->prepare($sqlInsert);
            $stmt->bind_param("iiiii", 
                $row['product_id'], 
                $row['quantity'], 
                $row['alert_quantity'], 
                $row['company_ID'], 
                $row['spt_id']
            );

            // Execute the statement
            if ($stmt->execute()) {
                echo "Record transferred successfully for product ID: " . $row['product_id'] . "<br>";
            } else {
                echo "Error: " . $stmt->error . "<br>";
            }

            // Close statement after each execution
            $stmt->close();
        }
    } else {
        echo "No records found in the inventory table.";
    }

    // Close connection
    $conn->close();
}

// Call the function to transfer data
transferInventoryToHistory($conn);
?>
