<?
include_once('/var/www/dinAktie2/dinAktie/data_access/brokers.php');
  set_include_path("/var/www/dinAktie2/dinAktie/data_access");
include_once('datamapper/BrokerShareRepository.php');
function draw_broker_share($symbol)
{
    
    $to = date("Y-m-d");
    $from = "2013-03-01";
    global $broker_list;
    echo "<div style=\"border:0px dotted black; position:absolute;
          top:130px; height:410px; left:20%; right:20% \">";

    $brokerShareRepository = new BrokerShareRepository(); 
    $rangeStart = $brokerShareRepository->FindOldestDate($symbol);
    $rangeStop = $brokerShareRepository->FindNewestDate($symbol);

    echo "<p style=\"color:#E2491D; font-size:1.1em;\">Broker statistics for "
         . $symbol . "<br>\n" . /* $rangeStart*/ $from . " to " . /* $rangeStop*/ $to ."<br></p>";

    //echo "<img src=\"plot.png\" class=\"post-body\" style=\"margin-top:10px;
    //      text-align:center\">";
 
    //Check that stock is in one of the lists
    $broker_share = $brokerShareRepository->FindByIsin($symbol, $from, $to);
    $all_brokers = array_merge($broker_share['bought'], $broker_share['sold']);

    echo "<table border=0 cellspacing=0 cellpadding=0 width=100% style=\"border:1px;\">";
    echo "<tr><td style=\"font-size:0.8em;\"><b>Broker</b></td>";
    echo "<td style=\"text-align:right; font-size:0.8em;\"><b>Buy volume</b></td>
          <td style=\"text-align:right; font-size:0.8em;\"><b>Sell volume</b></td>
          <td style=\"text-align:right; font-size:0.8em;\"><b>Net volume</b></td></tr>";
    foreach (array_keys($all_brokers) as $key => $broker)
    {
        $color = $key % 2 ? "":"background-color:#DFDFDF;";
        echo "<tr style=\"". $color . "\">";
        echo "<td style=\"font-size:0.7em;\">" .
             $broker . "</td>";
        echo "<td style=\"text-align:right; font-size:0.7em;\">" .
             $broker_share['bought'][$broker]  . "</td>";
        echo "<td style=\"text-align:right; font-size:0.7em;\">" .
             $broker_share['sold'][$broker] . "</td>";
        echo "<td style=\"text-align:right; font-size:0.7em;\">" .
           ($broker_share['bought'][$broker] - $broker_share['sold'][$broker]) ;
        echo "</td></tr>";
    }
    echo "</table>";
    echo "<br>";
    echo "<br>";

    echo "</div>";
}
?>
