
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta
        name="description"
        content="Lost and Found - Platform pengelolaan barang hilang dan temuan."
    >
    <meta name="theme-color" content="#1C2C58">
    <title>Coming Soon — FILKOM Finders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden antialiased">
    <main
        data-coming-soon
        class="coming-soon-bg relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-10"
    >
        <div class="coming-soon-grid absolute inset-0 pointer-events-none"></div>
        <div
            data-float="slow"
            class="coming-soon-orb coming-soon-orb-blue
            -left-32 -top-32 h-[420px] w-[420px] opacity-70"
        ></div>
        <div
            data-float="medium"
            class="coming-soon-orb coming-soon-orb-violet
            -bottom-40 -right-32 h-[520px] w-[520px] opacity-60"
        ></div>
        <div
            data-float="fast"
            class="coming-soon-orb coming-soon-orb-emerald
            right-[20%] top-[12%] h-[190px] w-[190px] opacity-40"
        ></div>
        <div
            data-float="slow"
            class="coming-soon-ring absolute -right-32 top-[10%]
            h-[420px] w-[420px] opacity-40"
        ></div>
        <div
            data-float="medium"
            class="coming-soon-ring absolute -right-16 top-[18%]
            h-[290px] w-[290px] opacity-30"
        ></div>
        <div
            data-float="fast"
            class="coming-soon-ring absolute -left-24 bottom-[5%]
            h-[250px] w-[250px] opacity-30"
        ></div>
        <div class="relative z-10 mx-auto w-full max-w-6xl">
            <header
                data-animate="header"
                class="mb-16 flex items-center justify-between"
            >
                <a href="/" class="group flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center
                        rounded-2xl bg-blue-500 shadow-lg
                        shadow-blue-500/25 transition-transform
                        duration-300 group-hover:rotate-6">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="23"
                            height="23"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="white"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                            <path d="m3.3 7 8.7 5 8.7-5"/>
                            <path d="M12 22V12"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-lg font-bold tracking-tight text-ghost-50">
                            FILKOM Finders
                        </span>
                        <span class="block text-[10px] font-medium
                            tracking-[0.25em] text-ghost-900 uppercase">
                            Campus Management System
                        </span>
                    </div>
                </a>
                <div class="coming-soon-label hidden items-center gap-2
                    rounded-full px-4 py-2 sm:flex">
                    <span class="coming-soon-dot"></span>
                    <span class="text-xs font-medium tracking-wide text-ghost-500">
                        UNDER DEVELOPMENT
                    </span>
                </div>
            </header>
            <section class="grid items-center gap-16 lg:grid-cols-2">
                <div data-animate="content" class="max-w-2xl">
                    <div class="coming-soon-label mb-8 inline-flex
                        items-center gap-2 rounded-full px-4 py-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                        <span class="text-xs font-semibold tracking-[0.18em]
                            text-ghost-500 uppercase">
                            Something new is coming
                        </span>
                    </div>
                    <h1 class="text-[clamp(3.2rem,8vw,6.5rem)]
                        font-extrabold leading-[0.95] tracking-[-0.065em]">
                        <span class="block text-ghost-50">
                            FILKOM
                        </span>
                        <span class="coming-soon-gradient block">
                            Finders
                        </span>
                        <span class="mt-4 block text-[clamp(1.5rem,4vw,2.8rem)]
                            font-semibold tracking-[-0.04em] text-ghost-700">
                            Coming Soon<span class="text-blue-500">.</span>
                        </span>
                    </h1>
                    <p class="mt-8 max-w-lg text-base leading-8 text-ghost-700 sm:text-lg">
                        A smarter way to report, discover, and recover
                        lost belongings. We are building a centralized
                        Lost and Found platform to make every discovery
                        easier.
                    </p>
                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <div class="coming-soon-glass flex items-center
                            gap-3 rounded-2xl px-5 py-4">
                            <div class="flex h-10 w-10 items-center
                                justify-center rounded-xl bg-emerald-500/10">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="21"
                                    height="21"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#3EC89A"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M12 8v4l3 2"/>
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-ghost-900">
                                    Current status
                                </p>
                                <p class="mt-0.5 text-sm font-semibold text-ghost-50">
                                    Building something useful
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 px-2">
                            <span class="coming-soon-dot"></span>
                            <span class="text-xs font-medium text-emerald-500">
                                In progress
                            </span>
                        </div>
                    </div>
                </div>
                <div
                    data-animate="visual"
                    class="relative mx-auto flex aspect-square w-full
                    max-w-[440px] items-center justify-center"
                >
                    <div class="absolute h-[75%] w-[75%] rounded-full
                        bg-blue-500/20 blur-[90px]"></div>
                    <div
                        data-float="slow"
                        class="coming-soon-ring absolute h-[94%] w-[94%]"
                    ></div>
                    <div
                        data-float="medium"
                        class="coming-soon-ring absolute h-[76%] w-[76%]
                        border-dashed opacity-60"
                    ></div>
                    <div
                        data-float="fast"
                        class="coming-soon-glass absolute -left-2 top-[17%]
                        z-20 flex items-center gap-3 rounded-2xl p-3 sm:-left-8"
                    >
                        <div class="flex h-10 w-10 items-center justify-center
                            rounded-xl bg-violet-500/15 text-violet-500">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.35-4.35"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-ghost-50">
                                Discover
                            </p>
                            <p class="text-[10px] text-ghost-900">
                                Find lost items
                            </p>
                        </div>
                    </div>
                    <div
                        data-float="medium"
                        class="coming-soon-glass absolute -right-2 bottom-[20%]
                        z-20 flex items-center gap-3 rounded-2xl p-3 sm:-right-8"
                    >
                        <div class="flex h-10 w-10 items-center justify-center
                            rounded-xl bg-emerald-500/15 text-emerald-500">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-ghost-50">
                                Reunited
                            </p>
                            <p class="text-[10px] text-ghost-900">
                                Return what matters
                            </p>
                        </div>
                    </div>
                    <div
                        data-float="slow"
                        class="coming-soon-glass relative z-10
                        flex aspect-square w-[58%] flex-col
                        items-center justify-center rounded-[2.5rem] p-6"
                    >
                        <div class="relative mb-7 flex h-28 w-28
                            items-center justify-center rounded-[2rem]
                            bg-gradient-to-br from-blue-500
                            via-blue-600 to-violet-500
                            shadow-2xl shadow-blue-500/30">
                            <div class="absolute inset-1 rounded-[1.7rem]
                                border border-white/20"></div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="54"
                                height="54"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="white"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                                <path d="m3.3 7 8.7 5 8.7-5"/>
                                <path d="M12 22V12"/>
                            </svg>
                        </div>
                        <p class="text-center text-sm font-bold
                            tracking-wide text-ghost-50">
                            FILKOM Finders
                        </p>
                        <p class="mt-2 text-center text-xs text-ghost-900">
                            One platform, easier discovery.
                        </p>
                        <div class="mt-7 flex items-center gap-2">
                            <span class="h-1.5 w-6 rounded-full bg-blue-500"></span>
                            <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        </div>
                    </div>
                    <div
                        data-float="fast"
                        class="absolute right-[16%] top-[7%] h-4 w-4
                        rounded-full bg-blue-500 shadow-lg shadow-blue-500/50"
                    ></div>
                    <div
                        data-float="medium"
                        class="absolute bottom-[10%] left-[15%] h-3 w-3
                        rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50"
                    ></div>
                    <div
                        data-float="slow"
                        class="absolute left-[17%] top-[65%] h-2 w-2
                        rounded-full bg-violet-500 shadow-lg shadow-violet-500/50"
                    ></div>
                </div>
            </section>
            <footer
                data-animate="footer"
                class="mt-20"
            >
                <div class="coming-soon-divider"></div>
                <div class="flex flex-col items-center
                    justify-between gap-4 pt-7 text-center sm:flex-row">
                    <p class="text-xs tracking-wide text-ghost-900">
                        &copy; {{ date('Y') }} Lost & Found.
                        All rights reserved.
                    </p>
                    <p class="text-xs text-ghost-900">
                        Built with purpose. Coming with care.
                    </p>
                </div>
            </footer>
        </div>
    </main>
</body>
</html>
