<?
function draw_search_form()
{

}

function draw_html_header()
{
echo "    
<!DOCTYPE html>
<html>
    <head>
        <title>dinAktie - Aktier!</title>
        <link href=\"presentation/basic.css\" rel=\"stylesheet\" type=\"text/css\">
    </head>
    <body>";

//           echo "<div id=\"banner-description\" class=\"banner-description\">";
           echo " <img style=\"float:left; margin-left:15px;\" src=\"logo.png\"/>";
           echo "<form action=\"index.php?m=search\" method=\"post\">
                    <input id=\"searchBox\" name=\"formData\" type=\"text\"/>
                    <input id=\"searchButton\" type=\"submit\" name=\"formSearch\"" .
                   " value=\"Search Stock\" action=\"\" /> </form>";
}
function draw_top_menu($entries)
{
    if ($entries == NULL) {
        die("No menu entries<br>");
    } else {
        echo "<div id=\"text-menu\" style=\"float:center; text-align:center;\">";

        foreach ($entries as $entry) {
        
            echo "<span style=\"float:center;padding:0px 40px 0px 0px;\">
                <a class=\"tablink\" href=\".?m=". $entry[strlen($entry)-1] ."\">" . $entry . "</a>
            </span>";
        }
        echo "</div>";

        /* Draw horizontal line */
        echo "<div id=\"banner-menu\" class=\"banner-menu\"></div>";
//
//      echo "<!--  <div id=\"header\"> 
//        <font face=\"Ubuntu\" size=30 color=#FF7010></font>
//        <div id=\"tablink\"> <center> <a class=\"tablink\" href=\".?name=\">Screening</a> </div>
//        <div id=\"tablink2\"> <center> <a class=\"tablink\" href=\".?name=\">Interaktiv</a></div>
//        <div id=\"tablink3\"> <center> <a class=\"tablink\" href=\".?name=\"></a> </div>
//        <div id=\"tablink4\"> <center> <a class=\"tablink\" href=\".?name=\">Virtuell portf&ouml;lj</a> </div>
//        </div>
//     --!>  
//        <!--<img src=\"http://chart.finance.yahoo.com/z?s=MEDA-A.ST&t=6m&q=c&l=on&z=l&p=m10,e30&a\">--!> ";
    }
}


?>
