@extends('layouts.app')

@section('content')
<main class="bg-black min-h-screen pt-6 pl-6">
    <!-- Container aligned left -->
    <div class="space-y-10 max-w-4xl">
        <!-- Title with animation (aligned same as welcome page) -->
        <h1 class="text-4xl font-extrabold text-white">
            About 
            <span class="inline-block animate-shake text-yellow-400">PostPit</span>
        </h1>

        <!-- Intro -->
        <p class="text-lg leading-relaxed text-white">
            Welcome to <span class="font-semibold">PostPit</span> — a community-driven platform where ideas, stories, and discussions thrive.
        </p>

        <p class="text-lg leading-relaxed text-white">
            At PostPit, our goal is to create a space where anyone can share their thoughts, discover new topics, 
            and connect with people who share similar interests. Whether it’s breaking news, funny memes, deep 
            discussions, or niche communities, there’s a place for everyone here.
        </p>

        <!-- Why PostPit Dropdown -->
        <section x-data="{ open: false }" class="space-y-2">
            <button @click="open = !open" class="flex items-center text-2xl font-bold mb-2 focus:outline-none space-x-2 hover:text-gray-300 transition-colors text-white">
                <span>Why PostPit?</span>
                <svg :class="{'rotate-180': open}" class="h-5 w-5 text-yellow-400 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <ul x-show="open" x-transition class="list-none pl-0 space-y-2 text-lg text-white">
                <li>Create and join groups around your favorite topics</li>
                <li>Share posts, links, images, and ideas</li>
                <li>Upvote content you like and help surface the best discussions</li>
                <li>Connect with people who share your passions</li>
            </ul>
        </section>

        <!-- Values Dropdown -->
        <section x-data="{ open: false }" class="space-y-2">
            <button @click="open = !open" class="flex items-center text-2xl font-bold mb-2 focus:outline-none space-x-2 hover:text-gray-300 transition-colors text-white">
                <span>Our Values</span>
                <svg :class="{'rotate-180': open}" class="h-5 w-5 text-yellow-400 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <ul x-show="open" x-transition class="space-y-3 text-lg pl-6 text-white">
                <li><span class="font-semibold">Community First</span> – PostPit is built for people, by people.</li>
                <li><span class="font-semibold">Respect & Inclusion</span> – Every voice matters.</li>
                <li><span class="font-semibold">Freedom to Explore</span> – From serious debates to lighthearted memes, the pit is yours to shape.</li>
            </ul>
        </section>

        <!-- Closing -->
        <p class="text-lg italic text-white">
            Join us in building a vibrant, welcoming space where conversations never stop.
        </p>
    </div>
</main>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-2px); }
        40% { transform: translateX(2px); }
        60% { transform: translateX(-1px); }
        80% { transform: translateX(1px); }
    }

    .animate-shake {
        display: inline-block;
        animation: shake 0.6s ease-in-out infinite;
    }
</style>
@endsection
