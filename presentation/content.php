<?
include_once('screen_manager.php');
include_once('filter.php');
include_once('broker_share.php');

function draw_contact_page()
{
    echo "<div style=\"border:0px dotted black; position:absolute; top:130px; height:410px; left:20%;  \">";
    echo "<form method=\"POST\" action=\"mailto:per.karlstedt@gmail.com\" method=\"post\" enctype=\"text/plain\">";
    echo "<p>Namn:</br><input name=\"name\" value=\"John Doe\"><p>";
    echo "Epost:</br><input name=\"email\" value=\"jdoe@someplace.edu\"><p>";
    echo "Meddelande:</br><textarea name=\"content_message\" rows=10 cols=70 ";
    echo "value=\"Here's some text.\"></textarea> <p>";
    echo "<input type=\"submit\" value=\"Skicka\">";
    echo "</form>";
    echo "</div>";             
    //mail("per.karlstedt@innocode.se", "Mail from dinAktie", "You need to add more setups!");

}


function draw_content($menu_option)
{
    if (!isset($menu_option)) {
    
        $dailyStockRepository = new DailyStockRepository();
        $sCollection = $dailyStockRepository->FindByIsin("MEDA-B.ST", 170);
        $col = $sCollection->GetCollection();
        do_diagram($col);
        echo "<img src=\"plot.png\" class=\"post-body\" style=\"margin-top:10%\">";
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
                draw_broker_share();
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
                
        echo "<img src=\"plot.jpg\" class=\"post-body\" style=\"margin-top:130px\">";
                break;
            }
            default:
                die("Invalid menu option");
        }
    }
}

?>
