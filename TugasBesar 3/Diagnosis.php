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
        <form method="GET" action="">
            <label for="gejala 1">Gejala 1</label><br>
            <input type="text" placeholder="gejala 1 " name="gejalaa" value="haus" /> <br /
        </form>
        <input type="button" value="Check" />

        <?php
            $gejala = $_GET['gejalaa'];
            
            $sql ="SELECT * FROM Gejala WHERE namaGejala = $gejala";
            $try = sqlsrv_query($conn,$sql);
            while($row = sqlsrv_fetch_array($try,SQLSRV_FETCH_ASSOC){

                echo $row['namaGejala'].",";
            }
        ?>
    </div>
</body>

</html>