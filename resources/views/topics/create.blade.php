@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <!-- Page Header Card -->
    <div class="p-6 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6 flex justify-between items-center">

        <h1 class="text-4xl font-extrabold text-gray-900">Create Topic</h1>
    </div>

    <form action="{{ route('topics.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Card wrapper -->
        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition space-y-6">

            <!-- Topic Name -->
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Topic Name</label>
                <input type="text" name="name" id="name" required
                       class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400" 
                       placeholder="Enter topic name">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700 font-medium mb-1">Description (optional)</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400" 
                          placeholder="Describe your topic..."></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                Create Topic
            </button>
        </div>
    </form>
</div>
@endsection
