<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>TIGR Arabidopsis thaliana Gene Expression</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="/arabidopsis/qpcr/qpcr.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    <script src="/arabidopsis/qpcr/js/menu.js"></script>
    </style>
</head>

<body style="margin-left":50%;">
<div id="container" style="position:relative; width: 760px; ">
	<div id="logo" align="center" style="position:absolute; width: 760px; top: 5px; left: 50px;"><img src="/arabidopsis/qpcr/imgs/title.jpg"  width="760" height="182"></div> 

     	<div id="navsite" align="center" style="position:absolute; width: 760px; top: 210px; left: 50px;"> 
  	<ul> 
    		<li><a href="/arabidopsis/qpcr/index.shtml">Home</a></li> 
    		<li><a href="/arabidopsis/qpcr/search.php">Gene Expression</a></li> 
    		<li><a href="/arabidopsis/qpcr/genelist.php">Gene List</a></li> 
		<li><a href="/arabidopsis/qpcr/protocols.php">Protocols</a></li>
		<li><a href="/arabidopsis/qpcr/expression.php">Reporter Images</a></li>
    		<li><a href="/arabidopsis/qpcr/contact.shtml">Contact</a></li>
    		<li><a href="http://www.tigr.org">TIGR Home</a></li> 
  	</ul> 
     	</div> 

    	<div id="main_content"  style="position:absolute; width: 760px; top: 250px; left: 40px;"> 
	 <form action="/cgi-bin/arabidopsis/qpcr/SingleSearch" method="POST" onsubmit="return checkSearch(this);"> 
     		<h5>Search the expression data of individual gene</h5>
     		<p>
     		Enter an Arabidopsis gene identifier AND/OR choose a tissue to view the expression report. <br>Return results as <input checked type='radio' name='format' value='html'> HTML or <input type='radio' name='format' value='text'> Plain text.
     		</p>

        <b>Gene Accession Number(s) &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Tissue/Treatment &nbsp</b>
	 <br>such as AT1G33930.1 ; AT1G01460.1 <br>(accessions must be seperated by ";" or ",")
	<p align="left"><textarea cols="30" rows="4" name="gene" multiline="true" value="Please type the gene access number(s) you want to search" id="gene" ></textarea>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 		
<select name="tissuesearch" multiple>

<?php

include_once ("dbconnection.php");

$query = "SELECT DISTINCT (
treatment_name
)
FROM treatment;";

  if (!mysql_select_db("town_at_qpcr", $connection))
     showerror();
        
  if (!($result = mysql_query ($query, $connection)))
     showerror();

   while($row= @mysql_fetch_array($result)){

	$current_id=$row["treatment_name"];
	
	# $current_id="treatment name";
	$len2=	strlen($current_id);
          #$show_value=substr($current_id,0,3);
	#if(strlen($current_id)>2)
	if($len2>2)
	{
	   #	$show_value=substr($current_id,0,3);
	   # JZ21 convert "T87 cell culture..." --> "T87"
	   # it is very buggy just chop first 3 chars, since then LEAF will be LEA!!!
           if (preg_match ("/(\w+)\s/", $current_id, $regs)) 
	   {
	      $show_value=$regs[0];
	   }   
	   else
	   {
	      $show_value=$current_id;
	      #$show_value=substr($current_id,0,4);
	   }
        }
	else
	{ 
	   $show_value=$current_id;
	}   
?>
			<option value="<?php echo $show_value;?>"><?php echo $current_id; ?></option>
<?php
} //while loop;
?>
	</p>
	<br></br>

	<p>&nbsp &nbsp &nbsp &nbsp <input type="submit" name="Submit" value="Search"> 
        <input type="reset" name="Submit2" value="Clear"></p>
  </form> 

  <form action="/cgi-bin/arabidopsis/qpcr/ComparativeSearch" onsubmit="return checkCompare(this)" method="POST"> 
     <h5>Comparative Expression Search</h5>
    <p>
	Select the comparison condition you want to explore. For example, if you want to examine genes that show 5-fold expression in ROOT  compared to LEAF, select the tissue (ROOT and LEAF) and conditions from the pulldown menu and press 'Search' button. 
    </p>
    <p>
	Searches may require several minutes to complete when many searching across multiple databases.
        If no databases have been selected, by default all databases will be searched.
    </p>
    <p> 
        A maximum of 100 results will be returned.  If more than 100 results were found, only the first
        100 hits will be shown.  

  <table border="1">

 	<colgroup span="11" ></colgroup>
  	<tbody>

    	<tr>
  		<th colspan="3"> Select the first tissue for comparison:</th>
		<th colspan="2"> Relation:</th>
		<th colspan="3"> Select the second tissue for comparison:</th>

		
		<th colspan="3"> Enter the fold change:</th>


    	</tr>

    	<tr>
		<th rowspan="3" colspan="3">
     		<select name="tissue1" id="tissue1" size="5">

