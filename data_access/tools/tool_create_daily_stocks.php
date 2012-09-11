
<?

set_include_path("/var/www/dinAktie/data_access");
include_once ('../largeCap.php');
include_once ('../midCap.php');
include_once ('../smallCap.php');
include_once ('../indexList.php');
include_once('tool_common.php');
include_once('tool_synchronizer.php');

define("TABLE_NAME", "daily");
define("DB_NAME", "dinAktie"); 

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


function insert_into_table($isin, $date, $high, $low, $open, $close, $volume)
{
    $con = connect(); 
   if($date == date("0000-00-00"))
    {
        echo "Something is seriously fucked up<br><br>";
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
    if($result)
        ;
    else
        print("Insert Failed: " . mysql_error() . "<br>\n");
    mysql_close($con);
}

ini_set('memory_limit', '96M'); 

function init($list)
{  
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

function read()
{
    return select_all_from_table(TABLE_NAME);
}
function fromYahooDate($date)
{
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



function updateDay($list, $date)
{
    $url = "http://download.finance.yahoo.com/d/quotes.csv?s=";
    $format = "&f=";
    $formatParams = "d1ohgl1v";
    $symbols = "";
    foreach($list as $symbol)
    {
        $symbolCollection[] = $symbol;
        $symbols .= $symbol;
        $symbols .= "+";
    }
    $symbols = trim($symbols, "+");

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
        }
        else
        {
            echo "Missing data for " . $symbolCollection[$i] .  ". Please check!\n<br>";    
        }
        $i++;
    } 
}   

function checkData($line)
{
    foreach($line as $cell)
    {
        if($cell == "N/A")
            return false;
    }
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
                 insert_into_table($symbolCollection[$i], date($cells[0]), $cells[2], $cells[3], $cells[1], $cells[4], $cells[5]);
            }
       }
       $i++;
   }
}  
//    $tableData = read();
//    foreach($tableData as $line)
//    {
//        print $line[isin] . "-" . $line[date] . "-" . $line[close] . "<br>";
//    }    
           
echo "<html>
    <head>
        <title>dinAktie.se</title>
        <link href=\"presentation/basic.css\" rel=\"stylesheet\" type=\"text/css\">
    </head>
    <body>
";
function fillDaily($list)
{
    $time_start = microtime(true);
    $default = ini_get('max_execution_time');
    set_time_limit(1000);

    init($list);

    set_time_limit($default);
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    echo $time . "<br>";
}
switch($_GET['action'])
{
    case "dumpTable":
        dump_table();
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
    case "index":
        fillDaily($index);
    break;
    case "all":
        fillDaily($smallCap);
        fillDaily($midCap);
        fillDaily($largeCap);
        fillDaily($index);
    break;
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
echo "Done<br>";
?>
</body>
</html>
