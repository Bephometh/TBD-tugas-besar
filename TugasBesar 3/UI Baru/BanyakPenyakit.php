
<html>
<?php
include ("../connection.php");
// print_r($conn);
// return;
session_start();
?>
<head>
    <title>Laporan Penyakit</title>
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
        <a href="first.php">Pasien</a>
        <a class="w3-padding" href="Histogram.php">Cek Histogram Penyakit</a>
        <a class="w3-padding" href="Histogram2.php">Cek Histogram Penyakit Sesuai Tanggal</a>
    </div>

    <form class="w3-container" method="GET" action="BanyakPenyakit.php">

        <p>Mencari Penyakit Yang Sering Muncul Pada Tanggal Tertentu</p>
        <p>
            Tanggal Awal :
            <input type="date" name="tanggalAwal" />
        </p>
        <p>
            Tanggal Akhir :
            <input type="date" name="tanggalAkhir" />
        </p>
        <input class="w3-button w3-border w3-border-red w3-round-xlarge w3-hover-red" type="submit" name="cekHasilPenyakit" value="Cek" />
    </form>




    <?php

    if(isset($_GET['cekHasilPenyakit'])){
        //ambil tgl dari input format Y-m-d
        $tglAwal = $_GET['tanggalAwal'];
        $tglAkhir = $_GET['tanggalAkhir'];

        //echo tgl
        echo "Tanggal Awal:".$tglAwal."<p>"."Tanggal Akhir:".$tglAkhir;
        $sql_banyakPenyakit = "exec PenyakitSeringMuncul '$tglAwal','$tglAkhir'";
        $hasil_banyakPenyakit = sqlsrv_query($conn,$sql_banyakPenyakit);
        if($hasil_banyakPenyakit=== false){
            echo"This ain't it cheif";
        }

        echo "<table>";
        echo "<tr>
                      <th> Penyakit </th>
                      </tr>";

        while( $row = sqlsrv_fetch_array($hasil_banyakPenyakit, SQLSRV_FETCH_NUMERIC)) {
            //array_push($penyakit, $row[0]);
            echo "<tr>";
            echo '<td>'.$row[0].'</td>';
            echo "</tr>";
        }

        echo "</table>";
    }
    ?>

</body>
</html>

