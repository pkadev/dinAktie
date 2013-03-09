<?
include_once('/var/www/dinAktie2/dinAktie/data_access/brokers.php');
  set_include_path("/var/www/dinAktie2/dinAktie/data_access");
include_once('datamapper/BrokerShareRepository.php');
function draw_broker_share($symbol)
{
    
    $to = date("Y-m-d");
    //$from = "2013-03-01";
    global $broker_list;
    echo "<div style=\"border:0px dotted black; position:absolute;
          top:130px; height:410px; left:20%; right:20% \">";

    $brokerShareRepository = new BrokerShareRepository(); 
    $from = $brokerShareRepository->FindOldestDate($symbol);
    $to = $brokerShareRepository->FindNewestDate($symbol);

    echo "<p style=\"color:#E2491D; font-size:1.1em;\">Broker statistics for "
         . $symbol . "<br>\n" . /* $rangeStart*/ $from . " to " . /* $rangeStop*/ $to ."<br></p>";

    //echo "<img src=\"plot.png\" class=\"post-body\" style=\"margin-top:10px;
    //      text-align:center\">";
 
    //Check that stock is in one of the lists
    $broker_share = $brokerShareRepository->FindByIsin($symbol, $from, $to);
    $all_brokers = array_merge($broker_share['sum_bought'], $broker_share['sum_sold']);
    //echo $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    //foreach(array_keys($_GET) as $key => $a) {
    //    $val = $_GET[$a];
    //    //echo $val;
    //    $a .= "="; 
    //    $a .= $val;
    //    $a .= "&";
    //    echo $a;
    //    
    //}

    if ($_SESSION['sort'] == "ASC")
        $_SESSION['sort'] = "DESC";
    else
        $_SESSION['sort'] = "ASC";
        
    
    echo "<table border=0 cellspacing=0 cellpadding=0 width=100% style=\"border:1px;\">";
    echo "<tr><td style=\"font-size:0.8em;\"><a class=\"searchHits\" href=\"?m=K&stock=".
          $symbol."&col=broker&sort=" . $_SESSION['sort']. "\"><b>Broker</b></a></td>";
    echo "<td style=\"text-align:right; font-size:0.8em;\"><a class=\"searchHits\" href=\"?m=K&stock=".
          $symbol."&col=buyer&sort=" . $_SESSION['sort']. "\"><b>Buy volume</a></b></td>
          <td style=\"text-align:right; font-size:0.8em;\"><a class=\"searchHits\" href=\"?m=K&stock=".
          $symbol."&col=seller&sort=" . $_SESSION['sort']. "\"><b>Sell volume</b></td>
          <td style=\"text-align:right; font-size:0.8em;\"><a class=\"searchHits\" href=\"?m=K&stock=".
          $symbol."&col=net&sort=" . $_SESSION['sort']. "\"><b>Net volume</b></td></tr>";
    foreach (array_keys($all_brokers) as $key => $broker)
    {
        $color = $key % 2 ? "":"background-color:#DFDFDF;";
        echo "<tr style=\"". $color . "\">";
        echo "<td style=\"font-size:0.7em;\">" .
             $broker . "</td>";
        echo "<td style=\"text-align:right; font-size:0.7em;\">" .
             $broker_share['sum_bought'][$broker]  . "</td>";
        echo "<td style=\"text-align:right; font-size:0.7em;\">" .
             $broker_share['sum_sold'][$broker] . "</td>";
        echo "<td style=\"text-align:right; font-size:0.7em;\">" .
           ($broker_share['sum_net'][$broker]) ;
        echo "</td></tr>";
    }
    echo "</table>";
    echo "<br>";
    echo "<br>";

    echo "</div>";
}
?>
