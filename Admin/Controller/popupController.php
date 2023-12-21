
<?php
// popupController.php

// Check if data is sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from POST request
    $apartman_adi = isset($_POST['apartman_adi']) ? $_POST['apartman_adi'] : null;
    $blokSay = isset($_POST['blokSay']) ? $_POST['blokSay'] : null;

    // Your processing logic here...

    // Example: You can send a response back
    $response = array('success' => true, 'message' => 'Data received successfully');
    echo json_encode($response);
} else {
    // Invalid request method
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>
