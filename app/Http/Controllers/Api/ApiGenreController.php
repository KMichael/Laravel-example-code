<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class ApiGenreController extends Controller
{
    public function index()
    {
        $books = Genre::with('books')->paginate(2);
        return response()->json($books);
    }
}
