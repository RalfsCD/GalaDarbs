{{-- =============================================================
  resources/views/groups/create.blade.php — Tailwind-only + plain JS (updated)
  - Matches topic bubble style from groups/index
  - Adds “Show all topics (N)” toggle like index
  - Primary row shows Top 3 topics (by groups_count when available)
  - Multi-select bubbles with selected counter
============================================================= --}}

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  @php
    // ----- Topic prep to mirror groups/index -----
    $hasTopics = isset($topics) && $topics && count($topics) > 0;
    $totalTopicsCount = $hasTopics ? $topics->count() : 0;

    if ($hasTopics) {
        // Prefer popularity if groups_count exists; otherwise keep given order
        $topicsSorted = $topics->sortByDesc(fn($t) => $t->groups_count ?? -1)->values();

        // Top 3 (or fewer) for the primary row
        $primaryTopics = $topicsSorted->take(3);
        $moreTopics    = $topicsSorted->slice(3)->values();
    }
  @endphp

  {{-- ===== Breadcrumbs ===== --}}
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
             stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </li>
      <li>
        <a href="{{ route('groups.index') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold">Groups</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </li>
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Create</li>
    </ol>
  </nav>

  {{-- ===== Hero ===== --}}
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
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">New group</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          Create a Group
        </h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
          Name your community, describe the vibe, and pick a few topics so people can find you.
        </p>
      </div>

      <div class="flex items-center gap-2 md:self-start">
        <a href="{{ route('groups.index') }}"
           class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 text-sm font-semibold
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:translate-y-[-2px]
                  hover:bg-yellow-50/60 dark:hover:bg-gray-800/80
                  transition-all focus:outline-none focus:ring-2
                  focus:ring-yellow-300 dark:focus:ring-yellow-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
          </svg>
          Back
        </a>
      </div>
    </div>
  </header>

  {{-- ===== Server-side validation ===== --}}
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

  {{-- ===== Form ===== --}}
  <form id="createGroupForm" action="{{ route('groups.store') }}" method="POST" class="space-y-6">
    @csrf

    <div class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-[0_16px_44px_-22px_rgba(0,0,0,0.45)] p-4 sm:p-6 space-y-6">

      {{-- Name --}}
      <div class="space-y-2">
        <label for="name" class="block text-sm font-semibold text-gray-800 dark:text-gray-100">Group Name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}"
               placeholder="e.g., European Coffee Lovers"
               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm">
        <p class="text-xs text-gray-500 dark:text-gray-400">Short, memorable, and searchable.</p>
      </div>

      {{-- Description --}}
      <div class="space-y-2">
        <label for="description" class="block text-sm font-semibold text-gray-800 dark:text-gray-100">
          Description <span class="font-normal text-gray-500">(optional)</span>
        </label>
        <textarea id="description" name="description" rows="4"
                  placeholder="What’s this group about? Who is it for?"
                  class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm">{{ old('description') }}</textarea>
        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
          <span class="inline-flex h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
          Tip: share example posts or simple guidelines.
        </div>
      </div>

      {{-- Topics (Top 3 + “Show all topics (N)” like index) --}}
      @if($hasTopics)
        <div class="space-y-2">
          <div class="flex items-center justify-between">
            <label class="block text-sm font-semibold text-gray-800 dark:text-gray-100">Topics</label>
            <span id="selected-count"
                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] sm:text-xs font-semibold
                         bg-yellow-400/15 dark:bg-yellow-500/20 text-yellow-900 dark:text-yellow-100
                         border border-yellow-300/40 dark:border-yellow-500/40">
              <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
              0 selected
            </span>
          </div>

          <div id="topicsWrapper"
               class="rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-950/30 p-3 sm:p-4">
            {{-- Primary row: Top 3 topics --}}
            <div class="flex flex-wrap items-center gap-2">
              @foreach($primaryTopics as $topic)
                <button type="button"
                        class="topic-bubble inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-sm font-semibold
                               bg-white/70 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200
                               border border-gray-300/70 dark:border-gray-700/70
                               hover:bg-gray-50 dark:hover:bg-gray-800 hover:shadow transition-all hover:-translate-y-0.5 select-none"
                        data-id="{{ $topic->id }}" aria-pressed="false">
                  <span class="inline-flex items-center gap-1">
                    {{ $topic->name }}
                    @if(isset($topic->groups_count))
                      <span class="opacity-70 text-xs font-semibold">• {{ $topic->groups_count }}</span>
                    @endif
                  </span>
                </button>
              @endforeach

              {{-- Toggle all topics --}}
              @if($moreTopics->count() > 0)
                <button id="toggleTopics" type="button"
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-sm font-semibold
                               bg-white/70 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200
                               border border-gray-300/70 dark:border-gray-700/70
                               hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                  <svg class="w-4 h-4 -ml-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                       stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                  </svg>
                  Show all topics ({{ $totalTopicsCount }})
                </button>
              @endif
            </div>

            {{-- Expanded list: remaining topics --}}
            @if($moreTopics->count() > 0)
              <div id="allTopics" class="hidden">
                <div class="mt-2 flex flex-wrap items-center gap-2">
                  @foreach($moreTopics as $topic)
                    <button type="button"
                            class="topic-bubble inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-sm font-semibold
                                   bg-white/70 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200
                                   border border-gray-300/70 dark:border-gray-700/70
                                   hover:bg-gray-50 dark:hover:bg-gray-800 transition select-none"
                            data-id="{{ $topic->id }}" aria-pressed="false">
                      <span class="inline-flex items-center gap-1">
                        {{ $topic->name }}
                        @if(isset($topic->groups_count))
                          <span class="opacity-70 text-xs font-semibold">• {{ $topic->groups_count }}</span>
                        @endif
                      </span>
                    </button>
                  @endforeach
                </div>
              </div>
            @endif

            {{-- Hidden inputs live here --}}
            <div id="selected-topics-container"></div>
          </div>

          <p class="text-xs text-gray-500 dark:text-gray-400">Choose at least one topic to boost discoverability.</p>
        </div>
      @endif

      {{-- Actions --}}
      <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
        <a href="{{ route('groups.index') }}"
           class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 text-sm font-semibold
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                  focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
          Cancel
        </a>

        <button type="submit"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full text-sm font-semibold tracking-tight
                       bg-yellow-400 text-gray-900 hover:bg-yellow-500 active:bg-yellow-500/90
                       dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:active:bg-yellow-400/90
                       border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                       focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
          </svg>
          Create Group
        </button>
      </div>
    </div>
  </form>

  {{-- ===== Client-side Validation Modal ===== --}}
  <div id="validationModal" class="fixed inset-0 bg-black/40 dark:bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-2xl max-w-lg w-full space-y-4 relative border border-gray-200 dark:border-gray-800">
      <button id="closeModal" class="absolute top-3 right-3 inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition" aria-label="Close validation modal">&times;</button>
      <div class="flex items-start gap-3">
        <div class="mt-0.5 text-red-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M4.93 4.93l14.14 14.14M12 3a9 9 0 1 1 0 18 9 9 0 0 1 0-18z"/>
          </svg>
        </div>
        <div>
          <h2 class="text-base font-bold text-gray-900 dark:text-gray-100">Please fix the following:</h2>
          <ul id="errorList" class="list-disc pl-5 text-gray-700 dark:text-gray-200 space-y-1 mt-2 text-sm"></ul>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ===== Plain JS only ===== --}}
