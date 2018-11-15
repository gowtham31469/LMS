/**
*	This function is used to search book loans
*/
function searchBookLoans() {
	$.ajax({
		url: base_url + "/search-book-loans",
		type: "Post",
		dataType: "json",
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			value: $('#searchValue').val()
		},
		beforeSend: function () {

		},
		success: function (data) {
			$("#results").html(`
				 <table class="table table-bordered table-striped table-hover listing-table">
					<thead>
					  <tr>
						<th>Book ID</th>
						<th>Title</th>
						<th>Card Numer</th>
						<th>Borrower Name</th>
<th>Actions</th>
					  </tr>
					</thead>
					<tbody>
					  
					</tbody>
				  </table>`);
			$.each(data, function (index, item) {

				$(".listing-table tbody").append(`
				  <tr>
						<td>` + item.book_id + `</td>
						<td>` + item.title + `</td>
						<td>` + item.card_no + `</td>
						<td>` + item.first_name + ` ` + item.last_name + `</td>
						<td><button  class="btn btn-info btn-sm" onclick="checkIn(` + item.id + `)">CheckIn</button></td>
				  </tr>
			`);
			});
			$('.listing-table').DataTable();
		},
		error: function (data) {

		},
		complete: function () {

		}
	})
}
/**
*	This function is used to check in the books
*/
function checkIn(id) {
	$.ajax({
		url: base_url + "/check-in-books",
		type: "Post",
		dataType: "json",
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			id: id
		},
		beforeSend: function () {

		},
		success: function (data) {
			var x = document.getElementById("snackbar")

			// Add the "show" class to DIV
			x.className = "show";

			// After 3 seconds, remove the show class from DIV
			setTimeout(function () {
				x.className = x.className.replace("show", "");
			}, 3000);
			searchBookLoans()
		},
		error: function (data) {

		},
		complete: function () {

		}
	})
}


/**
*	This function is used to check out the books
*/
function checkout() {
	$.ajax({
		url: base_url + "/check-out-books",
		type: "Post",
		dataType: "json",
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			id: $('#borrower').val(),
			book_id: $('#book_id').val(),
			branch_id: $('#branch_id').val()
		},
		beforeSend: function () {

		},
		success: function (data) {
			if (data == false) {
				$('.error-msg').removeClass('hidden')
			} else {
				$('.error-msg').addClass('hidden')
				$('#checkoutModal').modal("hide")

				var x = document.getElementById("snackbar")

				// Add the "show" class to DIV
				x.className = "show";

				// After 3 seconds, remove the show class from DIV
				setTimeout(function () {
					x.className = x.className.replace("show", "");
				}, 3000);
				searchBooks()
			}

		},
		error: function (data) {

		},
		complete: function () {

		}
	})
}

/**
*	This function is used to search books
*/
function searchBooks() {
	$.ajax({
		url: base_url + "/search-books",
		type: "Post",
		dataType: "json",
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			value: $('#searchValue').val()
		},
		beforeSend: function () {

		},
		success: function (data) {
			$("#results").html(`
				 <table class="table table-bordered table-striped table-hover listing-table">
					<thead>
					  <tr>
						<th>Book ID</th>
						<th>Title</th>
						<th>Authors</th>
						<th>Branch Name</th>
						<th>No of Copies</th>
						<th>Available</th>
<th>Actions</th>
					  </tr>
					</thead>
					<tbody>
					  
					</tbody>
				  </table>`);
			$.each(data, function (index, item) {
				var disabled = item.available == 0 ? "disabled" : "";
				$(".listing-table tbody").append(`
				  <tr>
						<td>` + item.book_id + `</td>
						<td>` + item.title + `</td>
						<td>` + item.authors + `</td>
						<td>` + item.branch_name + `</td>
						<td>` + item.no_of_copies + `</td>
						<td>` + item.available + `</td>
						<td><button ` + disabled + ` class="btn btn-info btn-sm" onclick="openmodal('` + item.book_id + `','` + item.branch_id + `')">Checkout</button></td>
				  </tr>
			`);
			});
			$('.listing-table').DataTable();
		},
		error: function (data) {

		},
		complete: function () {

		}
	})
}

/**
*	This function is used to open a checkout modal
*/

function openmodal(book_id, branch_id) {
	$('#book_id').val(book_id)
	$('#branch_id').val(branch_id)
	$('.error-msg').addClass('hidden')
	$('#checkoutModal').modal("show")
}