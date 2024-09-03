<x-app-layout>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <form action="{{ route('books.index') }}" method="GET">
                            <div class="form-group mb10">
                                <label for="title">Title:</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ request('title') }}">
                            </div>
                            <div class="form-group mb10">
                                <label for="author_id">Author:</label>
                                <select name="author_id" id="author_id" class="form-control">
                                    <option value="">Select Author</option>
                                    @foreach (\App\Models\User::where('is_admin', false)->get() as $author)
                                        <option value="{{ $author->id }}" {{ request('author_id') == $author->id ? 'selected' : '' }}>
                                            {{ $author->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="genre_id">Genre:</label>
                                <select name="genre_id" id="genre_id" class="form-control">
                                    <option value="">Select Genre</option>
                                    @foreach (\App\Models\Genre::all() as $genre)
                                        <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                                            {{ $genre->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('books.index') }}" class="btn btn-secondary">Reset Filters</a>
                            </div>
                        </form>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="border px-4 py-2">Title</th>
                            <th class="border px-4 py-2">Author</th>
                            <th class="border px-4 py-2">Genre</th>
                            <th class="border px-4 py-2">Date</th>
                            <th class="border px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td class="border px-4 py-2">{{ $book->title }}</td>
                                <td class="border px-4 py-2">{{ $book->author->name }}</td>
                                <td class="border px-4 py-2">
                                    @foreach($book->genres as $genre)
                                        {{ $genre->name }}@if (!$loop->last),@endif
                                    @endforeach
                                </td>
                                <td class="border px-4 py-2">{{ date('d.m.Y', strtotime($book->created_at)) }}</td>
                                <td class="border px-4 py-2 flex">
                                    <a href="{{ route('books.edit', $book) }}" class="btn btn-info">Edit</a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST"
                                          style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 flex">
                        <a href="{{ route('books.index', array_merge(request()->query(), ['sort' => 'asc'])) }}" class="btn btn-primary">Title Asc</a>
                        <a href="{{ route('books.index', array_merge(request()->query(), ['sort' => 'desc'])) }}" class="btn btn-secondary">Title Desc</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
