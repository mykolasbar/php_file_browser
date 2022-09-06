<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

    $path = 'C:\*';

    if (isset($_GET['target'])) {
        $path = $_GET['target'] . '\*';
        $paths = explode('\\', $path);
        $path_length = count($paths);
        if ($path_length>1){
            unset($paths[$path_length-1], $paths[$path_length-2]);
            $back_target = implode('\\', $paths);
        }
    }

     
    $directory = glob($path);

    if (isset($_GET['target'])) {
        echo '<a href="?target='. $back_target .'"><i class="large material-icons" style="padding:7px; margin:7px; background-color: yellow; border-radius:50%">arrow_back</i></a>';
        // echo '<button onclick="history.back()">Back</button>';
    }
        // echo "<i class='large material-icons' style = 'padding:7px; margin:7px; background-color: yellow; border-radius:50%'>arrow_forward</i>";
        echo "<div class = 'itemh'><div class='column'>Type</div><div class='column'>Name</div><div class='column'>Size</div></div>";

    foreach($directory as $name) {
        if (is_file($name)){
        echo "<div class = 'item'><div class='column'><b>File </b></div>" . "<div class='column'>" . basename($name) . "</div><div class='column'> " . filesize($name) . " mb. </div></div></br>";
        }
        else if (is_link($name)) "<div class = 'item'><b>Link </b>" . basename($name) . "</div>";
        else {
        echo '<div class ="item"><div class="column"><b>Directory </b></div> <div class="column"><a href="?target='. $name . '">'.basename($name).'</a></div> <div class="column">' . filesize($name) . ' mb. </div></div></br>';
        }
    }

    ?>
</body>
</html>