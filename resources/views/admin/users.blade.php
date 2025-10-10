@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  {{-- ===== Breadcrumbs ===== --}}
  <nav aria-label="Breadcrumb"
       class="rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur
              border border-gray-200/70 dark:border-gray-800/70 shadow-sm px-3 sm:px-4 py-2">
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
        <a href="{{ route('admin.index') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold">Admin</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </li>
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Users</li>
    </ol>
  </nav>

  {{-- ===== Header ===== --}}
  <header
    class="relative overflow-hidden rounded-3xl p-4 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -right-16 -top-10 h-44 w-44 sm:h-56 sm:w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="absolute -left-20 -bottom-16 h-52 w-52 sm:h-64 sm:w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    <div class="relative z-10 flex items-start justify-between gap-2">
      <div class="min-w-0">
        <div class="inline-flex items-center gap-2 mb-1">
          <span class="h-1.5 w-1.5 rounded-full bg-yellow-400 shadow-[0_0_16px_theme(colors.yellow.300)]"></span>
          <span class="text-[10px] sm:text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Management</span>
        </div>
        <h1 class="text-xl sm:text-3xl font-extrabold tracking-tight
                   bg-clip-text text-transparent bg-gradient-to-b
                   from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          User Management
        </h1>
      </div>

      <a href="{{ route('admin.index') }}"
         class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-full
                bg-white/70 dark:bg-gray-900/60 backdrop-blur
                text-gray-900 dark:text-gray-100 text-[13px] sm:text-sm font-semibold
                border border-gray-300/70 dark:border-gray-700/80
                shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
        </svg>
        Back
      </a>
    </div>
  </header>

  {{-- ===== Search + Sort (mobile-first; 320px-safe) ===== --}}
  <section class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl p-3 sm:p-6">
    <form method="GET" class="space-y-2.5 sm:space-y-0 sm:flex sm:items-center sm:gap-3">
      {{-- Search with right yellow icon --}}
      <div class="relative w-full min-w-0">
        <label for="users-search" class="sr-only">Search</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/>
          </svg>
        </span>

        <input type="text" id="users-search" name="search" value="{{ request('search', '') }}"
               placeholder="Search by name or email…"
               class="w-full min-w-0 pl-9 pr-24 sm:pr-40 py-2 rounded-full
                      text-[13px] sm:text-base
                      border border-gray-300 dark:border-gray-700
                      bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                      placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">

        @if(request('search'))
          <a href="{{ url()->current() }}"
             class="hidden sm:inline-flex absolute right-16 top-1/2 -translate-y-1/2 items-center gap-1 px-2.5 py-1.5 rounded-full
                    text-xs bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 hover:-translate-y-0.5 hover:shadow transition">
            Clear
          </a>
        @endif

        <button type="submit" title="Search" aria-label="Search"
                class="absolute right-1.5 top-1/2 -translate-y-1/2 inline-flex items-center justify-center px-2.5 py-1.5 rounded-full
                       bg-yellow-400 text-gray-900 border border-yellow-300/70 shadow-sm hover:shadow-md transition">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[20px] h-[20px]">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
        </button>
      </div>

      {{-- Sort & mobile clear --}}
      <div class="flex gap-2 sm:gap-3">
        <label for="users-sort" class="sr-only">Sort</label>
        <select name="sort" id="users-sort"
                class="w-full sm:w-auto px-3 py-2 rounded-full text-[13px] sm:text-sm
                       border border-gray-300 dark:border-gray-700
                       bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
          <option value="">Sort By</option>
          <option value="warnings_desc" {{ request('sort')=='warnings_desc' ? 'selected' : '' }}>Most Warnings</option>
          <option value="warnings_asc"  {{ request('sort')=='warnings_asc'  ? 'selected' : '' }}>Least Warnings</option>
          <option value="name_asc"      {{ request('sort')=='name_asc'      ? 'selected' : '' }}>Name A–Z</option>
          <option value="name_desc"     {{ request('sort')=='name_desc'     ? 'selected' : '' }}>Name Z–A</option>
        </select>

        @if(request('search'))
          <a href="{{ url()->current() }}"
             class="sm:hidden inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full text-xs
                    bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700">
            Clear
          </a>
        @endif
      </div>
    </form>
  </section>

  {{-- ===== Users List (320px-safe) ===== --}}
  <section class="space-y-3.5 sm:space-y-6">
    @forelse($users as $user)
      @php $initials = strtoupper(mb_substr($user->name, 0, 2)); $wCount = $user->warnings->count() ?? 0; @endphp
      <article
        class="p-3 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
               border border-gray-200/70 dark:border-gray-800/70
               shadow-sm hover:shadow-md transition">

        <div class="flex gap-2.5 sm:gap-3">
          <div class="shrink-0 w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-gradient-to-br from-yellow-400 to-amber-500 text-white font-bold grid place-items-center text-xs sm:text-base">
            {{ $initials }}
          </div>

          <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
              <p class="font-bold text-gray-900 dark:text-gray-100 leading-tight truncate max-w-full text-[14px] sm:text-base">
                {{ $user->name }}
              </p>

              @if($user->isAdmin())
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-[11px] font-semibold
                             bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                             text-gray-700 dark:text-gray-300">Admin</span>
              @endif

              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-[11px] font-semibold
                           border
                           {{ $wCount>=3 ? 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-200 dark:border-red-700/60'
                                         : ($wCount>=1 ? 'bg-yellow-50 text-yellow-800 border-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-100 dark:border-yellow-700/60'
                                                       : 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700') }}">
                Warnings: {{ $wCount }}
              </span>
            </div>

            <p class="text-gray-600 dark:text-gray-300 text-[12px] sm:text-sm mt-0.5 truncate">{{ $user->email }}</p>

            <div class="mt-2 sm:hidden">
              @if(!$user->isAdmin())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                      onsubmit="return confirm('Delete user?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-full
                                 bg-white/70 dark:bg-gray-900/60 backdrop-blur
                                 text-red-600 dark:text-red-400 text-[13px] font-semibold
                                 border border-red-300/60 dark:border-red-500/40
                                 shadow-sm hover:shadow-md
                                 hover:bg-red-50/70 dark:hover:bg-red-900/20
                                 focus:outline-none focus:ring-2 focus:ring-red-300/70 dark:focus:ring-red-600/50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.5"
                         class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 48.667 0 0 0-7.5 0"/>
                    </svg>
                    Delete
                  </button>
                </form>
              @endif
            </div>
          </div>

          <div class="hidden sm:flex sm:flex-col sm:items-end sm:justify-center sm:gap-2">
            @if(!$user->isAdmin())
              <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                    onsubmit="return confirm('Delete user?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-full
                               bg-white/70 dark:bg-gray-900/60 backdrop-blur
                               text-red-600 dark:text-red-400 text-sm font-semibold
                               border border-red-300/60 dark:border-red-500/40
                               shadow-sm hover:shadow-md
                               hover:bg-red-50/70 dark:hover:bg-red-900/20
                               focus:outline-none focus:ring-2 focus:ring-red-300/70 dark:focus:ring-red-600/50 transition">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                       fill="none" stroke="currentColor" stroke-width="1.5"
                       class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                  </svg>
                  Delete
                </button>
              </form>
            @endif
          </div>
        </div>
      </article>
    @empty
      <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">No users found.</p>
    @endforelse
  </section>

  {{-- ===== Pagination ===== --}}
  <div>
    {{ $users->appends(request()->query())->links() }}
  </div>
</div>

<script>
  document.getElementById('users-sort')?.addEventListener('change', function(){ this.form.submit(); });
</script>
@endsection
