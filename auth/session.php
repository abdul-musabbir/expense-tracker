<?php
    session_start();
    include "./db/db.php";

    $user = null;
    if (isset($_SESSION['email'])) {
        $user = $_SESSION['email'];
    }

    $users = null;
    if ($user) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $users = $result->fetch_assoc();
        }
    }
?>
