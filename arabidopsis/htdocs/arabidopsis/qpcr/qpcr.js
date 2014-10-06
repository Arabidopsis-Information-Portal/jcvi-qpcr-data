var MIN_TERM_SIZE = 6;


/*
 * is the search term kosher?
 */
function checkSearch(form) {

    var ta = document.getElementById('gene');

    if (form.gene.value == " ") {

        alert("Please enter a gene accession number!");
        return false;
    }

    else if (form.gene.value.length <= MIN_TERM_SIZE) {

        alert("Invalid gene accession number, we do not have information for this gene!");
        return false;
    }

    return true;
}


/*
 * is the search term kosher?
 */
function checkCompare(form) {

/*    var tissue1 = document.getElementById('tissue1');
    var tissue2 = document.getElementById('tissue2');
    var foldchange =document.getElementById('foldchange');
*/
    if (form.tissue1.value.length == 0) {

        alert("Please select the first tissue/treatment for comparison!");
        return false;
    }

    else if (form.tissue2.value.length == 0) {

        alert("Please select the second tissue/treatment for comparison!");
        return false;
    }
    else if (form.tissue1.value == form.tissue2.value){

	alert("Please select different tissue/treatments for comparison!");
	return false;
	}
	else if (form.foldchange.value.length==0){
	alert("Please enter fold of change for comparison!");
	return false;
	}

    return true;
}
