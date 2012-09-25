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
        do_diagram($col, 0, 107);
        echo "<img src=\"plot.png\" class=\"post-body\" style=\"margin-top:10%\">";
        return;
    } else {
        switch($menu_option)
        {
            case "R": /* Stock screener */
            {
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
            case "stock": /* Kontakt */
            {   
                $stock_ticker = $_GET['disp'];
                $dailyStockRepository = new DailyStockRepository();
                $sCollection = $dailyStockRepository->FindByIsin($stock_ticker, 120);
                $col = $sCollection->GetCollection();
                do_diagram($col, 0, 107);
                
        echo "<img src=\"plot.png\" class=\"post-body\" style=\"margin-top:10%\">";
                break;
            }
            default:
                die("Invalid menu option");
        }
    }
}



?>
