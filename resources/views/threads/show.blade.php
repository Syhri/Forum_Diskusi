<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Thread Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <!-- Judul & Informasi User -->
            <div class="flex items-center mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($thread->user->name) }}&background=1a2b50&color=fff&size=40"
                    class="w-10 h-10 rounded-full mr-3" alt="Avatar">
                <div>
                    <h1 class="text-2xl font-bold text-navy-800">{{ $thread->title }}</h1>
                    <p class="text-sm text-gray-500">Oleh: {{ $thread->user->name }} |
                        {{ $thread->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>

            <!-- Konten Thread -->
            <div class="bg-gray-100 p-4 rounded-lg text-gray-800">
                <p>{{ $thread->content }}</p>
            </div>

            <!-- Tombol Aksi -->
            @auth
                @if(auth()->id() === $thread->user_id)
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('threads.edit', $thread) }}"
                            class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                            ✏️ Edit
                        </a>
                        <form id="delete-form" method="POST" action="{{ route('threads.destroy', $thread) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete()"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                🗑 Hapus
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        <!-- Balasan -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-navy-800">💬 Komentar</h2>
            @forelse($thread->replies as $reply)
                <div class="mt-4 flex items-start bg-white shadow-md rounded-lg p-4 border border-gray-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&background=294374&color=fff&size=40"
                        class="w-10 h-10 rounded-full mr-3" alt="Avatar">
                    <div>
                        <p class="text-gray-800 font-semibold">{{ $reply->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                        <div class="bg-gray-100 p-3 rounded-lg mt-2 text-gray-800">
                            {{ $reply->content }}
                        </div>
                        @auth
                            @if(auth()->id() === $reply->user_id)
                                <form method="POST" action="{{ route('threads.replies.destroy', [$thread, $reply]) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-sm hover:underline">🗑 Hapus</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Belum ada komentar.</p>
            @endforelse
        </div>

        <!-- Form Balasan -->
        @auth
            <div class="mt-6 bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h2 class="text-lg font-semibold text-navy-800">✍️ Tambahkan Komentar</h2>
                <form method="POST" action="{{ route('threads.replies.store', $thread) }}">
                    @csrf
                    <textarea name="content" class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-300"
                        placeholder="Tulis balasan..." required></textarea>
                    <button type="submit"
                        class="mt-3 bg-navy-800 text-black px-4 py-2 rounded-lg hover:bg-navy-600 transition">
                        💬 Kirim
                    </button>
                </form>
            </div>
        @endauth
    </div>
</x-app-layout>