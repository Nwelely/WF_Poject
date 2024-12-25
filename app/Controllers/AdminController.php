<?php
require_once('../model/user.php');

class AdminController {
    private $model;

  

    public function handleUserCreation($postData) {
        $studentName = $postData["StudentName"];
        $gender = $postData["Gender"];
        $username = $postData["username"];
        $email = $postData["email"];
        $password = password_hash($postData["password"], PASSWORD_BCRYPT);
        $userTypeId = $postData["userTypeId"];

        if ($this->model->isUserExists($username, $email)) {
            echo "<script>alert('Username or Email already exists.'); window.history.back();</script>";
            return;
        }

        $userId = $this->model->createUser($username, $email, $password, $userTypeId);
        if (!$userId) {
            echo "<script>alert('Error: Could not create user.'); window.history.back();</script>";
            return;
        }

        if ($this->model->createStudent($userId, $studentName, $gender)) {
            echo "<script>alert('Student created successfully!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error: Could not create student record.'); window.history.back();</script>";
        }
    }
}
?>
