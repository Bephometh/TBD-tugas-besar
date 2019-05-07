<html>
<?php
    include ("../connection.php");
    // print_r($conn);
    // return;
    session_start();
?>
    <head>
        <title>Diagnosis 2</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
            <a href="">Cek Histogram</a>
        </div>

        <div class="w3-content w3-center w3-large">
            <p>Apa saja Gejala mu?</p>
        </div>

        <div class="w3-container w3-padding" style="height:80%">
           <?php
                                //Menghitung nama gejala
                                $sql_num_of_gejala = "SELECT COUNT(Gejala.idGejala) FROM Gejala";
                                $num_of_gejala = sqlsrv_query($conn,$sql_num_of_gejala);
                                $number = sqlsrv_fetch_array($num_of_gejala,  SQLSRV_FETCH_NUMERIC);
                    
                                //Mempartisi jumlah gejala menjadi 3
                                $part1 =  floor($number[0] / 3);
                                $part2 = $number[0] - ($part1+1);
                                $part3 = $number[0] ;
                                $j = 0;

                               
                               
                                
                                //query nama gejala
                                $sql_nama_gejala = "SELECT Gejala.namaGejala FROM Gejala";
                                $hasil_nama_gejala = sqlsrv_query($conn,$sql_nama_gejala);

                              
                                //Memasukkan hasil query ke array
                                $row1 = array();
                                while( $row = sqlsrv_fetch_array(  $hasil_nama_gejala, SQLSRV_FETCH_NUMERIC) ) {
                                    array_push($row1, $row[0]);
                                }

           ?>
            <form method="GET" action="Second.php">
                <fieldset class="w3-content w3-padding" style="width:40%">
                    <legend>Gejala</legend>
                    <div style="padding-left: 10%; padding-top:2%;">
                        Gejala 1 : 
                        <select name="gej1" id="gj1" style="width:60% ">
                            <?php
                                 //Populate select
                                for($j = 0; $j < $part1; $j++){
                                        echo '<option value="'.$row1[$j].'">'.$row1[$j].'</option>';
                                }
                              
                            ?>
                          
                        </select>
                        <p>
                        Gejala 2 :
                        <select name="gej2" id="gj2" style="width:60% ">
                             <?php
                                //Populate select
                                for($j = $part1+1; $j < $part2; $j++){
                                        echo '<option value="'.$row1[$j].'">'.$row1[$j].'</option>';
                                }
                            ?>
                        </select>
                        <p>
                        Gejala 3 :
                        <select name="gej3" id="gj3" style="width:60% ">
                            <?php
                                //Populate select
                                for($j = $part2+1; $j < $part3; $j++){
                                        echo '<option value="'.$row1[$j].'">'.$row1[$j].'</option>';
                                } 
                            ?>
                        </select>
                        
                        <p>
                            <input class="w3-button w3-border w3-border-red w3-round-xlarge w3-hover-red" type="submit" name="action" value="Kembali">
                            <input class="w3-button w3-border w3-border-red w3-round-xlarge w3-hover-red" type="submit" name="action" value="Cek">
                        </p>
                        <?php 
                            if(isset($_GET['action'])){
        
                                //Go back one page
                                if($_GET['action'] == 'Kembali'){
                                    header('Location:first.php');    
                                }
                                //Check Diagnose
                                else if($_GET['action'] == 'Cek'){
                                    //Memasukkan Value ke table checkup
                                    $date_now  = date("Ymd H:i:s A");
                                    $sql_checkUp = "INSERT INTO CheckUp VALUES ('$date_now')";
                                    $query_checkUp = sqlsrv_query($conn, $sql_checkUp);

                                    //Mendapatkan idCheckUp
                                    $sql_idCheckUp = "SELECT idCheckUp FROM CheckUp WHERE Tanggal = '$date_now' ";
                                    $query_idCheckUp = sqlsrv_query($conn,$sql_idCheckUp);
                                    if( sqlsrv_fetch( $query_idCheckUp ) === false) {
                                         echo"id check up tidak ditemukan."."</br>";
                                    }

                                    $idCheckUp = sqlsrv_get_field($query_idCheckUp,0);
                                    //Mendapatkan id pasien
                                    $nama = $_SESSION['namaPasien'];
                                    $sql_idPasien = "SELECT idPasien FROM Pasien WHERE namaPasien = '$nama' ";
                                    $quer_idPasien = sqlsrv_query($conn, $sql_idPasien);
                                    if( sqlsrv_fetch( $quer_idPasien ) === false) {
                                         echo"id pasien tidak dietmukan."."</br>";
                                    }

                                    $idPasien = sqlsrv_get_field($quer_idPasien,0);
                                    //Memasukkan data ke dalam tabel hasil
                                    $sql_insertHasil = "INSERT INTO Hasil VALUES ($idPasien, $idCheckUp)";
                                    $query_insertHasil = sqlsrv_query($conn, $sql_insertHasil);


                                    //Menyimpan gejala yang dialami
                                    $gejala1 = $_GET['gej1'];
                                    $gejala2 = $_GET['gej2'];
                                    $gejala3 = $_GET['gej3'];

                                    //Mencari id dari gejala2 yang dialami
                                    $sql_gej1 = "SELECT idGejala FROM Gejala WHERE namaGejala = '$gejala1'";
                                    $sql_gej2 = "SELECT idGejala FROM Gejala WHERE namaGejala = '$gejala2'";
                                    $sql_gej3 = "SELECT idGejala FROM Gejala WHERE namaGejala = '$gejala3'";
                                    //gejala 1
                                    $query_gej1 = sqlsrv_query($conn, $sql_gej1);
                                    if( sqlsrv_fetch( $query_gej1 ) === false) {
                                         echo"id gejala tidak dietmukan.";
                                    }

                                    $idGejala1 = sqlsrv_get_field($query_gej1,0);

                                    //gejala2
                                     $query_gej2 = sqlsrv_query($conn, $sql_gej2);
                                    if( sqlsrv_fetch( $query_gej2 ) === false) {
                                         echo"id gejala tidak dietmukan.";
                                    }

                                    $idGejala2 = sqlsrv_get_field($query_gej2,0);

                                    //gejala 3
                                     $query_gej3 = sqlsrv_query($conn, $sql_gej3);
                                    if( sqlsrv_fetch( $query_gej3 ) === false) {
                                         echo"id gejala tidak dietmukan.";
                                    }

                                    $idGejala3 = sqlsrv_get_field($query_gej3,0);
                                   //Memasukkan id gejala kedalam array
                                    $idGejala = array();
                                    array_push($idGejala, $idGejala1,$idGejala2,$idGejala3);



                                    //Memasukkan ke dalam table record
                                    $length = sizeof($idGejala);

                                    for($i = 0; $i < $length; $i++){
                                        $sql_insertRecord  = "exec insRoundRobinGejala $idCheckUp, $idGejala[$i] ";
                                        sqlsrv_query($conn, $sql_insertRecord);
                                    }

                                    //Mencari penyakit yang dialami pasien
                                    $sql_diagnos = "exec Diag $idCheckUp";
                                    $query_diagnosis = sqlsrv_query($conn, $sql_diagnos);
                                    if( $query_diagnosis === false) {
                                        echo "This aint it chief";
                                    }
           
         
                                    echo "<table>";
                                    echo "<tr>
                                               <th> Penyakit </th>
                                         </tr>";
            
                                    while( $row = sqlsrv_fetch_array(  $query_diagnosis, SQLSRV_FETCH_NUMERIC) ) {
                                        //array_push($penyakit, $row[0]);
                                         echo "<tr>";
                                         echo '<td>'.$row[0].'</td>';
                                         echo "</tr>";
                                    }
         
                                    echo "</table>";
                                }
        
                            }
                            else{
                            }
    

                        ?>    
                    </div>
                </fieldset>
            </form>
        </div>
    </body>
</html>

