<?php

session_start();
require('dbconn.php');

if(isset($_POST['save_student']))
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if($name == NULL || $email == NULL || $username == NULL || $password == NULL)
    {
        $res = [
            'status' => 400,
            'message' => 'All fields are required.'
        ];
        echo json_encode($res);
        return;
    }

    $sql = "INSERT INTO users (name,username,email,password) VALUES ('$name','$username','$email','$password')";
    $query = mysqli_query($conn, $sql);

    if($query)
    {
        $res = [
            'status' => 200,
            'message' => 'Student Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    
}

if(isset($_POST['all_users']))
{
    $sql = "SELECT * FROM users ORDER BY id desc";
    $query = mysqli_query($conn, $sql);

    
    if (mysqli_num_rows($query) > 0) {
        // Iterate through the query result
        
        // Display the user data
        $row = '';

        foreach ($query as $user) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($user['name']) . '</td>';
            echo '<td>' . htmlspecialchars($user['username']) . '</td>';
            echo '<td>' . htmlspecialchars($user['email']) . '</td>';
            echo '<td>';
            echo '<button data-toggle="modal" data-target="#exampleModal" class="btn btn-info btn-sm mr-1" onclick="editUser(' . $user['id'] . ', \'' . $user['name'] . '\', \'' . $user['username'] . '\', \'' . $user['email'] . '\', \'' . $user['password'] . '\')">Edit</button>';
            echo '<button class="btn btn-danger btn-sm" onclick="deleteUser(' . $user['id'] . ')">Delete</button>';
            echo '</td>';
            echo '</tr>';
        }
        
    } else {
        echo "No users found.";
    }
    
}

if(isset($_POST['update_student']))
{
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if($name == NULL || $email == NULL || $username == NULL || $password == NULL)
    {
        $res = [
            'status' => 400,
            'message' => 'All fields are required.'
        ];
        echo json_encode($res);
        return;
    }

    $sql = "UPDATE users SET name='$name', username='$username', email='$email', password='$password' 
                WHERE id='$userId'";
    $query = mysqli_query($conn, $sql);

    if($query)
    {
        $res = [
            'status' => 200,
            'message' => 'Student Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    
}

if(isset($_POST['delete_student']))
{
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);

    $query = "DELETE FROM users WHERE id='$userId'";
    $query_run = mysqli_query($conn, $query);

    if($query)
    {
        $res = [
            'status' => 200,
            'message' => 'Student Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    
}

if(isset($_POST['login']))
{
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if($username == NULL || $password == NULL)
    {
        $res = [
            'status' => 400,
            'message' => 'All fields are required.'
        ];
        echo json_encode($res);
        return;
    }

    $sql = "SELECT * FROM users WHERE '$username' = '$username' AND password = '$password'";
    $query = mysqli_query($conn, $sql);


    if(mysqli_num_rows($query) > 0)
    {
        $user = mysqli_fetch_array($query);
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['password'] = $user['password'];
        $_SESSION['isLoggedIn'] = true;

        $res = [
            'status' => 200,
            'message' => 'Welcome Back '. $username . '!'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 400,
            'message' => 'Invalid username or password!'
        ];
        echo json_encode($res);
        return;
    }
}