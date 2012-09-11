<?
include_once('StrategySMA.php');

class StrategyTAZ implements IStrategy
{
    private $_period;
    private $_dataCollection;
    private $_IStrategySMA10; 
    private $_IStrategySMA30; 

    public function __construct($dataCollection, $period)
    {
        $this->_period = $period;
        $this->_dataCollection = $dataCollection;
        $this->_IStrategySMA10 = new StrategySMA($this->_dataCollection, 10);
        $this->_IStrategySMA30 = new StrategySMA($this->_dataCollection, 30);
    }
    
    public function scan()
    {
        if ($this->_dataCollection[0]->_close < $this->_IStrategySMA10->Scan() &&
            $this->_dataCollection[0]->_close > $this->_IStrategySMA30->Scan() &&
            $this->_dataCollection[0]->_low < $this->_IStrategySMA30->Scan() &&
            $this->_dataCollection[0]->_volume > $this->_dataCollection[1]->_volume &&
            $this->_dataCollection[0]->_close > $this->_dataCollection[0]->_open )
        {
            return true;
        }
    }
}

?>
