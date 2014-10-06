
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
<body style="margin-left":50%;">
<div id="container" style="position:relative; width: 760px; ">
	<div id="logo" align="center" style="position:absolute; width: 760px; top: 5px; left: 50px;"><img src="/arabidopsis/qpcr/imgs/title_3.jpg"  width="760" height="182" ></div> 
     	<div id="navsite" align="center" style="position:absolute; width: 760px; top: 210px; left: 50px;"> 
  	<ul> 
    		<li><a href="/arabidopsis/qpcr/index.shtml">Home</a></li> 
    		<li><a href="/arabidopsis/qpcr/search.php">Gene Expression</a></li> 
    		<li><a href="/arabidopsis/qpcr/genelist.php">Gene List</a></li> 
		<li><a href="/arabidopsis/qpcr/protocols.php">Protocols</a></li>
		<li><a href="/arabidopsis/qpcr/expression.php">Promoter Results</a></li>
    		<li><a href="/arabidopsis/qpcr/contact.shtml">Contact</a></li>
    		<li><a href="http://www.tigr.org">TIGR Home</a></li> 

  	</ul> 
     	</div> 

    	<div id="main_content"  style="position:absolute; width: 760px; top: 250px; left: 40px;"> 

 	 <h4 align="center" size="12">Locus in TIGR Arabidopsis Study</h4> 

<?php
include_once ("dbconnection.php");
$member=$_GET["member"];

  if (empty($member))
     exit;

  $query="SELECT sequence FROM target WHERE locus='$file'";
  $query = "SELECT name, def FROM po_code WHERE po_code LIKE '$member%' ";

  if (!mysql_select_db("town_at_reporter", $connection))
     showerror();
        
  if (!($result = @ mysql_query ($query, $connection)))
     showerror();
  $description = mysql_query ($query, $connection);
   $description_row=@mysql_fetch_array($description);
   echo "$member";
   echo "<P>";
   echo $description_row["name"];
   echo "<P>";
   echo $description_row["def"]; 
   echo "<P>";
?>

<table>
  <tr> 
    <td>&nbsp;</td>
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
              for Genomic Research, a division of <a href="http://www.jcvi.org" class="c">J. Craig Venter Institute</a></font></div></td>

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
