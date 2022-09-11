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
                {echo '<div style="text-color:red">Please enter the correct password!</div>';}
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
</head>
    <form action = '' method='POST'>
        <label for="username">Enter username</label>
        <input type="text" name="username" required></input>
        <label for="username">Enter password</label>
        <input type="text" name="password" required></input>     
        <button id="confirm" onmouseover="displaynotif()" onmouseleave="hidenotif()" style="position:relative">Confirm</button>
        <div id="enternotif" style="display:none; width: 120px; background-color: rgb(249, 250, 164); border:1px solid; position:absolute; left:600px; top:40px">Confirm and enter</div>
    </form>
    <div id="enternotif" style="display:block"></div>
    <script type="text/javascript">
            function displaynotif() {
            document.getElementById("enternotif").style.display = 'block'
            console.log("test")
            }

            function hidenotif(){
                document.getElementById("enternotif").style.display = 'none'
            }
    </script>
<body>
</body>
</html>