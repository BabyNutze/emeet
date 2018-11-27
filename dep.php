<!DOCTYPE html>
<?php
include 'db.php';
?>

<html>

<head>
	<title>me</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script>
		$( document ).ready( function () {
			$( '#committee_id' ).on( 'change', function () {
				var committee_id = $( this ).val();
				console.log( committee_id );
				if ( committee_id ) {
					$.ajax( {
						type: 'POST',
						url: 'data.php',
						data: 'committee_id=' + committee_id,
						success: function ( html ) {
							$( '#subcommittee_id' ).html( html );
						}
					} );
				} else {
					$( '#subcommittee' ).html( '<option value="">Select country first</option>' );
				}
			} );


		} );
	</script>
</head>

<body>
	<?php
	$query = $conn->query( "SELECT * FROM committee" );

	//Count total number of rows
	$rowCount = $query->num_rows;
	?>
	<form name="frmMain" action="getvar.php" method="post">
		<select id="committee_id" name="committee_id">
			<option value="">Select committee</option>
			<?php
			if ( $rowCount > 0 ) {
				while ( $row = $query->fetch_assoc() ) {
					echo '<option value="' . $row[ 'committee_id' ] . '">' . $row[ 'committee_name' ] . '</option>';
				}
			} else {
				echo '<option value="">committee not available</option>';
			}
			?>
		</select>

		<select id="subcommittee_id" name="subcommittee_id">
			<option value="">Select committee first</option>
		</select>
		<input type="submit" value="ยืนยัน">
	</form>

</body>

</html>