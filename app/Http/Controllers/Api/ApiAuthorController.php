<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApiAuthorController extends Controller
{
    public function index()
    {
        $books = User::withCount('books')->paginate(2);
        return response()->json($books);
    }

    public function show($id)
    {
        $book = User::with('books.genres')->findOrFail($id);
        return response()->json($book);
    }

    public function update(Request $request)
    {
        $author = $request->user();

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $author->id,
            'password' => 'sometimes|required|min:6',
        ]);

        $author->name = $validated['name'];
        $author->email = $validated['email'];
        if (!empty($validated['password'])) {
            $author->password = bcrypt($validated['password']);
        }
        $author->update($validated);

        return response()->json($author, 200);
    }
}
