
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


<!--
     <h4 align="center" size="12">Search Reporter Image Database</h4> 
-->

<?php
//04/17/2008,  new interface, not show multiple images with the same line_id and locus_id
// 11/27/2007  add "expression"; new <th>?? pass 4,3line_id locus_id
//updated  08/07/2007 
//JZ1  06/06/2007 new code
   include_once ("dbconnection.php");
   $current_id=$_GET["current_id"];
   $line_id=$_GET["line_id"];
   $locus_id=$_GET["locus_id"];
    
    //clean the begin/end of a string,  leave no space
   $patterns[0]='/^\s+/'; $patterns[1]='/\n/'; $patterns[2]='/\s+$/';
   $replacements[0]=''; $replacements[1]=' '; $replacements[2]='';
   $current_id= preg_replace($patterns, $replacements, $current_id);

   $id_list= preg_split("/[\s,]+/", $current_id);

?>
    <b>  
    line_id is <?php echo "$line_id";?> ;  Promoter from locus  
      <a href="get_locus_seq.php?file=<?php echo "$locus_id";?>">
      <font size="4">
      <?php echo "{$locus_id}";?>
      </font></a> 
    </b>
    <table>
    <col span="1" align="left">
    <tr>
    </tr>
    <tr>
       <th>Thumbnails</th>
       <th></th>
       <th></th>
       <th>PO code</th>
       <th></th>
       <th>expression</th>
       <th>PO name</th>

    </tr>
    <tr>

<?php
   for($i=0; $i < count($id_list); $i++) { 
      $current_id=$id_list[$i];
   //if($cnt>=0  ) {
    //$search_= "<br>Your query was line_id:$line_id ";
?>
    
<th><hr width=160 > <a href="view.php?file=<?php echo $current_id ;?>"><IMG src="view.php?file=<?php echo $current_id;?>" width=160 height=120 border=1></a>
</th>
<th/>
<th/>
<?php 
      $po_set="";
      $exp_set="";
      //$query2 = "SELECT po_code,expression FROM po_assignment WHERE image_id='$current_id' ";
      $query2 = "SELECT po_code,expression FROM po_assignment WHERE image_id in ('$current_id') ";
      $po_result = mysql_query ($query2, $connection);
      while($po_row=@mysql_fetch_array($po_result))
      {
         $po_set[]=$po_row["po_code"];
         $exp_set[]=$po_row["expression"];
      }
      if(!($po_set[0]))
      {
         $po_set[0]="Unknown PO Code";
         $exp_set[0]="n/a";
      }
      $cnt_po=0;
      foreach ($po_set as $member)
      {
	 if($cnt_po>0)
	 {
            echo "<tr>";
            echo "<th>";
            echo "<th>";
            echo "<th>";
	 }
         $cnt_po++;
	 $exp_yes=$exp_set[$cnt_po-1];
?>
<th>
      <a href="get_po.php?member=<?php echo "$member";?>">
      <font size="2">
      <?php echo "{$member}";?>
      </font></a>
<th/>
</th>
<th>
<?php
         echo "$exp_yes";
         echo "</th>";
         echo "<th>";
         $query3 = "SELECT name, def FROM po_code WHERE po_code LIKE '$member%' ";
         $description = mysql_query ($query3, $connection);
         $description_row=@mysql_fetch_array($description);
?>
        <font size="2">
<?php
         echo $description_row["name"];
?>
      </font> 
</th>
<th> 
</th>
<?php
       }  //foreach loop
//JZ2 May 07, 2007 , Move next line </tr> down from up
?>
</tr>
<?php
   }// end for loop
?>
    <hr>
    </table>

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
          <td > <div align="right"><font size="-2">Last updated by Jun Zhuang 12-04-2007
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
</body>
</html>

