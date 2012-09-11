<?

class StrategyUpWithVolume implements IStrategy
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
        if($this->_dataCollection[1] != 0)
        {
            $stockGain = ($this->_dataCollection[0]->_close -
                          $this->_dataCollection[1]->_close) /
                          $this->_dataCollection[1]->_close * 100;
            $stockGain = number_format ( $stockGain , 2);

            if($this->_dataCollection[1]->_volume != 0)
            { 
                $volGain = ($this->_dataCollection[0]->_volume -
                          $this->_dataCollection[1]->_volume) /
                          $this->_dataCollection[1]->_volume * 100;
                $volGain = number_format ( $volGain , 2);
            }
        }
        
        if($stockGain > 2.0 && $volGain > 25.0)
        {
            return true;
        }
    }
}

?>
