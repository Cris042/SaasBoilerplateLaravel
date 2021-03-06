<?php

namespace SAASBoilerplate\Http\Tenant\Controllers;

use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Book\Requests\Validation;
use SAASBoilerplate\Domain\Book\Requests\ValidationEdit;
use SAASBoilerplate\Domain\Book\Models\Book;

class BookController extends Controller
{
    public function Index()
    {
       $books = Book::all()->Where( 'company_id', session('tenant') );
       return view('library.book')->with( 'books', $books );
    }

    public function Show( $id )
    {
        $book =  Book::find( $id );
    
        if ( !$book  ) 
        {
            return redirect()->route('tenant.library.book');
        }
        else if( $book->company_id == session('tenant')  )
        {
            return view('library.editBook', compact('book') );
        }
        else
        {
            return redirect()->route('tenant.library.book');
        }
    }

    public function Store( Validation $request )
    {
        $verificar = Book::where('title', $request->get('title') )->where( 'company_id' ,session('tenant' ) )->exists();

        if( $verificar == true  ) 
        {
            dd("Livro existente!");
        }
        else
        { 
            $book = new Book();
            $book->title =  $request->get('title');  
            $book->author = $request->get('author');
            $book->value =  $request->get('value'); 
            $book->description = $request->get('description');
            $book->amount = $request->get('amount'); 
            $book->company_id =  $request->get('company_id'); 
            $book->save();

            return redirect()->route('tenant.library.book');
        }
       
    }

    public function Update( ValidationEdit $request, $id)
    {
        if ( !$book = Book::find( $id ) ) 
        {
            return redirect()->back();
        }
       
        if( $request->get('titleCurrent') != $request->get('title') )
        {
            if ( Book::where('title', $request->get('title') )->where( 'company_id' ,session('tenant' ) )->exists() ) 
                    dd("Livro existente");
            else
            {
                $data = $request->all();
                $book->update( $data );
            }
        }
        else
        {
            $data = $request->all();
            $book->update( $data );
        }
     
        return redirect()->route('tenant.library.book');
    }

    public function Destroy( $id )
    {
        if ( !$book = Book::find( $id ) ) 
        {
            return redirect()->back();
        }

        $book->delete();

        return redirect()->route('tenant.library.book');
    }

    public function Search( Request $request )
    {
        $filters = $request->except('_token');

        $books = Book::where( 'company_id',session('tenant' ) )->where( 'title', 'LIKE', "%{$request->search}%" )->paginate();

        return view('library.book', compact('books', 'filters'));
    }
}
