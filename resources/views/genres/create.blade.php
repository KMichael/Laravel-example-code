<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('genres.store') }}">
                        @csrf
                        @method('POST')

                        <div class="mb10">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" required autofocus>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-info mt10">Create</button>
                        </div>
                    </form>
                    <a href="{{ route('genres.index') }}" class="btn btn-secondary mt10">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
