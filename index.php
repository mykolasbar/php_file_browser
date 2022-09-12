<?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST['username']) && isset($_POST['password'])) {
                session_start();
                if ($_POST['password'] == 'password') {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['logged_in'] = true;
                    header('Location: browser.php');
                }
                else 
                {echo '<span style="color:red; margin:10px; font-size:larger">Please enter the correct password!</span></br>';}
            }
            else
            echo '<div style="text-color:red">Please enter user name and password</div>';
        }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
            height:100vh;
            display:flex;
            align-content: center;
            justify-content:center;
            align-items:center;
        }
        .loginform{
            padding:20px;
            background-color:aqua;
            border-radius:10px;
            border:1px solid;
        }
        #enternotif{
            display:none; 
            width: 120px; 
            background-color: rgb(249, 250, 164); 
            border:1px solid; 
            position:absolute; 
            left:700px;
            top:455px;
            padding:1px;
        }
        .label {
            margin:5px;
            font-size: larger;
        }
        .inputfield {
            margin:5px;
            height:30px;
        }
        #confirm {
            height:40px;
            width:200px;
            margin:8px;
            border-radius:10px;
            border:1px solid;
        }
        .alignbutton {
            display:flex;
            justify-content:center;
        }
    </style>
</head>
<body>
    <div class='container'>
    <form action = '' method='POST' class='loginform'>
        <label for="username" class="label">Enter username</label>
        <input class="inputfield" type="text" name="username" required></input><br>
        <label for="username" class="label">Enter password</label>
        <input class="inputfield" type="text" name="password" placeholder="password" required></input>
        <div id="enternotif">Confirm and enter</div>  <br>
        <div class="alignbutton"><button id="confirm" onmouseover="displaynotif()" onmouseleave="hidenotif()" style="position:relative">Confirm</button></div>
    </form>
    </div>
    <script type="text/javascript">

        function displaynotif() {
            document.getElementById("enternotif").style.display = 'block'
        }

        function hidenotif(){
            document.getElementById("enternotif").style.display = 'none'
        }

    </script>
</body>
</html>