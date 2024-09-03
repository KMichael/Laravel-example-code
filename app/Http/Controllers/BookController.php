<?php

namespace App\Http\Controllers;

use App\Enums\EditionType;
use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('author', 'genres');

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('author_id') && $request->author_id != '') {
            $query->where('user_id', $request->author_id);
        }

        if ($request->filled('genre_id') && $request->genre_id != '') {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('id', $request->genre_id);
            });
        }

        $sortDirection = $request->get('sort', 'asc');
        $query->orderBy('title', $sortDirection);

        $books = $query->get();

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:books,title,' . $request->id,
            'edition' => 'required|in:graphic,digital,print',
            'user_id' => 'required|exists:users,id',
            'genre_ids' => 'required|array|min:1',
            'genre_ids.*' => 'exists:genres,id'
        ],
            [
                'title.unique' => 'The title of the book should be authoritative.',
                'genre_ids.required' => 'You must select at least one genre.',
            ]);

        $book = Book::create($validated);
        $book->genres()->attach($request->genre_ids);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = User::all();
        $genres = Genre::all();
        return view('books.edit', compact('book', 'authors', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:books,title,' . $book->id,
            'user_id' => 'required|exists:users,id',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
            'edition' => 'required|in:' . implode(',', array_map(fn($edition) => $edition->value, EditionType::cases())),
        ],
            [
            'title.unique' => 'The title of the book should be authoritative.',
            'genre_ids.required' => 'You must select at least one genre.',
        ]);

        $book->update($validated);
        $book->genres()->sync($request->genre_ids);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'The book has been successfully removed.');
    }
}