<?php   
  if (!($result = mysql_query ($query, $connection)))
     showerror();
  while($row1= @mysql_fetch_array($result)){

	$current_id=$row1["treatment_name"];
	if(strlen($current_id)>2){
           #	$show_value=substr($current_id,0,3);}
           if (ereg ("^\s*(\w+)\s", $current_id, $regs)) 
	   {
	      $show_value=$regs[1];
	   }   
	   else{	$show_value=substr($current_id,0,3);}
	}
	else
	{ 
	   $show_value=$current_id;
           #$show_value=substr($current_id,0,3);
	}
?>
			<option value="<?php echo $show_value;?>"><?php echo $current_id; ?></option>
<?php
} //while loop;
?>
	   	</select></th>

      		<th rowspan="2" colspan="2">
    		<select name="relation" size="2">
			<option value=">" selected>></option>
			<option value="<"><</option>
	   	</select></th> 

     		<th rowspan="3" colspan="3">
    		<select name="tissue2" id="tissue2" size="5">
<?php   
  if (!($result = mysql_query ($query, $connection)))
     showerror();
  while($row1= @mysql_fetch_array($result)){

	$current_id=$row1["treatment_name"];
	if(strlen($current_id)>2){
	   $show_value=substr($current_id,0,3);
	}
	else{ 
	   $show_value=$current_id;
        }
?>
			<option value="<?php echo $show_value;?>"><?php echo $current_id; ?></option>
<?php
} //while loop;
?>
	   	</select></th>

		<th rowspan="2" colspan="3">
		<input name="change" type="text" id="foldchange" size="20" maxlength="10">
    		
		<p>
        		<input type="submit" onClick="return checkCompare();" value="Search">
       			<input type="reset" value="Clear"></th>
    		</p>
    	</tr>
	</tbody>



  </form> 



    <h3>&nbsp;</h3>

<table>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top"> 
    <td colspan="4"><img src="/arabidopsis/qpcr/imgs/footer.jpg" width="760" height="15" alt="footer"></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="2" class="c" valign="top"><table border="0" align="right" cellpadding="0" cellspacing="0">
        <tr valign="top"> 
          <td > <div align="right"><font size="-2">Last updated by Jun Zhuang 
             </font></a> |  <font size="-2">&copy; <script type="text/javascript">var now = new Date(); year = now.getFullYear(); document.write(year);</script> The Institute 
              for Genomic Research, a division of <a href="http://www.venterinstitute.org" class="c">J. Craig Venter Institute</a></font></div></td>

        </tr>
      </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td width="377">&nbsp;</td>
    <td width="171">&nbsp;</td>
    <td>&nbsp;</td>

</table>


</div>
</body>

</html>

<script language="JavaScript" type="text/javascript">
<!--
function checkSearch(form) {

    var ta = document.getElementById('gene');

    if (form.gene.value == "") {

        alert("Please enter a gene accession number!");
        return false;
    }

    else if (form.gene.value.length <= 6) {

        alert("Invalid gene accession number, please re-enter the gene accession number!");
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

//-->
</script>















