<?
include_once('StrategyRSI.php');

class StrategyOversoldRSI implements IStrategy
{
    private $_period;
    private $_dataCollection;
    private $_IStrategy; 

    public function __construct($dataCollection, $period)
    {
        $this->_period = $period;
        $this->_dataCollection = $dataCollection;
        $this->_IStrategy = new StrategyRSI($this->_dataCollection, $this->_period);
    }
    
    public function scan()
    {
        $RSI = $this->_IStrategy->Scan();
        if ($RSI < 15)
        {
            return $RSI;
        }
    }
}

?>
