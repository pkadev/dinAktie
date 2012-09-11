<?

class Table
{
    protected $td_settings = "bgcolor=grey";
    protected $width = "";
    private $_list;
    private $bgcolor = "bgcolor=#AAAAAA";
    private $rowcolor = "bgcolor=#CCCCCC";

    public function __construct($list)
    {   
        if($list)
        {   
            $this->td_settings = $this->bgcolor;
            $this->_list = $list;
        }
    }
    
    public function ToString()
    {
            echo "<table cellpadding=1 cellspacing=0  " . $this->width . ">";
            foreach($this->_list as $row)
            {
                echo "<tr><td " . $this->td_settings . ">".
                $row  .
                "</td></tr>\n";
                $this->SwapRowColor();
            }
            echo "</table>";
    } 
    
    public function SetWidth($width)
    {
        $this->width = $width;
    }

    private function SwapRowColor()
    {
        $this->td_settings = $this->td_settings == "bgcolor=#AAAAAA" ? $this->rowcolor : $this->bgcolor;
    }
}

?>
