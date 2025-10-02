@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

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
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Admin</li>
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
      <div class="max-w-2xl">
        <div class="inline-flex items-center gap-2">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Console</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          Admin Dashboard
        </h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
          Review reports and manage users in one clean view.
        </p>
      </div>

      <div class="flex items-center gap-2 md:self-start">
        <a href="{{ route('admin.reports') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full
                  bg-yellow-400 text-gray-900 font-semibold text-sm
                  border border-yellow-300/70 shadow-sm hover:shadow-md transition">
          All Reports
        </a>
        <a href="{{ route('admin.users') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 font-semibold text-sm
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md transition">
          Users
        </a>
      </div>
    </div>
  </header>

  {{-- ===== Unsolved Reports ===== --}}
  <section>
    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">Unsolved Reports</h2>

    <div class="space-y-4 sm:space-y-6">
      @forelse($unsolvedReports as $report)
        <div class="p-5 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                    border border-gray-200/70 dark:border-gray-800/70
                    shadow-sm hover:shadow-md transition space-y-2">
          <p class="text-sm sm:text-base">
            <span class="font-semibold text-gray-900 dark:text-gray-100">Post:</span>
            @if($report->post && $report->post->id)
              <a href="{{ route('posts.show', $report->post->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                {{ Str::limit($report->post->title, 60) }}
              </a>
            @else
              <span class="text-gray-500 dark:text-gray-400">[Deleted]</span>
            @endif
          </p>

          <div class="grid sm:grid-cols-2 gap-x-6 gap-y-1 text-sm text-gray-700 dark:text-gray-300">
            <p><span class="font-semibold">Reported User:</span> {{ $report->reportedUser->name }}</p>
            <p><span class="font-semibold">Reporter:</span> {{ $report->reporter->name }}</p>
            <p><span class="font-semibold">Reason:</span> {{ $report->reason }}</p>
            <p><span class="font-semibold">Details:</span> {{ $report->details ?? 'N/A' }}</p>
          </div>

          <form action="{{ route('admin.reports.resolve', $report->id) }}" method="POST" class="pt-2">
            @csrf
            @method('PATCH')
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                           bg-white/70 dark:bg-gray-900/60 backdrop-blur
                           text-gray-900 dark:text-gray-100 font-semibold text-sm
                           border border-gray-300/70 dark:border-gray-700/80
                           hover:bg-yellow-50/60 dark:hover:bg-yellow-500/10
                           focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600
                           shadow-sm hover:shadow-md transition">
              Mark Resolved
            </button>
          </form>
        </div>
      @empty
        <p class="text-gray-500 dark:text-gray-400">No unsolved reports!</p>
      @endforelse
    </div>
  </section>
</div>
@endsection
