
var idSectionAux=0;

//function show modal
function showModal(idModal){
    var qtdDiv=$('#allNewSections')[0].children.length;
    
    while(qtdDiv > 1){
        $('#allNewSections')[0].children[0].remove();
        --qtdDiv;
    }
   
    $('.newSections')[0].children[0].selectedIndex=0
    $('.newSections')[0].children[1].value="";

    
    idSectionAux=0;
    $('#'+idModal).modal('show');
}
 
 //function para adiconar os dados introduzidos no modal para pagina
 function addSections() {
    var div= document.getElementsByClassName('newSections');

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
    var divNewSection = document.getElementsByClassName('newSections')[0];
    var clone=divNewSection.cloneNode(true);
    clone.children[1].value="";
    clone.id="newSection" + ++idSectionAux;
    divNewSection.parentNode.appendChild(clone);
}

function deleteNewSection(parent){
    $('#'+parent.id).remove();
    if($('#allNewSections')[0].children.length<2){
        document.getElementsByClassName('fa fa-trash')[0].style.display="none";
    }

}