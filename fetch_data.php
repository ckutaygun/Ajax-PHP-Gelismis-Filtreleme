<?php

//fetch_data.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM otomobil WHERE oto_durum = '1'
	";
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		 AND oto_fiyat BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["marka"]))
	{
		$marka_filter = implode("','", $_POST["marka"]);
		$query .= "
		 AND oto_marka IN('".$marka_filter."')
		";
	}
	if(isset($_POST["renk"]))
	{
		$renk_filter = implode("','", $_POST["renk"]);
		$query .= "
		 AND oto_renk IN('".$renk_filter."')
		";
	}
	if(isset($_POST["yil"]))
	{
		$yil_filter = implode("','", $_POST["yil"]);
		$query .= "
		 AND oto_yil IN('".$yil_filter."')
		";
	}
    if(isset($_POST["tur"]))
    {
        $ototur_filter = implode("','", $_POST["tur"]);
        $query .= "
		 AND oto_tur IN('".$ototur_filter."')
		";
    }

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
			<div class="col-sm-4 col-lg-3 col-md-3">
				<div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:450px;">
					<img src="image/'. $row['oto_foto'] .'" alt="" class="img-responsive" >
					<p align="center"><strong><a href="#">'. $row['oto_name'] .'</a></strong></p>
					<h4 style="text-align:center;" class="text-danger" >'. $row['oto_fiyat'] .'</h4>
					<p>Tür : '. $row['oto_tur'].' <br />
					Marka : '. $row['oto_marka'] .' <br />
					Yıl : '. $row['oto_yil'] .' <br />
					Renk : '. $row['oto_renk'] .'</p>
				</div>

			</div>
			';
		}
	}
	else
	{
		$output = '<h3>Araç Bulunamadı!</h3>';
	}
	echo $output;
}

?>