
 function myFunction() {
    var div= document.getElementsByClassName('newSections');
    //alert($div[0].children[0].value);
    for( var i=0; i< div.length; i++){
        var qtdCld=div[i].children.length;
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
            label.for=sectionText+nameSection;
            label.innerHTML= sectionText+nameSection;

            li.appendChild(input);
            li.appendChild(label);

            document.getElementById('ulSections').appendChild(li);
    }
            document.getElementById('addSection').remove();
} 