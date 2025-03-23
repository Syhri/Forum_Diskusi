<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <!-- Header -->
        <header class="bg-navy text-white py-4 px-6 flex justify-between items-center shadow-md">
            <h1 class="text-2xl font-bold">Forum Diskusi</h1>
        
            <!-- Search Bar -->
            <form method="GET" action="{{ route('threads.index') }}" class="flex bg-white rounded-lg overflow-hidden shadow-md">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="px-4 py-2 w-72 text-gray-800 outline-none" placeholder="Cari thread...">
                <button type="submit"
                    class="bg-yellow-400 px-4 py-2 text-navy font-semibold border-none hover:bg-yellow-500 transition">
                    🔍
                </button>
            </form>
        
            <a href="{{ route('threads.create') }}"
                class="bg-yellow-400 text-navy-800 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-500 transition">
                + Buat Thread Baru
            </a>
        </header>


        <div class="container mx-auto px-6 py-8 flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            <aside class="w-full md:w-1/4 bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-navy-800 mb-3">Kategori</h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('threads.index') }}" class="text-gray-700 hover:text-navy-600">Semua
                            Kategori</a></li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('threads.index', ['category_id' => $category->id]) }}"
                                class="text-gray-700 hover:text-navy-600 {{ request('category_id') == $category->id ? 'font-bold text-navy-800' : '' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

            </aside>
{{-- 
            @if (session('success'))
                <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif --}}

            <!-- Daftar Threads -->
            <main class="w-full md:w-3/4">
                <!-- Form Filter Kategori -->
                <form method="GET" action="{{ route('threads.index') }}" class="mb-4">
                    <label for="category_id" class="text-lg font-semibold text-gray-700">Filter Kategori:</label>
                    <select name="category_id" class="form-control w-full md:w-1/3 border p-2 mt-2"
                        onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($threads as $thread)
                        <div class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition">
                            <h3 class="text-lg font-bold text-navy-800">
                                <a href="{{ route('threads.show', $thread) }}"
                                    class="hover:underline">{{ $thread->title }}</a>
                            </h3>
                            <p class="text-gray-600 mt-2 text-sm">
                                {{ Str::limit($thread->content, 100) }}
                                <a href="{{ route('threads.show', $thread) }}"
                                    class="text-navy-600 font-semibold hover:underline">
                                    Selengkapnya
                                </a>
                            </p>
                            <p class="text-sm text-gray-500 mt-2">Oleh: {{ $thread->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $thread->created_at->diffForHumans() }}</p>
                            <p class="text-sm text-gray-500 mt-2">
                                Kategori: <span
                                    class="font-semibold text-navy-600">{{ $thread->category->name ?? 'Tanpa Kategori' }}</span>
                            </p>
                        </div>
                    @endforeach
                </div>

                <!-- Paginasi -->
                <div class="mt-6">
                    {{ $threads->links() }}
                </div>
            </main>
        </div>
    </div>
</x-app-layout>