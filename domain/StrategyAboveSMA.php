<?
include_once('StrategySMA.php');

class StrategyAboveSMA implements IStrategy
{
    private $_period;
    private $_dataCollection;
    private $_IStrategy; 

    public function __construct($dataCollection, $period)
    {
        $this->_period = $period;
        $this->_dataCollection = $dataCollection;
        $this->_IStrategy = new StrategySMA($this->_dataCollection, $this->_period);
    }
    
    public function scan()
    {
        if($this->_dataCollection[0]->_close > $this->_IStrategy->Scan())
        {
            return true;
        }
    }
}

?>
