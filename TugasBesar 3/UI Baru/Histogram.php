<<<<<<< HEAD
<html>
<?php
    include ("../connection.php");
    // print_r($conn);
    // return;
    session_start();
?>
    <head>
        <title>Laporan Gejala</title>
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
            <a class="w3-padding" href="Histogram2.php">Cek Histogram Sesuai Tanggal</a>
        </div>

        <!--buat graph-->
        <div class="w3-show w3-content" id="chartContainer" style="height: 370px; width: 100%; margin-top:2%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
    </body>
</html>

    <?php
        //histogram4
        $sql_histo4 = "exec histo4";
        $hasil_histo4 = sqlsrv_query($conn,$sql_histo4);
        $hasil = [];
        while($row = sqlsrv_fetch_array($hasil_histo4, SQLSRV_FETCH_NUMERIC)){
            $hasil[] = $row;

        }
    ?>

    <script type="text/javascript">
        

        window.onload = function () {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light1", // "light2", "dark1", "dark2"
            animationEnabled: false, // change to true		
            title:{
                text: "Gejala Yang Muncul"
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
    </script>
        
   
    <script>
        //Fungsi untuk histogram banyak penyakit
        function btnHisto4(){
            var x = document.getElementById("chartContainer");
            x.className = "w3-show";
        }

=======
<html>
<?php
    include ("../connection.php");
    // print_r($conn);
    // return;
    session_start();
?>
    <head>
        <title>Laporan Gejala</title>
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
            <a class="w3-padding" href="Histogram2.php">Cek Histogram Sesuai Tanggal</a>
        </div>

        <!--buat graph-->
        <div class="w3-show w3-content" id="chartContainer" style="height: 370px; width: 100%; margin-top:2%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
    </body>
</html>

    <?php
        //histogram4
        $sql_histo4 = "exec histo4";
        $hasil_histo4 = sqlsrv_query($conn,$sql_histo4);
        $hasil = [];
        while($row = sqlsrv_fetch_array($hasil_histo4, SQLSRV_FETCH_NUMERIC)){
            $hasil[] = $row;
            echo $row[0].",";

        }
    ?>

    <script type="text/javascript">
        

        window.onload = function () {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light1", // "light2", "dark1", "dark2"
            animationEnabled: false, // change to true		
            title:{
                text: "Gejala Yang Muncul"
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
    </script>
        
   
    <script>
        //Fungsi untuk histogram banyak penyakit
        function btnHisto4(){
            var x = document.getElementById("chartContainer");
            x.className = "w3-show";
        }

>>>>>>> 7d740d97db00be25fb168aaaf1f1276766819d19
    </script>