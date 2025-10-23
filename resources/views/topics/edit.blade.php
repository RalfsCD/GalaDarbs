@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  {{-- Breadcrumb --}}
  <nav aria-label="Breadcrumb"
       class="rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-sm px-3 sm:px-4 py-2">
    <ol class="flex items-center flex-wrap gap-1.5 text-xs sm:text-sm text-gray-600 dark:text-gray-300">
      <li>
        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold text-gray-900 dark:text-gray-100">PostPit</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </li>
      <li>
        <a href="{{ route('topics.index') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold">Topics</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </li>
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Manage</li>
    </ol>
  </nav>

  {{-- Header --}}
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10 opacity-70">
      <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full blur-3xl bg-gradient-to-br from-yellow-300/40 to-orange-400/30 dark:from-yellow-500/25 dark:to-orange-400/20"></div>
      <div class="absolute -bottom-28 -left-20 h-80 w-80 rounded-full blur-3xl bg-gradient-to-tr from-white/40 to-yellow-200/40 dark:from-gray-800/40 dark:to-yellow-500/20"></div>
    </div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
      <div class="max-w-2xl space-y-2">
        <div class="inline-flex items-center gap-2">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Manage</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          Edit Topic
        </h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
          Update the name or description. You can also delete the topic from here.
        </p>
      </div>

      <div class="flex items-center gap-2 md:self-start">
        <a href="{{ route('topics.index') }}"
           class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 text-sm font-semibold
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                  focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
          </svg>
          Back
        </a>
      </div>
    </div>
  </header>

  {{-- Server-side errors --}}
  @if ($errors->any())
    <div class="rounded-3xl border border-red-300/60 dark:border-red-600/50 bg-red-50/80 dark:bg-red-900/30 p-4 sm:p-5 text-red-800 dark:text-red-100 shadow-xl">
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

  {{-- Manage Card --}}
  <div class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-[0_16px_44px_-22px_rgba(0,0,0,0.45)] p-4 sm:p-6 space-y-6">

    {{-- Update form --}}
    <form id="editTopicForm" action="{{ route('topics.update', $topic) }}" method="POST" class="space-y-6">
      @csrf
      @method('PATCH')

      {{-- Name --}}
      <div class="space-y-2">
        <label for="name" class="block text-sm font-semibold text-gray-800 dark:text-gray-100">
          Topic Name <span class="text-red-500">*</span>
        </label>
        <input id="name" name="name" type="text" value="{{ old('name', $topic->name) }}"
               required maxlength="255"
               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700
                      bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                      placeholder-gray-400 focus:outline-none focus:ring-2
                      focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm"
               placeholder="e.g., Sustainable Cooking">
      </div>

      {{-- Description --}}
      <div class="space-y-2">
        <div class="flex items-center justify-between">
          <label for="description" class="block text-sm font-semibold text-gray-800 dark:text-gray-100">
            Description <span class="font-normal text-gray-500">(optional)</span>
          </label>
          <span id="descCount" class="text-[11px] text-gray-500 dark:text-gray-400">0/300</span>
        </div>
        <textarea id="description" name="description" rows="4" maxlength="300"
                  class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700
                         bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                         placeholder-gray-400 focus:outline-none focus:ring-2
                         focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm"
                  placeholder="Describe this topic…">{{ old('description', $topic->description) }}</textarea>
      </div>

      {{-- Actions (Save / Cancel / Delete) --}}
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
        <a href="{{ route('topics.index') }}"
           class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 text-[13px] sm:text-sm font-semibold
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                  focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
          Cancel
        </a>

        <button type="submit"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-full
                       text-[13px] sm:text-sm font-semibold tracking-tight whitespace-nowrap
                       bg-yellow-400 text-gray-900 hover:bg-yellow-500 active:bg-yellow-500/90
                       dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:active:bg-yellow-400/90
                       border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                       focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
          Save Changes
        </button>

        {{-- Subtle inline Delete (inside card, not sticking out) --}}
        <form action="{{ route('topics.destroy', $topic) }}" method="POST"
              onsubmit="return confirm('Delete this topic? This cannot be undone.');"
              class="sm:ml-auto">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-full
                         text-[13px] sm:text-sm font-semibold
                         bg-red-50/80 dark:bg-red-900/20 text-red-700 dark:text-red-200
                         border border-red-200/70 dark:border-red-800/60
                         hover:bg-red-100 dark:hover:bg-red-900/30 hover:shadow-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M6 7h12m-1-2.5A1.5 1.5 0 0 0 15.5 3h-7A1.5 1.5 0 0 0 7 4.5V7h10V4.5z"/>
            </svg>
            Delete
          </button>
        </form>
      </div>
    </form>
  </div>

  {{-- Client-side validation modal (reused pattern, optional) --}}
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

{{-- Scripts --}}
<script>
  const form = document.getElementById('editTopicForm');
  const nameInput = document.getElementById('name');
  const desc = document.getElementById('description');
  const descCount = document.getElementById('descCount');

  function updateCount() {
    if (!desc || !descCount) return;
    descCount.textContent = (desc.value?.length || 0) + '/300';
  }
  desc?.addEventListener('input', updateCount);
  updateCount();

  form.addEventListener('submit', function(e) {
    const errors = [];
    nameInput.classList.remove('ring-2','ring-red-500','border-red-600');

    if (!nameInput.value.trim()) {
      errors.push("Topic name is required.");
      nameInput.classList.add('ring-2','ring-red-500','border-red-600');
    }

    if (errors.length > 0) {
      e.preventDefault();
      const list = document.getElementById('errorList'); list.innerHTML = '';
      errors.forEach(err => { const li = document.createElement('li'); li.textContent = err; list.appendChild(li); });
      const modal = document.getElementById('validationModal'); modal.classList.remove('hidden'); modal.classList.add('flex');
    }
  });

  document.getElementById('closeModal').addEventListener('click', () => {
    const modal = document.getElementById('validationModal'); modal.classList.add('hidden'); modal.classList.remove('flex');
  });
</script>
@endsection
