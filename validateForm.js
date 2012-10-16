function validateForm()
{
    alert("entry");
var x=document.forms["myForm"]["price"].value;
alert(x);
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
        document.write(price);
  alert("Not a valid e-mail address");
  return false;
  }
}
