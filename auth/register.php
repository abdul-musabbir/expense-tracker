<?php
    include_once "././db/db.php";
    session_start();

    if (isset($_SESSION['email'])) {
        header('Location: /');
        exit();
    }

    $name = $email = "";

    if (isset($_POST['submit'])) {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format!";
        } else if (empty($name) || empty($email) || empty($password)) {
            $error = "All fields are required!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $checkSql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($checkSql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "User with this email already exists.";
            } else {
                $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $created_time = date("Y-m-d H:i:s");
                $stmt->bind_param("ssss", $name, $email, $hashed_password, $created_time);
                
                if ($stmt->execute()) {
                    header('Location: /login');
                    exit();
                } else {
                    $error = "Error: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Signup Form</title>
</head>
<body>
    <main class="w-full flex h-screen items-center justify-center">
        <form method="post" class="flex flex-col gap-5 w-[450px] bg-white shadow-2xl rounded-2xl border py-10 px-10">
            <input type="text" name="name" placeholder="Name" class="border px-6 py-3 rounded-xl" required value="<?php echo $name; ?>">
            <input type="email" name="email" placeholder="Email" class="border px-6 py-3 rounded-xl" required value="<?php echo $email; ?>">
            <input type="password" name="password" placeholder="Password" class="border px-6 py-3 rounded-xl" required>

            <?php if (isset($error)) : ?>
                <p class="text-red-500"><?php echo $error; ?></p>
            <?php endif; ?>

            <input type="submit" name="submit" value="Sign Up" class="border px-6 py-3 rounded-xl bg-black text-white font-bold uppercase cursor-pointer">
        </form>
    </main>
</body>
</html>
