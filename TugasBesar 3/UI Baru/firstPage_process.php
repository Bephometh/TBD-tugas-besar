<?php
if($_GET['action'] == 'Daftar'){
    //insert datanya
    if(isset($_GET['nama'])){
        $nama = $_GET['nama'];
        $sql_insert = "INSERT INTO Pasien (namaPasien) VALUES ('$nama')";
        $in = sqlsrv_query($conn,$insertPasien);
        echo 'Berharsil terdaftar';
    }
    else{
        echo 'Masukkan Nama';
    }

}
else if($_GET['action'] == 'Lanjut'){
    //cek ke server ada/tidak
    //jika ada lanjut ke halaman 2
    //jika tidak keluarkan echo harus daftar
    if(isset($_GET['nama'])){
        $name = $_GET["nama"];

        $sql ="SELECT namaPasien FROM Pasien WHERE namaPasien = '$name'";
        //echo $sql;
        $try = sqlsrv_query($conn,$sql);

        while($row = sqlsrv_fetch_array($try,SQLSRV_FETCH_ASSOC)){
            if($row['namaPasien'] != NULL){
                echo 'sudah terdaftar';
                header("Location:second.html");
            }
            else if($row['namaPasien'] == NULL){
                echo 'belum terdaftar';
            }
        }
    }
    echo 'TBD';
}

?>