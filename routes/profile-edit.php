<?php
include_once "./db/db.php";
include_once "./auth/session.php";

$user = null;
if (isset($users)) {
    $user = $users;
}

$email = $name = $profile_img = null;

if (isset($user['email'])) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_details = $result->fetch_assoc();

    if ($user_details) {
        $email = $user_details['email'];
        $name = $user_details['name'];
        $profile_img = $user_details['profile_img']; // Fetch current profile image URL
    }
}

if (isset($_POST['submit'])) {
    $user_name = htmlspecialchars($_POST['name']);
    $user_email = htmlspecialchars($_POST['email']);
    $filename = $_FILES['fileToUpload']['name'];
    $tmp_file = $_FILES['fileToUpload']['tmp_name'];

    // Initialize the profile image URL as the current one
    $profile_img = $profile_img;

    $upload_dir = __DIR__ . "/../images/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
    }
    $file_path = $upload_dir . basename($filename);

    if (!empty($filename)) {
        // Validate file type and size
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($ext, $allowed_exts) && $_FILES['fileToUpload']['size'] < 5000000) { // 5MB max size
            if (move_uploaded_file($tmp_file, $file_path)) {
                $profile_img = 'images/' . basename($filename); // Save the relative URL
            } else {
                echo 'Failed to upload the file.';
                exit;
            }
        } else {
            echo 'Invalid file type or size.';
            exit;
        }
    }

    if (!empty($user_name) && !empty($user_email)) {
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email format.';
        } else {
            $sqls = "UPDATE users SET name = ?, email = ?, profile_img = ? WHERE email = ?";
            $stmt = $conn->prepare($sqls);
            $stmt->bind_param('ssss', $user_name, $user_email, $profile_img, $email);

            if ($stmt->execute()) {
                header('Location: /profile');
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    } else {
        echo 'Name and Email are required.';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/output.css">
    <script defer src="https://unpkg.com/alpinejs@3.2.2/dist/cdn.min.js"></script>
    <style>
        /* Your existing CSS styles */
    </style>
</head>
<body class="bg-blue-50">
    <div class="m-4">
        <main class="credit-card sm:w-auto h-screen flex items-center justify-center mx-auto rounded-xl ">
            <form method="POST" class="mt-4 p-4 w-[450px]" enctype="multipart/form-data">
                <h1 class="text-xl font-semibold text-gray-700 text-center">Edit Your Profile</h1>
                <div>
                    <div class="my-3">
                        <input type="file" name="fileToUpload" id="fileToUpload" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg">
                    </div>
                    <?php if (!empty($profile_img)): ?>
                    <div class="my-3">
                        <img src="../<?php echo htmlspecialchars($profile_img); ?>" alt="Profile Picture" class="w-full h-auto rounded-lg">
                    </div>
                    <?php endif; ?>
                    <div class="my-3">
                        <input type="text" name="name" id="name" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:outline-none" placeholder="Name" value="<?php echo htmlspecialchars($name); ?>" required />
                    </div>
                    <div class="my-3">
                        <input type="email" name="email" id="email" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:outline-none" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required />
                    </div>
                </div>
                <input class="submit-button px-4 py-3 rounded-full bg-blue-300 text-blue-900 focus:ring focus:outline-none w-full text-xl font-semibold transition-colors" type="submit" name="submit" value="Update">
            </form>
        </main>
    </div>
</body>
</html>

