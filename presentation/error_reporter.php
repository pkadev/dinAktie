<?
class Error {
    public static function Create($error_msg)
    {
        if (!$error_msg) {
            die("Failed to write error report!");
        }
        
        echo "Something went wrong:<b>\" ". $error_msg ."</b>\"<br>An error report has been created\n<br>";
    }
}
?>
