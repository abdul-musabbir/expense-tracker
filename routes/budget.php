<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('Location: /login');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Document</title>
</head>
<body>
    <main class="grid grid-cols-[250px_1fr] grid-rows-[60px_1fr] w-full h-screen">
        <!-- Left Sidebar -->
        <div class="col-start-1 col-end-2 row-start-1 row-end-3 border-r-2">
            <?php include_once "./components/left-bar.php"; ?>
        </div>
        
        <!-- Top Bar -->
        <div class="w-full col-start-2 col-end-3 row-start-1 row-end-2 sticky top-0 right-0 left-0">
            <?php include "./components/top-bar.php"; ?>
        </div>

        <!-- Main Content -->
        <div class="w-full h-full">
            <?php
                echo "Budget Page";
            ?>
        </div>
    </main>
</body>
</html>
