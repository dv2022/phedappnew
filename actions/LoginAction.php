<?php

require_once __DIR__ . '/../core/ActionInterface.php';

class LoginAction implements ActionInterface {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function execute() {
        // Validate input
        if (empty($this->data['username']) || empty($this->data['password'])) {
            throw new Exception("Username and password are required.");
        }

        $username = $this->data['username'];
        $password = $this->data['password'];

        // Simulate database check (replace with actual database query)
        $validUsers = [
            'admin' => 'password123',
            'user1' => 'mypassword',
        ];

        if (isset($validUsers[$username]) && $validUsers[$username] === $password) {
            // Start the session and set user data
            session_start();
            $_SESSION['phed_user'] = $username;
            $_SESSION['phed_id'] = uniqid(); // Simulate user ID
            return ['message' => 'Login successful', 'redirect' => 'home.php'];
        }

        throw new Exception("Invalid username or password.");
    }
}
