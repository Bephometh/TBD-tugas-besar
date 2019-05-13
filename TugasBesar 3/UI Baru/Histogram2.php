<<<<<<< HEAD
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
        </div>

        <form class="w3-container" method="GET" action="Histogram2.php">
            <p>Tanggal Awal : <input type="date" name="tanggalAwal"></p>
            <p>Tanggal Akhir : <input type="date" name="tanggalAkhir"></p>
            <input onclick="btnCek()" class="w3-button w3-border w3-border-red w3-round-xlarge w3-hover-red" type="submit" name="cekHasil" value="Cek">
        </form>
        
        <?php
            if (isset($_GET['cekHasil'])){
                //ambil tgl dari input format Y-m-d
                $tglAwal = $_GET['tanggalAwal'];
                $tglAkhir = $_GET['tanggalAkhir'];

                //echo tgl
                echo "Tanggal Awal:".$tglAwal."<p>"."Tanggal Akhir:".$tglAkhir;
                $sql_histo3 = "exec Histogr '$tglAwal','$tglAkhir'";
                $hasil_histo3 = sqlsrv_query($conn,$sql_histo3);
                if($hasil_histo3 === false){
                    echo"This ain't it cheif";
                }
                //hasil nya ga keluar, pdhl parameter exec udh sama
                //tipe data di sql "DateTime"
                //tipe data di html "date"
                $hasil = [];
                while($row = sqlsrv_fetch_array($hasil_histo3, SQLSRV_FETCH_NUMERIC)){
                    $hasil[] = $row;
                   // var_dump($row[0],$row[1]);
                    //echo $row[0]."<br>";
                    //echo $row[1];
                }
                
            }
        ?>

        <!--buat graph-->
        <div class="w3-show w3-content" id="chartContainer" style="height: 370px; width: 100%; margin-top:2%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
    </body>
</html>

    

    <script type="text/javascript">

        window.onload = function () {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light1", // "light2", "dark1", "dark2"
            animationEnabled: false, // change to true		
            title:{
                text: "Banyak Penyakit Pada Tanggal Tertentu"
            },
            data: [
            {
                // Change type to "bar", "area", "spline", "pie",etc.
            
                type: "column",
                dataPoints: <?= json_encode(array_values(array_map(function($data) {
                    return [
                        "label" => $data[0],
                        "y"=> $data[1]
                    ];
                }, $hasil)));?>
                
            }
            ]
        });
        chart.render();
        
        }

        function btnCek(){
            var x = document.getElementById(chartContainer);
            x.className = "w3-show";
        }
    </script>
=======
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
        </div>

        <form class="w3-container" method="GET" action="Histogram2.php">
            <p>Tanggal Awal : <input type="date" name="tanggalAwal"></p>
            <p>Tanggal Akhir : <input type="date" name="tanggalAkhir"></p>
            <input onclick="btnCek()" class="w3-button w3-border w3-border-red w3-round-xlarge w3-hover-red" type="submit" name="cekHasil" value="Cek">
        </form>
        
        <?php
            if (isset($_GET['cekHasil'])){
                //ambil tgl dari input format Y-m-d
                $tglAwal = $_GET['tanggalAwal'];
                $tglAkhir = $_GET['tanggalAkhir'];

                //echo tgl
                echo "Tanggal Awal:".$tglAwal."<p>"."Tanggal Akhir:".$tglAkhir;
                $sql_histo3 = "exec Histogr '$tglAwal','$tglAkhir'";
                $hasil_histo3 = sqlsrv_query($conn,$sql_histo3);
                //hasil nya ga keluar, pdhl parameter exec udh sama
                //tipe data di sql "DateTime"
                //tipe data di html "date"
                $hasil = [];
                while($row = sqlsrv_fetch_array($hasil_histo3, SQLSRV_FETCH_ASSOC)){
                    $hasil[] = $row;
                    echo $row[0]."<br>";
                }
                
            }
        ?>

        <!--buat graph-->
        <div class="w3-show w3-content" id="chartContainer" style="height: 370px; width: 100%; margin-top:2%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
    </body>
</html>

    

    <script type="text/javascript">

        window.onload = function () {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light1", // "light2", "dark1", "dark2"
            animationEnabled: false, // change to true		
            title:{
                text: "Banyak Penyakit Pada Tanggal Tertentu"
            },
            data: [
            {
                // Change type to "bar", "area", "spline", "pie",etc.
            
                type: "column",
                dataPoints: <?= json_encode(array_values(array_map(function($data) {
                    return [
                        "label" => $data[0],
                        "y"=> $data[1]
                    ];
                }, $hasil)));?>
                
            }
            ]
        });
        chart.render();
        
        }

        function btnCek(){
            var x = document.getElementById(chartContainer);
            x.className = "w3-show";
        }
    </script>
>>>>>>> 7d740d97db00be25fb168aaaf1f1276766819d19
