
var idClone=0;

//function show modal
function showModal(idModal){

    if(idModal=='addSection'){
        
        qtdDiv=$('#allNewsSections')[0].children.length;

        while(qtdDiv > 1){
            $('#allNewsSections')[0].children[0].remove();
            --qtdDiv;
        }

        $('.news')[0].children[0].selectedIndex=0
        $('.news')[0].children[1].value="";

    }else if(idModal=='addArea'){

        qtdDiv=$('#allNewsAreas')[0].children.length;

        while(qtdDiv > 1){
            $('#allNewsAreas')[0].children[0].remove();
            --qtdDiv;
        }
        $('.news')[0].children[0].value="";
        $('.news')[0].children[1].selectedIndex=0
        $('.news')[0].children[2].selectedIndex=0
    }else if(idModal=='addEquipment'){

        qtdDiv=$('#allNewsEquipments')[0].children.length;

        $('.news')[0].children[0].value="";
        $('.news')[0].children[1].selectedIndex=0
        $('.news')[0].children[2].selectedIndex=0
    }
        
    idClone=0;

    $('#'+idModal).modal('show');
}

 //function para adiconar os dados introduzidos no modal para pagina
 function addSections() {
    var div= document.getElementsByClassName('news');

    for( var i=0; i< div.length; i++){
        var sectionValue=div[i].children[0].selectedIndex;
        var sectionText=div[i].children[0].options[sectionValue].text;
        var nameSection=div[i].children[1].value;
        var li = document.createElement('li');
        var input= document.createElement('input');

        var value = {
            "idSection" : sectionValue,
            "idClientSection" : 0,
            };
    
        input.type="checkbox";
        input.id=sectionText+nameSection;
        input.name="sections[]";
        input.value=JSON.stringify(value);
        input.checked=true;

        var label = document.createElement('label');
        label.htmlFor=sectionText+nameSection;
        label.innerHTML= sectionText+nameSection;

        li.appendChild(input);
        li.appendChild(label);

        document.getElementById('ulSections').appendChild(li);
    }

    $('#addSection').modal('hide');
} 
//function para guardar as secçoes na bd
function saveSections(){
    var allSections=[];
    var sections=document.getElementsByName('sections[]');
    var sectionSize=sections.length;


    for(var i=0; i<sectionSize;i++){
        if(sections[i].checked){
            var values = JSON.parse(sections[i].value);
            var section = {};
            section.designation=sections[i].id;
            section.sectionId=values['idSection'];
            section.idClientSection=values['idClientSection'];
            allSections.push(section);
        }
    }
    var sectionsJson = JSON.stringify(allSections);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: "/frontoffice/personalizeSection/save",
        data:{sections: sectionsJson}
    }).done(
        setTimeout(function(){
            window.location.replace('/frontoffice/documents/HACCP');
        },1000)
    );
}

//function clonar uma "linha " no modal 
function clone(idModal){
    if(idModal=='addSection'){
        var allNewsAreas = document.getElementById('allNewsSections');
        var divNewClone  = allNewsAreas.getElementsByClassName('news')[0];
    }else if(idModal=='addArea'){
        var allNewsAreas = document.getElementById('allNewsAreas');
        var divNewClone  = allNewsAreas.getElementsByClassName('news')[0];
    }else if(idModal=='addEquipment'){
        var allNewsEquipments = document.getElementById('allNewsEquipments');
        var divNewClone  = allNewsEquipments.getElementsByClassName('news')[0];
    }
    document.getElementsByClassName('fa fa-trash')[0].style.display="block";
    var clone=divNewClone.cloneNode(true);
    clone.children[0].value="";
    clone.children[1].value="";
    clone.id="oneNew" + ++idClone;
    divNewClone.parentNode.appendChild(clone);
}

function deleteNewSection(parent){
    $('#'+parent.id).remove();
    if($('#allNews')[0].children.length<2){
        document.getElementsByClassName('fa fa-trash')[0].style.display="none";
    }

}

//funcção para adicionar uma nova(s) area(s) á tabela
function addAreasTable(){
    var allNewAreas = document.getElementById('allNewsAreas');
    var div = allNewAreas.getElementsByClassName('news');
    for( var i=0; i< div.length; i++){
        var name=div[i].children[0].value;
        var productAux=div[i].children[1].selectedIndex;
       // var productId=div[i].children[1].options[productAux].value;
        var cleaningFrequencyAux=div[i].children[2].selectedIndex;
        //var cleaningFrequencyID=div[i].children[2].options[cleaningFrequencyAux].value;

        var row = document.getElementsByClassName("tableRow")[0];
        //var aux=  document.getElementById("areasTable").getElementsByTagName('tbody').length;
        var table = document.getElementById("areasTable").getElementsByTagName('tbody')[1];  
 
        var clone = row.cloneNode(true); 
        clone.children[0].children[0].value=0;
        clone.children[0].children[1].innerHTML=name;
        clone.children[1].childNodes[1].selectedIndex=productAux;
        clone.children[2].childNodes[1].selectedIndex=cleaningFrequencyAux;
        clone.children[3].childNodes[0].checked=true;
        clone.style = "display:true";

        table.appendChild(clone); // add new row to end of table
    }

    $('#addArea').modal('hide');
}

