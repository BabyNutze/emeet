<script>
	$( document ).ready( function () {
		load_data();

		function load_data( query ) {
			$.ajax( {
				url: "menu/agenda/ajaxsearchagenda.php",
				method: "post",
				data: {
					query: query
				},
				success: function ( data ) {
					$( '#result' ).html( data );
				}
			} );
		}

		$( '#search_text' ).keyup( function () {
			var search = $( this ).val();
			if ( search != '' ) {
				load_data( search );
			} else {
				load_data();
			}
		} );
	} );
</script>
<div class="wrapper">
	<div class="container bg-dark">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header clearfix">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php" class="btn btn-outline-danger">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item"><a href="home.php?menu=agenda" class="btn btn-outline-danger">งานประชุม</a></li>							
							<li class="breadcrumb-item active"><button type="button" class="btn btn-danger" disabled>ค้นหาการประชุม</button></li>
						</ol>
					</nav>
					<div class="float-right"><a href="?menu=agenda&sub=addagenda" class="btn btn-outline-info">เพิ่มการประชุม</a>
				</div>

			</div>
				<br>
			<h2></h2>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">ค้นหา</span>
				</div>
				<input type="text" name="search_text" id="search_text" class="form-control"/>
			</div>

			<div id="result"></div>

		</div>
	</div>
</div>
</div>