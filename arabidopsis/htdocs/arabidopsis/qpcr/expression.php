
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
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

<body style="margin-left":50%;" onload='process()'>
<div id="container" style="position:relative; width: 760px; ">

	<div id="logo" align="center" style="position:absolute; width: 760px; top: 5px; left: 50px;"><img src="/arabidopsis/qpcr/imgs/title_3.jpg" width="760" height="182"></div> 
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

    	<div id="main_content"  style="position:absolute; width: 760px; top: 250px; left: 50px;"> 

<!-- Tissue->locus->Po  on Mar27,2007, JZ1 -->
   <form action="tissuesearch.php" onsubmit="return checkCompare(this)" method="GET"> 
     <h4>Search Reporter Images by tissue</h4>

     <table cellspacing="0" cellpadding="0" border="0">
      <tr>
      <td valign="bottom">
     	Please type a description of <br> tissue to search plant images. <br>For example: leaf. 
      </td>
      <td>
	<textarea cols="30" rows="4" name="tissue" multiline="true" value="Please type the tissue name you want to search" id="tissue" ></textarea>
      </td>
      </tr>
    </table>	

	<p>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  <input type="submit" name="Submit" value="Search"> 
        <input type="reset" name="Submit2" value="Clear"></p>
  </form> 


 <form action="locussearch.php" method="GET" > 
     	<h4>Search Reporter Image Database by Locus Name</h4>

     <table cellspacing="0" cellpadding="0" border="0">
      <tr>
      <td valign="bottom">
    Enter an Arabidopsis locus name<br> to view the available reporter images. 
   <br>For example, AT.CHR1.19.84.
      </td>
      <td>
	<textarea cols="30" rows="4" name="locus" multiline="true" value="Please type the locus identifiers you want to search" id="locus" ></textarea>

      </td>
      </tr>
    </table>	

	<p>&nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
        <input type="submit" name="Submit" value="Search"> 
        <input type="reset" name="Submit2" value="Clear"></p>
  </form> 

  <form action="posearch.php" onsubmit="return checkCompare(this)" method="GET"> 
     <h4>Search Reporter Images by PO Code</h4>
     <table cellspacing="0" cellpadding="0" border="0">
      <tr>
      <td valign="bottom">
    Enter a PO code to view<br> the available reporter images. 
      <br>For example,PO:0005660. 
      </td>
      <td>
	<textarea cols="30" rows="4" name="pocode" multiline="true" value="Please type the PO code identifiers you want to search" id="pocode" ></textarea>
      </td>
      </tr>
    </table>	
	<p> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
	<input type="submit" name="Submit" value="Search"> 
        <input type="reset" name="Submit2" value="Clear"></p>
  </form> 



</div> 


</body>

</html>

<script language="JavaScript" type="text/javascript">
<!--
function checkSearch(form) {

    var ta = document.getElementById('locus');

    if (form.gene.value == "") {

        alert("Please enter a genomics locus!");
        return false;
    }

    else if (form.gene.value.length <= 6) {

        alert("Invalid locus identifier, please re-enter!");
        return false;
    }

    return true;
}



//-->
</script>















