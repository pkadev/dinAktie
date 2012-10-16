var counter = 0;
var limit = 5;
var price = new array();
function addInput(divName){
     if (counter == limit)  {
          alert("Max antar rader: " + counter);
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "\
    <input type='hidden' name='active[" + counter + "]' value='off'>\
    <input type='checkbox' name='active[" + counter + "]' value='on'>\
    <select name='type[]'>\
    <option value='close'>pris</option>\
    <option value='volume'>volym</option>\
    <option value='value'>v&auml;rde</option>\
    </select> \
    <select name='condition[]'>\
    <option value=\"&lt;=\">&lt;=</option>\
    <option value=\"&gt;=\">&gt;=</option>\
    </select>\
    <input type='text' style='width:60px;' name='value[]'>";
    document.getElementById(divName).appendChild(newdiv);
    counter++;
     }
}

function selectCheckBox()
{
  var e= document.myForm.elements.length;
  var cnt=0;

  for(cnt=0;cnt<e;cnt++)
  {
    if(document.myForm.elements[cnt].name=="price"){
     alert(document.myForm.elements[cnt].value)
    }
  }
}
