<?
include_once('data_access/brokers.php');
include_once('/var/www/dinAktie2/dinAktie/data_access/brokers.php');
  set_include_path("/var/www/dinAktie2/dinAktie/data_access");
include_once('datamapper/BrokerShareRepository.php');
function validate_date($date, $default_date)
{
    $date_components = explode("-", $date);

    if (count($date_components) != 3) {
        return $default_date;
    }

    $date_components[0] = preg_replace ('/[^0-9]/i', '', $date_components[0]);
    $date_components[1] = preg_replace ('/[^0-9]/i', '', $date_components[1]);
    $date_components[2] = preg_replace ('/[^0-9]/i', '', $date_components[2]);

    if (checkdate($date_components[1], $date_components[2], $date_components[0])) {
        return ($date_components[0] . "-" . $date_components[1] . "-". $date_components[2]);
    }
    else {
        return $default_date;
    }
}
function draw_broker_share($symbol)
{
    global $broker_list;
    echo "<div style=\"border:0px dotted black; position:absolute;
          top:130px; height:410px; left:20%; right:20% \">";

    $brokerShareRepository = new BrokerShareRepository(); 
    $from = $brokerShareRepository->FindOldestDate($symbol);
    $to = $brokerShareRepository->FindNewestDate($symbol);

    /* Keep dates posted from user form inside the collected data set */
    if ($_POST['from_date'] < $from)
        $_POST['from_date'] = $from;

    if ($_POST['to_date'] > $to)
        $_POST['to_date'] = $to;

    if (isset($_POST['from_date'])) {
        $_SESSION['from_date'] = validate_date($_POST['from_date'], $from);
    }
    else {
        if (!isset($_SESSION['from_date']))
            $_SESSION['from_date'] = $from;
    }

    if (isset($_POST['to_date'])) {
        $_SESSION['to_date'] = validate_date($_POST['to_date'], $to);
    }
    else {
        if (!isset($_SESSION['to_date']))
            $_SESSION['to_date'] = $to;
    }


    echo "<form action=\"\" method=\"post\">";
    echo "<p style=\"color:#E2491D; font-size:1.1em;\">Broker statistics for "
         . $symbol . "<br>\n" .
    "<input id=\"dateBox\" value=\"" . $_SESSION['from_date'] ."\" name=\"from_date\" type=\"text\"/> to " .
    "<input id=\"dateBox\" value=\"" . $_SESSION['to_date'] ."\" name=\"to_date\" type=\"text\"/>";
                   echo " <input type=\"submit\" name=\"refresh_date\"" .
                   " value=\"update\" action=\"\" /></p>";
    "</form>";

    //TODO: Check that stock is in one of the lists
    $broker_share = $brokerShareRepository->FindByIsin($symbol, $_SESSION['from_date'], $_SESSION['to_date']);
    $all_brokers = array_merge($broker_share['sum_bought'], $broker_share['sum_sold']);

    /* Keep sorting on columns */
    if ($_SESSION['sort'] == "ASC")
        $_SESSION['sort'] = "DESC";
    else
        $_SESSION['sort'] = "ASC";
        
    
    echo "<table border=0 cellspacing=0 cellpadding=0 width=100% style=\"border:1px;\">";
    echo "<tr><td colspan=2 style=\"font-size:0.8em;\"><a class=\"broker\" href=\"?m=K&stock=".
          $symbol."&col=broker&sort=" . $_SESSION['sort']. "\">Broker</a></td>";
    echo "<td style=\"text-align:right; font-size:0.8em;\"><a class=\"broker\" href=\"?m=K&stock=".
          $symbol."&col=buyer&sort=" . $_SESSION['sort']. "\">Buy volume</a></td>
          <td style=\"text-align:right; font-size:0.8em;\"><a class=\"broker\" href=\"?m=K&stock=".
          $symbol."&col=seller&sort=" . $_SESSION['sort']. "\">Sell volume</a></td>
          <td style=\"text-align:right; font-size:0.8em;\"><a class=\"broker\" href=\"?m=K&stock=".
          $symbol."&col=net&sort=" . $_SESSION['sort']. "\">Net volume</a></td></tr>";

    foreach (array_keys($all_brokers) as $key => $broker)
    {
        global $broker_hash;
        $color = $key % 2 ? "":"background-color:#DFDFDF;";
        echo "<tr style=\"". $color . "\">";
        echo "<td style=\"font-size:0.8em;font-family:titilliumlight; \">" .
             $broker . "</td>";
        echo "<td style=\"font-size:0.8em;font-family:titilliumlight; \">" .
             utf8_decode($broker_hash[$broker])  . "</td>";
        echo "<td style=\"text-align:right; font-size:0.8em;font-family:titilliumlight; \">" .
             $broker_share['sum_bought'][$broker]  . "</td>";
        echo "<td style=\"text-align:right; font-size:0.8em;font-family:titilliumlight; \">" .
             $broker_share['sum_sold'][$broker] . "</td>";
        echo "<td style=\"text-align:right; font-size:0.8em;font-family:titilliumlight; \">" .
           ($broker_share['sum_net'][$broker]) ;
        echo "</td></tr>\n";
    }
    echo "</table>";
    echo "<br>";
    echo "<br>";

}
?>
