<html>
<?php
    include ("../connection.php");
    // print_r($conn);
    // return;
    session_start();
?>
    <head>
        <title>Diagnosis 1</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
        <style>
            table, th, td {
                border: 1px solid black;
            }
        </style>
    </head>
    

    <body>
        <div class="w3-container w3-display-container w3-black w3-padding">
            <h1>Diagnosis</h1>
        </div>

        <div class="w3-container w3-display-container w3-red w3-padding">
            <a href="Histogram.php">Cek Histogram Penyakit</a>
        </div>

        <div class="w3-content w3-center w3-large">
            <p>Selamat Datang di Diagnosis Sederhana</p>
        </div>

        <div class="w3-container w3-padding" >
            <form method="GET" action="first.php">
                <fieldset class="w3-content w3-padding" style="width:40%">
                    <legend>Pasien</legend>
                    <div style="padding-left: 10%; padding-top:2%;">
                        Nama Pasien : <input style="width:60%" type="text" name="namaPasien" placeholder="Nama">
                        <p>
                        <input class="w3-button w3-border w3-border-red w3-round-xlarge w3-hover-red" type="submit" name="action" id="buttonDaftar" value="Daftar">
                        <input class="w3-button w3-border w3-border-red w3-round-xlarge w3-hover-red" type="submit" name="action" id="buttonLanjut" value="Lanjut">
                        <input class="w3-button w3-border w3-border-red w3-round-xlarge w3-hover-red" type="submit" name="action" id="buttonCekSejarah" value="Cek Sejarah" />

                            <?php

                         if(isset($_GET['action'])){
                            if($_GET['action'] == 'Daftar'){
                                //insert datanya
                                if(empty($_GET['namaPasien'])){
                                    echo "<p>";
                                    echo"Masukkan nama lengkap";
                                }
                                else{
                                     $namaBaru = $_GET['namaPasien'];
                                    //Periksa apakah sudah terdaftar
                                    $sql ="SELECT namaPasien FROM Pasien WHERE namaPasien = '$namaBaru'";
                                    $try = sqlsrv_query($conn,$sql);
                                    if($try){
                                        $check_row = sqlsrv_has_rows($try);
                                        if($check_row === true){
                                            echo '<p>';
                                            echo 'Sudah terdaftar';
                                        }
                                        else{
                                             $insertPasien = "INSERT INTO Pasien (namaPasien) VALUES ('$namaBaru')";
                                             $in = sqlsrv_query($conn,$insertPasien);
                                             echo '<p>';
                                             echo"Berhasil Terdaftar";
                                        }
                                    }
                                }
                            }
                            else if($_GET['action'] == 'Lanjut'){
                                //cek ke server ada/tidak
                                //jika ada lanjut ke halaman 2
                                //jika tidak keluarkan echo harus daftar
                                if(isset($_GET['namaPasien'])){
                                    $name = $_GET["namaPasien"];

                                    $sql ="SELECT namaPasien FROM Pasien WHERE namaPasien = '$name'";
                                    //echo $sql;
                                    $try = sqlsrv_query($conn,$sql);

                                     if($try){
                                        $check_row = sqlsrv_has_rows($try);
                                        if($check_row === true){
                                            $_SESSION['namaPasien'] = $name;
                                            header("Location:Second.php");
                                        }
                                        else{
                                            echo '<p>';
                                             echo"Belum Terdaftar";
                                        }
                                    }
                                }
                            }
                            else if($_GET['action'] == 'Cek Sejarah'){
                                $name = $_GET['namaPasien'];

                                //Mencari sejarah penyakit pasien
                                $sql_sejarah = "exec Sejarah '$name'";
                                $query_sejarah = sqlsrv_query($conn, $sql_sejarah);
                                //echo "$query_sejarah";
                                if( $query_sejarah === false) {
                                    echo "This aint it chief";
                                }
                                echo "<table>";
                                    echo "<tr>
                                               <th> Penyakit </th>
                                         </tr>";
                                while($penyakit = sqlsrv_fetch_array($query_sejarah,SQLSRV_FETCH_ASSOC)){
                                    echo "<tr>";
                                    echo '<td>'.$penyakit[0].'</td>';
                                    echo "</tr>";
                                }
                                echo "</table>";
                            }
                         }

                            ?> 
                   
                    </div>
                    
                </fieldset>
            </form>
        </div>
    </body>
</html>