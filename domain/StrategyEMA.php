<?
include_once('IStrategy.php');

class StrategyEMA implements IStrategy
{
    private $_period;
    private $_dataCollection;

    public function __construct($dataCollection, $period)
    {
        $this->_period = $period;
        $this->_dataCollection = $dataCollection;
    }        
    public function scan()
    {
        $multiplier = (2 / ($this->_period + 1));
        $SMAarray = array_slice($this->_dataCollection, $this->_period*2, $this->period);
        $sma = new StrategySMA($SMAarray, $this->_period);
        
        $emaPrev = $sma->scan(); 
//        echo "Period: " . $this->_period . "<br>"; 
//        echo "Multiplier: " . $multiplier . "<br>";
//        echo "SMA: " . $emaPrev . "<br>";

 //       echo "-----------------------<br><br>";
        
        for($i=$this->_period*2-1; $i >= 0 ; $i--)
        {
            // mult * (close-prevEma)+prevEma
            $emaPrev = ($multiplier * ($this->_dataCollection[$i]->_close - $emaPrev)+$emaPrev ) ;
 //           echo $emaPrev . " | " . $this->_dataCollection[$i]->_close . "|" .
 //                $this->_dataCollection[$i]->_date . "<br>";
        }
        return $emaPrev;
    }
}

?>
