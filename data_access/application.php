
<?

include ('DailyStockRepository.php');

    $dailyStockRepository = new DailyStockRepository();
    $period = 200;    
    include('../largeCap.php');

    $stockCollection = $dailyStockRepository->FindByIsin("KINV-B.ST");
    $collection = $stockCollection->GetCollection();    
       
    doji($collection, 1500);
    $dailyStockRepository->GetNumDaysToDate();

    foreach($largeCap as $symbol)
    {

        $stockCollection = $dailyStockRepository->FindByIsin($symbol);
        $collection = $stockCollection->GetCollection();    
       
       doji($collection, 100);
       // if($collection[0]->_close > movingAverage($collection, 30)
       //     && $collection[0]->_close < movingAverage($collection, 10)
       //     && $collection[0]->_close > movingAverage($collection, $period))
       // {
       //     print $symbol . "<br>";
       // }

    }
        
//$stockCollection->ToString();
 
function doji($col, $period)
{
    for($i=0; $i<$period; $i++)
    {
        if($col[$i]->_close == $col[$i]->_open)
        {
            print $col[$i]->_isin . " -- ";
            print $col[$i]->_date . "<br>";
        }
    } 
}

function movingAverage($col, $period)
{
    for($i=0; $i<$period; $i++)
    {
        $sum += $col[$i]->_close;
    }
    return ($sum / $period);        
}

?>
