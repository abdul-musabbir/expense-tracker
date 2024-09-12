<?php
   
   include_once "././db/db.php";

    session_start();
    $user_id = null;
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        var_dump($user_id);
    }

    if ($user_id) {

        $sqls = "UPDATE users SET active = ?, logout_at = ? WHERE user_id = '$user_id'";
        $stmt = $conn->prepare($sqls);

        $active = 0;
        $logout_time = date("Y-m-d H:i:s");

   
        $stmt->bind_param("is", $active, $logout_time);

  
        $stmt->execute();
    }

    session_unset();
    session_destroy();

    header('Location: /login');
   exit();
?>
