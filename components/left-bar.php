<?php

$single_value;

  $arr = [
    [
      "name" => 'Dashboard',
      "url" => "https://cdn.hugeicons.com/icons/chart-relationship-stroke-standard.svg",
    ],
    [
      "name" => 'Budget',
      "url" => "https://cdn.hugeicons.com/icons/chart-relationship-stroke-standard.svg",
    ],
    [
      "name" => 'Transitiion',
      "url" => "https://cdn.hugeicons.com/icons/chart-relationship-stroke-standard.svg",
    ],
    [
      "name" => 'Setting',
      "url" => "https://cdn.hugeicons.com/icons/chart-relationship-stroke-standard.svg",
    ],
  ];

  $pathname = $_SERVER['REQUEST_URI'];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
</head>
<body>
<div class="w-full flex h-screen sticky top-0 left-0 bottom-0 items-center justify-center transition duration-300 bg-white">
        <div class="flex flex-col w-full lg:w-[95%] h-screen p-4 md:p-0 relative">
          <div class="absolute md:top-5 md:left-5 left-2 right-2 md:right-5">
            <h2 class="flex items-end gap-3">
              <p class="font-bold text-2xl text-[#005F59] hidden md:block">Tracker</p>
            </h2>
          </div>
          <div class="h-[75vh] md:h-[80vh] md:px-3 my-auto flex flex-col w-full items-center justify-center md:justify-between">
            <div class="flex flex-col w-full space-y-2 items-center md:items-stretch mt-5">
                  
            <?php
foreach ($arr as $item) {
    $link = '/' . strtolower(trim($item['name']));
    $isActive = $pathname === $link ? 'bg-green-700 text-black' : '';
    echo '<a href="' . $link . '" 
              class="w-full md:p-6 py-0 px-0 size-10 md:w-full md:h-8 items-center justify-center flex gap-3 md:justify-start hover:bg-green-700 transition-all duration-300 bg-green-300 text-white rounded-xl ' . $isActive . '">
            <div>
                <img src="' . $item['url'] . '" class="fill-white" alt="' . htmlspecialchars($item['name']) . '" />
            </div>
            <span class="hidden md:block">
                ' . htmlspecialchars($item['name']) . '
            </span>
        </a>';
}
?>

                 
            </div>

            <div class="w-full">
              <div class="flex flex-col gap-4 w-full">
                <div class="w-full hidden md:block">
                  <button class="bg-[#E1F38E] hover:bg-[#e0f38ebd] text-[#005F59] w-full py-2 rounded">
                    Upgrade Plan
                  </button>
                </div>
                <button>
                  
                </button>
                <div class="w-full bg-[#F9F9F9] rounded border hidden  md:flex border-[#2020d8] justify-between p-2 items-center">
                  <button
                      class=
                          "py-2 px-6 h-9 bg-blue-500 shadow-none text-white flex gap-2  items-center rounded"
                  >
                    Light
                  </button>
                  <button
                      class=
                          "py-2 px-6 h-9 bg-blue-500 shadow-none text-white flex gap-2  items-center rounded" 
                  >
                   
                    Dark
                  </button>
                </div>
                <div class="w-full flex-col hidden md:flex">
                  <select class="py-2 px-3 bg-white border rounded cursor-pointer">
                        <option selected>--Currency--</option>
                        <option value="apple">$ USD</option>
                        <option value="banana">€ EURO</option>
                        <option value="blueberry">৳ BDT</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

         
          <div class="w-full absolute bottom-5 left-0 right-0 md:px-3">
         
              <button class="bg-transparent text-[#8A8A8F] w-full flex text-xs items-center justify-center md:items-stretch md:justify-start shadow-none md:flex gap-4">
                <div>
                  <img src="https://cdn.hugeicons.com/icons/logout-02-solid-rounded.svg" alt="">
                </div>
                <a href="/logout" class='hidden md:block'>Logout</a>
              </button>
           
          </div>
        </div>
      </div>
</body>
</html>