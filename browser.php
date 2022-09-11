<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>PHP File browser</title>
    <style>
        .container {
            width:100%;
            display:inline-flex;
            align-content: center;
            justify-content:center;
            align-items:center;
            text-align: start;
        }
        .item {
            padding:10px;
            display:inline-flex;
            justify-content:space-between;
            width:100%;
            text-align:start;
        }
        .itemh {
            padding:10px;
            display:inline-flex;
            justify-content:space-between;
            align-items:space-between;
            width:100%;
            background-color:aqua;
            font-weight: bold;
        }
        .list {
            width:100%;
            align-content: center;
            justify-content:space-between;
            align-items:space-between;
            text-align:start;
            border:1px solid;
            padding-right:18px;
        }
        .item:hover{
            background-color: rgb(176, 214, 186);
            width:100%;
        }
        .column {
            text-align:start;
            min-width:275px;
        }
        #actions {
            display:none;
        }
    </style>
</head>
<body>

<!-- 'C:\*' -->
<!-- './' -->
<!-- $_SERVER["DOCUMENT_ROOT"] . '\*' -->

    <?php

    session_start();

    if (!isset($_SESSION['username']))
        header('Location: index.php');

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

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_GET['target'])) {
            $newdirname = $_REQUEST['newdir'];
            if (isset($_POST['newdir']) && !file_exists($_REQUEST['target'] . '\\' . $newdirname)) {      
                mkdir($_REQUEST['target'] . '\\' . $newdirname);
                header("Refresh:0");
            }
            else if (file_exists($_REQUEST['target'] . '\\' . $newdirname))
            echo 'Please choose a different name for your directory.';
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['target'])) {
            if(isset($_POST['rename'])) {      
                $currentname = $_REQUEST['target'];
                $newname = $_REQUEST['target'] . '/../' . $_REQUEST['rename'];
                rename ($currentname, $newname);
                header("Refresh:0");
            }
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_FILES['upload'])){
            $temp_name = $_FILES['upload']['tmp_name'];
            $file_name = $_FILES['upload']['name'];
            $file_name = str_replace(' ', '%20', $file_name);
            $file_size = $_FILES['upload']['size'];
            header("Refresh:0");
            if($file_size < 500000) {
                move_uploaded_file($temp_name, $_GET['target'] . '\\' . $file_name);
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
                    unlink(str_replace('_', ' ', $renamed));
                    header("Refresh:0");
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

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['logout'])) {
            $_SESSION['logged_in'] = false;
            session_destroy();
            header('Location: index.php');
        }
    }

    function converttoMB($bytes) {
        $mb = $bytes * 0.00000095367432;
        $mb = round($mb, 2);
        return $mb;
    }

    echo "<div style='text-align:right'>You are logged in as <b>" . $_SESSION['username'] . "</b> <form action='' method='POST'><button name='logout'>Logout</button></form></div>
    
    <div class='container'>
        <div style='width:85%'>
            <div style='display:inline-flex'>";

    if (isset($_GET['target'])) {
    echo       '<div id="backbutton"><a href="?target='. $back_target .' " ><i class="large material-icons" style="padding:7px; margin:7px; background-color: yellow; border-radius:50%">arrow_back</i></a></div>';
    }

    echo        "<div id='newdirnotif' style='display:none; position:absolute; background-color: rgb(249, 250, 164); padding: 2px; top:30px'>Create new directory</div>
                <form action='' method='POST'><button type='submit' for='newdir' style = 'background-color:inherit; border:none'><i id='newdirectory' class='large material-icons' style='padding:7px; margin:7px; background-color: red; border-radius:50%'>create_new_folder</i></button><input type='text' name='newdir' placeholder='New directory name'></form>
                <div id='uploadfilenotif' style='display:none; position:absolute; background-color: rgb(249, 250, 164); padding: 2px; top:30px; left:400px'>Upload file</div>
                <form action='' method='POST' enctype='multipart/form-data'><button style='background-color:inherit; border:none' type='submit' for='upload'><i id='uploadfile' class='large material-icons' style='padding:7px; margin:7px; background-color: green; border-radius:50%'>file_upload</i></button><input style='background-color:inherit; border:none' name='upload' type='file' placeholder='Upload file'></input></form>
            </div>
        <div>
            <div class = 'itemh'><div class='column'>Type</div><div class='column'>Name</div><div class='column'>Size</div><div class='column'>Action</div>
        </div>
        <div class='list'>";

    foreach($directory as $key => $name) {
        if (is_file($name)){
        echo "<div class = 'item'>
                <div class='column'><b>File </b></div>" . "
                <div class='column'>" . basename($name) . "</div>
                <div class='column'> " . converttoMB(filesize($name)) . " mb. </div>
                <div class='column'>
                    <button id='$key' class='actionsbutton' onclick='displayactions()'><div>Choose action</div></button>
                    <div class='$key' style = 'display:none'>
                        <form action = '' method='POST'><input type='hidden' name='oldname' value='$name' /><input type='hidden' name='deletion' value=".str_replace(' ', '_', $name)." /><button type='submit' name='delete'>Delete</button></form>
                        <form action = '' method='POST' enctype='multipart/form-data'><input type='hidden' name='download' value='$name' /><button type='submit' for='download'>Download</button></form>
                    </div>
                    </div>
            </div></br>";
        }
        else if (is_link($name)) "<div class = 'item'><b>Link </b>" . basename($name) . "</div>";
        else {
        echo "<div class ='item'>     
                <div class='column'><b>Directory </b></div> 
                <div class='column'><a href='?target=$name'>".basename($name)."</a></div> 
                <div class='column'>" . converttoMB(filesize($name)) . " mb. </div>
                <div class='column'>
                    <button id='$key' class='actionsbutton' onclick='displayactions()'><div>Choose action</div></button>
                    <div class = '$key' style = 'display:none' >
                        <form action = '' method='POST'><input type='hidden' name='target' value='$name' /><button type='submit' for='rename'>Rename</button><input type='text' name='rename'></form>
                    </div>
                </div>
            </div></br>";
        }
    }
    echo        "</div>
            </div>
        </div>
    </div>";

    echo "<script>
            document.getElementById('newdirectory').addEventListener('mouseenter', () => {
                document.getElementById('newdirnotif').style.display = 'block';
            })
            document.getElementById('newdirectory').addEventListener('mouseleave', () => {
                document.getElementById('newdirnotif').style.display = 'none';
            })

            document.getElementById('uploadfile').addEventListener('mouseenter', () => {
                document.getElementById('uploadfilenotif').style.display = 'block';
            })
            document.getElementById('uploadfile').addEventListener('mouseleave', () => {
                document.getElementById('uploadfilenotif').style.display = 'none';
            })

            function displayactions(){
                console.log(event.target.parentNode)
                if (event.target.parentNode.nextElementSibling.style.display === 'block') {
                    event.target.parentNode.nextElementSibling.style.display = 'none';
                        } else {
                            event.target.parentNode.nextElementSibling.style.display = 'block';
                        }

                }
        </script>";

    ?>
</body>
</html>

