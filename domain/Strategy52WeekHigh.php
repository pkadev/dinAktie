<?

include_once('IStrategy.php');
class Strategy52WeekHigh implements IStrategy
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
        $max = 0;
           $startPos = $this->GetStartPos();     
        for($i = $startPos; $i > 0; $i--)
        {
            if($this->_dataCollection[$i]->_high > $max)
            {
                $max = $this->_dataCollection[$i]->_high;
            }
               //echo $this->_dataCollection[$i]->_isin . " ". $i . " " .
               //     $this->_dataCollection[$i]->_date . "<br>";        
        }
        if($this->_dataCollection[0]->_high > $max)
        {
            return true;
        }
        //echo $this->_dataCollection[0]->_isin . " : ";
        //echo $max . " : "; 
        //echo $this->_dataCollection[0]->_high . "<br>";
        
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
