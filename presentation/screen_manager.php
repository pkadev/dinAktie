<?

        $predefinedScans = array(
                                 array("&Ouml;ver 10-dagars SMA", "aboveSMA10"),
                                 array("&Ouml;ver 20-dagars SMA", "aboveSMA20"),
                                 array("&Ouml;ver 50-dagars SMA", "aboveSMA50"),
                                 array("&Ouml;ver 200-dagars SMA", "aboveSMA200"),
                                 array("SMA50 korsar SMA200", "bullish50-200"),
                                 array("Nya 52-veckors h&ouml;gsta", "52weekHigh"),
                             //    array("Traders Action Zone", "taz"),
                                 array("B&auml;ttre &auml;n OMXS30 idag", "bullOMXS30"),
                                 array("&Ouml;kar med stor volym", "volGain"),
                                 array("&Ouml;vers&aring;ld RSI","oversoldRSI"),
                                 array("Upp minst 15% p&aring; tre dagar","upShort"),
                                 array("Kurs +2%, Volym +25%", "up"),
                                 array("Gap Upp&aring;t", "gapUps"),
                                ); 
        $predefinedScansBear = array(
                                 array("Under 10-dagars SMA", "belowSMA10"),
                                 array("Under 20-dagars SMA", "belowSMA20"),
                                 array("Under 50-dagars SMA", "belowSMA50"),
                                 array("Under 200-dagars SMA", "belowSMA200"),
                                 array("SMA50 korsar SMA200", "bearish50-200"),
                                 array("Nya 52-veckors l&auml;gsta", "52weekLow"),
                                 array("S&auml;mre &auml;n OMXS30 idag", "bearOMXS30"),
                                 array("Minskar med stor volym", "volLoss"),
                                 array("&Ouml;verk&ouml;pt RSI","overboughtRSI"),
                                 array("Ner minst 15% p&aring; tre dagar","downShort"),
                                 array("Kurs -2%, Volym -25%", "down"),
                                 array("Gap ned&aring;t", "gapDowns"),
                            );
    function draw_predefined_bear_screens()
    {
        global $predefinedScansBear;
        echo "Bear<br>\n";
        echo "<select onchange=\"";
        echo "window.open(this.options[this.selectedIndex].value,'_top')\">\n";
        echo "<option value=\"\">V&auml;lj...</option>";
        foreach($predefinedScansBear as $scan) {
            echo "<option value=\"index.php?name=" . $scan[1] ."\">". $scan[0] ."</option>";
        }
        echo "</select>";
    }
    function draw_predefined_bull_screens()
    {
        global $predefinedScans;
        echo "Bull<br>\n";
        echo "<select onchange=\"";
        echo "window.open(this.options[this.selectedIndex].value,'_top')\">\n";
        echo "<option value=\"\">V&auml;lj...</option>";
        foreach($predefinedScans as $scan) {
            echo "<option value=\"index.php?name=" . $scan[1] ."\">". $scan[0] ."</option>";
        }
        echo "</select>";
    }

    function draw_predefined_screens()
    {
        //draw_tab_menu();
        echo "<p1 style=\"font-family: Titilum; color : #676D71;".
             " font-size: 0.9em; \">";
        if ($_GET['tab'] == "predefined")
        {
            echo "<b>F&ouml;rdefinierade screens</b><br><br>";
            draw_predefined_bull_screens();
            echo "<br><br>";
            draw_predefined_bear_screens();
            echo "</p1>";
        }
    }

function price_screen($filter)
{
    $dailyStockRepository = new DailyStockRepository();

    $res = $dailyStockRepository->FindByType($filter);
    echo "<div style=\"border:0px dotted #bbbbbb; position:absolute;".
         " top:140px; height:410px; right:20%; left:20%;  \">";
    foreach($res as $result) {
        echo "<a class=\"searchHits\" href=\"index.php?m=stock&disp=" .
             $result . "\">" . $result . "</a><br>";
        //echo $result . "<br>";
    }
    echo "</div>";
}

function draw_screen_builder()
{
echo "Filter<br>";
echo "<script src=\"addInput.js\" language=\"Javascript\" type=\"text/javascript\"></script><br />";
echo"  
        <form name=\"myForm\" action=\"index.php?m=screen\" method=\"post\" onsubmit=\"return selectCheckBox()\">
    <div id=\"dynamicInput\">
    </div>
    <input type=\"button\" value='L&auml;gg till' onClick=\"addInput('dynamicInput');\">
<div><input id=\"searchButton\" value='Screen' type=\"submit\" name=\"\">";
echo "</div></form>";
}

function draw_tab_menu()
{
    echo "  <div id=\"talltabs-orange\">";
    echo "      <ul>";
    echo "          <li class=\"first\"><a href=\".?m=R&tab=predefined#\">".
         "          <span>F&ouml;rdefinierade</span></a></li>";
    echo "          <li class=\"active\"><a href=\"#\">Our <span>Products</span></a></li>";
    echo "          <li><a href=\"#\">About <span>Us</span></a></li>";
    echo "          <li class=\"last\"><a href=\#\">Contact <span>Us</span></a></li>";
    echo "      </ul>";
    echo "  </div>";
}

function draw_stock_screener()
{
    echo "<div style=\"border:1px dotted #bbbbbb; position:absolute;".                                     " top:140px; height:410px; right:20%; left:20%;  \">";
    draw_predefined_screens();
    draw_screen_builder();
    echo "</div>";
    
}

?>
