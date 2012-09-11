<?
include_once('IStrategy.php');

class StrategyStrongVolumeDown implements IStrategy
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
        $volumeFactor = 4;
        for($i=0; $i < $this->_period; $i++)
        {
            $sum += $this->_dataCollection[$i]->_volume;
        }
        $volSMA = ($sum / $this->_period);
        
        if($this->_dataCollection[0]->_volume > $volSMA*$volumeFactor &&
           $this->_dataCollection[0]->_close < $this->_dataCollection[1]->_close)
        {
            return true;
        } 
       
    }
}

?>
