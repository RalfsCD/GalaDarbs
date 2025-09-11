@extends('layouts.app')

@section('content')
<div class="min-h-screen flex justify-center p-6">
    <div class="w-full max-w-2xl bg-white/50 backdrop-blur-md border border-gray-200 rounded-3xl p-8 shadow-sm space-y-6">

        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-900">Create Topic</h1>

        <!-- Form -->
        <form action="{{ route('topics.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-900 font-medium">Name</label>
                <input type="text" name="name" id="name" required
                       class="w-full mt-1 px-4 py-2 rounded-lg border-2 border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300"/>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-900 font-medium">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full mt-1 px-4 py-2 rounded-lg border-2 border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                Create Topic
            </button>
        </form>
    </div>
</div>
@endsection
