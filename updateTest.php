<?

    $myFile = "/var/www/dinAktie/testFile.txt";
    $fh = fopen($myFile, 'w');
    $dt =  date("H-i-s");
    echo $dt;
    fwrite($fh, $dt);
?>
