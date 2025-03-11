<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

require 'dbconn.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
</head>
<body>

    
    <button class="btn btn-danger btn-sm rounded-0 float-right" onClick="logoutUser()">Logout</button>
    <div class="clearfix"></div>
    <h2 class="text-center">Hi <?= $_SESSION['name']?> !</h2>
    <div class="container">
    <div class="row">
        <div class="col-md-4">
        <form id="formUser">
            <h2>Student System</h2>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
        </div>
        <div class="col-md-8">
        <table class="tableUsers">
            <thead>
                <tr>
                <th scope="col">Name</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tbodyUsers"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="formUserEdit">
            <input type="hidden" class="form-control" id="userId" name="userId" aria-describedby="emailHelp">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
    $(document).ready(() => {
        displayUsers();
    });

    $(document).on('submit', '#formUser', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("save_student", true);

        $.ajax({
            type: "POST",
            url: 'crud.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                
                var res = jQuery.parseJSON(response);
                // console.log(response)
                if(res.status == 200) {
                    $('#name').val('')
                    $('#username').val('')
                    $('#password').val('')
                    $('#email').val('')
                    displayUsers();
                } 
                alert(res.message);
            }
        });

    });

    function displayUsers() {
        // console.log('test');
        
        $.ajax({
            type: "POST",
            url: 'crud.php',
            data: {all_users: 'all_users'},
            success: function (response) {
                // console.log(response)
                $('#tbodyUsers').html(response)
                // $('#tableUsers').DataTable().clear().destroy();
                let table = new DataTable('.tableUsers');
            }
        });
    }

    function editUser(id, name, username, email, password) {
        $('#formUserEdit #userId').val(id)
        $('#formUserEdit #name').val(name)
        $('#formUserEdit #username').val(username)
        $('#formUserEdit #email').val(email)
        $('#formUserEdit #password').val(password)
    }

    
    $(document).on('submit', '#formUserEdit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("update_student", true);

        if(confirm("Are you sure?")) {
            $.ajax({
                type: "POST",
                url: 'crud.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    // console.log(response)
                    if(res.status == 200) {
                        displayUsers();
                        $('#exampleModal').modal('toggle');
                    } 

                    alert(res.message);                
                }
            });
        }
    });

    function deleteUser(userId) {
        // alert(id)
        if(confirm('Are you sure?'))
        {
            $.ajax({
                type: "POST",
                url: "crud.php",
                data: {
                    'delete_student': true,
                    'userId': userId
                },
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    // console.log(response)
                    if(res.status == 200) {
                        displayUsers();
                    } 
                    alert(res.message);    
                }
            });
        }
    }

    function logoutUser() {
        if(confirm("Are you sure?")) {
            window.location.href = 'logout.php';
        }
    }


</script>
</body>
</html>