<html>
<?php
    include ("../connection.php");
    // print_r($conn);
    // return;
    session_start();
?>
    <head>
        <title>Laporan</title>
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
            <a href="">Cek Histogram</a>
        </div>

        <div  class="w3-container w3-display-container">
            <br>
            <input onclick="btnHisto4()" class="w3-button w3-border w3-border-red w3-round-xlarge w3-hover-red" type="submit" name="action" id="buttonHisto1" value="Histogram Penyakit">
        </div>
        <br>

        <!--buat graph-->
        <div class="w3-hide" id="chartContainer" style="height: 370px; width: 100%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
    </body>
</html>

        <?php
        $sql_histo4 = "exec histo4";
        $hasil_histo4 = sqlsrv_query($conn,$sql_histo4);
        $hasil = [];
        while($row = sqlsrv_fetch_array($hasil_histo4, SQLSRV_FETCH_NUMERIC))
            $hasil[] = $row;
    ?>
<script type="text/javascript">
    window.onload = function () {
    
    var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light1", // "light2", "dark1", "dark2"
        animationEnabled: false, // change to true		
        title:{
            text: "Basic Column Chart"
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
        function btnHisto4(){
            var x = document.getElementById("chartContainer");
            x.className = "w3-show";
        }
    </script>