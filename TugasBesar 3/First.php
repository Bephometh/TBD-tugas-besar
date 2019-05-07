<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<?php
    include ("connection.php");
    // print_r($conn);
    // return;
?>
<head>
    <meta charset="utf-8" />
    <title>Your Medical Friend</title>
    <style>
        input[type=text] {
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 2px solid black;
        -webkit-transition: width 0.4s ease-in-out;
        transition: width 0.4s ease-in-out;
    }
    input[type=button] {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 16px 32px;
        text-decoration: none;
        margin: 4px 2px;
        cursor: pointer;
    }
    </style>
</head>
<body>
    <div class="header">
        <header>
            <h1>ANALYST YOUR SYMPTOMS</h1>
        </header>
        <hr>
    </div>
    <br>
    <div>
        <form method="GET" action="First.php">
            <label for="gejala 1">Nama Pasien</label><br>
            <input type="text" placeholder="nama " name="nama" value="" /> <br 
        
        </form>
        <input type="submit" name="action" value="Check" />
        <input type="submit" name="action" value="Daftar"/>
        <?php

        if(isset($_GET['action'])){
            if($_GET['action'] == 'Check'){
                if(isset($_GET['nama'])){
                    $name = $_GET["nama"];

                    $sql ="SELECT namaPasien FROM Pasien WHERE namaPasien = '$name'";
                    //echo $sql;
                    $try = sqlsrv_query($conn,$sql);

                    while($row = sqlsrv_fetch_array($try,SQLSRV_FETCH_ASSOC)){
                        if($row['namaPasien'] != NULL){
                            echo 'sudah terdaftar';
                        }
                        else if($row['namaPasien'] == NULL){
                            echo 'belum terdaftar';
                        }
                    }
                }
            }
            if($_GET['action'] == 'Daftar'){
                $namaBaru = $_GET['nama'];
                $insertPasien = "INSERT INTO Pasien (namaPasien) VALUES ('$namaBaru')";
                $in = sqlsrv_query($conn,$insertPasien);
                echo 'Berharsil terdaftar';
            }
        }


        ?>
    </div>
</body>

</html>