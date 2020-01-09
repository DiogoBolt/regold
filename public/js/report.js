function verifyAnswer(){
    var tableRules = document.getElementById("reportRules");
    var rowsRules= tableRules.getElementsByClassName("tableRow");

    var answersRow=[];
    var answersAll=[];

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
        tableRules.getElementsByClassName("tableRow")[noAnswer[i]].style.background="#ffe6e6";
    }
}

function dontShowCorrective(id){
   // document.getElementById(id).style.display="none";
    var tableRules = document.getElementById("reportRules");

    console.log( tableRules.getElementsByClassName("tableRow")[id-1].style.background);
    tableRules.getElementsByClassName("tableRow")[id-1].style.background="white";

    var tableCorrective =  document.getElementById("correctiveRules");

    var tableCorrectiveRows=tableCorrective.getElementsByClassName('tableRow');

    var qtdRowBlock=0;

    if(tableCorrective.getElementsByClassName('tableRow')[id-1].style.display="table-row"){
        tableCorrective.getElementsByClassName('tableRow')[id-1].style.display="none";
    }

    for(var i=1;i<tableCorrectiveRows.length;i++){
        if(tableCorrectiveRows[i].style.display=="table-row"){
            qtdRowBlock++;
        }
    }
    console.log(qtdRowBlock);
    if(qtdRowBlock==0){
        document.getElementById("correctiveRules").style.visibility="hidden";
    }

   

}

function showCorrective(id){
    document.getElementById("correctiveRules").style.visibility="visible";
    var tableRules = document.getElementById("reportRules");
    tableRules.getElementsByClassName("tableRow")[id-1].style.background="white";

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

    var li = document.createElement('li');

    var lblIndex=document.createElement('label');

    lblIndex.value=idRule;
    lblIndex.innerHTML=index+"-> ";

    var lblObs=document.createElement('label');
    lblObs.innerHTML=iptObs;

    li.appendChild(lblIndex);
    li.appendChild(lblObs);

    document.getElementById('obsList').appendChild(li);

    document.getElementById('indexObs').selectedIndex=0;
    document.getElementById('iptObs').value="";



}