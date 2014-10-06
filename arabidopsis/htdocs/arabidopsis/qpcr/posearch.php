
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
   <div id="logo" align="center" style="position:absolute; width: 760px; top: 5px; left: 50px;"><img src="/arabidopsis/qpcr/imgs/title_3.jpg"  width="760" height="182"></div> 

        <div id="navsite" align="left" style="position:absolute; width: 760px; top: 210px; left: 50px;"> 
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

<?php
//Notes: 
//JZ2 02/27/2008 PASS LINE_ID add group by locus
//JZ1  03/26/2007 preg_replace
include_once ("dbconnection.php");
$search_pocode=$_GET["pocode"];
$patterns[0]='/^\s+/'; $patterns[1]='/\n/'; $patterns[2]='/\s+$/';
$replacements[0]=''; $replacements[1]=' '; $replacements[2]='';
$search_pocode= preg_replace($patterns, $replacements, $search_pocode);

// $query = "SELECT image_id FROM po_assignment WHERE po_code LIKE '%$search_pocode%' ";

$query = "
SELECT locus_intended,plant_image.image_id FROM `agro_to_plant` LEFT JOIN plant_image ON agro_to_plant.agro_clone_plate = plant_image.agro_clone_plate AND agro_to_plant.agro_clone_well = plant_image.agro_clone_well WHERE plant_image.image_id in
(
SELECT DISTINCT 
po_assignment.image_id
FROM po_assignment WHERE po_code LIKE '%$search_pocode%')
order by locus_intended
 ";


  if (!mysql_select_db("town_at_reporter", $connection))
     showerror();
        
  if (!($result = @ mysql_query ($query, $connection)))
     showerror();
  //added Mar27, JZ1 to check if return 0
   $cnt=0;
  $result2 = @ mysql_query ($query, $connection);
   while($row= @mysql_fetch_array($result2))
   {
     $cnt++;
   }
   if($cnt==0)
   {
      
?>
    <h3>No images were found. Please adjust your search criteria and try again.
    <?php 
    $search_= "<br>Your query was \"$search_pocode\"";
   echo  $search_; ?>.
    </h3>
<?php
   }
   else
   {
 
?>
    <table>
    Query is: <?php echo $search_pocode ?>.
    <col span="3" align="left"  cellspacing="50">
    <tr>

       <th>Locus</th>
       <th>line_id(s)</th>
    </tr>
    <tr>
       (Click each line_id to see details)

    </tr>
    <tr>
<?php
      $last_locus="unknown";
      $cnt3=0;
      while($row= @mysql_fetch_array($result))
      {
         $current_id=$row["image_id"];
         $locus_id=$row["locus_intended"];
         $line_id="";
         $query2 = "SELECT CONCAT_WS( '-',agro_clone_plate,  agro_clone_well, dip_number, plant_number)  FROM plant_image WHERE image_id='$current_id' ";
         $po_result = mysql_query ($query2, $connection);
         while($po_row=@mysql_fetch_array($po_result))
         {
            $line_id=$po_row[0];  
         }
         if(!($line_id)) {$line_id="Unknown";}

         //<tr>
         if(strcmp($locus_id,$last_locus)!=0 )
         {
            echo "<tr>";
            echo " <th align=\"left\">";
            echo $locus_id;
            $cnt3=0;
         }
         else
         {
            $cnt3++;
	    if(($cnt3 % 5)==0)
	    {
               echo " <tr>";
               echo " <th>";
	    }
            //echo $cnt3;
         }
         $last_locus=$locus_id;
         echo "</th>";
         echo "<td>";

?>
<a href="line_id.php?current_id=<?php echo $current_id;?>&line_id=<?php echo $line_id;?>&locus_id=<?php echo $locus_id;?>">
     <?php echo $line_id;?></a>
<?php
         echo "</td>";
       } //end while loop
   }//end else <table>
?>
   </tr>
</table>

    <h3>&nbsp;</h3>

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
          <td > <div align="right"><font size="-2">Last updated by Jun Zhuang; Feb 27,2008
             </font></a> |  <font size="-2">&copy; <script type="text/javascript">var now = new Date(); year = now.getFullYear(); document.write(year);</script> The Institute 
              for Genomic Research, a division of <a href="http://jcvi.org/" class="c">J. Craig Venter Institute</a></font></div></td>

        </tr>
      </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td width="377">&nbsp;</td>
    <td>&nbsp;</td>

</table>
</body>
</html>
