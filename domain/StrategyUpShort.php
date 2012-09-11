<?

class StrategyUpShort implements IStrategy
{
    private $_period;
    private $_dataCollection;
    private $_IStrategy; 

    public function __construct($dataCollection, $period)
    {
        $this->_period = $period;
        $this->_dataCollection = $dataCollection;

        $dailyStockRepository = new DailyStockRepository();
    }
   
    public function scan()
    {
        if($this->_dataCollection[3] != 0)
        {
            $stockGain = ($this->_dataCollection[0]->_close -
                          $this->_dataCollection[3]->_close) /
                          $this->_dataCollection[3]->_close * 100;
            $stockGain = number_format ( $stockGain , 2);
        }
        if ($stockGain > 15.0)
        {
            return true;
        }
    }
}

?>
