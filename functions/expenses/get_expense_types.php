<?php
// Include the database connection file
require_once '../connection.php';

// Retrieve the salepoint_id from POST or wherever you have it
$salepoint_id = intval($_POST['salepoint_id']);

// Fetch expense types for the given salepoint_id
$sql = "SELECT id, name FROM expenses_type WHERE salepoint_id = $salepoint_id";
$result = $conn->query($sql);

// Generate <option> elements for the select element
$options = '';
while ($row = $result->fetch_assoc()) {
    $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
}

// Return the generated options
echo $options;
?>
