<!-- resources/views/partials/comment.blade.php -->
<div class="bg-white p-4 rounded-lg shadow-sm mb-4 {{ $comment->parent_id ? 'comment-indent' : '' }}" id="comment-{{ $comment->id }}">
    <div class="flex items-center justify-between mb-2">
        <div class="font-semibold text-gray-800">
            {{ $comment->guest_name }}
            @if ($comment->parent)
                <span class="text-gray-500 text-sm ml-1">membalas {{ $comment->parent->guest_name }}</span>
            @endif
        </div>
        <div class="text-gray-500 text-sm">
            {{ $comment->created_at->diffForHumans() }}
            @if (!$comment->approved)
                <span class="ml-2 text-red-500">(Menunggu Persetujuan)</span>
            @endif
        </div>
    </div>
    <p class="text-gray-700 mb-3">{{ $comment->body }}</p> {{-- Ini adalah baris untuk menampilkan isi komentar --}}

    <!-- Display Replies -->
    @if ($comment->replies->count() > 0)
        <div class="mt-4">
            @foreach ($comment->replies->sortBy('created_at') as $reply)
                @include('partials.comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>
-