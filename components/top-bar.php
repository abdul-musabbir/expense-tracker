<?php

$user_id = null;
if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
}

$profile_image = null;

// Connect to the database
require "./db/db.php";


// Get the user's profile image from the database
$sql = "SELECT profile_img FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_details = $result->fetch_assoc();

if ($user_details) {
    $profile_image = $user_details['profile_img'];
}

// Determine the URL for the profile image
$profile_image_url = $profile_image ? '../images/' . htmlspecialchars($profile_image) : 'https://img.freepik.com/premium-vector/cute-baby-boy-profile-picture-kid-avatar_176411-4644.jpg';
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Profile Page</title>
</head>
<body>
<div class="w-full py-2 border-b-2 h-full flex bg-white items-center">
    <div class="w-11/12 mx-auto flex">
        <div class="flex w-full justify-between">
            <div class="relative flex items-center">
                <input
                    type="text"
                    class="w-96 px-6 py-2 rounded-2xl border"
                    placeholder="Search"
                />
            </div>
            <div class="flex items-center gap-5">
                <div>
                    <img src="https://cdn.hugeicons.com/icons/mail-01-twotone-rounded.svg" alt="">
                </div>
                <div class="flex gap-5">
                    <button>
                        <img src="https://cdn.hugeicons.com/icons/notification-01-stroke-standard.svg" alt="">
                    </button>
                </div>

                <div class="relative">
                    <button id="profile-button">
                        <img class="profile-image size-10 rounded-full object-cover object-center" src="<?php echo $profile_image ?? "https://img.freepik.com/premium-vector/cute-baby-boy-profile-picture-kid-avatar_176411-4644.jpg"; ?>" alt="Profile Image">
                    </button>

                    <div id="drop-down" class="absolute w-36 p-2 bg-white shadow-xl border top-14 right-0 rounded hidden">
                        <a href="/profile" class="inline-block px-2 py-2 hover:bg-gray-300 hover:text-white w-full rounded-md">Go To Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  const profileBtn = document.getElementById('profile-button');
  const dropDown = document.getElementById('drop-down');

  profileBtn.addEventListener('click', (e) => {
    e.stopPropagation(); 
    dropDown.classList.toggle('hidden'); 
  });

  document.addEventListener('click', (e) => {
    if (!dropDown.contains(e.target) && !profileBtn.contains(e.target)) {
      dropDown.classList.add('hidden');  
    }
  });
</script>
</body>
</html>
