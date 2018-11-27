<?php


if ( isset( $_GET[ "ag" ] ) && !empty( trim( $_GET[ "ag" ] ) ) ) {

	// Prepare a select statement
	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et , term_no, term_subject , subterm.subterm_subject
	FROM agenda 
	LEFT JOIN term ON agenda.agenda_id = term.agenda_id 
	LEFT JOIN subterm on subterm.term_id = term.term_id
	WHERE agenda.agenda_id = " . $_GET[ 'ag' ] . " and term.term_id = " . $_GET[ 't' ];

	if ( $result = mysqli_query( $conn, $sql ) ) {
		if ( mysqli_num_rows( $result ) == 1 ) {
			/* Fetch result row as an associative array. Since the result set
			contains only one row, we don't need to use while loop */
			$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );

			// Retrieve individual field value
			$agenda_id = $row[ "agenda_id" ];
			$agenda_subject = $row[ "agenda_subject" ];
			$md = $row[ "md" ];
			$st = $row[ "st" ];
			$et = $row[ "et" ];
			$term_subject = $row[ "term_subject" ];
			$term_no = $row[ "term_no" ];

		} else {
			// URL doesn't contain valid id parameter. Redirect to error page
			header( "location: error.php" );
			exit();
		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ "agenda_id" ] ) && !empty( $_POST[ 'hdnCount' ] ) && isset( $_POST[ "term_id" ] ) ) {
	for ( $i = 1; $i <= ( int )$_POST[ "hdnCount" ]; $i++ ) {
		$sql = "SELECT MAX(subterm_id) AS subterm_id FROM subterm";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$subterm_id = $row[ "subterm_id" ] + 1;
			}
		} else {
			$subterm_id = 1;
		}
		$term_id = $_POST[ "term_id" ];


		if ( isset( $_POST[ "subterm_no$i" ] ) ) {
			if ( $_POST[ "subterm_no$i" ] != "" ) {

				$sql = "INSERT INTO subterm (subterm_id,  agenda_id, term_id, subterm_no, subterm_subject) 
					VALUES ($subterm_id, $agenda_id, $term_id, '" . $_POST[ "subterm_no$i" ] . "','" . $_POST[ "subterm_subject$i" ] . "')";
				echo $sql;
				$query = mysqli_query( $conn, $sql );
				if ( $conn->query( $sql ) === TRUE ) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}




			}
		}
	}

} else {

}

