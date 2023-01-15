<?php

include "../config/koneksi.php";
include "../config/inc.library.php";
error_reporting(0);
//$dataGejala  = $_POST['cekGejala'];
//$datagejala2=$dataGejala; 
//var_dump($dataGejala);
//exit;
$nama=trim($_POST['nama']);
$jnsk=trim($_POST['jnsk']);
$usia=trim($_POST['usia']);
$alamat=trim($_POST['alamat']);
$dataGejala  = $_POST['cekGejala'];

if (empty($nama)){
          echo "<script>window.alert('Anda belum melengkapi semua data');
                window.location=('solusi.html')</script>";}

elseif (empty($jnsk)){
              echo "<script>window.alert('Anda belum mengisikan Jenis Kelamin');
                    window.location=('solusi.html')</script>"; }

elseif (empty($usia)){
              echo "<script>window.alert('Anda belum mengisikan Usia');
                    window.location=('solusi.html')</script>"; }

/*
elseif (($usia <1)||($usia >12)) { 
              echo "<script>window.alert('Usia Anak Minimal 1 Tahun dan Maksimal 12 Tahun');
                    window.location=('solusi.html')</script>"; }
*/

elseif (empty($dataGejala)) { 
              echo "<script>window.alert('Data Gejala Belum di Pilih ');
                    window.location=('solusi.html')</script>"; }

else{
					
mysql_query("insert into pasien values ('','$_POST[nama]','$_POST[jnsk]','$_POST[usia]','$_POST[alamat]')");	

}
$sql = 'select LAST_INSERT_ID() as id_pasien';
$res = mysql_query($sql);
$dt = mysql_fetch_row($res);
$id_pasien = $dt[0];
//echo $id_pasien;

$tampil=mysql_query("SELECT * FROM gejala ORDER BY (SUBSTR(kd_gejala,2,17) + 0) ASC");
$dt = null;
while ($q = mysql_fetch_array($tampil)){
	$dt[] = $q;
}
//$dataGejala  = $_POST['cekaja']; 
$dataGejala  = $_POST['cekGejala']; 


//echo $dataGejala;
//exit;

$HiHasil = array();
//echo $HiHasil;
//exit;
echo "<hr><h3>DATA PASIEN</b><hr><br/>";
echo "<div style='margin-left:20px;'><table class='in' width='60%'>
	  <tr><td>Nama</td><td> : <b>$nama</b></td></tr>
	  <tr><td>Jenis Kelamin</td><td> : <b>$jnsk</b></td></tr>
	  <tr><td>Usia</td><td> : <b>$usia Tahun</b></td></tr>
	  <tr><td>Alamat</td><td> : <b>$alamat</b></td></tr></table><br></div>";

echo "<hr><h3>HASIL DIAGNOSA MENURUT METODE NAIVE BAYES</b><hr><br/>";
$dataGejala2 = array();
$i = 0;
$ya = 17;
$tidak = 2;
foreach($dataGejala as $n){
	if($n == 1){
		array_push($dataGejala2,$dt[$i]);
		$ya++;
	}else{
		$tidak++;
	}
	$i++;
}
if($tidak > $ya){
	echo"<br><br>";
	echo "<h2 align=center> Gejala anda kurang mencukupi, Cek ke dokter untuk memastikan penyakit nya</b></h2>";
}else {
	

//foreach ($dataGejala2 as $nilai) {
//echo $nilai['kd_gejala'];
//}
//exit;


$jum  = count($dataGejala2);
$gjala = array();
echo "<h3>Gejala yang dialami : </h3><br>";
		foreach ($dataGejala2 as $nilai) {
			$gejalaSQL = "SELECT * FROM gejala WHERE kd_gejala='".$nilai['kd_gejala']."'";
			$gejalaQry = mysql_query($gejalaSQL) or die ("Error gejala".mysql_error());
			$gejalaHsl = mysql_fetch_array($gejalaQry);
			echo $gejalaHsl['kd_gejala'].": ".$gejalaHsl['nm_gejala']."<br>";
		 	$kdgejala= $gejalaHsl['kd_gejala'];
			array_push($gjala, $gejalaHsl['kd_gejala']);
			//echo $tes;
			//mysql_query($tes) or die ("Error inTmpSql".mysql_error());
			
		}
		
		
		# TAMPILKAN SEMUA DAFTAR PENYAKIT, Sekaligus membuat Rumus berulang sejumlah Penyakit
		echo "<br>";
		echo "<h3> Step 4 : </h3><hr>";
		$Hi	= 1; $h = 0; $PH = 0;
		$penyakitSql = "SELECT * FROM penyakit";
		$penyakitQry = mysql_query($penyakitSql) or die ("Error penyakit".mysql_error());
	
			$diagnosa = array();
			while ($penyakitData = mysql_fetch_array($penyakitQry)){
		
			$h++;
			#Buat info aja
			echo "<br> <b> $penyakitData[kd_penyakit] $penyakitData[nm_penyakit]</b><br>";
			
			$np_populasi = $penyakitData['np_populasi'];
			
			// Kode untuk mengurai Gejala yang dipilih
			if(count($dataGejala2) <=0 ) {
			$Em=0;
			
			}
			else {
			$Em = 1;
			}

			if(count($dataGejala2) <=0 ) {
				$Em2=0;
				
				}
				else {
				$Em2 = 1;
				}

			// mengambil nilai probabilitas

		
			$nilai_probabilitas = 0;
			foreach ($dataGejala2 as $kd_gejala) {
				$aturanSql  = "SELECT * FROM aturan WHERE kd_penyakit='$penyakitData[kd_penyakit]' AND kd_gejala='".$kd_gejala['kd_gejala']."'";
				$aturanQry  = mysql_query($aturanSql) or die ("Error program".mysql_error());
				$aturanData = mysql_fetch_array($aturanQry);
				
				$kd_gejala2 = $aturanData['kd_gejala'];
				$nilai_probabilitas = $aturanData['nilai_probabilitas'];

				
				
				echo $kd_gejala2." Probabilitas : ".$nilai_probabilitas;
				echo "<br>";
				
				// Periksa jika memiliki Nilai Probabilitas pada tabel aturan
				if(mysql_num_rows($aturanQry) >= 1) {
					$Em = R1($nilai_probabilitas, $np_populasi);
					// echo " hasil :  " .$Em;

					$Em2 = calcKali($Em2,$Em);
					$hasil2 = $np_populasi * $Em2;

					// echo " selesai : " .$hasil2;
					
				}
				else {
					// Jika tidak ada, atau bernilai 0.0000
					$Em = R1($Em, 0.0000);
				}
				
				



			}
			
			
			// Simpan hasil kali ke variabel Array $hiHasil[Hx]
			$HiHasil[$penyakitData['kd_penyakit']] = $hasil2;
	
			// Informasi
			//menghitung 
			echo "<br><br/> <u> Populasi Penyakit $penyakitData[kd_penyakit] </u> = ".$np_populasi;
			echo "<br> <u> p(E01 | Hi) x p(E01 | Hi) x p(En | Hi) : $Em2 * $np_populasi </u> = ".$hasil2;
			echo "<br>";
		}
		
		# HITUNG : STEP 5
		# ========================================================
		echo "<br>";
		echo "<h3> Step 5 : </h3><hr>";
		echo "<br><br>";

		// Kosongkan (jika sudah pernah konsultasi)
		mysql_query("DELETE FROM tmp_diagnosa WHERE ID='$ID'") or die ("Error delete tmp".mysql_error());
		
		$PHitung = array();
	// var_dump($HiHasil);
		
		foreach ($HiHasil as $kode => $nilai) {
			$PHitung[$kode] = calcBagi($nilai, $PH);
			echo "Hasil hitung $kode : ";
			echo "<br><u> p(Hi | E01, E02, En) : $nilai </u> ";
			echo "<br><br>";
			
		
			// Simpan konsultasi ke Temporary
			$inTmpSql = "INSERT INTO tmp_diagnosa (ID,kd_penyakit,hasil_hitung)Values ('$ID','$kode','$nilai')";
						 //echo $inTmpSql ;
			mysql_query($inTmpSql) or die ("Error inTmpSql".mysql_error());
			
			
			
			
			
		}
			//exit;
		# HITUNG : STEP 6 : CARI NILAI MAKSIMAL
		# ========================================================
		echo "<br>";
		echo "<h3> Step 6 : </h3><hr>";
		$maxSql = "SELECT * FROM tmp_diagnosa WHERE hasil_hitung=(SELECT MAX(hasil_hitung) FROM tmp_diagnosa WHERE ID='$ID') AND ID='$ID'";
		$maxQry = mysql_query($maxSql) or die ("Error maxSql".mysql_error());
		$maxHsl = mysql_fetch_array($maxQry);
		
		$maxHasil = $maxHsl['hasil_hitung'];
	

		$penyakit2Sql = "SELECT * FROM penyakit WHERE kd_penyakit='$maxHsl[kd_penyakit]'";
		$penyakit2Qry = mysql_query($penyakit2Sql) or die ("Error penyakit2Sql".mysql_error());
		$penyakit2Hsl = mysql_fetch_array($penyakit2Qry);
		$nm_penyakit = $penyakit2Hsl['nm_penyakit'];
		
		$id_p = $maxHsl[kd_penyakit];
		foreach($gjala as $v){
			$sql ='select * from aturan where kd_penyakit="'.$id_p.'" and kd_gejala ="'.$v.'"';
			$res = mysql_query($sql);
			$hsl = mysql_fetch_row($res);
			$nilai = $hsl[3];
			//echo $nilai;
			//var_dump($hsl);
			//exit;
			//id_p
			//v
			//nilai
			//id_pasien	
			$masuk =("INSERT INTO diagnosa (kd_gejala,kd_penyakit,idpasien,nama,jenis_kelamin,usia,alamat,nilai,tgl_diagnosa) values 									('$v','$id_p','$id_pasien','$nama','$jnsk','$usia','$alamat','$nilai',NOW())");
			//echo $masuk;
			
			mysql_query($masuk) or die ("Error inTmpSql".mysql_error());	
		}

		echo "Kesimpulan diambil paling besar Max(H01, Hn) dengan kode penyakit  <b> $maxHsl[kd_penyakit] = ".$maxHasil."($nm_penyakit) </b>";

		# HITUNG : STEP 7 : INTERPRETASI NILAI PROBABILITAS
		# ========================================================
		echo "<br>";
		echo "<br>";
		echo "<h3> Step 7 : </h3><hr>";	
		if($maxHasil < 0) {
			$hasil = "Tidak diketahui";
		}
		elseif($maxHasil == -1) {
			$hasil = "Negatif";
		}
		elseif($maxHasil >  -1 && $maxHasil <= -0.8) {
			$hasil = "Negatif";
		}
		elseif($maxHasil >  -0.8 && $maxHasil <= -0.6) {
			$hasil = "Negatif";
		}
		elseif($maxHasil >  -0.6 && $maxHasil <= -0.4) {
			$hasil = "Negatif";
		}
		elseif($maxHasil >  -0.4 && $maxHasil <= -0.2) {
			$hasil = "Negatif";
		}
		elseif($maxHasil >  -0.2 && $maxHasil <= -0.2) {
			$hasil = "Negatif";
		}
		elseif($maxHasil >  0.2 && $maxHasil <= 0.4) {
			$hasil = "Positif";
		}
		elseif($maxHasil >  0.4 && $maxHasil <= 0.6) {
			$hasil = "Positif";
		}
		else if($maxHasil >  0.6 && $maxHasil <= 0.8) {
			$hasil = "Positif";
		}
		else if($maxHasil >  0.8 && $maxHasil <= 1) {
			$hasil = "Positif";
		}
		else if($maxHasil > 1) {
			$hasil = "Tidak diketahui";
		}
		echo "<br>";
		echo "Pasien <b>$hasil</b> menderita penyakit <b>$nm_penyakit</b> dengan nilai probabilitas  <b>$maxHasil</b><br/><br/><center><b><a href='solusi.html'>KONSULTASI ULANG</a></b></center>";

}

?>