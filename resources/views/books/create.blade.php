<x-app-layout>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('books.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" required autofocus class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="edition">Edition</label>
                            <select name="edition" id="edition" required class="form-control">
                                <option value="graphic">Graphic</option>
                                <option value="digital">Digital</option>
                                <option value="print">Print</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="author_id">Author:</label>
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach (\App\Models\User::where('is_admin', false)->get() as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="genre_ids">Genre:</label>
                            <select name="genre_ids[]" id="genre_ids" class="form-control" multiple>
                                @foreach (\App\Models\Genre::all() as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-info">Create</button>
                    </form>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary mt10">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
