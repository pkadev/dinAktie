<?
include_once('IStrategy.php');

class StrategySMA implements IStrategy
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
        for($i=0; $i < $this->_period; $i++)
        {
        //echo $this->_dataCollection[$i]->_date . " , " .
        //$this->_dataCollection[$i]->_close . "<br>";
            $sum += $this->_dataCollection[$i]->_close;
        }
        return ($sum / $this->_period);        
    }
}

?>
