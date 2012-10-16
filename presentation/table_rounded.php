<?

class TableBlue
{
    private $_list;
    public function __construct($list)
    {   
        if($list)
        {   
            $this->_list = $list;
        }
    }
   
    public function Draw()
    {
        echo "        
        <table id=\"rounded-corner\" summary=i\"Aktiedata\">
            <thead>
                <tr>
                    <th scope=\"col\" class=\"rounded-company\">Datum</th>
                    <th scope=\"col\" class=\"rounded-q1\">V&auml;rdepapper</th>
                    <th scope=\"col\" class=\"rounded-q1\">Kortnamn</th>
                    <th scope=\"col\" class=\"rounded-q1\">Lista</th>
                    <th scope=\"col\" class=\"rounded-q2\">&Ouml;ppning</th>
                    <th scope=\"col\" class=\"rounded-q3\">H&ouml;gsta</th>
                    <th scope=\"col\" class=\"rounded-q3\">L&auml;gsta</th>
                    <th scope=\"col\" class=\"rounded-q3\">Senast</th>
                    <th scope=\"col\" class=\"rounded-q4\">Antal</th>
                </tr>
            </thead>
                <tfoot>
                <tr>
                    <td colspan=\"" . (count($this->ParseTableKeys($this->_list[0]))-1) . "\" class=\"rounded-foot-left\">
                        <em>Antal tr&aumlffar: " . count($this->_list) . "</em></td>
                    <td class=\"rounded-foot-right\">&nbsp;</td>
                </tr>
            </tfoot>
            <tbody>";
        foreach($this->_list as $array)
        {
                echo "
                <tr style: onclick=\"document.location = 'index.php?m=stock&disp=".
                    $array[Kortnamn] .".ST';\">
                    <td>" . $array[Datum]  . "</td>
                    <td>" . $array[Namn]  . "</td>
                    <td>" . $array[Kortnamn]  . "</td>
                    <td>" . $array[Lista] . "</td>
                    <td>" . $array[Open] . "</td>
                    <td>" . $array[High] . "</td>
                    <td>" . $array[Low] . "</td>
                    <td>" . $array[Close] . "</td>
                    <td>" . $array[Volume] . "</td>
                </tr>";
        }
    echo "
    </tbody>
</table>";
    }
 
    private function ParseTableKeys($tableData)
    {
        $table_columns = array_keys($tableData);
        return $table_columns; 
    }
}

?>
