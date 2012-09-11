<?
include_once('IStrategy.php');

class StrategyRSI implements IStrategy
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
        //$SMAarray = array_slice($this->_dataCollection, $this->_period, $this->_period+1);
        $SMAarray = array_slice($this->_dataCollection, 0);
        for($i = $this->_period; $i >= 0; $i--) 
        {
            if($i==$this->_period)
            {
                //echo $SMAarray[$i]->_date . " - " . $SMAarray[$i]->_close . "<br>";
                continue;
            }
      
            //echo $SMAarray[$i]->_date . " - " . $SMAarray[$i]->_close . " - ";

            $diff = $SMAarray[$i]->_close - $SMAarray[$i+1]->_close ;
            if($diff < 0)
            {
                //echo $diff. "<br>";
                $loss += $diff;
            }
            else
            {
                //echo $diff. "<br>";
                $gain += $diff;
            }
        }
        
        $loss = abs($loss);

        //echo "Gain: " . $gain . "<br>";
        //echo "Loss: " .$loss . "<br>";
        $avgGain = $gain / $this->_period;
        $avgLoss = $loss / $this->_period;         
        if ($avgLoss == 0)
        {
            //echo $this->_dataCollection[0]->_isin . "<br>";
            $RSI = 100;
        }
        else
        {
            $RS = $avgGain / $avgLoss;
            $RSI = 100 - 100/(1+$RS);
        }
        //echo $RS . "<br>";
        
        //echo "AvgGain: " .$avgGain . "<br>"; 
        //echo "AvgLoss: " . $avgLoss . "<br>"; 
        //echo "RSI: " .$RSI . "<br>";
        return $RSI;
    }
    
    private function averageLoss()
    {
    }

    private function averageGain()
    {
    }

}

?>
