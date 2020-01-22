<?php

require( "..\..\inc\db.php" );

$output = '';
if ( isset( $_POST[ "query" ] ) ) {
	$search = mysqli_real_escape_string( $conn, $_POST[ "query" ] );
	$sql = "
	SELECT *, TIME_FORMAT(start_time, '%H:%i') as st,TIME_FORMAT(end_time, '%H:%i') as et,
			DATE_FORMAT(meeting_day, '%d/%m/%Y') as md, date_format(DATE_ADD(meeting_day, INTERVAL 543 year),'%d/%m/%Y') as thaidate
			FROM agenda 
	WHERE agenda_subject LIKE '%" . $search . "%'
	OR meeting_day LIKE '%" . $search . "%' 
	OR round LIKE '%" . $search . "%' 
	";
} else {
	$sql = "
	SELECT *, TIME_FORMAT(start_time, '%H:%i') as st,TIME_FORMAT(end_time, '%H:%i') as et,
			DATE_FORMAT(meeting_day, '%d/%m/%Y') as md, date_format(DATE_ADD(meeting_day, INTERVAL 543 year),'%d/%m/%Y') as thaidate
			FROM agenda order by meeting_day asc ";
}
//echo $sql;
$result = mysqli_query( $conn, $sql );
if ( mysqli_num_rows( $result ) > 0 ) {

	$output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th>หัวข้อการประชุม</th>
							<th>วันเวลา</th>
							<th></th>
						</tr>';
	$i = 1;
	while ( $row = mysqli_fetch_array( $result ) ) {
		
		$agenda_id = $row[ "agenda_id" ];
		$agenda_subject = $row[ "agenda_subject" ];
		$round = $row[ "round" ];
		$thaidate = $row[ "thaidate" ];
		$st = $row[ "st" ];
		$et = $row[ "et" ];
		$md= $row["md"];
		$output .= '<tr>
				<td><a href="home.php?menu=agenda&sub=read&a='. $agenda_id .'" class="btn btn-outline-success" >' . $i . ". " .$agenda_subject . ' ครั้งที่ ' . $round . '</a></td>
				<td>' . $md . ' ' . $st . ' - ' . $et . ' น.</td>';
		$output .= '<td>
					<a href="home.php?menu=agenda&sub=read&a=' . $agenda_id .  '" title="รายละเอียด" data-toggle="tooltip"><span><i class="fas fa-eye fa-2x"></i></span></a>
					<a href="home.php?menu=agenda&sub=editagenda&a=' . $agenda_id .  '" title="แก้ไข" data-toggle="tooltip"><span><i class="fas fa-edit fa-2x"></i></span></a>			
					<a href="home.php?menu=agenda&sub=deleteagenda&a= ' . $agenda_id  . '" onclick="return confirm(Are you sure?)" title="ลบ" data-toggle="tooltip"><span><i class="fas fa-trash-alt fa-2x"></i></span></a>
</td>
			</tr>
		';
		$i++;
	}
	echo $output;
} else {
	$output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th>หัวข้อการประชุม</th>
							<th>วันเวลา</th>
							<th>#</th>

						</tr>';
	$output .= '<tr>
	<td>ไม่พบข้อมูลที่ตรงกับที่ค้นหา
	</td>
	</tr>
	</table>
	';
	echo $output;
}
?>