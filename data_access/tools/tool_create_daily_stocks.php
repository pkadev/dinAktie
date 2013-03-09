
<?

include_once ('../largeCap.php');
include_once ('../midCap.php');
include_once ('../smallCap.php');
include_once ('../indexList.php');
include_once ('../firstNorth.php');
include_once('tool_common.php');
include_once('tool_synchronizer.php');
include_once('../../presentation/error_reporter.php');

define("DB_NAME", "dinAktie"); 

define("TABLE_NAME", "daily");
define("TABLE_NAME_BROKER_SHARE", "broker_share");

function create_table()
{
    $con = connect();

    $sql_create_query = "CREATE TABLE " . TABLE_NAME . "
                         (  isin VARCHAR(12) NOT NULL,
                            date DATE,
                            high FLOAT,
                            low  FLOAT,
                            open FLOAT,
                            close FLOAT, 
                            volume BIGINT,
                            PRIMARY KEY (isin, date))";
 
    if (mysql_query($sql_create_query, $con)) {
        echo "Table \"" . TABLE_NAME . "\" created<br />";
    }
    else {
        echo "Failed to create table \"" . TABLE_NAME . "\" <br/>";
        echo mysql_error();
    }

    mysql_close($con);
}

function create_table_broker_share()
{
    $con = connect();

    $sql_create_query = "CREATE TABLE " . TABLE_NAME_BROKER_SHARE . "
                         (
                            id INT NOT NULL AUTO_INCREMENT,
                            symbol VARCHAR(12) NOT NULL,
                            date DATE NOT NULL,
                            buy_volume BIGINT NOT NULL,
                            sell_volume BIGINT NOT NULL,
                            broker VARCHAR(10),
                            PRIMARY KEY (id)
                         )";
 
    if (mysql_query($sql_create_query, $con)) {
        echo "Table \"" . TABLE_NAME_BROKER_SHARE . "\" created<br />";
    }
    else {
        echo "Failed to create table \"" . TABLE_NAME_BROKER_SHARE . "\" <br/>";
        echo mysql_error();
    }

    mysql_close($con);
}

function insert_into_broker_share($symbol, $date, $buy_volume, $sell_volume, $broker)
{
    $con = connect(); 
    $mysql_insert_query = "INSERT INTO " . TABLE_NAME_BROKER_SHARE .
                      " (symbol, date, buy_volume, sell_volume, broker)" .
                      "VALUES ('" .
                       $symbol . "','" .
                       $date . "','" .
                       $buy_volume . "','" .
                       $sell_volume . "','" .
                       $broker . "');";
    $result = mysql_query($mysql_insert_query, $con);
    //print $query;
    if(!isset($result))
        print("Insert Failed: " . mysql_error() . "<br>\n");
    mysql_close($con);
}

function insert_into_table($isin, $date, $high, $low, $open, $close, $volume)
{
    $con = connect(); 
    if(strcmp($date, "0000-00-00") == 0)
    {
        echo "Something is seriously wrong with this data!<br><br>";
    }
    $mysql_insert_query = "INSERT INTO " . TABLE_NAME .
                      " (isin, date, high, low, open, close, volume)" .
                      "VALUES ('" .
                       $isin . "','" .
                       $date . "','" .
                       $high . "','" .
                       $low  . "','" .
                       $open . "','" .
                       $close . "','" .
                       $volume . "');";
    $result = mysql_query($mysql_insert_query, $con);
    //print $query;
    if(!isset($result))
        print("Insert Failed: " . mysql_error() . "<br>\n");
    mysql_close($con);
}

ini_set('memory_limit', '96M'); 

function init($list)
{  
    echo "function init()";
    $stockDataLines = array();
    
    foreach($list as $symbol)
    {
        $dataCollection[] = getDailyDataForStock($symbol, "netfonds");
        $symbolCollection[] = $symbol;
    }
    
    print count($dataCollection) . "<br>";
    $i = 0;
    foreach($dataCollection as $stockData)
    {
        foreach($stockData as $data)
        {
            $cells = explode(",", $data);
            //if($cells[0] != "")
            {   
                  //  echo $symbolCollection[$i]. "|" . date($cells[0]). "|" .  $cells[2]."|" .
                  //                $cells[3]."|" . $cells[1]."|" . $cells[4]."|" . $cells[5]. "<br>";
                insert_into_table($symbolCollection[$i], date($cells[0]), $cells[2],
                                 $cells[3], $cells[1], $cells[4], $cells[5]);
            }
           // else
           // {
           //     echo "Null date<br>";
           // }
        }
        $i++;
    }
}  

function fromYahooDate($date)
{
    //echo "function fromYahooDate() <br>";
    $month = substr($date, 0, strpos($date, "/"));
    if($month < 10)
        $month = 0 . $month;
    
    $date = substr($date, strpos($date, "/")+1);
    $day = substr($date, 0, strpos($date, "/"));
    if($day < 10)
        $day = 0 . $day; 
    
    $year = substr($date, strpos($date, "/")+1);
    
    return $year . "-" . $month . "-" . $day;
}

