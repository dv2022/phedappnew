<?php

class ActionDispatcher
{
    // Array to hold action mappings from pid to action class
    private $actions = [];

    // Method to register actions with their corresponding pid
    public function registerAction(string $pid, string $className): void
    {
        $this->actions[$pid] = $className;
    }

    // Method to dispatch an action based on pid and request data
    public function dispatch(string $pid, array $request): void
    {
        // Check if the pid is registered
        if (!isset($this->actions[$pid])) {
            throw new Exception("Action not found for pid: $pid");
        }

        // Get the action class associated with the pid
        $actionClass = $this->actions[$pid];

        // Check if the class exists
        if (!class_exists($actionClass)) {
            throw new Exception("Class $actionClass does not exist.");
        }

        // Create an instance of the action class
        $action = new $actionClass();

        // Ensure the class implements ActionInterface
        if (!$action instanceof ActionInterface) {
            throw new Exception("$actionClass must implement ActionInterface.");
        }

        // Execute the action
        $action->execute($request);
    }
}


?>