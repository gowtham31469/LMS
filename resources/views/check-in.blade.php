@extends('layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Check In</div>
				<div class="panel-body">
					<div class="col-xs-4">
					
					</div>
					<div class="col-xs-4">
						<div class="input-group">
							<input type="text" id="searchValue" class="form-control" placeholder="Search">
							<span onclick="searchBookLoans()" class="input-group-addon"><img class="img cursor" src="{{ asset('images/search.png') }}"></span>
						</div>
					</div>
					<div id="results">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="snackbar">Checkin completed</div>
@endsection @section('jqueryIncludes')
<script>
	 $(document).ready(function() {
		 	   $('.check-in').addClass('custom-nav-bar-active')
     });
</script>
@endsection
