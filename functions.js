setTimeout(function(){location.reload(1);},100000)
console.log("Hello")





//_____________________checkTime________________________
let d=(new Date())
let cTime=d.getHours()+":"+d.getMinutes()+":00";
var MS_PER_MINUTE = 60000;
let timeReserve= new Date();
timeReserve.setMinutes(timeReserve.getMinutes-4);
console.log(timeReserve);
let time=document.querySelectorAll(".departurebody");

timeColored(time);

function timeColored(element){
  console.log(element);
  if(element.id==cTime){
  element.style.color = "red";}else if(element.id>=timeReserve&&element.id<cTime){
    element.style.color = "orange";
  }else{
    element.style.color = "green";
  }
}
//____________________drag___________________________________________

//dragElement(document.getElementById("departure"));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "body")) {
    // if present, the header is where you move the DIV from:
    document.getElementById(elmnt.id + "body").onmousedown = dragMouseDown;
  } else {
    // otherwise, move the DIV from anywhere inside the DIV:
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
//______________________________________________________________________
