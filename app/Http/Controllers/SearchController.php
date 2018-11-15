<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @return json Value
     */
    public function index(Request $request)
    {
       $value= $request->value;
		
		
		 $books = DB::table('books')
			 ->join('book_copies','books.book_id','book_copies.book_id')
		     ->join('library_branch','book_copies.branch_id','library_branch.branch_id')
  			 ->leftJoin('book_authors', function ($join) use ($value) {
				  $join->on('book_authors.book_id', '=', 'books.book_id');
			  })
		     ->where('books.book_id', 'like',"%".$value."%")
			 ->orWhere('books.title', 'like',"%".$value."%")
			 ->orWhere('book_authors.author_name', 'like',"%".$value."%")
			  ->select([
				  'books.*','library_branch.branch_id','library_branch.branch_name','book_copies.no_of_copies',
				  DB::raw('group_concat(distinct book_authors.author_name separator ", ") AS authors')
			  ])
			  ->groupBy('books.book_id','library_branch.branch_name','library_branch.branch_id','book_copies.no_of_copies')
			  ->get();
		
		foreach($books as $value)
		{
				$book_loan = DB::table('book_loans')
							->where('book_loans.date_in', null)
							->where('book_loans.book_id', $value->book_id)
							->where('book_loans.branch_id', $value->branch_id)
							->select('book_loans.*')->get();
			    $value->available =   $value->no_of_copies - count($book_loan);
		}
		
		return $books;
    }
	
	/**
     * Display a listing of the book Loans.
     *
     * @return json Value
     */
    public function searchBookLoans(Request $request)
    {
        $value= $request->value;
		
		
		 $book_loans =DB::table('books')
					 ->join('book_loans', function ($join) {
						  $join->on('book_loans.book_id', 'books.book_id');
						  $join->where('book_loans.date_in', null);
					  })
					 ->join('borrower','book_loans.card_no','borrower.card_no')
					 ->where('books.book_id', 'like',"%".$value."%")
					 ->orWhere('book_loans.card_no', 'like',"%".$value."%")
					 ->orWhere('borrower.first_name', 'like',"%".$value."%")
					 ->orWhere('borrower.last_name', 'like',"%".$value."%")
					 ->select('book_loans.*','books.title','borrower.first_name','borrower.last_name')
			 		 ->get();
		
		return $book_loans;
    }
	
	/**
     * Checkout the Books.
     *
     * @return boolean Values
     */
	
	public function checkOut(Request $request)
    {
        $id= $request->id;
		$branch_id= $request->branch_id;
		$book_id= $request->book_id;
		$date_out=date("Y-m-d");
		$due_date=date('Y-m-d', strtotime($date_out. ' + 14 days'));
		
	    $borrower   = DB::table('book_loans')->where('card_no',$id)->where('date_in', null)->select('*')->get();
		
		if(count($borrower) >= 3)
		{
			return "false";
		}
		else
		{
			DB::table('book_loans')->insert(
				['book_id' => $book_id, 'branch_id' => $branch_id, 'card_no' => $id, 'date_out' => $date_out, 'due_date' => $due_date]
			);
			return "true";
		}
    }
	/**
     * Checkin the Books.
     *
     * @return boolean Values
     */
	
	public function checkIn(Request $request)
    {
        $id= $request->id;
		$date_in=date("Y-m-d");
		DB::table('book_loans')
            ->where('id', $id)
            ->update(['date_in' => $date_in]);
		return "true";
    }
}