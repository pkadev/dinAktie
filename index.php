<?
error_reporting(E_ERROR);

session_start();
include ('data_access/datamapper/DailyStockRepository.php');
include('data_access/largeCap.php');
include('data_access/midCap.php');
include('data_access/smallCap.php');
include('data_access/firstNorth.php');
include('data_access/indexList.php');
include('domain/Strategy52WeekHigh.php');
include('domain/Strategy52WeekLow.php');
include('domain/StrategySMA.php');
include('domain/StrategyTAZ.php');
include('domain/StrategyAboveSMA.php');
include('domain/StrategyBelowSMA.php');
include('domain/StrategyHigherThanIndex.php');
include('domain/StrategyLowerThanIndex.php');
include('domain/StrategyUpWithVolume.php');
include('domain/StrategyDownWithVolume.php');
include('domain/StrategyBullish50_200.php');
include('domain/StrategyStrongVolumeUp.php');
include('domain/StrategyStrongVolumeDown.php');
include('domain/StrategyBullishMACD.php');
include('domain/StrategyRSI.php');
include('domain/StrategyOversoldRSI.php');
include('domain/StrategyOverboughtRSI.php');
include('domain/StrategyUpShort.php');
include('domain/StrategyDownShort.php');
include('domain/StrategyGapUp.php');
include('domain/StrategyGapDown.php');
include('presentation/table.php');
include('presentation/table_rounded.php');
include('presentation/helpers.php');
include('candlestick.php');
include('presentation/footer.php');
include('presentation/content.php');
include_once('presentation/screen_manager.php');
include_once('presentation/header.php');
$join = "Vill du kombinera och konfigurera dina s&ouml;kningar? Blir medlem och logga in!" .
        "<br>Show shakers and movers, risers and decliners on start page!<br>";

$menuOption = ""; ?>

        <? draw_html_header(); ?>
        <?
            $menu_entries = array("STOCK SCREENER", "ALARM", "MEMBER", "CONTACT");
            draw_top_menu($menu_entries);
        ?>