function print_admin_fill_database_links()
{
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=dumpTable\">Dump table</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=createTable\">Create table</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=large\">Large</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=mid\">mid</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=small\">small</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=firstNorth\">firstNorth</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=index\">index</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=all\">all</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=updateDay\">updateDay</a><br>";
echo "<br>Statistik<br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=dumpTableBrokerShare\">Dump table - Broker Share</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=createTableBrokerShare\">Create table - Broker Share</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=broker_share\">Broker share</a><br>";
    echo "<a class=\"searchHits\" href=\"".$_SELF['url'] .
         "?action=broker_history\">Broker history</a><br>";
}

function updateDay($list, $date)
{
    echo "function updateDay() <br>";
    //print_r($list);
    if (count($list) == 0) {
        Error::Create("Bad input parameters in updateDay()");
    }

    $url = "http://download.finance.yahoo.com/d/quotes.csv?s=";
    $format = "&f=";
    $formatParams = "d1ohgl1v";
    $symbols = "";
//static function generate_symbol_string() {
    foreach($list as $symbol)
    {
        $symbolCollection[] = $symbol;
        $symbols .= $symbol;
        $symbols .= "+";
    }
    $symbols = trim($symbols, "+");
//}
    $curl_query = $url . $symbols . $format . $formatParams;
    $csvBlob = getOneStock($curl_query);
    $csvBlob = trim($csvBlob);
    $csvLines = explode("\n", $csvBlob);
    $cells = array();
    $i = 0;
    foreach($csvLines as $line)
    {
        $cells = explode(",", $line);
        $cells[0] =  trim($cells[0], "\"");
        $cells[0] = fromYahooDate($cells[0]);
        if(checkData($cells))
        {
            insert_into_table($symbolCollection[$i], date($cells[0]),
                              $cells[2], $cells[3], $cells[1],
                              $cells[4], $cells[5]);
        } else {
            echo "Missing data for " . $symbolCollection[$i] .  ". Please check with ".
            $url . $symbolCollection[$i] . $format . $formatParams ."\n<br>";    
        }
        $i++;
    } 
}   

function checkData($columns)
{
    //echo "function checkData() <br>";
    //echo "Number of Cells: " . count($columns) ."<br>";
    $i = 0;
    $hasNA = false;
    $hasClose = false;
    foreach($columns as $column)
    {
        if($column == "N/A") {
            $hasNA = true;
            //return false;
        }
        if ($i == 4 && $hasNA) {
            echo $column;
            if ($column > 0)
                echo "Create database row<br>";
        }
        $i++;
    }
    if ($hasNA)
        return false;
    return true; 
}

function initPeriod($list)
{  
    $stockDataLines = array();
    
    $sync = new Synchronizer();
    foreach($list as $symbol)
    {
        $lastRecordedDate = $sync->LastRecordedDate($symbol);
        $today = date("Y-m-d");
        $dataCollection[] = getPeriodDataForStock($symbol, $lastRecordedDate , $today);
        $symbolCollection[] = $symbol;
    }
    
    print count($dataCollection) . "<br>";
    
    $i = 0;
    foreach($dataCollection as $stockData)
    {
        foreach($stockData as $data)
        {
            $cells = explode(",", $data);
    
            if($cells[0] != "")
            {
                 insert_into_table($symbolCollection[$i], date($cells[0]),
                                   $cells[2], $cells[3], $cells[1],
                                   $cells[4], $cells[5]);
            }
       }
       $i++;
   }
}  

function read()
{
    echo "function read() <br>";
    return select_all_from_table(TABLE_NAME);
}

//    $tableData = read();
//    foreach($tableData as $line)
//    {
//        print $line[isin] . "-" . $line[date] . "-" . $line[close] . "<br>";
//    }    
           
echo "<!DOCTYPE html><html>
    <head>
        <title>dinAktie.se</title>
        <link href=\"../../presentation/basic.css\" rel=\"stylesheet\" type=\"text/css\">
    </head>
    <body>
";

function fillDaily($list)
{
    echo "function fillDaily()";
    $time_start = microtime(true);
    $default = ini_get('max_execution_time');
    set_time_limit(1000);

    init($list);

    set_time_limit($default);
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    echo $time . "<br>";
}

function create_mysql_date($netfonds_date_time)
{

define("LENGHT_OF_DATETIME_STR", "15"); 

    if(strlen($netfonds_date_time) != LENGHT_OF_DATETIME_STR)
        die("Wrong length in date_time");
    $date_time = explode("T", $netfonds_date_time);

    $date = substr($date_time[0], 0, 4) . "-" .
            substr($date_time[0], 4, 2) . "-" .
            substr($date_time[0], 6, 2) . " ";

    //$date .= substr($date_time[1], 0, 2). ":" .
    //         substr($date_time[1], 2, 2). ":" .
    //         substr($date_time[1], 2, 2);
    return $date;
}

