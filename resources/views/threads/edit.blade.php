<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Card Edit Thread -->
        <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <h2 class="text-2xl font-bold text-navy-800 flex items-center">
                ✏️ Edit Thread
            </h2>

            <!-- Form Edit Thread -->
            <form method="POST" action="{{ route('threads.update', $thread) }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <!-- Input Judul -->
                <div>
                    <label for="title" class="block text-lg font-semibold text-gray-700">Judul Thread</label>
                    <div class="relative">
                        <input type="text" name="title" value="{{ $thread->title }}" required
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-navy-500 focus:border-navy-500 transition">
                        <span class="absolute right-3 top-3 text-gray-400">✍️</span>
                    </div>
                </div>

                <!-- Input Isi -->
                <div>
                    <label for="content" class="block text-lg font-semibold text-gray-700">Isi Thread</label>
                    <textarea name="content" required rows="4"
                        class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-navy-500 focus:border-navy-500 transition">{{ $thread->content }}</textarea>
                </div>

                <!-- Dropdown Kategori -->
                <div>
                    <label for="category_id" class="block text-lg font-semibold text-gray-700">Kategori</label>
                    <select name="category_id" required
                        class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-navy-500 focus:border-navy-500 transition">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $thread->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Simpan & Batal -->
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('threads.show', $thread) }}"
                        class="text-gray-600 hover:text-gray-800 px-4 py-2 transition">
                        ❌ Batal
                    </a>
                    <button type="submit"
                        class="bg-navy text-white px-6 py-2 rounded-lg hover:bg-navy-700 transition">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>