<?
/**
 * Generates a multi-column table from an array 
 *
 * @param array         Array to process 
 * @param columns       Number of columns to return  
 * @param id            (Optional) ID attribute to attach to the table
 * @param class         (Optional) CSS class attribute to attach to the table 
 */
function generate_table($array, $columns, $table_id='', $table_class='') {
        $array_size = count($array);
        $col_size = ceil($array_size / $columns);
 
        $table = "<table";
        $table .= !empty($table_id) ? " id='".$table_id."'" : '';
        $table .= !empty($table_class) ? " class='".$table_class."'" : '';
        $table .= ">\n";
        for ($i = 0; $i < $col_size; $i++) {
                $table .= "\t<tr>";
                for ($j = 0; $j < $columns; $j++) {
                        $table .= (($i+$j*$col_size) < $array_size) ? '<td>'.$array[$i+$j*$col_size].'</td>' : '<td>&nbsp;</td>';
                }
                $table .= "</tr>\n";
        }
        $table .= "</table>\n";
        return $table;
}


function stripFrom($string, $strip)
{
    $array = str_split($string,1);

    foreach($array as $char)
    {
        if($char != $strip)
        {
            $strippedStr .= $char; 
        }
    }
    return $strippedStr;
}
?>

