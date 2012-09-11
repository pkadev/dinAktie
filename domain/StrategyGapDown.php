<?
include_once('IStrategy.php');

class StrategyGapDown implements IStrategy
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
        if( $this->_dataCollection[0]->_high < $this->_dataCollection[1]->_low )
        {
            return true;
        }
    }
}
?>
