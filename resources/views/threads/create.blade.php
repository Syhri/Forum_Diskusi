<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-2xl font-bold text-navy-800">Buat Thread Baru</h1>
        <form method="POST" action="{{ route('threads.store') }}" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="title" class="block text-lg font-semibold">Judul:</label>
                <input type="text" class="form-control w-full border p-2" name="title" required>
            </div>

            <div class="form-group mt-4">
                <label for="content" class="block text-lg font-semibold">Isi:</label>
                <textarea class="form-control w-full border p-2" name="content" required></textarea>
            </div>

            <div class="form-group mt-4">
                <label for="category_id" class="block text-lg font-semibold">Kategori:</label>
                <select name="category_id" class="form-control w-full border p-2" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-navy text-white text-sm px-4 py-2 rounded-md btn btn-primary mt-4">Posting</button>
        </form>
    </div>
</x-app-layout>