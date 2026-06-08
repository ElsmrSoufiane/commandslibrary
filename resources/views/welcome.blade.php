<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Commands Library</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts

        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 min-h-screen flex flex-col">
        {{-- Navigation --}}
        <header class="w-full border-b border-zinc-200 dark:border-zinc-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('cmd.png') }}" alt="Commands Library" class="h-8 w-auto" />
                        <span class="text-lg font-semibold text-zinc-900 dark:text-white">Commands Library</span>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a
                                    href="{{ url('/user') }}"
                                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-colors"
                                >
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25Zm9.75-9.75A2.25 2.25 0 0 1 15.75 6H18a2.25 2.25 0 0 1 2.25 2.25v2.25A2.25 2.25 0 0 1 18 12.75h-2.25a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75A2.25 2.25 0 0 1 15.75 13.5H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                    </svg>
                                    User Panel
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white transition-colors"
                                >
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-colors"
                                    >
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </nav>
            </div>
        </header>

        {{-- Hero Section --}}
        <main class="flex-1 flex flex-col">
            <section class="relative flex flex-col items-center justify-center flex-1 px-4 py-24 sm:py-32 lg:px-8">
                {{-- Background decoration --}}
                <div class="absolute inset-0 -z-10 overflow-hidden">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] rounded-full bg-emerald-50 dark:bg-emerald-950/30 blur-3xl opacity-60 dark:opacity-30"></div>
                </div>

                <div class="mx-auto max-w-3xl text-center">
                    {{-- Logo --}}
                    <div class="mb-8 flex justify-center">
                        <img src="{{ asset('cmd.png') }}" alt="Commands Library" class="h-20 w-auto" />
                    </div>

                    {{-- Heading --}}
                    <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-6xl">
                        Commands Library
                    </h1>

                    <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto">
                        Your centralized hub for managing, organizing, and discovering commands. Built with the modern TALL stack for speed, simplicity, and elegance.
                    </p>

                    {{-- CTA --}}
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        @auth
                            <a
                                href="{{ url('/user') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all hover:shadow-emerald-600/30 hover:-translate-y-0.5"
                            >
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25Zm9.75-9.75A2.25 2.25 0 0 1 15.75 6H18a2.25 2.25 0 0 1 2.25 2.25v2.25A2.25 2.25 0 0 1 18 12.75h-2.25a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75A2.25 2.25 0 0 1 15.75 13.5H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>
                                Go to Panel
                            </a>
                        @else
                            <a
                                href="{{ url('/user') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all hover:shadow-emerald-600/30 hover:-translate-y-0.5"
                            >
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25Zm9.75-9.75A2.25 2.25 0 0 1 15.75 6H18a2.25 2.25 0 0 1 2.25 2.25v2.25A2.25 2.25 0 0 1 18 12.75h-2.25a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75A2.25 2.25 0 0 1 15.75 13.5H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>
                                Open Panel
                            </a>
                        @endauth
                    </div>
                </div>
            </section>

            {{-- Features Section --}}
            <section class="border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-4xl">
                            Built with the TALL Stack
                        </h2>
                        <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">
                            Powered by modern, performant technologies that developers love.
                        </p>
                    </div>

                    <div class="mx-auto mt-16 grid max-w-5xl grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        {{-- Tailwind --}}
                        <div class="relative rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8 shadow-sm">
                            <div class="mb-4 flex size-12 items-center justify-center rounded-xl bg-sky-50 dark:bg-sky-950">
                                <svg class="size-6 text-sky-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Tailwind CSS</h3>
                            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Utility-first CSS framework for rapid, responsive UI development.</p>
                        </div>

                        {{-- Alpine --}}
                        <div class="relative rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8 shadow-sm">
                            <div class="mb-4 flex size-12 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-950">
                                <svg class="size-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 0 0-2.455 2.456Z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Alpine.js</h3>
                            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Lightweight JavaScript framework for declarative interactivity.</p>
                        </div>

                        {{-- Laravel --}}
                        <div class="relative rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8 shadow-sm">
                            <div class="mb-4 flex size-12 items-center justify-center rounded-xl bg-rose-50 dark:bg-rose-950">
                                <svg class="size-6 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125v-3.75" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Laravel</h3>
                            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Robust PHP framework with elegant syntax and powerful features.</p>
                        </div>

                        {{-- Livewire --}}
                        <div class="relative rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8 shadow-sm">
                            <div class="mb-4 flex size-12 items-center justify-center rounded-xl bg-purple-50 dark:bg-purple-950">
                                <svg class="size-6 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Livewire</h3>
                            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Reactive UI framework for Laravel without leaving PHP.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        &copy; {{ date('Y') }} Commands Library. All rights reserved.
                    </p>
                    <div class="flex items-center gap-6">
                        <a href="{{ url('/user') }}" class="text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 transition-colors">
                            User Panel
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
