<?

class Filter
{
    public $type;
    public $condition;
    public $value;

    public function __construct($type, $condition, $value)
    {
        $this->type = $type;        
        $this->condition = $condition;
        $this->value = $value;
    }

}
?>
