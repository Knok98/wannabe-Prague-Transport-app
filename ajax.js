import * as handler from 'functions.js';

//________ajax  a jquery na zapis vysledku a dovrseni aktualizace dat_______
let queque=[];
const vole=new Audio("./images/jede_vlak.mp3");

$(document).ready(function()
{


$(document).on("submit","#routeQuery",function(event){
    event.preventDefault();
    vole.play();
    $.ajax({
        type: 'post',
        url: './controllers/processQuery.php',
        data:$("#routeQuery").serialize(),
        dataType: "json",
        encode:true,
     }).done(function (data) {
        if(data[1]!=0){
            let text="";
            for(let i=0;i<data[0].length;i++){
                text+=data[0][i];
            }
            $("body").append(text);
        }
        queque[data[1]]=data[2]+":00";
        let target=$('#'+data[1])
        let val="";
        
            for(let i=2;i<data.length;i++){
            val+="<p>"+(i-1)+". jede ve "+data[i]+".</p>";
            }
        $(target).append(val)
        checkQueque(queque);
        setTimeout(checkQueque(queque),30000);
        

        //______________________________________________konec sucess ajax
        
        })



        queque.toSorted();
        console.log(queque);

        
             
});
});


setTimeout(function(){location.reload(1);},100000)
console.log("Hello")





//_____________________time_functions________________________
//________aktualni time string
function currentTime(){
  let date=new Date();
  let hours=date.getHours();
  let minutes=date.getMinutes();
  let seconds=date.getSeconds();
  let cTime=`${hours}:${minutes}:${seconds}`;
  if(minutes<10){cTime=`${hours}:0${minutes}:${seconds}`};
  return cTime;
}

//____________časova rezerva
function timeReserve(res){
  d=new Date();
  cH=d.getHours();
  cM=d.getMinutes()+res;
  if(cM>60){cM-=60;cH+=1;};
  if(cM<10){return `${cH}:0${cM}:00`;};
  return `${cH}:${cM}:00`;

}

//________zabarvení____________________

//__barva podle času_______
function colorTime(index,color){
  $(`#${index}`).find('p').eq(0).css({'color':color})
}

//________departure n queque řadič_______
function checkQueque (element){
  console.log('fce bezi');
  let cTime=currentTime();
  let reserveT=timeReserve(10);

  element.forEach(function callback(value, index) {
      console.log(`${index}: ${value}`);
    
      switch(true){
          case (value>cTime):
              if(value>reserveT){console.log("green");color.time(index,"green");}else{
                console.log("red");
                colorTime(index,"red");
              }
              break;
          case (value<=cTime):
            console.log("refresh time info");
            formRefresh(index);
            break;
          default:
             console.log("refresh nefunguje, nebo nejsou žádná data")
      }
  });
  }
//_________znovu odeslani formu________________
function formRefresh(id){
let spoj=(document.getElementById(id).value).split();
document.getElementsByName('routeF').value=spoj[0];
document.getElementsByName('routeT').value=spoj[1];
document.getElementsByName('idDiv').value=id;
document.getElementById('send').submit();
}

//____________________drag___________________________________________

//dragElement(document.getElementById("departure"));
/*
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
*/
//______________________________________________________________________