<?
        //drawInfo();
        //drawMenu($predefinedScans, $predefinedScansBear);

        $dailyStockRepository = new DailyStockRepository();
        if ($_POST['formData'])
        {
            draw_search_result($dailyStockRepository);
        }
        echo "<span position:absolute; style=\"height:1000px;\">";
        draw_content($_GET['m']);
        
        echo "<div id=\"scans\">";

        $allLists = array_merge($largeCap, $midCap, $smallCap, $firstNorth);
        $res = array(); 
        
        if($_GET['name'] == "aboveSMA10")
        {
            //foreach($allLists as $symbol) 
            { 
                $stockCollection = $dailyStockRepository->FindByIsin("ABB.ST", 60);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyAboveSMA($collection, 30); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "belowSMA10")
        {
            foreach($allLists as $symbol) 
            { 
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, 10);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyBelowSMA($collection, 10); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }

        if($_GET['name'] == "aboveSMA20")
        {
            foreach($allLists as $symbol) 
            { 
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, 20);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyAboveSMA($collection, 20); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "belowSMA20")
        {
            foreach($allLists as $symbol) 
            { 
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, 20);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyBelowSMA($collection, 20); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }

        if($_GET['name'] == "aboveSMA50")
        {
            foreach($allLists as $symbol) 
            { 
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, 50);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyAboveSMA($collection, 50); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "belowSMA50")
        {
            foreach($allLists as $symbol) 
            { 
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, 50);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyBelowSMA($collection, 50); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }

        if($_GET['name'] == "aboveSMA200")
        {
            foreach($allLists as $symbol) 
            { 
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, 200);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyAboveSMA($collection, 200); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "belowSMA200")
        {
            foreach($allLists as $symbol) 
            { 
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, 200);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyBelowSMA($collection, 200); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
    
        if($_GET['name'] == "52weekHigh")
        {
            $period = 270;
            foreach($allLists as $symbol) 
            {  
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new Strategy52WeekHigh($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "52weekLow")
        {
            $period = 270;
            foreach($allLists as $symbol) 
            {  
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new Strategy52WeekLow($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        
        if($_GET['name'] == "bullOMXS30")
        {
            $period = 2;
            foreach($allLists as $symbol) 
            {  
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyHigherThanIndex($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "bearOMXS30")
        {
            $period = 2;
            foreach($allLists as $symbol) 
            {  
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyLowerThanIndex($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }


        if($_GET['name'] == "volGain")
        {
            $period = 60;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyStrongVolumeUp($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "volLoss")
        {
            $period = 60;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyStrongVolumeDown($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        
        if($_GET['name'] == "bullish50-200")
        {
            $period = 200;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, 201);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyBullish50_200($collection); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        
        if($_GET['name'] == "bullMACDCross")
        {
            $period = 26;
            //foreach($allLists as $symbol)
            //{
                $stockCollection = $dailyStockRepository->FindByIsin("ABB.ST", $period*3);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyMACD($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            //}
        }

        if($_GET['name'] == "oversoldRSI")
        {
            $period = 14;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period*2+1);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyOversoldRSI($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "overboughtRSI")
        {
            $period = 14;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period*2+1);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyOverboughtRSI($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        
        if($_GET['name'] == "upShort")
        {
            $period = 4;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyUpShort($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "downShort")
        {
            $period = 4;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyDownShort($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }

        if($_GET['name'] == "up")
        {
            $period = 2;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyUpWithVolume($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "down")
        {
            $period = 2;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyDownWithVolume($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] == "gapUps")
        {
            $period = 2;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyGapUp($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
            
        }
        if($_GET['name'] == "gapDowns")
        {
            $period = 2;
            foreach($allLists as $symbol)
            {
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, $period);
                $collection = $stockCollection->GetCollection();
                $strategy = new StrategyGapDown($collection, $period); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
            
        }
        if($_GET['name'] == "taz")
        {
            foreach($allLists as $symbol) 
            { 
                $stockCollection = $dailyStockRepository->FindByIsin($symbol, 30);
                $collection = $stockCollection->GetCollection(); 
                $strategy = new StrategyTAZ($collection, 30); 
                if($strategy->scan())
                {
                    $res = buildResult($res, $collection);
                }
            }
        }
        if($_GET['name'] != "")
        {
                presentResultHeader($_GET['name'], array_merge($predefinedScans, $predefinedScansBear));
                presentResult($res);
        }
        else
        {
            //echo "<p style=\"color:#E2491D; font-size:1.1em;\">Search for a stocks you are interested in.</p>";
            //echo "<img style=\"margin:70px 100px 400px 0px;\" src=\"newsFlash520x82.jpg\"/>";
        }
        if($_GET['name'] != "")
            echo "<p style=\"color:#E2491D; font-size:1.1em;\">Search for a stocks you are interested in.</p>";
        echo "</div>" ;
       //echo "<div id=\"popularScans\"></div>";

function buildResult($base, $array)
{
    $array[0]->_name = ucwords(strtolower(str_replace("-", " ",
                            stripFrom($array[0]->_name, "\""))));
    array_push($base,
               array("Datum" => $array[0]->_date,
                     "Kortnamn" => substr($array[0]->_isin, 0, -3),
                     "Namn" => $array[0]->_name,
                     "Lista" => $array[0]->_listName,
                     "Open" => $array[0]->_open,
                     "High" => $array[0]->_high,
                     "Low" => $array[0]->_low,
                     "Close" => $array[0]->_close,
                     "Volume" => $array[0]->_volume));

    return $base;
}

function presentResultHeader($scanName, $allscans)
{
    foreach($allscans as $scan)
    {
        if($scan[1] == $scanName)
        {
            echo "<p style=\"text-align:center; font-size: 25px;font-family: \"Lucida Sans Unicode\", \"Lucida Grande\", Sans-Serif;\">" . $scan[0] . "<br> </p>";
    
        }
    }
}

function presentResult($result)
{
    if($result)
    {
        $table = new TableBlue($result);
        $table->Draw();
    }
    else
    {
        echo "No stocks found.";
    }
}

function drawInfo()
{
    if($_GET['i'] == "i")
    {
        
        echo "<div id=\"banner1\"> 
              <i>dinAktie.se &auml;r en tj&auml;nst som f&ouml;rser dig med ett bra underlag inf&ouml;r en aktieaff&auml;r. Vi tillhandah&aring;ller verktyg f&ouml;r att hitta just den sorts aktie-setup du &auml;r intresserad av. <br> 
</i></div>";
        echo "<div id=\"banner2\"> 
              <p style=\"color:#333367; font-size:21px;font-family:\"Georgia\";\">S&ouml;k igenom hela Stockholmsb&ouml;rsen p&aring; n&aring;gra sekunder</p> 
                Minska tiden du sitter och tittar p&aring; helt ointressanta aktier. dinAktie.se hj&auml;lper dig att hitta aktier som passar din strategi. 
</i></div>";
    }
}

function drawMenu($menuOptionsBull, $menuOptionsBear)
{
    switch($_GET{'m'})
    {
        case "bull":
                echo "<div id=\"predefinedScans\">\n";
                echo "<h6>Tekniska signaler<br>Tjur</h6>\n";
                foreach($menuOptionsBull as $is)
                {
                    print "<a class=\"darkLink\" href=\"?m=bull&name="  . $is[1] . "\">" .
                           $is[0] . "</a><br>\n";
                }
                echo "</div>";
        break;
        case "bear":
            echo "<div id=\"predefinedScans\">\n";
            echo "<h6>Tekniska signaler<br>Bj&ouml;rn</h6>\n";        
            foreach($menuOptionsBear as $is)
            {
                print "<a class=\"darkLink\" href=\"?m=bear&name=" . $is[1] . "\">" .
                       $is[0] . "</a><br>\n";
            }
            echo "</div>";
        break;
        case "bull":
        break;
    }
}
function draw_search_result($dailyStockRepository)
{
            $searchInput = $_POST['formData'];
             
                    echo "<div style=\"border:0px dotted #bbbbbb; position:absolute;".
                         " top:140px; height:410px; right:20%; left:20%;  \">";
            if (strlen($searchInput) < 2)
            {
                echo "<p style=\"color:#E2491D; font-size:1.1em;\">Input to short.</p>";
            }
            else
            {
                /* Save all search queries into database */
                $sys_msg = new SystemMessage();
                $sys_msg->save_search_query($searchInput);

                    $searchHits = $dailyStockRepository->FindByText($searchInput);
                    
                    $searchHitCollection = $searchHits->GetCollection();
                    if (count($searchHitCollection) > 0) {
                        //if (count($searchHitCollection) == 1) {
                        //    $_GET['disp'] = $searchHitCollection[0]->_isin;
                        //    $_GET['m'] = "stock";
                        //} else
                        {
                            foreach($searchHitCollection as $hit) {
                                $name =  ucwords(strtolower(str_replace("-", " ",
                                    stripFrom($hit->_name, "\""))));  
                                echo "<a class=\"searchHits\" href=\"index.php?m=K&stock=" .
                                     $hit->_isin . "\">" . $name . "</a><br>";
                            }
                        
                        }
                    } else {
                        echo "<p style=\"color:#E2491D; font-size:1.1em;\">No stocks found.</p>";
                        echo "<p style=\"color:#E2491D; font-size:1.1em;\">Add your ticker here:</p>";
                        echo "<form action=\"index.php?m=add\" method=\"post\">";
                        echo "<input id=\"addBox\" name=\"formDataAdd\" type=\"text\"/> " .
                             "<input id=\"addButton\" type=\"submit\" name=\"formSearch\"" .
                                " value=\"Add Stock\" action=\"\" /> </form>";
                    }
                 echo "</div>";
               }
}
  ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29308430-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
