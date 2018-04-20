var counter = 0;

function moreFields() {
  counter++;
  document.getElementById('ingredientTitle').innerHTML = "Ingredient "+counter+": ";				
  var newFields = document.getElementById('template').cloneNode(true);
  newFields.id = 'block'+counter;
  newFields.style.display = 'block';
  var newField = newFields.childNodes;
  for (var i=0;i<newField.length;i++) {
    var theName = newField[i].name
    if (theName)
      newField[i].name = theName + counter;
  }
  var insertHere = document.getElementById('writeZone');
  insertHere.parentNode.insertBefore(newFields,insertHere);				
}

function firstAdd() {
  moreFields();
  document.getElementById('moreFields').onclick = moreFields;
  document.getElementById('removeField').setAttribute("style","display:inline");
}

function remF() {
  var elem = document.getElementById('block'+counter);
  elem.parentNode.removeChild(elem);
  counter--;
  if (counter < 2) {
    document.getElementById('moreFields').onclick = firstAdd;
    document.getElementById('removeField').setAttribute("style","display:none");
  }	
}

window.onload = moreFields;
document.getElementById('moreFields').onclick = firstAdd;
