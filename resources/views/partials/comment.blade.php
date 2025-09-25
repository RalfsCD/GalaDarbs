<div class="comment p-3 rounded-xl 
            bg-gray-100 dark:bg-gray-800 
            text-gray-900 dark:text-gray-100 
            shadow-sm">
    <strong>{{ $comment->user->name ?? 'User' }}</strong>: 
    {{ $comment->content }}
</div>
