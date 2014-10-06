
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


	<div id="logo" align="center" style="position:absolute; width: 760px; top: 5px; left: 50px;"><img src="/arabidopsis/qpcr/imgs/title_4.jpg"  width="760" height="182"></div> 





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


 	 <h4 align="center" size="12">Gene List in TIGR Arabidopsis Study</h4> 


<?php
include_once ("dbconnection.php");
$file=$_GET["file"];


  if (empty($file))
     exit;

$query="SELECT sequence FROM target WHERE target_id='$file'";

  if (!mysql_select_db("town_at_qpcr", $connection))
     showerror();
        
  if (!($result = @ mysql_query ($query, $connection)))
     showerror();
?>

    <h3>Sequence of <?php echo $file;?> &nbsp <a href="downloadfile.php?file=seqfile.fasta" style="text-decoration: none;"><button >Download Sequence</button></a> </h3>

 <p style="font-family: courier new, serif">
><?php echo $file;?> </p>


<?php
$row= @mysql_fetch_array($result);
$seq=$row["sequence"];
$length=strlen($seq);
$start=0;
$end=80;

$Handle = fopen("seqfile.fasta", 'w');

fwrite($Handle, ">");

fwrite($Handle, $file);
fwrite($Handle, "\n");
fwrite($Handle, $seq);
fwrite($Handle, "\n");

fclose($Handle); 


	while($start < $length){

	if($start>($length-80)){$end=$length-$start;}




?>

 <p  style="font-family: courier new, serif; line-height:50%">
<?php echo substr($seq,$start,$end);?>
</p>

<?php
	$start+=80; 
   } 
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
          <td > <div align="right"><font size="-2">Last updated by Hui Quan 
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
