@extends('layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Check Out</div>
				<div class="panel-body">
					<div class="col-xs-4"></div>
					<div class="col-xs-4">
						<div class="input-group">
							<input type="text" id="searchValue" class="form-control" placeholder="Search">
							<span onclick="searchBooks()" class="input-group-addon"><img class="img cursor" src="{{ asset('images/search.png') }}"></span>
						</div>
					</div>
					<div id="results">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="checkoutModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Check Out</h4>
      </div>
      <div class="modal-body">
		  <input type="hidden" id="book_id">
		  <input type="hidden" id="branch_id">
		  <div class="error-msg hidden">
			   <label class="label label-danger">Maximum Limit Reached for particular user</label>
		  </div>
		   <div>
			    <select id="borrower" style="width:50%">
				  @foreach($borrower as $vals)
					<option value="{{$vals->card_no}}">{{$vals->first_name}} {{$vals->last_name}}</option>
				  @endforeach
				  </select>
		  </div>
      </div>
      <div class="modal-footer">
		<button type="button" onclick="checkout()" class="btn btn-default">Checkout</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div id="snackbar">Checkout completed</div>
@endsection @section('jqueryIncludes')
<script>
	 $(document).ready(function() {
		 	   $('.check-out').addClass('custom-nav-bar-active')
               $('#borrower').select2();
     });
</script>
@endsection
