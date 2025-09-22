@extends('layouts.app')

@section('content')
<main class="bg-gray-100 min-h-screen pt-6 px-6">
    <div class="max-w-4xl mx-auto space-y-6">

       
        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm">
            <h1 class="text-4xl font-extrabold text-gray-900">About PostPit</h1>
        </div>

       
        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm space-y-4">
            <p class="text-lg leading-relaxed text-gray-700">
                Welcome to <span class="font-semibold text-gray-900">PostPit</span> — a community-driven platform where ideas, stories, and discussions thrive.
            </p>

            <p class="text-lg leading-relaxed text-gray-700">
                At PostPit, our goal is to create a space where anyone can share their thoughts, discover new topics, 
                and connect with people who share similar interests. Whether it’s breaking news, funny memes, deep 
                discussions, or niche communities, there’s a place for everyone here.
            </p>
        </div>

        
        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm">
            <section x-data="{ open: false }" class="space-y-2">
                <button @click="open = !open" 
                        class="flex items-center justify-between w-full text-2xl font-bold px-4 py-2 rounded text-gray-900 hover:bg-gray-200 transition">
                    <span>Why PostPit?</span>
                    <svg :class="{'rotate-180': open}" class="h-5 w-5 text-gray-900 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul x-show="open" x-transition class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>Create and join groups around your favorite topics</li>
                    <li>Share posts, links, images, and ideas</li>
                    <li>Connect with people who share your passions</li>
                </ul>
            </section>
        </div>

        
        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm">
            <section x-data="{ open: false }" class="space-y-2">
                <button @click="open = !open" 
                        class="flex items-center justify-between w-full text-2xl font-bold px-4 py-2 rounded text-gray-900 hover:bg-gray-200 transition">
                    <span>Our Values</span>
                    <svg :class="{'rotate-180': open}" class="h-5 w-5 text-gray-900 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul x-show="open" x-transition class="space-y-3 pl-6 text-gray-700">
                    <li><span class="font-semibold text-gray-900">Community First</span> – PostPit is built for people, by people.</li>
                    <li><span class="font-semibold text-gray-900">Respect & Inclusion</span> – Every voice matters.</li>
                    <li><span class="font-semibold text-gray-900">Freedom to Explore</span> – From serious debates to lighthearted memes, the pit is yours to shape.</li>
                </ul>
            </section>
        </div>

       
        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm">
            <p class="text-lg italic text-gray-900">
                Join us in building a vibrant, welcoming space where conversations never stop.
            </p>
        </div>
    </div>
</main>
@endsection
