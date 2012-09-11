<?

class StrategyLowerThanIndex implements IStrategy
{
    private $_period;
    private $_dataCollection;
    private $_indexDataCollection;
    private $_IStrategy; 
    private $_indexToCompare;

    public function __construct($dataCollection, $period)
    {
        $this->_period = $period;
        $this->_dataCollection = $dataCollection;

        $dailyStockRepository = new DailyStockRepository();
        $stockCollection = $dailyStockRepository->FindByIsin("OMXS30.ST", $this->_period);
        $this->_indexDataCollection = $stockCollection->GetCollection(); 
    }
   

    public function SetIndex($compareWith)
    {
        $this->_indexToCompare = $compareWith;        
    } 

    public function scan()
    {
        
        if($this->_indexDataCollection[1] != 0)
        {
            $omxs30gain = ($this->_indexDataCollection[0]->_close -
                           $this->_indexDataCollection[1]->_close) /
                           $this->_indexDataCollection[1]->_close * 100;
            $omxs30gain = number_format ( $omxs30gain , 2) ;
        }
        if($this->_dataCollection[1] != 0)
        {
            $stockGain = ($this->_dataCollection[0]->_close -
                          $this->_dataCollection[1]->_close) /
                          $this->_dataCollection[1]->_close * 100;
            $stockGain = number_format ( $stockGain , 2);
        }
        //echo "Stock: " . $this->_dataCollection[0]->_isin . $stockGain . "<br>"; 
        //echo "Index: " . $omxs30gain . "<br>"; 
       if($stockGain < $omxs30gain)
       {
            return true;
       }
    }
}

?>
