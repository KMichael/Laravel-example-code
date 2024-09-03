<?php

namespace App\Http\Controllers\Api;

use App\Enums\EditionType;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:books,title,' . $book->id,
            'edition' => 'required|in:graphic,digital,print',
        ]);

        $book->update($validated);

        return response()->json($book, 200);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Book successfully deleted'], 200);
    }
}
