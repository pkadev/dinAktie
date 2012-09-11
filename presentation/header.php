<?

function draw_header()
{
echo "    
<html>
    <head>
        <title>dinAktie.se - Tj&auml;na pengar p&aring; r&auml;tt aktier!</title>
        <link href=\"presentation/basic.css\" rel=\"stylesheet\" type=\"text/css\">
    </head>
    <body>
        <div id=\"banner-description\" class=\"banner-description\">
        <img style=\"float:left; margin-left:15px;\" src=\"logo.png\"/>
            <form action=\"index.php\" method=\"post\">
                <input id=\"searchBox\" name=\"formData\" type=\"text\" />
                <input id=\"searchButton\" type=\"submit\" name=\"formSearch\" value=\"S&ouml;k aktie\" action=\"?search=\" />
            </form>
        </div>
        <div id=\"banner-menu\" class=\"banner-menu\">
            <span style=\"float:left;margin-left:20px;padding:5px;\">
                <a class=\"tablink\" href=\".?m=bull\">Tjur</a>
            </span>
            <span style=\"float:left;margin-left:20px;\">
                <a class=\"tablink\" href=\".?m=bear\">Bj&ouml;rn</a>
            </span>
            <span style=\"float:left;margin-left:20px;\">
            <a class=\"tablink\" href=\".?i=i\">V&aring;ra tj&auml;nster</a>
            </span>
            <span style=\"float:left;margin-left:20px;\">
            <a class=\"tablink\" href=\".?i=member\">Logga in</a>
            </span>
        </div>

      <!--  <div id=\"header\"> 
        <font face=\"Ubuntu\" size=30 color=#FF7010></font>
        <div id=\"tablink\"> <center> <a class=\"tablink\" href=\".?name=\">Screening</a> </div>
        <div id=\"tablink2\"> <center> <a class=\"tablink\" href=\".?name=\">Interaktiv</a></div>
        <div id=\"tablink3\"> <center> <a class=\"tablink\" href=\".?name=\"></a> </div>
        <div id=\"tablink4\"> <center> <a class=\"tablink\" href=\".?name=\">Virtuell portf&ouml;lj</a> </div>
        </div>
     --!>  
<!--<img src=\"http://chart.finance.yahoo.com/z?s=MEDA-A.ST&t=6m&q=c&l=on&z=l&p=m10,e30&a\">--!>
";
}

?>
