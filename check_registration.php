<?php

$page_title = "Check registration";

include 'mysqli_connect.php';

include 'includes/header.html';

include 'includes/navbar.html';

if (isset ($_SESSION['username'])){
	header('location: index.php');
}
else{
	
    $username = $_POST['username'];
    $password = $_POST['pass'];

    $sql1 = "SELECT users_username, users_password FROM users WHERE users_username = ? AND users_password = ?";
    $stmt1 = mysqli_prepare($connection, $sql1);
    if ($stmt1) {
        mysqli_stmt_bind_param($stmt1, 'ss', $username, $password);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
    } else {
        die(mysqli_error($connection));
    }

    $sql2 = "INSERT INTO users (users_username, users_password) VALUES (?, ?)";
    $stmt2 = mysqli_prepare($connection, $sql2);
    if (!$stmt2) {
        die(mysqli_error($connection));
    }
    mysqli_stmt_bind_param($stmt2, 'ss', $username, $password);

    if (mysqli_num_rows($result1) == 0){
        if (mysqli_stmt_execute($stmt2)){
            include 'includes/new_registration.php';
        }
        else{
            include 'includes/error.php';
            
        }

    }
    else{
        include 'includes/notregistered.php';
    }
}

mysqli_close ($connection);

include 'includes/footer.html';

?>