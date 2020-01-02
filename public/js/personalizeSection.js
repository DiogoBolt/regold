
var idSectionAux=0;

//function show modal
function showModal(idModal){

    var qtdDiv=$('#allNews')[0].children.length;
        
    while(qtdDiv > 1){
        $('#allNews')[0].children[0].remove();
        --qtdDiv;
    }
    if(idModal=='addSection'){      
        $('.news')[0].children[0].selectedIndex=0
        $('.news')[0].children[1].value="";
    }else if(idModal=='addArea'){
        $('.news')[0].children[0].value="";
        $('.news')[0].children[1].selectedIndex=0
        $('.news')[0].children[2].selectedIndex=0
    }
        
    idSectionAux=0;

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
    
        input.type="checkbox";
        input.id=sectionText+nameSection;
        input.name="sections[]";
        input.value=sectionValue;
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
            var section = {};
            section.designation=sections[i].id;
            section.sectionId=sections[i].value;
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
    }).then(
        window.location.replace('/frontoffice/documents/HACCP')
    );
}
//function para add nova seccao individual
function addnewSection(){
    document.getElementsByClassName('fa fa-trash')[0].style.display="block";
    var divNewSection = document.getElementsByClassName('news')[0];
    var clone=divNewSection.cloneNode(true);
    clone.children[0].value="";
    clone.children[1].value="";
    clone.id="oneNew" + ++idSectionAux;
    divNewSection.parentNode.appendChild(clone);
}

function deleteNewSection(parent){
    $('#'+parent.id).remove();
    if($('#allNews')[0].children.length<2){
        document.getElementsByClassName('fa fa-trash')[0].style.display="none";
    }

}

//funcção para adicionar uma nova(s) á tabela

function addAreasTable(){
    var div= document.getElementsByClassName('news');

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
        clone.children[0].childNodes[0].innerHTML=name;
        clone.children[1].childNodes[1].selectedIndex=productAux;
        clone.children[2].childNodes[1].selectedIndex=cleaningFrequencyAux;
        clone.children[3].childNodes[0].checked=true;

        table.appendChild(clone); // add new row to end of table

    }
    $('#addArea').modal('hide');
}

function saveEachPersonalize(){
    var tableArea = document.getElementById("areasTable");
    var rows= tableArea.getElementsByClassName("tableRow");

    var areasSelected=[];
    
    var idSection=document.getElementById("idSection").value; 
   //console.log(document.getElementById("idSection").value);
    for(var i=0; i<rows.length; i++){
       console.log("designation-> "+ rows[i].cells[0].children[0].textContent);
       console.log("idProduto-> "+ rows[i].cells[1].children[0].value);
       console.log("idFrequencia-> "+ rows[i].cells[2].children[0].value);

        if(rows[i].cells[3].children[0].checked){
            console.log("checked");
            var area = {};
            area.designation= rows[i].cells[0].children[0].textContent;
            area.idProduto=rows[i].cells[1].children[0].value;
            area.idCleaningFrequency=rows[i].cells[2].children[0].value;
            area.idSection=idSection;
            areasSelected.push(area);
        }else{
            console.log("not checked");
        }
    }
    var areas = JSON.stringify(areasSelected);
    console.log(areasSelected);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: "/frontoffice/personalizeAreasEquipments/personalizeEachSection/save",
        data:{areas: areas, idSection:idSection}
    }).then(
        //window.location.replace('/frontoffice/documents/HACCP')
    );

}