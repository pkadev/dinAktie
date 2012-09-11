<?
include_once('IStrategy.php');

class StrategyBullish50_200 implements IStrategy
{

    private $_period = 200;
    private $_dataCollection;

    public function __construct($dataCollection)
    {
        $this->_dataCollection = $dataCollection;
    }
    
    public function scan()
    {
        $sma50 = new StrategySMA($this->_dataCollection, 50);
        $sma200 = new StrategySMA($this->_dataCollection, $this->_period);

        $sma50Res = $sma50->scan();
        $sma200Res = $sma200->scan();

        if( $sma50Res > $sma200Res )
        {

            unset($this->_dataCollection[0]); 
            $this->_dataCollection = array_values($this->_dataCollection);

            $sma50 = new StrategySMA($this->_dataCollection, 50);
            $sma200 = new StrategySMA($this->_dataCollection, $this->_period);

            //echo $this->_dataCollection[0]->_date . " - " . $this->_dataCollection[0]->_isin .
            //     " - sma50(" . $sma50Res . ") " . "< sma200(" .  $sma200Res .  ") on " . "<br>";

            //echo $this->_dataCollection[0]->_date . " - " .$this->_dataCollection[0]->_isin .
            //     " - sma50(" . $sma50->scan() . ") " . "< sma200(" . $sma200->scan() .  ") on " . "<br>";
            if($sma50->scan() < $sma200->scan())
            {
                return true;
            }
            else
            {
                return false;
            } 

        } 

    }
}


?>
