
//co se muze srat
// dodelat fci na zabarveni
// ajax spravny presmerovani na process php
// nemuzu to delat pres form



$(document).ready(() => {
  console.log("restart")
    for (const cookie of decodeURIComponent(document.cookie).split('; ')) {
        // setCookie("Z", "zas1|zas2");
        const [from, to] = cookie.substring(15).replace(/['"]+/g, '').split('|'); // must have 2 elements
        console.log([from, to]);
        getTimesFor(from, to, undefined);
    }
});
function setCookie(name, value) {
    const date = "expires=" + new Date(new Date().getTime() + (365 * 24 * 60 * 60 * 1000)).toUTCString(); // +rok
    document.cookie = `${name} =${JSON.stringify(value)} ; ${date} + path=/`;
    let direct=value.split('|');
    getTimesFor(direct[0], direct[1], undefined);
}
  
function getTimesFor(from, to, element) {
    const div = element ?? $('<div>', {'class': 'departure'});
    /*
    fetch('url', {}).then((res) => {
      return JSON.parse(res);
    }).then((res) => {
      res.timeout;
    });
    */
   
    $.ajax({
      type: 'post',
      url: 'newWorldProcess.php',
      data: {"routeF":from,"routeT":to},
      dataType: "json",
      encode: true,
    }).done(data => {
      console.log(data)
      // parse data from PHP to data.times, data.timeout, data.......
      div.html(data.times);
      $("body").append(div);
      console.log(data.timeout);
      if (data.timeout >  60 ) {
        colorTime(div,'green');
        setTimeout(() => {
          getTimesFor(from, to, div);;
        }, data.timeout-5000);
      } else {
        colorTime(div,'red');
      }
  
      setTimeout(() => {
        getTimesFor(from, to, div);
      }, data.timeout);
    });

}
function colorTime(index, color) {
  $(index).find('p').eq(0).css({ 'color': color })
}

$("#send").on("click",function(){
console.log("triggered click");
  let from=$(".from").val();
  let to=$(".to").val();
  let timestamp = new Date().getTime();
  let coVal=`${from}|${to}`;
  setCookie(`z${timestamp}`,coVal);

}




)

