<?php
    include_once "././db/db.php";
    session_start();

    if (isset($_SESSION['email'])) {
        header('Location: /dashboard');
        exit();
    }

    $email = $password = $login_error = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        if (!empty($email) && !empty($password)) {
            // Prepare and execute the SQL query to fetch the user
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user) {
                // Password is correct, start the session and update user info
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user['user_id']; // Example: storing user ID instead of password

                // Update user's active status and login time
                $sqls = "UPDATE users SET active = ?, login_at = ? WHERE user_id = ?";
                $stmt = $conn->prepare($sqls);
                $active = true;
                $login_time = date("Y-m-d H:i:s"); // Changed date format to SQL-compatible format
                $stmt->bind_param("iss", $active, $login_time, $user['user_id']);
                $stmt->execute();

                header("Location: /dashboard");
                exit();
            } else {
                $login_error = "Invalid email or password!";
            }
        } else {
            $login_error = "Please fill out both fields!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Signin Form</title>
</head>
<body>
    <main class="w-full flex h-screen items-center justify-center">
        <form method="post" class="flex flex-col gap-5 w-[450px] bg-white shadow-2xl rounded-2xl border py-10 px-10">
            <input type="email" name="email" placeholder="Email" class="border px-6 py-3 rounded-xl" required value="<?php echo htmlspecialchars($email); ?>">
            <input type="password" name="password" placeholder="Password" class="border px-6 py-3 rounded-xl" required>

            <input type="submit" name="submit" value="Sign In" class="border px-6 py-3 rounded-xl bg-black text-white font-bold uppercase cursor-pointer">

            <!-- Show error message if login fails -->
            <?php if (!empty($login_error)): ?>
                <p class="text-red-500"><?php echo $login_error; ?></p>
            <?php endif; ?>
        </form>
    </main>
</body>
</html>
