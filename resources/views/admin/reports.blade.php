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
      <li class="text-gray-900 dark:text-gray-100 font-semibold">All Reports</li>
    </ol>
  </nav>

  {{-- ===== Header ===== --}}
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="relative z-10 flex items-start justify-between gap-4">
      <div>
        <div class="inline-flex items-center gap-2">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)]"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Moderation</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          All Reports
        </h1>
      </div>

      <a href="{{ route('admin.index') }}"
         class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full
                bg-white/70 dark:bg-gray-900/60 backdrop-blur
                text-gray-900 dark:text-gray-100 text-sm font-semibold
                border border-gray-300/70 dark:border-gray-700/80
                shadow-sm hover:shadow-md transition">
        ← Back
      </a>
    </div>
  </header>

  {{-- ===== Reports List ===== --}}
  <section class="space-y-4 sm:space-y-6">
    @forelse($reports as $report)
      <div class="p-5 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70 shadow-sm hover:shadow-md transition">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
          <div class="space-y-1">
            <p class="text-sm sm:text-base">
              <span class="font-semibold text-gray-900 dark:text-gray-100">Post:</span>
              @if($report->post && $report->post->id)
                <a href="{{ route('posts.show', $report->post->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                  {{ Str::limit($report->post->title, 70) }}
                </a>
              @else
                <span class="text-gray-500 dark:text-gray-400">[Deleted]</span>
              @endif
            </p>
            <p class="text-sm text-gray-700 dark:text-gray-300"><span class="font-semibold">Reported User:</span> {{ $report->reportedUser->name }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-300"><span class="font-semibold">Reporter:</span> {{ $report->reporter->name }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-300"><span class="font-semibold">Reason:</span> {{ $report->reason }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-300"><span class="font-semibold">Details:</span> {{ $report->details ?? 'N/A' }}</p>
          </div>

          <div class="shrink-0">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                         {{ $report->resolved ? 'bg-green-100/70 text-green-800 border border-green-300/60 dark:bg-green-500/15 dark:text-green-100 dark:border-green-500/30'
                                             : 'bg-yellow-100/70 text-yellow-800 border border-yellow-300/60 dark:bg-yellow-500/15 dark:text-yellow-100 dark:border-yellow-500/30' }}">
              {{ $report->resolved ? 'Resolved' : 'Pending' }}
            </span>
          </div>
        </div>

        @if(!$report->resolved)
          <form action="{{ route('admin.reports.resolve', $report->id) }}" method="POST" class="pt-3">
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
        @endif
      </div>
    @empty
      <p class="text-gray-500 dark:text-gray-400">No reports available.</p>
    @endforelse
  </section>
</div>
@endsection
