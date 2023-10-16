//________ajax  a jquery na zapis vysledku a dovrseni aktualizace dat_______
$("routeQuery").submit(function(event){
    
    $.ajax({
        type: 'post',
        url: 'controllers/processQuery.php',
        dataType: "json",
        encode: "true",
    }).done(function (data){



    });
    event.preventDefault();
})