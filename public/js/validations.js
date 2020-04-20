
function validateNIF(value) {
    // const nif = typeof value === 'string' ? value : value.toString();
    // const validationSets = {
    //     one: ['1', '2', '3', '5', '6', '8'],
    //     two: ['45', '70', '71', '72', '74', '75', '77', '79', '90', '91', '98', '99']
    // };
    //
    // if (nif.length !== 9) {
    //     return false;
    // }
    //
    // if (!validationSets.one.includes(nif.substr(0, 1)) && !validationSets.two.includes(nif.substr(0, 2))) {
    //     return false;
    // }
    //
    // let total = nif[0] * 9 + nif[1] * 8 + nif[2] * 7 + nif[3] * 6 + nif[4] * 5 + nif[5] * 4 + nif[6] * 3 + nif[7] * 2;
    // let modulo11 = (Number(total) % 11);
    //
    // const checkDigit = modulo11 < 2 ? 0 : 11 - modulo11;
    //
    // return checkDigit === Number(nif[8]);

    return true;
}

function validateForm(){
   var radios = document.getElementsByName('verifyHaveRegister');
   
   if(radios[0].checked){
        if(document.getElementById('registedMail').value==""){
            document.getElementById('registedMail').style.border="1px solid #ff0000";
            return false;
        }else{
            document.getElementById('registedMail').style.border="none";
        }
    }else{
        //verificar email
        if(!verifyEmailExist(document.getElementById('loginMail').value)){
            document.getElementById('loginMail').style.border="1px solid #ff0000";
            return false;
        }else{
            document.getElementById('loginMail').style.border="none";
        }
    }

    if(!validateNIF(document.getElementById('nif').value)){
        document.getElementById('nif').style.border="1px solid #ff0000";
        return false;
    }else{
        document.getElementById('nif').style.border="none";
    }


    if(document.getElementById('serviceType1').checked == true){
        document.getElementById('serviceTypesDiv').style.border="none";
        return true;

    }else if(document.getElementById('serviceType3').checked == true){
        document.getElementById('serviceTypesDiv').style.border="none";
        return true;
    }else if(document.getElementById('serviceType4').checked == true){
        document.getElementById('serviceTypesDiv').style.border="none";
        return true;
    }else{
        document.getElementById('serviceTypesDiv').style.border="1px solid #ff0000"
        return false;
    }
}
//listarcidades en função do distrito

    function listCities(cityObj){
        //aqui chamar pedro
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
                                    
        
        var id=cityObj.value; 
        
        $.ajax({
            type:'GET',
            url:'/users/getCities/'+id,
        }).done(function(data){
            var optionCityd =  document.createElement("option");
            optionCityd.text="Selecione a Cidade";
            optionCityd.value="";
            optionCityd.selected=true;
            optionCityd.disabled=true;
            selectCity.appendChild(optionCityd);
            for(var i=0; i<data.length;i++){
                var optionCity =  document.createElement("option");
                optionCity.value=data[i].id; 
                optionCity.text=data[i].name;
                optionCity.disable=true;
                selectCity.appendChild(optionCity);
            }
        });
    }


function getParishName(postalCode,id) {
    if (postalCode.length == 8) {
        $.ajax({
            type: 'GET',
            url: '/users/getParish/' + postalCode,
        }).done(function (data) {
            if (data.name != undefined) {
                if (id == "postal_code") {
                    document.getElementsByClassName("labelParish")[0].innerHTML = data.name;
                    document.getElementsByClassName("labelParish")[0].style.display = "block";
                } else {
                    alert("aqui");
                    document.getElementsByClassName("labelParish")[1].innerHTML = data.name;
                    document.getElementsByClassName("labelParish")[1].style.display = "block";
                }

            } else {
                console.log("sem resultado");
            }
        });
    } else {
        if (id == "postal_code") {
            document.getElementsByClassName("labelParish")[0].innerHTML = "";
        } else {
            document.getElementsByClassName("labelParish")[1].innerHTML = "";
        }
    }
}
    function showRegistedMail(){
        document.getElementById("EmailInvoice").style.display="none";
        document.getElementById('ReceiptEmail').required=false;
    }
    function notshowRegistedMail(){
        document.getElementById("EmailInvoice").style.display="block";
        document.getElementById('ReceiptEmail').required=true;
    }
    //aparecer e desaparecer a inserção da morada
function showAddressInvoice(){ 
    document.getElementById("AddressInvoice").style.display="block";
    document.getElementById('selectDistrictInvoice').required=true;
    document.getElementById('selectCityInvoice').required=true;
    document.getElementById('invoicePostalCode').required=true;
    document.getElementById('invoiceAddress').required=true;
}
function notshowAddressInvoice(){
    document.getElementById("AddressInvoice").style.display="none";
    document.getElementById('selectDistrictInvoice').required=false;
    document.getElementById('selectCityInvoice').required=false;
    document.getElementById('invoicePostalCode').required=false
    document.getElementById('invoiceAddress').required=false;
}          

function ownerRegister(myRadio){
    if(myRadio.value=='sim'){
        document.getElementById("ownerRegister").style.display="none";
        document.getElementById("registeredOwner").style.display="block";
        document.getElementById('ownerName').required=false;
        document.getElementById('loginMail').required=false;
        document.getElementById('password').required=false;
        document.getElementById('registedMail').required=true;
    }else{
        document.getElementById("ownerRegister").style.display="block";
        document.getElementById("registeredOwner").style.display="none";
        document.getElementById('ownerName').required=true;
        document.getElementById('loginMail').required=true;
        document.getElementById('password').required=true;
        document.getElementById('registedMail').required=false;
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

function IsEmail(email){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
    
}

function validateEmailExist(email){
    var eMail=email.value;
    if(IsEmail(eMail)){
        if(!verifyEmailExist(eMail)){
            document.getElementById("registedMail").style.border="2px solid #00ff00";
            return true;
        }else{
            document.getElementById("registedMail").style.border="1px solid #ff0000";
            return false;
        }
    }else{
        document.getElementById("registedMail").style.border="1px solid #ff0000";
        return false;
    }
}
//fazer ajax para validar email e nif já existem ou não metodos já estao criados!!!

function myFunction() {
    var x = document.getElementById("selectEstablishment").value;
    $.ajax({
        type: 'POST',
        url: '/client/addSessionVar/'+x,
        data: {token: "{{ csrf_token() }}"},
        async: false,
        success: success
      }) .done(window.location.reload());
  }


  //função para saber o typo de pagemento

  function payType(payType){
      if(payType.value == 'Debito Direto'){
          document.getElementById("divNib").style.display="block";
          document.getElementById("nib").required=true;
      }else{
        document.getElementById("divNib").style.display="none";
        document.getElementById("nib").required=false;
      }
  }


  //teste remover

  function removeItem(select, itemid){

    var id=itemid;
    qt=select.value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        type: 'POST',
        url: "/frontoffice/cart/removeitem",
        data:{id: id, qt: qt}
    }).done(
        setTimeout(function(){
            window.location.reload();
        },500)
    );
      
  }
  

