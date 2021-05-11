function sortTable(n) {
    var table,
        rows,
        switching,
        i,
        x,
        y,
        shouldSwitch,
        dir,
        switchcount = 0;
    table = document.getElementById("myTable");
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("TR");
        for (i = 1; i < rows.length - 1; i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function showInput(id) {
    switch (id) {
        case 2:
            $("#divTemp").show();
            break
        case 4:
            $("#divClean").show();
            break
        case 6:
            $("#divStatus").show();
            break
        case 8:
            $("#divPackage").show();
            break
        case 10:
            $("#divLabel").show();
            break
    }

}
function dontShowInput(id) {
    switch (id) {
        case 1:
            $("#divTemp").hide();
            break
        case 3:
            $("#divClean").hide();
            break
        case 5:
            $("#divStatus").hide();
            break
        case 7:
            $("#divPackage").hide();
            break
        case 9:
            $("#divLabel").hide();
            break
    }
}