@section('scripts')
<script>
  // Selected topics comes back from validation (old input)
  const selectedTopics = @json(old('topics', []));
  const nameInput      = document.getElementById('name');
  const topicsWrapper  = document.getElementById('topicsWrapper');
  const selectedCount  = document.getElementById('selected-count');

  // Match groups/index default vs active chip classes
  const defaultClasses = [
    'bg-white/70','dark:bg-gray-900/60',
    'text-gray-800','dark:text-gray-200',
    'border-gray-300/70','dark:border-gray-700/70'
  ];
  const activeClasses = [
    'bg-yellow-400','text-gray-900',
    'border-yellow-300/70','shadow-sm',
    'dark:bg-yellow-500','dark:text-gray-900'
  ];

  // Toggle "Show all topics"
  document.getElementById('toggleTopics')?.addEventListener('click', () => {
    const wrap = document.getElementById('allTopics');
    if (!wrap) return;
    wrap.classList.toggle('hidden');
  });

  // Wire up bubbles (both primary and 'more')
  function bindBubbles() {
    document.querySelectorAll('.topic-bubble').forEach(b => {
      const id = Number(b.dataset.id);
      // init state from old()
      if (selectedTopics.includes(id)) toggleChip(b, true);

      // avoid double-binding
      if (b.dataset.bound === '1') return;
      b.dataset.bound = '1';

      b.addEventListener('click', function () {
        const idx = selectedTopics.indexOf(id);
        if (idx > -1) { selectedTopics.splice(idx, 1); toggleChip(this, false); }
        else { selectedTopics.push(id); toggleChip(this, true); }
        updateHidden(); updateCount();
      });
    });
  }
  bindBubbles();

  function toggleChip(el, on) {
    el.setAttribute('aria-pressed', on ? 'true' : 'false');
    if (on) { el.classList.remove(...defaultClasses); el.classList.add(...activeClasses); }
    else    { el.classList.remove(...activeClasses); el.classList.add(...defaultClasses); }
  }

  function updateHidden() {
    const c = document.getElementById('selected-topics-container');
    if (!c) return;
    c.innerHTML = '';
    selectedTopics.forEach(id => {
      const i = document.createElement('input');
      i.type = 'hidden'; i.name = 'topics[]'; i.value = id; c.appendChild(i);
    });
  }

  function updateCount() {
    if (!selectedCount) return;
    selectedCount.innerHTML = `<span class="h-1.5 w-1.5 rounded-full bg-yellow-400 inline-block"></span> ${selectedTopics.length} selected`;
  }

  updateHidden(); updateCount();

  // Client-side validation
  document.getElementById('createGroupForm').addEventListener('submit', function(e) {
    const errors = [];
    const name = nameInput.value.trim();

    nameInput.classList.remove('ring-2','ring-red-500','border-red-600');
    topicsWrapper?.classList.remove('ring-2','ring-red-500','border-red-600');

    if (!name) {
      errors.push('Group name is required.');
      nameInput.classList.add('ring-2','ring-red-500','border-red-600');
    }
    if (selectedTopics.length === 0) {
      errors.push('Please select at least one topic.');
      topicsWrapper?.classList.add('ring-2','ring-red-500','border-red-600');
    }

    if (errors.length > 0) {
      e.preventDefault();
      const list = document.getElementById('errorList');
      list.innerHTML = '';
      errors.forEach(err => {
        const li = document.createElement('li'); li.textContent = err; list.appendChild(li);
      });
      const modal = document.getElementById('validationModal');
      modal.classList.remove('hidden'); modal.classList.add('flex');
    }
  });

  document.getElementById('closeModal')?.addEventListener('click', () => {
    const modal = document.getElementById('validationModal');
    modal.classList.add('hidden'); modal.classList.remove('flex');
  });
</script>
@endsection
@endsection
