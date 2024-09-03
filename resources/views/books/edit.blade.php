<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('books.update', $book->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb10">
                            <label for="name">Title</label>
                            <input type="text" name="title" id="title" value="{{ $book->title }}" required autofocus>
                        </div>
                        <div class="form-group mb10">
                            <label for="edition">Edition:</label>
                            <select name="edition" id="edition" class="form-control">
                                @foreach (App\Enums\EditionType::cases() as $edition)
                                    <option value="{{ $edition->value }}" {{ $book->edition->value === $edition->value ? 'selected' : '' }}>
                                        {{ ucfirst($edition->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb10">
                            <label for="author_id">Author: </label>
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach (\App\Models\User::where('is_admin', false)->get() as $author)
                                    <option value="{{ $author->id }}" {{ $book->author->id == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="genre_id">Genre:</label>
                            <select name="genre_ids[]" id="genre_ids" class="form-control" multiple>
                                @foreach (\App\Models\Genre::all() as $genre)
                                    <option value="{{ $genre->id }}" {{ $book->genres->contains($genre->id) ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-info mt10">Update</button>
                        </div>
                    </form>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary mt10">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
