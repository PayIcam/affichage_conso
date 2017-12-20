var names = [];
var prices = [];
var init = true;

// Déclenche les animations et mets à jour les données au bout de 2s
function update(){
    for(var i = 0; i < 5; i++){
        for(var j = 0; j < names.length; j++){
            if(j > i && document.getElementById("name" + i).innerHTML == names[j] && names[j] != "---"){
                var value1 = i;
                var value2 = j;
                if(value1 > 4){
                    value1 = 4;
                }
                if(value2 > 4){
                    value2 = 4;
                }
                if(value1 != value2){
                    invert(value1, value2);
                }
            }

            if(j < i && document.getElementById("name" + i).innerHTML == names[j] && names[j] != "---"){
                var value1 = i;
                var value2 = j;
                if(value1 > 4){
                    value1 = 4;
                }
                if(value2 > 4){
                    value2 = 4;
                }
                if(value1 != value2){
                    invert(value1, value2);
                }
            }
        }
    }

    setTimeout(function() {
        fill();
    }, 2000);
}

// Déclenche deux animations pour échanger deux cases
function invert(e1, e2){

    var element = document.getElementById("item" + e1);

    if(element != null){
        element.style.webkitAnimationName = 'anim' + e1 + e2;
        element.style.webkitAnimationDuration = '2s';

        setTimeout(function() {
            element.style.webkitAnimationName = '';
        }, 2000);
    }

    console.log(e1 + " " + e2);
}

// Envoie la requête AJAX
function request(callback) {
    var xhr = getXMLHttpRequest();
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseXML);
        }
    };

    xhr.open("GET", "data.php");
    xhr.send(null);
}

// Lis la requête AJAX
function readData(oData) {
    var rows = oData.getElementsByTagName("row");
    var i;
    names = [];
    prices = [];
    for(i = 0; i < rows.length; i++) {
        var name = rows[i].getAttribute('name');
        var price = rows[i].getAttribute('price');
        names.push(name);
        prices.push(price);
    }

    if(init == false){
        update();
    }else{
        fill();
        init = false;
    }
}

// Mets à jour les prix
function fill(){
    for(var i = 0; i < 5; i++){
        document.getElementById("price" + i).innerHTML = prices[i];
        document.getElementById("name" + i).innerHTML = names[i];
    }
}

// Fonction appelée toutes les 3s
function timer(){
    request(readData);
}

// Appelle la fonction timer toutes les 3s
setInterval(timer, 3000);
request(readData);