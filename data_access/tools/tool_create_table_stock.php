<?
    include_once('../largeCap.php');
    include_once('../midCap.php');
    include_once('../smallCap.php');
    include_once('../firstNorth.php');
    include_once('tool_common.php');

    define("TABLE_NAME", "stock");
    define("DB_NAME", "dinAktie"); 

    function create_table()
    {
        $con = connect();

        $sql_create_query = "CREATE TABLE " . TABLE_NAME . "
                             ( isin VARCHAR(12) NOT NULL,
                               name VARCHAR(50),
                               listId INT,
                               PRIMARY KEY (isin))";
     
        if (mysql_query($sql_create_query, $con)) {
            echo "Table \"" . TABLE_NAME . "\" created<br />";
        }
        else {
            echo "Failed to create table \"" . TABLE_NAME . "\" <br/>";
        }

        mysql_close($con);
    }


    function insert_into_table($isin, $name, $listId)
    {
        $con = connect(); 
        
        $mysql_insert_query = "INSERT INTO " . TABLE_NAME .
                          " (isin, name, listId)" .
                          "VALUES ('" .
                           $isin . "','" .
                           $name . "' ,'" .
                           $listId . "');";
        
        $result = mysql_query($mysql_insert_query, $con);
        if($result)
            ;
        else {
            print("Insert Failed for " . $isin. "<br>");
            print $query . "<br>";
        }
        mysql_close($con);
    }


    function getNameForSymbol($string)
    {
        $query = "http://download.finance.yahoo.com/d/quotes.csv?s=" . $string . "&f=n";
        // create a new cURL resource
        $ch = curl_init($query);
        
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
       
        // grab URL and pass it to the browser
        $csv = curl_exec($ch);
        // close cURL resource, and free up system resources
        curl_close($ch);
        return $csv;
    }

?>

<?
    dump_table(TABLE_NAME);
    create_table();
    foreach($largeCap as $stock)
    {
        insert_into_table($stock, getNameForSymbol($stock), $largeCapId);
    }
    foreach($midCap as $stock)
    {
        insert_into_table($stock, getNameForSymbol($stock), $midCapId);
    }
    foreach($smallCap as $stock)
    {
        insert_into_table($stock, getNameForSymbol($stock), $smallCapId);
    }
    foreach($firstNorth as $stock)
    {
        insert_into_table($stock, getNameForSymbol($stock), $firstNorthId);
    }

print ("<table border=1 cellpadding=0 cellspacing=1><tr><td><b>Isin</td><td><b>Name</td><td><b>ListId</td></tr>");
    $data = select_all_from_table(TABLE_NAME);
    $tdHeader = "<td><font size=2>";
    foreach($data as $line)
    {
        print("<tr>"); 
        print($tdHeader . $line[isin] . "</td>");
        print($tdHeader . $line[name] . "</td>");
        print($tdHeader . $line[listId] . "</td>");
        print("</tr>");
    }

    print ("</tr></table>");

?>

