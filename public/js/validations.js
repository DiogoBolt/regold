
function validateNIF(value) {
    const nif = typeof value === 'string' ? value : value.toString();
    const validationSets = {
        one: ['1', '2', '3', '5', '6', '8'],
        two: ['45', '70', '71', '72', '74', '75', '77', '79', '90', '91', '98', '99']
    };

    if (nif.length !== 9) {
        return false;
    }

    if (!validationSets.one.includes(nif.substr(0, 1)) && !validationSets.two.includes(nif.substr(0, 2))) {
        return false;
    }

    let total = nif[0] * 9 + nif[1] * 8 + nif[2] * 7 + nif[3] * 6 + nif[4] * 5 + nif[5] * 4 + nif[6] * 3 + nif[7] * 2;
    let modulo11 = (Number(total) % 11);

    const checkDigit = modulo11 < 2 ? 0 : 11 - modulo11;

    return checkDigit === Number(nif[8]);
}

function validateForm(){
    alert("entrei aqui");
   var radios = document.getElementsByName('verifyHaveRegister');
   if(radios[0].checked){
        console.log(radios[0].value);
    }else{
        //verificar email
        if(document.getElementById('ownerName').value == ""){
            console.log("nome vazio");
            document.getElementById('ownerName').style.border="1px solid #ff0000";
            return false;
        }else if(document.getElementById('password').value==""){
            console.log("pass vazio");
            document.getElementById('password').style.border="1px solid #ff0000";
            return false;
        }else if(verifyEmailExist(document.getElementById('loginMail').value) || document.getElementById('loginMail').value==""){
            document.getElementById('loginMail').style.border="1px solid #ff0000";
            console.log("email existe o vazio");
            return false;
        }

    }
}
//listarcidades en função do distrito
function listCities(cityObj){
    if(cityObj.id == "selectDistrict"){
        var selectCity = document.getElementById("selectCity");
        while (selectCity.firstChild) {
            selectCity.removeChild(selectCity.firstChild);
        } 
    }else{
        var selectCity = document.getElementById("selectCityInvoice");
        while (selectCity.firstChild) {
            selectCity.removeChild(selectCity.firstChild);
        } 
    }
    
    var optionCity =  document.createElement("option");
    var id=cityObj.value; 
    optionCity.text="Selecione a Cidade";
    optionCity.disable=true;
    selectCity.appendChild(optionCity);
    $.ajax({
        type:'GET',
        url:'/users/verifyEmailExist/'+id,
    }).done(function(data){
        for(var i=0; i<data.length;i++){
            var optionCity =  document.createElement("option");
            optionCity.value=data[i].id; 
            optionCity.text=data[i].name;
            optionCity.disable=true;
            selectCity.appendChild(optionCity);
        }
    });
}


function ownerRegister(myRadio){
    if(myRadio.value=='sim'){
        document.getElementById("ownerRegister").style.display="none";
        document.getElementById("registeredOwner").style.display="block";
    }else{
        document.getElementById("ownerRegister").style.display="block";
        document.getElementById("registeredOwner").style.display="none";
    }

}

function verifyEmailExist(email){
    var aux = null;
    $.ajax({
        type:'GET',
        url: '/users/verifyEmailExist/'+email,
        async: false,
        success: function(data) {
            // Call this function on success
            if(data==0){
                aux= false; 
            }else{
                aux = true;
            }
        }
    });
    return aux;


}


function validateEmailExist(email){
    var email=email.value;
    if(!verifyEmailExist(email)){
        document.getElementById("registedMail").style.border="2px solid #00ff00";
        return true;
    }else{
        document.getElementById("registedMail").style.border="1px solid #ff0000";
        return false;
    }
}

//fazer ajax para validar email e nif já existem ou não metodos já estao criados!!!
