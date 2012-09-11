<?

include_once('IStrategy.php');
class Strategy52WeekLow implements IStrategy
{
    private $_period ;
    private $_dataCollection;

    public function __construct($dataCollection, $period)
    {
        $this->_period = $period;
        $this->_dataCollection = $dataCollection;
    }
    
    public function scan()
    {
        $min = 0;
           $startPos = $this->GetStartPos();     
        for($i = $startPos; $i > 0; $i--)
        {
            if($this->_dataCollection[$i]->_low < $min)
            {
                $min = $this->_dataCollection[$i]->_low;
            }
               //echo $this->_dataCollection[$i]->_isin . " ". $i . " " .
               //     $this->_dataCollection[$i]->_date . "<br>";        
        }
        if($this->_dataCollection[0]->_low < $min)
        {
            return true;
        }
    }
    
    private function GetStartPos()
    { 
        for($i = $this->_period-1; $i >= 0; $i--)
        {
            if($this->_dataCollection[$i]->_date >= "2010-12-19")
            {
                return $i;
            }
        }
    }
}
?>
