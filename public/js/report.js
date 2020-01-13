function verifyAnswer(){

    var tableRules = document.getElementById("reportRules");
    var rowsRules= tableRules.getElementsByClassName("tableRow");

    var answersRow=[];
    var answersAll=[];

    var allCorrect=false;

    for(var i=0;i<rowsRules.length;i++ ){ 
        answersRow.push(rowsRules[i].children[2].children[0].checked);
        answersRow.push(rowsRules[i].children[3].children[0].checked);
        answersRow.push(rowsRules[i].children[4].children[0].checked);
        answersAll.push(answersRow);
        
        answersRow=[];
    }

    var noAnswer=[];

    for(var i=0; i<answersAll.length; i++){
        if(answersAll[i][0] || answersAll[i][1] || answersAll[i][2] ){
        }else{
            noAnswer.push(i);
        }
    }

    for(var i=0; i<noAnswer.length; i++){
        for(var j=0; j<4;j++){
            tableRules.getElementsByClassName("tableRow")[i].getElementsByTagName('td')[j].style.background="#ffe6e6";
        }
    }

    if(noAnswer.length>0){
        allCorrect=false;
    }else{
        allCorrect=true;
    }

    return allCorrect;
}

function dontShowCorrective(id){
    var tableRules = document.getElementById("reportRules");

    for(var j=0; j<4;j++){
        tableRules.getElementsByClassName("tableRow")[id-1].getElementsByTagName('td')[j].style.background="#ffffff";
    }

    var tableCorrective =  document.getElementById("correctiveRules");

    var tableCorrectiveRows=tableCorrective.getElementsByClassName('tableRow');

    if(tableCorrective.getElementsByClassName('tableRow')[id-1].style.display="table-row"){
        tableCorrective.getElementsByClassName('tableRow')[id-1].style.display="none";
    }

    var qtdRowBlock=0;
    for(var i=0;i<tableCorrectiveRows.length;i++){
        if(tableCorrectiveRows[i].style.display=="table-row"){
            qtdRowBlock++;
        }
    }

    if(qtdRowBlock==0){
        document.getElementById("divCorrectiveRules").style.visibility="hidden";
        document.getElementById("titleCorrective").style.display="none";
      
    }
}

function showCorrective(id){

    document.getElementById("divCorrectiveRules").style.visibility="visible";
    document.getElementById("titleCorrective").style.display="block";

    var tableRules = document.getElementById("reportRules");

    for(var j=0; j<4;j++){
        tableRules.getElementsByClassName("tableRow")[id-1].getElementsByTagName('td')[j].style.background="#ffffff";
    }

    var tableCorrective =  document.getElementById("correctiveRules");

    tableCorrective.getElementsByClassName('tableRow')[id-1].style.display="table-row";

}

function focusObs(id){
    document.getElementById('indexObs').selectedIndex=id;
    document.getElementById('iptObs').focus();
}


function addObsList(){
    var index = document.getElementById('indexObs').selectedIndex;
    var idRule= document.getElementById('indexObs').options[index].value;
    var iptObs = document.getElementById('iptObs').value;

    var tr= document.createElement('tr');
    tr.className="tableRow";

    var thIndex= document.createElement('th');
    thIndex.id="correctiveRulesIndex";
    thIndex.value=idRule;
    thIndex.className="index";
    thIndex.innerHTML=index;

    var tdObs=document.createElement('td');
    tdObs.class="tdRuleBackground";
    txtAreaObs=document.createElement('textarea');
    txtAreaObs.className="corrective";
    txtAreaObs.value=iptObs;
    txtAreaObs.innerHTML=iptObs;
    tdObs.appendChild(txtAreaObs);

    var tdTrash=document.createElement('td');
    tdTrash.className="trashTd";

    var iTrash=document.createElement('i');
    iTrash.className="fas fa-trash";
    iTrash.onclick=function(){deleteObs(this)};

    tdTrash.appendChild(iTrash);

    tr.appendChild(thIndex);
    tr.appendChild(tdObs);
    tr.appendChild(tdTrash);

    document.getElementById('observations').getElementsByTagName('tbody')[1].appendChild(tr);
    document.getElementById("divObservationsRules").style.visibility="visible";
    document.getElementById("titleObservations").style.display="block";

    document.getElementById('indexObs').selectedIndex=0;
    iptObs = document.getElementById('iptObs').value="";

}

function deleteObs(element){
    
    trIndex=element.parentNode.parentNode.rowIndex;
    document.getElementById("observations").deleteRow(trIndex);

    var countRow=document.getElementById('observations').getElementsByTagName('tbody')[1].getElementsByTagName('tr').length;

    if(countRow==0){
        document.getElementById("divObservationsRules").style.visibility="hidden";
        document.getElementById("titleObservations").style.display="none";
    }
}

function allNotAplly(){

    var tableRows=document.getElementById('reportRules').getElementsByTagName('tbody')[1].getElementsByTagName('tr');
    for(i=0; i< tableRows.length; i++){
        tableRows[i].children[4].children[0].checked=true;
    }

}

var answers=[];
var observations=[];

function addAnswerArray(){
    
    var tableRules = document.getElementById("reportRules");
    var rowsRules= tableRules.getElementsByClassName("tableRow");

    var tableCorrectives = document.getElementById("correctiveRules");
    var rowsCorrectiveRules= tableCorrectives.getElementsByClassName("tableRow");

    var answer={};

    for(var i=0; i< rowsRules.length; i++){

        if(rowsRules[i].children[2].children[0].checked){
            answer.resp='c';
        }else if(rowsRules[i].children[3].children[0].checked){
            answer.resp='nc';
        }else if(rowsRules[i].children[4].children[0].checked){
            answer.resp='np';
        }
        
        answer.idRule=rowsRules[i].children[0].getAttribute('value');
        answer.corrective=rowsCorrectiveRules[i].children[2].children[0].value;
        answers.push(answer);
        answer={};

    }
    
    var tableObs=document.getElementById("observations"); 
    var rowsObs=tableObs.getElementsByClassName("tableRow");

    var obs={};

    if(rowsObs.length>0){
        for(var j=0; j<rowsObs.length; j++){
            obs.idClientSection=document.getElementById('idSection').value;
            obs.observations=rowsObs[j].children[1].children[0].value;
            obs.rule=rowsObs[j].children[0].value;
            observations.push(obs);
            obs={};
        }
    }
}

function testarLink($id){

    if(verifyAnswer()){
        addAnswerArray();

        var answersJson = JSON.stringify(answers);
        var obs = JSON.stringify(observations);
        var idSection = document.getElementById("idSection").value;

        //console.log("->"+idSection);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "/frontoffice/saveAnswers",
            data:{answers:answersJson, obs:obs, idSection:idSection}
        }).then(
            window.location.replace('/frontoffice/newReportSections')
        );
    

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "/frontoffice/addSection/"+$id,
        }).then(
            window.location.replace('/frontoffice/newReportSections')
        );*/
    }
    //console.log(answers);
}

function testeFunc(){
    
    var visitNumber=document.getElementById("visitNumber").innerHTML;
    console.log(visitNumber);

   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: "/frontoffice/saveReport/"+visitNumber,
    }).then(
        window.location.replace('/frontoffice/newReportRules/0')
    );
}