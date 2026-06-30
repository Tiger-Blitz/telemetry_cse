<?php

$page_title = 'Check login';

include 'includes/header.html';

include 'mysqli_connect.php';

if (isset ($_SESSION['username'])){
	header ('location: index.php');
}
else{
    $username = $_POST['username'];
    $password = $_POST['pass'];

    $sql1 = "SELECT users_username, users_password FROM users WHERE users_username = ? AND users_password = ?";
    $stmt = mysqli_prepare($connection, $sql1);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        die(mysqli_error($connection));
    }

    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['users_username'];
        header('Location: dashboard/dashboard.php');
        exit;
    }
    else{
        include 'includes/navbar.html';
        include 'includes/notlogged.php';
        
    }
}

mysqli_close($connection);

include 'includes/footer.html';
?>