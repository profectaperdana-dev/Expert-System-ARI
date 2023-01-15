<style type="text/css">
.style1 {
	color: #336699;
}
</style>
<span class="style1"></span>
<?php

echo "
<div class=judul align=center><h2>Daftar Penyakit Terdaftar</h2></div>
<br/><br/><br/>"; 
	
	$sql=mysql_query("SELECT * FROM penyakit");
	$no=1; 
	echo "<br/>
	<table id=o  align=center border=3 width=900px><tbody> <tr>
			  <th class=th>No</th>
			  <th class=th>Nama</th>
			  <th class=th>Pencegahan</th>
			  <th class=th>Pengobatan</th>
	      </tr>";
    while($q=mysql_fetch_array($sql)){
	if (($no % 2) > 0)
            $bg = '#ffffff'; else
            $bg = '#f5f5f5';
       echo "	         
         
		  <tr bgcolor=" . $bg . ">
		      <td class=td align=center>$no</td>
              <td class=td>$q[nm_penyakit]</td>
              <td class=td>$q[pencegahan]</td>
              <td class=td>$q[pengobatan]</td>  
		 </tr>";
		 $no++;
		 }
		 echo"
		 
		 </tbody></table><hr><br/>";




?>
