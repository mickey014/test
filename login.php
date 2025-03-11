<?php
session_start();
if(isset($_SESSION['isLoggedIn'])) {
    header('Location: /testexam/');
}

require 'dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
</head>
<body>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 offset-md-4">
            <h2>Login</h2>
            <form id="loginForm">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <input type="submit" value="Login" class="btn btn-dark">
            </form>
            </div>
        </div>
    </div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
    $(document).on('submit', '#loginForm', function(e) {
        e.preventDefault(); // Prevent page refresh

        var formData = new FormData(this);
        formData.append("login", true);

        // Send the form data via AJAX
        $.ajax({
            url: 'crud.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // console.log(response)
                var res = jQuery.parseJSON(response);
                alert(res.message);
                if(res.status == 200) {
                    window.location.href = '/testexam/'; // Redirect to dashboard
                } 
            }
        });
    });
</script>
</body>
</html>
