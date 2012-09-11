
<?

class ScanComposite
{
    function scan()
    {
        
    }
    
    function add(ScanComponent $comp)
    {
    }
    
    function remove(ScanComponent $comp)
    {
    }
}

abstract class ScanComponent
{
    abstract function scan();
}

class MovingAverage extends ScanComponent
{
    public function scan()
    {
        echo "SMA<br>\n";
    }
}

?>