//funcção para adicionar uma novo(s) equipamento(s) á tabela
function addEquipmentTable(){
    var allNewsEquipments = document.getElementById('allNewsEquipments');
    var div = allNewsEquipments.getElementsByClassName('news');
   
    for( var i=0; i< div.length; i++){
        var name=div[i].children[0].value;
        var productAux=div[i].children[1].selectedIndex;
       // var productId=div[i].children[1].options[productAux].value;
        var cleaningFrequencyAux=div[i].children[2].selectedIndex;
        //var cleaningFrequencyID=div[i].children[2].options[cleaningFrequencyAux].value;

        var row = document.getElementsByClassName("tableRow")[0];
        //var aux=  document.getElementById("areasTable").getElementsByTagName('tbody').length;
        var table = document.getElementById("equipmentTable").getElementsByTagName('tbody')[1];  
 
        var clone = row.cloneNode(true); 
        clone.children[0].children[0].value=0;
        clone.children[0].children[1].innerHTML=name;
        clone.children[1].childNodes[1].selectedIndex=productAux;
        clone.children[2].childNodes[1].selectedIndex=cleaningFrequencyAux;
        clone.children[3].childNodes[0].checked=true;
        clone.style = "display:true";

        table.appendChild(clone); // add new row to end of table

    }
    $('#addEquipment').modal('hide');
}

function saveEachPersonalize(){
    //areas selecionadas criar o json para mandar para o controller
    var tableArea = document.getElementById("areasTable");
    var rowsArea= tableArea.getElementsByClassName("tableRow");
    var areasSelected=[];
    var idSection=document.getElementById("idSection").value; 

    for(var i=0; i<rowsArea.length; i++){
       /*console.log("designation-> "+ rowsArea[i].cells[0].children[0].textContent);
       console.log("idProduto-> "+ rowsArea[i].cells[1].children[0].value);
       console.log("idFrequencia-> "+ rowsArea[i].cells[2].children[0].value);*/
       if(i>0) {
           if (rowsArea[i].cells[3].children[0].checked) {
               var area = {};
               area.idAreaSectionClient = rowsArea[i].cells[0].children[0].value;
               area.designation = rowsArea[i].cells[0].children[1].textContent;
               area.idProduct = rowsArea[i].cells[1].children[0].value;
               area.idCleaningFrequency = rowsArea[i].cells[2].children[0].value;
               area.idSection = idSection;
               areasSelected.push(area);
           }
       }
    }
    var areas = JSON.stringify(areasSelected);

    //equipamentos selecionados criar o json para mandar para o controller
    var tableEquipment = document.getElementById("equipmentTable");
    var rowsEquipments= tableEquipment.getElementsByClassName("tableRow");
    var equipmentsSelected=[];

    for(var i=0; i<rowsEquipments.length; i++){
       /*console.log("designation-> "+ rowsEquipments[i].cells[0].children[0].textContent);
       console.log("idProduto-> "+ rowsEquipments[i].cells[1].children[0].value);
       console.log("idFrequencia-> "+ rowsEquipments[i].cells[2].children[0].value);*/
        if(i>0)
        {
            if(rowsEquipments[i].cells[3].children[0].checked){
                var equipment = {};
                equipment.idAreaSectionClient = rowsEquipments[i].cells[0].children[0].value;
                equipment.designation = rowsEquipments[i].cells[0].children[1].textContent;
                equipment.idProduct = rowsEquipments[i].cells[1].children[0].value;
                equipment.idCleaningFrequency = rowsEquipments[i].cells[2].children[0].value;
                equipment.idSection = idSection;
                equipmentsSelected.push(equipment);
            }
        }

    }
    var equipments = JSON.stringify(equipmentsSelected);

    console.log(equipments);

    //console.log(areas);
    //console.log(equipments);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: "/frontoffice/personalizeAreasEquipments/personalizeEachSection/save",
        data:{areas: areas,equipments:equipments,idSection:idSection}
    }).then(
       window.location.replace('/frontoffice/personalizeAreasEquipments')
    );



}