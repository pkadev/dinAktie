<?
include_once('StrategyEMA.php');
class StrategyMACD implements IStrategy
{
    private $_period;
    private $_dataCollection;
    private $_IStrategyEMA26;
    private $_IStrategyEMA12;
    
    public function __construct($dataCollection, $period)
    {
        $this->_period = $period;
        $this->_dataCollection = $dataCollection;
        $this->_IStrategyEMA26 = new StrategyEMA($this->_dataCollection, $this->_period);
        $this->_IStrategyEMA12 = new StrategyEMA($this->_dataCollection, 12);
        
    }

    public function scan()
    {
      echo $this->_IStrategyEMA12->Scan() - $this->_IStrategyEMA26->Scan();
      return   $this->_IStrategyEMA26->Scan() - $this->_IStrategyEMA12->Scan();
       echo "MACD: <br><br>";
    }


}

?>
