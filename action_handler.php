<?php
// Start the session
session_start();

// Include necessary core files
require_once __DIR__ . '/core/ActionDispatcher.php'; // The dispatcher
require_once __DIR__ . '/core/ActionInterface.php';  // The action interface (if not autoloaded)
require_once __DIR__ . '/actions/LoginAction.php';  // Include LoginAction class

// Create the dispatcher instance
$dispatcher = new ActionDispatcher();

// Register the action for login
$dispatcher->registerAction('login', 'LoginAction');

// Get the `pid` from the request
// $pid = $_REQUEST['pid'] ?? null; // Fallback to null if `pid` is not set

$pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : null;

// Validate session variables (ensures the user is logged in)
if (!isset($_SESSION['phed_user'], $_SESSION['phed_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Please log in.']);
    exit;
}

// Retrieve input data
$data = $_REQUEST;

// Dispatch the action
try {
    // Dispatch the action based on pid (e.g., 'login')
    $dispatcher->dispatch($pid, $data);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>