
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
      <li><a href="/arabidopsis/qpcr/expression.php">Promoter Results</a></li>
          <li><a href="/arabidopsis/qpcr/contact.shtml">Contact</a></li>
          <li><a href="http://www.tigr.org">TIGR Home</a></li> 
     </ul> 
        </div> 

       <div id="main_content"  style="position:absolute; width: 760px; top: 250px; left: 50px;"> 


   <!--   <h4 align="center" size="12">Search Reporter Image Database</h4> 
   -->

<?php
//Notes: 
//JZ4  05/19/2008, working new interface, all same line_id are joined.
//JZ2 02/27/2008 PASS LINE_ID add group by locus ;  $line_id="$line_id-$current_id" ??
//JZ1  03/26/2007 preg_replace

include_once ("dbconnection.php");
$search_locus=$_GET["locus"];

$patterns[0]='/^\s+/'; $patterns[1]='/\n/'; $patterns[2]='/\s+$/';
$replacements[0]=''; $replacements[1]=' '; $replacements[2]='';
$search_locus= preg_replace($patterns, $replacements, $search_locus);
//New array (as a hash in PHP) , March, 2008
$ary[0]="na";
//To do:fix query, use two left join of 2 table instead of left join 3 table at time.
$query = "SELECT locus_intended, plant_image.image_id FROM `agro_to_plant`
LEFT JOIN plant_image ON agro_to_plant.agro_clone_plate = plant_image.agro_clone_plate
AND agro_to_plant.agro_clone_well = plant_image.agro_clone_well
WHERE agro_to_plant.locus_intended='$search_locus' AND plant_image.image_id > 0
GROUP BY plant_image.image_id";

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
    $search_tissue= "<br>Your query was \"$search_locus\"";
   echo  $search_tissue; ?>.
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
      $cnt2=0;
      $arr_1 = array();
      $current_id_list="";

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
         $arr_1[$current_id]=$line_id ;
         $last_locus=$locus_id;

       } //end while loop
       //May,2008
      if(count($arry_1) >-1)
      {
	 asort($arr_1);
	 $last_value="na";
         echo "<tr>";
         echo " <th align=\"left\">";
         echo "$last_locus" ;
	 foreach($arr_1 as $key => $value) //$current_id => $line_id
	 {
            // echo "  sub list Got  $key => $value ";
	    if( strcmp($value,$last_value)!=0   &&  strcmp("na",$last_value)!=0)
	    {
               //echo "key/value=".$key . " = " . $value . "<br>";
               echo "<td>";
?>   
<a href="line_id.php?current_id=<?php echo $current_id_list;?>&line_id=<?php echo $last_value;?>&locus_id=<?php echo $last_locus;?>">
<?php echo "$last_value";?></a>
          <?php
               $current_id_list=$key;
               echo "</td>";
               $cnt2++;
	       if(($cnt2 % 5)==0)
	       {
                   echo "<tr>";
                   echo "<th>";
	       }
	    }
	    else
	    {
	       $current_id_list=$current_id_list." ".$key;
	    }
	    $last_value=$value;
	 }
	 if(strcmp($current_id_list,"") !=0)
	 {
	    echo "<td>";
?>   
<a href="line_id.php?current_id=<?php echo $current_id_list;?>&line_id=<?php echo $last_value;?>&locus_id=<?php echo $last_locus;?>">
<?php echo "$last_value";?></a>
          <?php
            $current_id_list="";
            echo "</td>";

         }
         echo "</th>";
         echo "</tr>";
      } //end new	

   
   }//old,  end else <table>
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
          <td > <div align="left"><font size="-2">Last updated by Jun Zhuang; March 07,2008
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

