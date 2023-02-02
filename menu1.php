<?
 include "../../includes/session.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?
 include "./menudock.php"; 
 
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

</br></br></br></br></br></br></br>
<link href=jws.css rel=stylesheet type=text/css><div align=center><a class=verdana10blk><b>PROFIL AGEN</b></a></div><br>
<table align=center border="0">
<tr><td align=center><a class=verdana10blk href=../ntryagen_new_2019.php><img src="images/baru.gif" width="80" height="80" border=0 alt="Event"></br></a>AGEN BARU</td>
<td align=center><a class=verdana10blk href=../ntryagen_new_lpa.php><img src="images/baru.gif" width="80" height="80" border=0 alt="Event"></br></a>AGEN BARU </br>BANCAS WORKSITE</td>
<td align=center><a class=verdana10blk href=../updatepkajagen.php><img src="images/kontrak.gif" width="80" height="80" border=0 alt="Event"></br></a>KONTRAK AGEN</td>
</tr>
<tr>
	<td align=center><a class=verdana10blk href=../rekomendasi_mutasi_agen><img src="images/update.gif" width="80" height="80" border=0 alt="Event"></br></a>REKOMENDASI <br />MUTASI AGEN </td>
	<td align=center><a class=verdana10blk href=../evaluasiprod_orgedit_d3d1_new.php><img src="images/tetap.gif" width="80" height="80" border=0 alt="Event"></br></a>PENETAPAN AGEN</td>
</tr>
<tr>
	<td align=center><a class=verdana10blk href=../daftar_nama_agen.php><img src="images/update.gif" width="80" height="80" border=0 alt="Event"></br></a>CEK REK AGEN</td>
	<? if ($kantor=='KP' && $modul == 'IBS') { ?>
	<td align=center><a class=verdana10blk href=../approval_spa_new2020.php><img src="images/valroral.gif" width="80" height="80" border=0 alt="Event"></br></a>APPROVAL SPA AGEN *</td>
	<? } ?>
</tr>
<tr>
	<td align=center><a class=verdana10blk href=../updateagen_new.php><img src="images/update.gif" width="80" height="80" border=0 alt="Event"></br></a>UPDATE AGEN</td>
	<td align=center><?php if ($kantor == 'KP') { ?> 
		<a class=verdana10blk href=../historis_spa_new2020.php><img src="images/mis.gif" width="80" height="80" border=0 alt="Event"></br></a>HISTORIS SPA AGEN *
		<?php } ?>
	</td>
</tr>
<tr>
    <?php if (in_array($modul, array('ALL','MKT','ITC'))) { ?>
        <td align=center><a class=verdana10blk href=../updateagen_rekrut.php><img src="images/update.gif" width="80" height="80" border=0 alt="Update Rekrut"></br></a>UPDATE REKRUT</td>
    <?php } ?>
    <td align=center><?php if ($kantor == 'KP') { ?> 
		<a class='verdana10blk' href='../mutasiagen.php'><img src='images/mutasi.gif' width='80' height='80' border='0' alt='Event'></br></a>MUTASI AGEN<?php } ?>
	</td>
	<!-- <td align=center><? if(in_array($userid, array("DEDI","FENDY"))){ ?><a class=verdana10blk href=../hirarkiagen_kumpulan.php><img src="images/baru.gif" width="80" height="80" border=0 alt="Event"></br></a>HIRARKI AGEN<? }else{ echo "&nbsp"; }?>
    </td> -->
</tr>
</body>

</html>
