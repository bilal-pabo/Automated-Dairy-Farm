<?php 
    $size = count(explode("/", $_SERVER["REQUEST_URI"])) - 2;
    $dots = "./";
    for ($i = 1; $i < $size; $i++)
    {
        if ($i == 1) $dots = "../";
        else $dots .= "../";
    }
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href=<?php echo $dots.'components/style.css' ?>>
</head>
<body>
  <div class="container">
    