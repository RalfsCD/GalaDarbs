@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6">

    {{-- ===== Hero Header (consistent with Groups/Topics) ===== --}}
    <header
        class="relative overflow-hidden rounded-3xl p-4 sm:p-8
               bg-gradient-to-br from-yellow-100 via-white to-yellow-50
               dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
               border border-yellow-200/60 dark:border-gray-800 shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-3 sm:gap-4">

            <div class="max-w-full md:max-w-2xl min-w-0">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-yellow-400 shadow-[0_0_10px_rgba(250,204,21,0.85)]"></span>
                    <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                               bg-clip-text text-transparent truncate
                               bg-gradient-to-b from-gray-900 to-gray-600
                               dark:from-white dark:to-gray-300">
                        Create Post
                        <span class="text-yellow-500">in {{ $group->name }}</span>
                    </h1>
                </div>

                <p class="mt-1 sm:mt-2 text-[13px] sm:text-base text-gray-700 dark:text-gray-300">
                    Share a thought, question, link, or image with your group.
                </p>
            </div>

            <div class="flex items-center gap-2 md:self-start">
                <a href="{{ route('groups.show', $group) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                          bg-white/60 dark:bg-gray-900/60 backdrop-blur
                          text-gray-900 dark:text-gray-100 text-xs sm:text-sm font-semibold
                          border border-gray-300/70 dark:border-gray-700/80
                          shadow-sm hover:shadow-md
                          hover:bg-yellow-400/15 hover:border-yellow-400/50
                          transition whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
                    </svg>
                    Back to Group
                </a>
            </div>
        </div>

        <!-- soft decorative blobs -->
        <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
        <div class="pointer-events-none absolute -left-16 -bottom-12 h-48 w-48 rounded-full blur-3xl bg-orange-300/20 dark:bg-orange-400/10"></div>
    </header>

    {{-- ===== Server-side errors (if any) ===== --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-red-300/60 dark:border-red-600/60 bg-red-50/70 dark:bg-red-900/30 p-4 sm:p-5 text-red-800 dark:text-red-100 shadow">
            <div class="flex items-start gap-3">
                <div class="shrink-0 mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M4.93 4.93l14.14 14.14M12 3a9 9 0 1 1 0 18 9 9 0 0 1 0-18z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold mb-1">Please fix the following:</p>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- ===== Create Post Form (glass card) ===== --}}
    <form id="createPostForm" action="{{ route('posts.store', $group) }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
        @csrf

        <div class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl p-4 sm:p-6 space-y-4 sm:space-y-6">

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    placeholder="Catchy headline goes here"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700
                           bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                           placeholder-gray-400 focus:outline-none focus:ring-2
                           focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm">
            </div>

            {{-- Content --}}
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Content</label>
                <textarea name="content" id="content" rows="5"
                          placeholder="Write what’s on your mind…"
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700
                                 bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                                 placeholder-gray-400 focus:outline-none focus:ring-2
                                 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm">{{ old('content') }}</textarea>
            </div>

            {{-- Media Upload --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Media (optional)</label>

                <label for="media"
                       class="flex items-center justify-between gap-3 w-full px-4 py-2.5 rounded-xl
                              border border-gray-300 dark:border-gray-700
                              bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                              cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-900
                              transition shadow-sm">
                    <div class="flex items-center gap-2 min-w-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2"/>
                        </svg>
                        <span id="mediaFileName" class="truncate text-sm">Choose a file</span>
                    </div>

                    <span class="shrink-0 inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold
                                 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200
                                 border border-gray-200 dark:border-gray-700">
                        Browse
                    </span>
                </label>
                <input type="file" name="media" id="media" class="hidden" />
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                <a href="{{ route('groups.show', $group) }}"
                   class="inline-flex justify-center items-center gap-2 px-3 py-2 rounded-full
                          bg-white/60 dark:bg-gray-900/60 backdrop-blur
                          text-gray-900 dark:text-gray-100 text-sm font-semibold
                          border border-gray-300/70 dark:border-gray-700/80
                          shadow-sm hover:shadow-md
                          hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    Cancel
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full
                               text-sm font-semibold tracking-tight
                               bg-yellow-400 text-gray-900
                               hover:bg-yellow-500 active:bg-yellow-500/90
                               dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:active:bg-yellow-400/90
                               border border-yellow-300/70 shadow-sm hover:shadow-md transition whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span class="whitespace-nowrap">Create Post</span>
                </button>
            </div>
        </div>
    </form>

    {{-- ===== Validation Modal (client-side) ===== --}}
    <div id="validationModal"
         class="fixed inset-0 bg-black/40 dark:bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-2xl max-w-lg w-full space-y-4 relative border border-gray-200 dark:border-gray-800">
            <button id="closeModal"
                    class="absolute top-3 right-3 inline-flex items-center justify-center w-8 h-8 rounded-full
                           bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300
                           hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                &times;
            </button>
            <div class="flex items-start gap-3">
                <div class="mt-0.5 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M4.93 4.93l14.14 14.14M12 3a9 9 0 1 1 0 18 9 9 0 0 1 0-18z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900 dark:text-gray-100">
                        Please fix the following:
                    </h2>
                    <ul id="errorList" class="list-disc pl-5 text-gray-700 dark:text-gray-200 space-y-1 mt-2 text-sm"></ul>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ===== Page Scripts ===== --}}
<script>
    // Media file name preview
    const mediaInput = document.getElementById('media');
    const mediaFileName = document.getElementById('mediaFileName');
    mediaInput?.addEventListener('change', () => {
        mediaFileName.textContent = mediaInput.files?.length ? mediaInput.files[0].name : 'Choose a file';
    });

    // Form validation
    const form = document.getElementById('createPostForm');
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');

    form?.addEventListener('submit', function(e) {
        const errors = [];

        titleInput.classList.remove('ring-2','ring-red-500','border-red-600');
        contentInput.classList.remove('ring-2','ring-red-500','border-red-600');

        if (!titleInput.value.trim()) {
            errors.push("Title is required.");
            titleInput.classList.add('ring-2','ring-red-500','border-red-600');
        }

        if (!contentInput.value.trim()) {
            errors.push("Content is required.");
            contentInput.classList.add('ring-2','ring-red-500','border-red-600');
        }

        if (errors.length > 0) {
            e.preventDefault();
            const errorList = document.getElementById('errorList');
            errorList.innerHTML = '';
            errors.forEach(err => {
                const li = document.createElement('li');
                li.textContent = err;
                errorList.appendChild(li);
            });
            const modal = document.getElementById('validationModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    });

    // Close modal
    document.getElementById('closeModal')?.addEventListener('click', function() {
        const modal = document.getElementById('validationModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });
</script>
@endsection
