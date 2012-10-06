<?
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
    mail("per.karlstedt@innocode.se", "Mail from dinAktie", "You need to add more setups!");

}


function draw_content($menu_option)
{
    if (!isset($menu_option)) {
    
        $dailyStockRepository = new DailyStockRepository();
        $sCollection = $dailyStockRepository->FindByIsin("MEDA-B.ST", 120);
        $col = $sCollection->GetCollection();
        do_diagram($col);
        echo "<img src=\"plot.png\" class=\"post-body\" style=\"margin-top:10%\">";
        return;
    } else {
        switch($menu_option)
        {
            case "R": /* Stock screener */
            {
                draw_stock_screener();
                break;
            }
            case "K": /* Sök */
            {
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
            case "search": /* Kontakt */
            {
                
                break;
            }
            case "stock": /* Show single stock */
            {   
                $stock_ticker = $_GET['disp'];
                $dailyStockRepository = new DailyStockRepository();
                $sCollection = $dailyStockRepository->FindByIsin($stock_ticker, 170);
                $col = $sCollection->GetCollection();
                do_diagram($col, 0, 107);
                
        echo "<img src=\"plot.jpg\" class=\"post-body\" style=\"margin-top:10%\">";
                break;
            }
            default:
                die("Invalid menu option");
        }
    }
}
function draw_stock_screener()
{
    echo "<div style=\"border:1px dotted #bbbbbb; position:absolute; top:130px; height:410px; left:20%;  \">";
echo " <select>
  <option value=\"volvo\">SMA</option>
  <option value=\"saab\">Volume</option>
  <option value=\"mercedes\">Mercedes</option>
  <option value=\"audi\">Audi</option>
</select>";
    echo "<p1 style=\"font-family: Titilum; color : #676D71; font-size: 0.9em; \">Stock screener</p1>";
    echo "</div>";

}

?>
