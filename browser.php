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
    // $renamed = str_replace(' ', '_', $_REQUEST['target']);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_GET['target'])) {
            if (isset($_POST['newdir'])) {
                $newdirname = $_REQUEST['newdir'];
                mkdir($_REQUEST['target'] . '\\' . $newdirname);
            }
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['target'])) {
            if(isset($_POST['rename'])) {      
                $currentname = $_REQUEST['target'];
                $newname = $_REQUEST['target'] . '/../' . $_REQUEST['rename'];
                rename ($currentname, $newname);
            }
        }
      }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_FILES['upload'])){
          $temp_name = $_FILES['upload']['tmp_name'];
          $file_name = $_FILES['upload']['name'];
          $file_name = str_replace(' ', '%20', $file_name);
          $file_size = $_FILES['upload']['size'];
          if($file_size < 500000) {
             move_uploaded_file($temp_name, $_GET['target'] . '\\' . $file_name);
             echo $file_name . ' line89';
          }else{
             print("File too big");
          }
       }
      }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['deletion'])) {
            if (isset($_POST['oldname'])){
                if(isset($_POST['delete'])) {
                    $oldname = $_REQUEST['oldname'];
                    $renamed = $_REQUEST['deletion'];
                    // rename ($oldname, $renamed);              
                    // echo $oldname . ' 104 ';
                    // unlink(($renamed); 
                    unlink(str_replace('_', ' ', $renamed));
                }
            }
        }
      }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['download'])) {
            ob_clean();
            ob_start();
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($_REQUEST['download']).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($_REQUEST['download']));
            ob_end_flush();
            readfile($_REQUEST['download']);
            exit;
        }
      }


    echo "<div style='display:inline-flex'>";

    if (isset($_GET['target'])) {
        echo '<a href="?target='. $back_target .'"><i class="large material-icons" style="padding:7px; margin:7px; background-color: yellow; border-radius:50%">arrow_back</i></a>';
    }

    echo "<form action='' method='POST'><button type='submit' for='newdir' style = 'background-color:inherit; border:none'><i class='large material-icons' style='padding:7px; margin:7px; background-color: red; border-radius:50%'>create_new_folder</i></button><input type='text' name='newdir' placeholder='New directory name'></form>";

    echo "<form action='' method='POST' enctype='multipart/form-data'><button style='background-color:inherit; border:none' type='submit' for='upload'><i class='large material-icons' style='padding:7px; margin:7px; background-color: green; border-radius:50%'>file_upload</i></button><input style='background-color:inherit; border:none' name='upload' type='file' placeholder='Upload file'></input></form>";

    echo "</div>";

    echo "<div class = 'itemh'><div class='column'>Type</div><div class='column'>Name</div><div class='column'>Size</div></div>";

    foreach($directory as $name) {
        if (is_file($name)){
        echo "<div class = 'item'>
                <div class='column'><b>File </b></div>" . "
                <div class='column'>" . basename($name) . "</div>
                <div class='column'> " . filesize($name) . " kb. </div>
                <div class='column'><form action = '' method='POST'><input type='hidden' name='oldname' value=".$name." /><input type='hidden' name='deletion' value=".str_replace(' ', '_', $name)." /><button type='submit' name='delete'>Delete</button></form>
                <form action = '' method='POST' enctype='multipart/form-data'><input type='hidden' name='download' value=".$name." /><button type='submit' for='download'>Download</button></form></div>
            </div></br>";
        }
        else if (is_link($name)) "<div class = 'item'><b>Link </b>" . basename($name) . "</div>";
        else {
        echo '<div class ="item">     
                <div class="column">
                    <b>Directory </b></div> 
                <div class="column"><a href="?target='. $name . '">'.basename($name).'</a></div> 
                <div class="column">' . filesize($name) . ' kb. </div>
                <form action = "" method="POST"><div class="column"><input type="hidden" name="target" value='.$name.' /><button type="submit" for="rename">Rename</button><input type="text" name="rename"></div>
            </div></form></br>';
        }
    }

    ?>
</body>
</html>