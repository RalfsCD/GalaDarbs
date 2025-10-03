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
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -right-16 -top-10 h-56 w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="absolute -left-20 -bottom-16 h-64 w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    <div class="relative z-10 flex items-start justify-between gap-3">
      <div>
        <div class="inline-flex items-center gap-2 mb-1">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_16px_theme(colors.yellow.300)]"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Management</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight
                   bg-clip-text text-transparent bg-gradient-to-b
                   from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          User Management
        </h1>
      </div>

      <a href="{{ route('admin.index') }}"
         class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                bg-white/70 dark:bg-gray-900/60 backdrop-blur
                text-gray-900 dark:text-gray-100 text-sm font-semibold
                border border-gray-300/70 dark:border-gray-700/80
                shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
        </svg>
        Back
      </a>
    </div>
  </header>

  {{-- ===== Search + Sort ===== --}}
  <section class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl p-4 sm:p-6">
    <form method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
      <input type="text" name="search" value="{{ request('search') }}"
             placeholder="Search by name or email…"
             class="flex-1 px-4 py-2.5 rounded-full border border-gray-300 dark:border-gray-700
                    bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                    placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">

      <div class="flex items-center gap-2">
        <select name="sort"
                class="px-3 py-2.5 rounded-full border border-gray-300 dark:border-gray-700
                       bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
          <option value="">Sort By</option>
          <option value="warnings_desc" {{ request('sort')=='warnings_desc' ? 'selected' : '' }}>Most Warnings</option>
          <option value="warnings_asc" {{ request('sort')=='warnings_asc' ? 'selected' : '' }}>Least Warnings</option>
          <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Name A–Z</option>
          <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Name Z–A</option>
        </select>

        <button type="submit"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                       bg-yellow-400 text-gray-900 text-sm font-semibold
                       border border-yellow-300/70 shadow-sm hover:shadow-md transition">
          Apply
        </button>
      </div>
    </form>
  </section>

  {{-- ===== Users List ===== --}}
  <section class="space-y-4 sm:space-y-6">
    @forelse($users as $user)
      <div class="p-5 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70
                  shadow-sm hover:shadow-md transition flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        {{-- Info --}}
        <div class="flex items-start gap-3 min-w-0">
          @php $initials = strtoupper(mb_substr($user->name, 0, 2)); @endphp
          <div class="shrink-0 w-11 h-11 rounded-full bg-gradient-to-br from-yellow-400 to-amber-500 text-white font-bold flex items-center justify-center">
            {{ $initials }}
          </div>

          <div class="min-w-0">
            <p class="font-bold text-gray-900 dark:text-gray-100 leading-tight truncate">{{ $user->name }}</p>
            <p class="text-gray-600 dark:text-gray-300 text-sm truncate">{{ $user->email }}</p>
            <p class="text-sm mt-1">
              <span class="text-gray-500 dark:text-gray-400">Warnings:</span>
              <span class="{{ ($user->warnings->count() ?? 0) >= 3 ? 'text-red-600 font-semibold' : (($user->warnings->count() ?? 0) >= 1 ? 'text-yellow-600 font-semibold' : 'text-gray-500') }}">
                {{ $user->warnings->count() ?? 0 }}
              </span>
            </p>
          </div>
        </div>

        {{-- Actions --}}
        <div class="mt-1 sm:mt-0 flex items-center gap-2">
          @if($user->isAdmin())
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                         bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                         text-gray-700 dark:text-gray-300">Admin</span>
          @else
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                  onsubmit="return confirm('Delete user?');">
              @csrf
              @method('DELETE')
              {{-- compact ghost-danger with YOUR SVG --}}
              <button type="submit"
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                             bg-white/70 dark:bg-gray-900/60 backdrop-blur
                             text-red-600 dark:text-red-400 text-sm font-semibold
                             border border-red-300/60 dark:border-red-500/40
                             shadow-sm hover:shadow-md
                             hover:bg-red-50/70 dark:hover:bg-red-900/20
                             focus:outline-none focus:ring-2 focus:ring-red-300/70 dark:focus:ring-red-600/50
                             transition">
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
    @empty
      <p class="text-gray-500 dark:text-gray-400">No users found.</p>
    @endforelse
  </section>

  {{-- ===== Pagination ===== --}}
  <div>
    {{ $users->appends(request()->query())->links() }}
  </div>
</div>
@endsection
