<?


include ('data_access/tools/tool_common.php');

function getData($list, $date)
{
    $url = "http://download.finance.yahoo.com/d/quotes.csv?s=";
    $format = "&f=";
    $formatParams = "k1";
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
        
       
            echo $symbol . "<br>";
            echo $cells[0] . "<br>";
           // insert_into_table($symbolCollection[$i], date($cells[0]),
           //                   $cells[2], $cells[3], $cells[1],
           //                   $cells[4], $cells[5]);
      
     
    
   
  
        $i++;
    } 
}   
$stockList = array("VRG-B.ST");
getData($stockList, "2012-01-17");

?>
