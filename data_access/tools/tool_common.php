<?
include ('/var/www/dinAktie2/dinAktie/data_access/pwd.php');
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

function dump_table($table_name)
{
    global $db_pwd;

    $con = mysql_connect("localhost","root", $db_pwd);
    mysql_select_db("dinAktie", $con);
    $sql_drop_query = "DROP TABLE " . $table_name ;
    if (mysql_query($sql_drop_query, $con))
    {
        echo "Table \"" . $table_name . "\" dropped<br />";
    }
    else
    {
        echo "Failed to drop table \"" . $table_name ."\"<br/>";
    }
    mysql_close($con);
}
function getBrokerShareForStock($symbol, $supplier, $url_date)
{
    //echo $symbol . " " . $url_date . "<br>";
    $format0 = "txt"; //space separated
    $format1 = "csv"; //comma separated
    $format2 = "sdv"; //semi colon separated
    switch($supplier)
    {
        case "netfonds":
           $query = "http://www.netfonds.se/quotes/tradedump.php?date=".$url_date."&paper=" . $symbol .
//           $query = "http://www.netfonds.se/quotes/tradedump.php?paper=" . $symbol .
                      "&csv_format=" . $format1;
            //echo $query;
            
            //time,price,quantity,board,source,buyer,seller,initiator
            $csvBlob = getOneStock($query);
            //echo $csvBlob;
            $csvLines = explode("\n", $csvBlob);
            //print_r($csvLines);           
            return $csvLines;

        break;
        default:
            die("No supplier");
        break;
    }    
}

function getDailyDataForStock($isin, $supplier)
{
    switch($supplier)
    {
        case "yahoo":
            $query ="ichart.finance.yahoo.com/table.csv?s=" . $isin;
            //print $query . "<br>";
            $csvBlob = getOneStock($query);
            //print $csvBlob . "<br>";
            $csvLines = explode("\n", $csvBlob);
            unset($csvLines[0]);
            return $csvLines;
        break;
        case "netfonds":
            $query ="http://www.netfonds.se/quotes//paperhistory.php?paper=" .
            $isin . "&csv_format=csv" ;
            $csvBlob = getOneStock($query);
            $csvLines = explode("\n", $csvBlob);
            unset($csvLines[0]);
           $data = array(); 
            foreach($csvLines as $line)
            {
                $line = explode(",", $line);
                if($line[0] != "")
                {
                    $line = $line[0] . "," .
                            $line[3] . "," .
                            $line[4] . "," .
                            $line[5] . "," .
                            $line[6] . "," .
                            $line[7] . "," .
                            $line[6] ;
            //        echo $line. "<br>";
                    $data[] .= $line;
                }
           }
        return $data;
        break;
        default:
            die("No supplier");
        break;
    }

}

function getPeriodDataForStock($isin, $from, $to)
{
 //   echo $from . " - " . $to . "<br>";
    $fromYear = substr($from, 0, 4);
    $fromMonth = intval(substr($from, 5, 2))-1;
    $fromDay = intval(substr($from, 8, 2))+1;
    $toYear = substr($to, 0, 4);
    $toMonth = intval(substr($to, 5, 2))-1;
    $toDay = substr($to, 8, 2);
 //   echo $fromYear . "<br>";
 //   echo $fromMonth . "<br>";
 //   echo $fromDay . "<br>";

    $query = "http://ichart.finance.yahoo.com/table.csv?s=" . $isin .
             "&a=". $fromMonth . "&b=".$fromDay . "&c=" . $fromYear .
             "&d=". $toMonth . "&e=" . $toDay . "&f=" . $toYear . "&g=d&ignore=.csv";

    $csvBlob = getOneStock($query);
    //print $csvBlob . "<br>";
    $csvLines = explode("\n", $csvBlob);
    unset($csvLines[0]);

    return $csvLines;
}

function getOneStock($query_input)
{
    //$query = "http://download.finance.yahoo.com/d/quotes.csv?s=" . $query_input . "&f=k1";
    // create a new cURL resource
    $ch = curl_init($query_input);
   
curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000); 
    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
   
    // grab URL and pass it to the browser
    $csv = curl_exec($ch);
    // close cURL resource, and free up system resources
    curl_close($ch);
    //print $csv;
    return $csv;
}

function select_from_table($tableName, $col_str, $match)
{
    $con = connect();
    
    if($con)
    { 
        $mysql_select_all_query = "SELECT * FROM " . $tableName .
                                  " where " . $col_str. "='".$match ."';";

        $result = mysql_query($mysql_select_all_query, $con);
        
        if ($result)
        {
            $data = array();
            while($row = mysql_fetch_array($result))
            {
                array_push($data, $row);
            }
        }
        else
        {
            echo "Failed!";
        }
        mysql_close($con);
    }   
    else
    {
        die('Could not connect: ' . mysql_error()); 
    }
    
    return $data;
}
function select_all_from_table($tableName)
{
    $con = connect();
    
    if($con)
    { 
        $mysql_select_all_query = "SELECT * FROM " . $tableName .";";
        
        $result = mysql_query($mysql_select_all_query, $con);
        
        if ($result)
        {
            $data = array();
            while($row = mysql_fetch_array($result))
            {
                array_push($data, $row);
            }
        }
        else
        {
            echo "Failed!";
        }
        mysql_close($con);
    }   
    else
    {
        die('Could not connect: ' . mysql_error()); 
    }
    
    return $data;
}

function connect()
{
    global $db_pwd;
    $con = mysql_connect("localhost","root", $db_pwd);
    if($con)
    {
        if(mysql_select_db(DB_NAME, $con))
        {
            return $con;
        }
        else
        {
            die('Could not select database: ' . mysql_error()); 
        }
    }
    else
    {
        die('Could not connect: ' . mysql_error()); 
    }
}

?>
