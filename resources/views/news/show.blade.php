<!-- resources/views/news/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .comment-indent {
            margin-left: 2rem; /* Indent for replies */
            border-left: 2px solid #e5e7eb; /* Light gray border for replies */
            padding-left: 1rem;
        }
    </style>
</head>
<body class="p-4 sm:p-6 md:p-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $news->title }}</h1>

        @if ($news->image)
            <img src="{{ $news->image }}" alt="{{ $news->title }}" class="w-full h-auto rounded-lg mb-6 object-cover" style="max-height: 400px;">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-lg mb-6 text-gray-500 text-lg">Tidak Ada Gambar</div>
        @endif

        <div class="text-gray-600 text-sm mb-4">
            <p>Published: {{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('d F Y') : 'Not yet published' }}</p>
            <p>Views: {{ $news->views }}</p>
        </div>

        <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
            <p>{{ $news->body }}</p>
        </div>

        <a href="{{route('news.public_index')}}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-300 mb-8">
            &larr; Kembali
        </a>

        <!-- Comments Section -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Komentar ({{ $news->comments->where('parent_id', null)->count() }})</h2>

            <!-- Comment Form -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Tulis Komentar</h3>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="news_id" value="{{ $news->id }}">
                    <input type="hidden" name="parent_id" id="parent_id_form" value="">

                    <div class="mb-4">
                        <label for="guest_name" class="block text-gray-700 text-sm font-semibold mb-2">Nama Anda:</label>
                        <input type="text" name="guest_name" id="guest_name" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('guest_name') }}" required>
                        @error('guest_name')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="guest_email" class="block text-gray-700 text-sm font-semibold mb-2">Email Anda (Opsional):</label>
                        <input type="email" name="guest_email" id="guest_email" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('guest_email') }}">
                        @error('guest_email')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="body" class="block text-gray-700 text-sm font-semibold mb-2">Komentar Anda:</label>
                        <textarea name="body" id="body" rows="5" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                        Kirim Komentar
                    </button>
                    <button type="button" id="cancel_reply_btn" class="hidden ml-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-300" onclick="cancelReply()">
                        Batalkan Balasan
                    </button>
                </form>
            </div>

            <!-- Display Comments -->
            <div id="comments-list">
                @forelse ($news->comments->where('parent_id', null)->sortByDesc('created_at') as $comment)
                    @include('partials.comment', ['comment' => $comment])
                @empty
                    <p class="text-gray-600 text-center">Belum ada komentar untuk berita ini.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function replyToComment(commentId, guestName) {
            document.getElementById('parent_id_form').value = commentId;
            // Gunakan JSON.stringify untuk memastikan nama tamu dienkode dengan aman
            document.getElementById('body').value = `@${guestName} `;
            document.getElementById('body').focus();
            document.getElementById('cancel_reply_btn').classList.remove('hidden');
        }

        function cancelReply() {
            document.getElementById('parent_id_form').value = '';
            document.getElementById('body').value = '';
            document.getElementById('cancel_reply_btn').classList.add('hidden');
        }
    </script>
</body>
</html>
