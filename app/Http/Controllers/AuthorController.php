<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем всех пользователей, кроме админа
        $authors = User::where('is_admin', false)->get();

        return view('authors.index', compact('authors'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
            'password' => 'required|min:6',
        ],[
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
        ]);

        $author = new User();
        $author->name = $request->name;
        $author->email = $request->email;
        if (!empty($request->password)) {
            $author->password = bcrypt($request->password);
        }
        $author->save();

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $author)
    {
        return view('authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $author)
    {
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $author)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $author->id,
            'password' => 'sometimes|nullable|min:6',
        ],
            [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
        ]);

        $author->name = $validatedData['name'];
        $author->email = $validatedData['email'];
        if (!empty($validatedData['password'])) {
            $author->password = bcrypt($validatedData['password']);
        }
        $author->save();

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $author)
    {
        $author = User::find($author->id);

        if ($author->books()->exists()) {
            return redirect()->back()->with('error', "You can't delete an author who has books.");
        }

        $author->delete();
        return redirect()->route('authors.index')->with('success', 'The author has been successfully removed.');

    }
}
