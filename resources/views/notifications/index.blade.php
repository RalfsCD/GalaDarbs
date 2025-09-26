@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6">

    {{-- Page Header (matches Topics header styling) --}}
    <div class="p-4 sm:p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-gray-100">Notifications</h1>
    </div>

    {{-- Notifications List (grid like Topics) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @forelse($notifications as $notification)
            @php
                $data = $notification->data;
                $type = $data['type'] ?? 'info';
                $isUnread = is_null($notification->read_at ?? null);
            @endphp

            {{-- One card per notification --}}
            <div class="p-4 sm:p-6 rounded-lg sm:rounded-xl bg-white dark:bg-gray-800
                        border border-gray-200 dark:border-gray-700
                        shadow-md hover:shadow-lg transition duration-200
                        {{ $isUnread ? 'ring-2 ring-yellow-300 dark:ring-yellow-600' : '' }}">
                <div class="flex items-start gap-3 sm:gap-4">
                    {{-- Type Icon --}}
                    @if($type === 'post_deleted')
                        <div class="flex-shrink-0 w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center
                                    bg-red-100 dark:bg-red-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107
                                      1.022.166m-1.022-.165L18.16 19.673a2.25
                                      2.25 0 0 1-2.244 2.077H8.084a2.25
                                      2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108
                                      48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114
                                      1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5
                                      0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964
                                      51.964 0 0 0-3.32 0c-1.18.037-2.09
                                      1.022-2.09 2.201v.916m7.5 0a48.667
                                      48.667 0 0 0-7.5 0"/>
                            </svg>
                        </div>
                    @elseif($type === 'post_liked')
                        <div class="flex-shrink-0 w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center
                                    bg-pink-100 dark:bg-pink-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                 fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 text-pink-600 dark:text-pink-400">
                                <path
                                  d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 0 1-1.003-.617 25.18 25.18 0 0 1-4.244-3.17C3.223 15.108 1.5 12.89 1.5 10.5 1.5 7.462 3.962 5 7 5c1.47 0 2.77.5 3.78 1.342A5.483 5.483 0 0 1 14.5 5c3.038 0 5.5 2.462 5.5 5.5 0 2.39-1.722 4.608-4.87 6.608a25.18 25.18 0 0 1-4.244 3.17 15.247 15.247 0 0 1-1.003.617l-.022.012-.007.003-.003.001a.75.75 0 0 1-.706 0l-.003-.001z" />
                            </svg>
                        </div>
                    @elseif($type === 'post_commented')
                        <div class="flex-shrink-0 w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center
                                    bg-blue-100 dark:bg-blue-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M7.5 8.25h9M7.5 12h6m-6 3.75h3M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    @else
                        <div class="flex-shrink-0 w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center
                                    bg-gray-100 dark:bg-gray-900/40">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600 dark:text-gray-300">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6v6l4 2" />
                            </svg>
                        </div>
                    @endif

                    {{-- Message + time --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm sm:text-base text-gray-900 dark:text-gray-100 break-words leading-relaxed">
                            @if($type === 'post_deleted')
                                Your post "<span class="font-semibold">{{ $data['post_title'] ?? '' }}</span>" has been reported and deleted by admin.
                            @elseif($type === 'post_liked')
                                <span class="font-semibold">{{ $data['user_name'] ?? 'Someone' }}</span> liked your post "<span class="font-semibold">{{ $data['post_title'] ?? '' }}</span>".
                            @elseif($type === 'post_commented')
                                <span class="font-semibold">{{ $data['user_name'] ?? 'Someone' }}</span> commented on your post "<span class="font-semibold">{{ $data['post_title'] ?? '' }}</span>".
                            @else
                                {{ $data['message'] ?? 'You have a new notification.' }}
                            @endif
                        </p>
                        <p class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 mt-2">
                            {{ $notification->created_at->diffForHumans() }}
                            @if($isUnread)
                                <span class="ml-2 inline-block w-2 h-2 rounded-full bg-yellow-400 align-middle"></span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400">No notifications yet.</p>
        @endforelse
    </div>

</div>
@endsection
