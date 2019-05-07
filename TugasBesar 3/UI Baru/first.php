<html>
<?php
    include ("../connection.php");
    // print_r($conn);
    // return;
    session_start();
?>
    <title>Diagnosis 1</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <body>
        <div class="w3-container w3-display-container w3-black w3-padding">
            <h1>Diagnosis</h1>
        </div>

        <div class="w3-container w3-display-container w3-red w3-padding">
            <a href="">Cek Histogram</a>
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
                   <?php

                         if(isset($_GET['action'])){
                            if($_GET['action'] == 'Daftar'){
                                //insert datanya
                                if(empty($_GET['namaPasien'])){
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
                                            echo 'Sudah terdaftar';    
                                        }
                                        else{
                                             $insertPasien = "INSERT INTO Pasien (namaPasien) VALUES ('$namaBaru')";
                                             $in = sqlsrv_query($conn,$insertPasien);
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
                                             echo"Belum Terdaftar";    
                                        }
                                    }
                                }
                            }
                         }
    
                     ?> 
                   
                    </div>
                    
                </fieldset>
            </form>
        </div>

        <div class="w3-container w3-padding w3-center">
            <p>buat nampilin pasien jika belum terdaftar</p>
            <!--
                buat nampilin kalau pasien belum terdaftar
            -->
        </div>
    </body>
</html>

<!--
<php>
    function btnDL(){
        // 1.cek nama pasien sudah ada di DB / belum
        // 2. jika ada lanjutkan ke second.html
        // 3. jika tidak ada tampilkan "Nama tidak ditemukan, Daftarkan terlebih dahulu"
    }
</php>
-->