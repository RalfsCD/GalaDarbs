<div class="comment p-2 rounded-lg 
            bg-white/30 backdrop-blur-sm border border-gray-200 shadow-sm flex items-start gap-2">
    <span class="font-semibold text-gray-900">{{ $comment->user->name ?? 'User' }}:</span>
    <span class="text-gray-700">{{ $comment->content }}</span>
</div>
