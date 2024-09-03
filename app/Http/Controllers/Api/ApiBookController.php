<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class ApiBookController extends Controller
{
    public function index()
    {
        $books = Book::with('author', 'genres')->paginate(10);
        return response()->json($books);
    }

    public function show($id)
    {
        $book = Book::with('author', 'genres')->findOrFail($id);
        return response()->json($book);
    }
}

