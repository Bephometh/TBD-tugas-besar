<?php
    $servername = "(localdb)\MSSQLLocalDB";
    $connectioninfo = array("Databasae"=>"master");

    $conn = sqlrv_connect($servername, $connectioninfo);
?>