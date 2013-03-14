<?
include_once('screen_manager.php');
include_once('/var/www/dinAktie2/dinAktie/data_access/datamapper/StockRepositoy.php');
include_once('filter.php');
include_once('broker_share.php');
include_once('/var/www/dinAktie2/dinAktie/data_access/tools/tool_create_daily_stocks.php');
function getNameForTicker($string)
{
        $query = "http://download.finance.yahoo.com/d/quotes.csv?s=" . $string . "&f=n";
        // create a new cURL resource
        $ch = curl_init($query);
        //echo $query . "<br>";
        
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
       
        // grab URL and pass it to the browser
        $csv = curl_exec($ch);
        // close cURL resource, and free up system resources
        curl_close($ch);
        
        if (strlen($csv) > 30)
            $csv = "error";
        return $csv;
}
function draw_contact_page()
{
    echo "<div style=\"border:0px dotted black; position:absolute; top:130px; height:410px; left:20%;  \">";
    echo "<p style=\"color:#E2491D; font-size:1.1em;\">Found a bug?</p>\n";
    echo "<p style=\"color:#E2491D; font-size:1.1em;\">Suggest improvement?</p>\n";


    echo "<p  style=\"color:#E2491D; font-size:1.1em;\">Send mail to <a style=\"color:#000000; font-size:0.9em;\" href=\"mailto:dinaktie@gmail.com\">dinaktie@gmail.com</a></p>";

    //echo "<form method=\"POST\" action=\"mailto:per.karlstedt@gmail.com\" method=\"post\" enctype=\"text/plain\">";
    //echo "<p>Namn:</br><input name=\"name\" value=\"John Doe\"><p>";
    //echo "Epost:</br><input name=\"email\" value=\"jdoe@someplace.edu\"><p>";
    //echo "Meddelande:</br><textarea name=\"content_message\" rows=10 cols=70 ";
    //echo "value=\"Here's some text.\"></textarea> <p>";
    //echo "<input type=\"submit\" value=\"Skicka\">";
    //echo "</form>";
    echo "</div>";             
    //mail("per.karlstedt@innocode.se", "Mail from dinAktie", "You need to add more setups!");

}


function draw_content($menu_option)
{
    $stockRepository = new StockRepository();
    
    if (!isset($menu_option)) {
    
        $dailyStockRepository = new DailyStockRepository();
        $sCollection = $dailyStockRepository->FindByIsin("MEDA-B.ST", 170);
        $col = $sCollection->GetCollection();
        do_diagram($col);
        //echo "<img src=\"plot.png\" class=\"post-body\" style=\"margin-top:10%\">";
        return;
    } else {
        switch($menu_option)
        {
            case "R": /* Stock screener */
            {
                //draw_stock_screener();
                break;
            }
            case "K": /* Sök */
            {
    
                draw_broker_share($_GET['stock']);
                break;
            }
            case "M": /* Bli medlem */
            {
                break;
            }
            case "S": /* Om oss */
            {
                break;
            }
            case "T": /* Kontakt */
            {
                draw_contact_page();
                break;
            }
            case "screen": /* Screen */
            {
                $cnt = count($_REQUEST[active]);
                $filters = array();

                for ($i = 0; $i < $cnt; $i++) {
                    if($_REQUEST[active][$i] == "on") {
                        array_push($filters, new Filter($_REQUEST[type][$i],
                                   $_REQUEST[condition][$i], $_REQUEST[value][$i]));
                    } 
                }
                
                price_screen($filters);
                echo "<br>";
                break;
            }
            case "search": /* Kontakt */
            {
                
                break;
            }
            case "stock": /* Show single stock */
            {   
                $stock_ticker = $_GET['disp'];
                //echo $stock_ticker;
                $dailyStockRepository = new DailyStockRepository();
                $sCollection = $dailyStockRepository->FindByIsin($stock_ticker, 170);
                $col = $sCollection->GetCollection();
                
                if(count($col) == 0) {   
                    die("Cannot draw empty collection");
                }
                do_diagram($col, 0, 107);
                
                //echo "<img src=\"plot.jpg\" class=\"post-body\" style=\"margin-top:130px\">";
                break;
            }
            case "add":
                echo "<div style=\"border:0px dotted black; position:absolute;
                      top:130px; height:410px; left:20%; right:20% \">";
                echo "<p style=\"color:#E2491D; font-size:1.1em;\">";
                /* Save all search queries into database */
                $sys_msg = new SystemMessage();
                $sys_msg->save_add_query($_POST['formDataAdd']);
                
                $search_str = strtoupper($_POST['formDataAdd']); 
                /* Find on internet */
                $result = getNameForTicker($_POST['formDataAdd']);
                $result = stripFrom($result, "\"");
                $result = trim($result);
                
                if( $result == $search_str ||
                    $result == "Missing Symbols List.") {
                    echo "Could not find any data for " .
                          $_POST['formDataAdd'];
                }
                else
                {
                    $sys_msg->save_add_query($_POST['formDataAdd']);
                    $result = ucwords(strtolower(str_replace("-", " ",
                            stripFrom($result, "\""))));
                    $_SESSION['ticker'] = $_POST['formDataAdd']; 
            
                    /* Seach for isin/symbol in database */
                    if ($stockRepository->ExistInDB($_SESSION['ticker']))
                    {
                        echo "Already in database\n<br>";
                        break;
                    }

                    $_SESSION['stock_name'] = $result;
                    echo "Did you mean:<br>\n";
                    echo "<a href=\"?m=save\">" . $_SESSION['stock_name'] . "</a>";
                    //echo $result . " - [Under construction]<br>";
                }

                echo "</p></div>";
            break;
            case "save":
                echo "<div style=\"border:0px dotted black; position:absolute;
                      top:130px; height:410px; left:20%; right:20% \">";
                $list = array($_SESSION['ticker']);

                $date = "2013-02-20";
                $start_date  = Date('Y-m-d', strtotime("-20 days"));

                $brokerShareRepository = new BrokerShareRepository();

                /* Prevent user from updating page and inserting the symbol twice */
                if ($stockRepository->ExistInDB($_SESSION['ticker'])) {
                     //echo "Symbol already in database";
                     break; 
                }

                $stockRepository->SaveStock($_SESSION['ticker'],
                                            $_SESSION['stock_name']);

                $found = $brokerShareRepository->IsSymbolInDB($_SESSION['ticker']);
                if ($found) {
                    //echo "Already in database\n<br>";
                }
                else
                {
                echo "<p style=\"color:#E2491D; font-size:1.1em;\">". $_SESSION['stock_name'] .
                     " added to database.</p>";
                echo "<a href=\"?m=K&stock=". $_SESSION['ticker'] ."\">".
                      $_SESSION['stock_name'] ."</a>";
                    while ($date <= date('Y-m-d'))
                    {
                        $url_date = stripFrom($date, "-");
                        getBrokerShare($list, $url_date);
                        //echo $url_date . "<br>";

                        list($y,$m,$d)=explode('-',$date);
                        $date2 = Date("Y-m-d", mktime(0,0,0,$m,$d+1,$y));
                        $date = date($date2);
                    }
                }
                echo "</div>";
            break;
            default:
                die("<p style=\"color:#E2491D; font-size:1.1em;\">Invalid menu option</p>");
                die("");
        }
    }
}

?>