?>

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header clearfix">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item" aria-current="page"><a href="home.php?menu=agenda">งานประชุม</a>
							</li>
							<li class="breadcrumb-item"><a href="home.php?menu=agenda&sub=read&ag=<?php echo $agenda_id;?>">
								<?php echo $agenda_subject . " วันที่ " . $md. " เวลา " . $st . "-" . $et ; ?></a>
							</li>							
							<li class="breadcrumb-item active" aria-current="page">
								<?php echo $term_subject ; ?>
							</li>
						</ol>
					</nav>
				</div>
				<?php 
				$term_id = $_GET["t"];
				?>

				<br>
				<h3>
					<?php echo $agenda_subject ;  ?>
				</h3>
				<form action="" id="addsubtermform" name="addtermform" method="post">
					<h5>
						<?php echo $term_no ." " .$term_subject ;  ?>
					</h5>
					<br>
					<label for="editor1">รายละเอียด</label>
					<textarea id="editor1">
		&lt;h2 style="text-align: center;"&gt;The Flavorful Tuscany Meetup&lt;/h2&gt;
		&lt;p style="text-align: center;"&gt;&lt;span style="color: #007ac9;"&gt;&lt;strong&gt;Welcome letter&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;
		&lt;p&gt;Dear Guest,&lt;/p&gt;
		&lt;p&gt;We are delighted to welcome you to the annual &lt;em&gt;Flavorful Tuscany Meetup&lt;/em&gt; and hope you will enjoy the programme as well as your stay at the Bilancino Hotel.&lt;/p&gt;
		&lt;p&gt;Please find below the full schedule of the event.&lt;/p&gt;
		&lt;table class="schedule" cellpadding="15" cellspacing="0" style="border-collapse:collapse;width:100%;"&gt;
			&lt;thead&gt;
				&lt;tr&gt;
					&lt;th colspan="2" scope="col" style="background-color: #F2F9FF; text-align: center; font-size: 21px;"&gt;&lt;span&gt;Saturday, July 14&lt;/span&gt;&lt;/th&gt;
				&lt;/tr&gt;
			&lt;/thead&gt;
			&lt;tbody&gt;
				&lt;tr&gt;
					&lt;td style="white-space:nowrap;"&gt;&lt;span&gt;9:30 AM - 11:30 AM&lt;/span&gt;&lt;/td&gt;
					&lt;td&gt;&lt;span&gt;Americano vs. Brewed - “know your coffee” session with &lt;strong&gt;Stefano Garau&lt;/strong&gt;&lt;/span&gt;&lt;/td&gt;
				&lt;/tr&gt;
				&lt;tr&gt;
					&lt;td style="white-space:nowrap;"&gt;&lt;span&gt;1:00 PM - 3:00 PM&lt;/span&gt;&lt;/td&gt;
					&lt;td&gt;&lt;span&gt;Pappardelle al pomodoro - live cooking session with &lt;strong&gt;Rita Fresco&lt;/strong&gt;&lt;/span&gt;&lt;/td&gt;
				&lt;/tr&gt;
				&lt;tr&gt;
					&lt;td style="white-space:nowrap;"&gt;&lt;span&gt;5:00 PM - 8:00 PM&lt;/span&gt;&lt;/td&gt;
					&lt;td&gt;&lt;span&gt;Tuscan vineyards at a glance - wine-tasting session with &lt;strong&gt;Frederico Riscoli&lt;/strong&gt;&lt;/span&gt;&lt;/td&gt;
				&lt;/tr&gt;
			&lt;/tbody&gt;
		&lt;/table&gt;
		&lt;blockquote&gt;
			&lt;p&gt;The annual Flavorful Tuscany meetups are always a culinary discovery. You get the best of Tuscan flavors during an intense one-day stay at one of the top hotels of the region. All the sessions are lead by top chefs passionate about their profession. I would certainly recommend to save the date in your calendar for this one!&lt;/p&gt;
			&lt;p&gt;Angelina Calvino, food journalist&lt;/p&gt;
		&lt;/blockquote&gt;
		&lt;p&gt;Please arrive at the Bilancino Hotel reception desk at least &lt;strong&gt;half an hour earlier&lt;/strong&gt; to make sure that the registration process goes as smoothly as possible.&lt;/p&gt;
		&lt;p&gt;We look forward to welcoming you to the event.&lt;/p&gt;
		&lt;p&gt;&lt;/p&gt;
		&lt;p&gt;&lt;strong&gt;Victoria Valc&lt;/strong&gt;&lt;/p&gt;
		&lt;p&gt;&lt;strong&gt;Event Manager&lt;/strong&gt;&lt;/p&gt;
		&lt;p&gt;&lt;strong&gt;Bilancino Hotel&lt;/strong&gt;&lt;/p&gt;
	</textarea>
				


					<input type="submit" value="บันทึก">
				</form>


			</div>
		</div>
	</div>
</div>
<script>
	CKEDITOR.plugins.add( 'uploadfile', {
		requires: 'uploadwidget,link',
		init: function( editor ) {
			// Do not execute this paste listener if it will not be possible to upload file.
			if ( !CKEDITOR.plugins.clipboard.isFileApiSupported ) {
				return;
			}

			var fileTools = CKEDITOR.fileTools,
				uploadUrl = fileTools.getUploadUrl( editor.config );

			if ( !uploadUrl ) {
				CKEDITOR.error( 'uploadfile-config' );
				return;
			}

			fileTools.addUploadWidget( editor, 'uploadfile', {
				uploadUrl: fileTools.getUploadUrl( editor.config ),

				fileToElement: function( file ) {
					// Show a placeholder with an empty link during the upload.
					var a = new CKEDITOR.dom.element( 'a' );
					a.setText( file.name );
					a.setAttribute( 'href', '#' );
					return a;
				},

				onUploaded: function( upload ) {
					this.replaceWith( '<a href="' + upload.url + '" target="_blank">' + upload.fileName + '</a>' );
				}
			} );
		}
	} );
</script>