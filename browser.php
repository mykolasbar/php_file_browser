<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naršyklė</title>
    <style>
        .container {
            padding: 8px;
        }
        .list {

        }
        .item {
            padding:10px;
            display:inline-flex;
            width:100%;
        }
        .itemh{
            padding:10px;
            display:inline-flex;
            width:100%;
            background-color:aqua;
            font-weight: bold;
        }
        .item:hover{
            background-color: rgb(176, 214, 186);
            width:100%;
        }
        .column {
            min-width:400px;
        }
    </style>
</head>
<body>
<!-- scandir() → gražina failus ir direktorijas kurie yra direktorijoje paduodamoje per parametrą.
is_dir() arba is_file();
bei $_SERVER['REQUEST_URI'] ir pan. superglobaliuosius.
isset() → patiktinti ar kintamieji turi reikšmę (isset($_GET[‘x’])). -->

<!-- 'C:\*' -->
<!-- './' -->

    <?php

    $path = '';

    if (isset($_POST['name'])) {
        $path = $_REQUEST['name'];
    }


    echo $path;

    $directory = scandir('./');

    // print_r($directory);


    echo "<form action = '' method='POST' class = 'list'>
    <div class = 'itemh'><div class='column'>Type</div><div class='column'>Name</div><div class='column'>Size</div></div>";

    foreach($directory as $name) {
        if (is_file($name)){

        echo "<div class = 'item'><div class='column'><b>File </b></div>" . "<div class='column'>" . basename($name) . "</div><div class='column'> " . filesize($name) . " mb. </div></div></br>";
        }
        else if (is_link($name)) "<div class = 'item'><b>Link </b>" . basename($name) . "</div>";
        else {

        echo "<div class = 'item'><div class='column'><b>Directory </b></div> <div class='column'><a href = $name>" . basename($name) . "</a><button name = 'name' type='submit'>Atidaryti</button></div> <div class='column'>" . filesize($name) . " mb. </div></div></br>";
        }
    }

    echo "</form>"

    ?>
</body>
</html>