function getAllBrokers($row)
{
    $brokers = array();
    
    for($j = 1; $j < count($row)-1; $j++)
    {
        $cols = explode(",", $row[$j]);

        if(!in_array($cols[5], $brokers)) {
            array_push($brokers, $cols[5]);
        }
        if(!in_array($cols[6], $brokers)) {
            array_push($brokers, $cols[6]);
        }
    }
    
    return $brokers;
}
function redirect($loc){
    echo "<script>window.location.href='".$loc."'</script>";
}
function getBrokerShare($list)
{
    $time_start = microtime(true);
    $default = ini_get('max_execution_time');
    set_time_limit(1000);
    //echo "getBrokerShare<br>";

    foreach($list as $symbol)
    {
        //echo $symbol;
        //echo "<br>";
        
        $dataCol = getBrokerShareForStock($symbol, "netfonds");
        
        $broker_list = getAllBrokers($dataCol);

        //$symbolCollection[] = $symbol;
        foreach($broker_list as $broker)
        {
            $buy_volume = 0;
            $sell_volume = 0;
            

            for($j = 1; $j < count($dataCol)-1; $j++)
            {
                $cols = explode(",", $dataCol[$j]); 
                $date = create_mysql_date($cols[0]);
                
                if($broker == $cols[5]) {
                    $buy_volume += $cols[2]; 
                }
                if($broker == $cols[6]) {
                // echo $cols[2] . "<br>";
                    $sell_volume += $cols[2]; 
                }
                //echo $datetime . "<br>";
                //print_r($cols); echo "<br>";
                //                         $cols[4], $cols[5], $cols[6], $cols[7]);
                
            }
            echo "Broker: " . $broker . ": " . $buy_volume . " - " . $sell_volume . "<br>";
                insert_into_broker_share($symbol, $date, $buy_volume, $sell_volume, $broker);
                
        }
//        redirect('tool_create_daily_stocks.php?cnt=' . $list[1]);
    }
    //$table_data = select_all_from_table(TABLE_NAME_BROKER_SHARE); 
    ////print(count($table_data[0]));
    //foreach($table_data as $row) {
    //    print_r ($row);
    //    echo "<br>";
    //}

    set_time_limit($default);
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    echo $time . "<br>";
}

switch($_GET['action'])
{/*
    case "dumpTable":
        dump_table(TABLE_NAME);
    break;
    case "createTable":
        create_table();
    break;
    case "large":
        fillDaily($largeCap);
    break;
    case "mid":
        fillDaily($midCap);
    break;
    case "small":
        fillDaily($smallCap);
    break;
    case "firstNorth":
        print_r($firstNorth);
        fillDaily($firstNorth);
    break;
    case "index":
        fillDaily($index);
        echo "Filling index";
        print_r($index);
    break;
    case "all":
        fillDaily($index);
        fillDaily($smallCap);
        fillDaily($midCap);
        fillDaily($largeCap);
        fillDaily($firstNorth);
    break;
    case "updateDay":
        updateDay($largeCap, "2011-12-28");
        updateDay($midCap, "2011-12-28");
        updateDay($smallCap, "2011-12-28");
        updateDay($firstNorth, "2011-12-28");
        echo "Updating missing days<br>";
    break;*/
    case "broker_share":
        getBrokerShare($largeCap);
        getBrokerShare($midCap);
        getBrokerShare($smallCap);
        getBrokerShare($firstNorth);
    break;
/*
    case "broker_history":
        echo "Nothing to be done for broker_history<br>";
    break;
    case "createTableBrokerShare":
        create_table_broker_share();
    break;
    case "dumpTableBrokerShare":
        dump_table(TABLE_NAME_BROKER_SHARE);
    break;
*/    
    default:
        echo "<font color=red>Did not do anything<br></font>";
}

//$smallList = array("ERIC-A.ST", "ERIC-B.ST");

//initPeriod($largeCap);

//updateDay($largeCap, "2011-12-28");



//$part1 = array_slice($largeCap, 0, 10);
//init($part1);
//$part1 = array_slice($largeCap, 10, 10);
//init($part1);
//$part1 = array_slice($largeCap, 20, 10);
//init($part1);
//$part1 = array_slice($largeCap, 30, 10);
//init($part1);
//$part1 = array_slice($largeCap, 40, 10);
//init($part1);
//$part1 = array_slice($largeCap, 50, 10);
//init($part1);
//$part1 = array_slice($largeCap, 60, 10);
//init($part1);

//$part1 = array_slice($largeCap, 70, 10);
//init($part1);

//print_admin_fill_database_links();
echo "Done<br>";
?>
</body>
</html>
