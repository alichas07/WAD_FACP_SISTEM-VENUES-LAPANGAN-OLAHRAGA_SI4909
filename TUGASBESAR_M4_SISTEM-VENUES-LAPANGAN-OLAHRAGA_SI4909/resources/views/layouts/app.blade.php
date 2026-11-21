<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Venue Manager')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 text-xs antialiased">
<div class="min-h-screen flex">
    <!-- Sidebar Kiri -->
    <aside class="w-56 bg-white border-r border-slate-200 flex flex-col shrink-0">
        <div class="h-14 px-4 flex items-center border-b border-slate-200">
            <span class="font-bold text-sm text-slate-900">Venue Manager</span>
        </div>

        <nav class="flex-1 p-3 space-y-1">
            <a href="{{ route('venues.index') }}"
               class="block px-3 py-2 rounded-lg {{ request()->routeIs('venues.*') ? 'bg-slate-900 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                Lapangan
            </a>
            <a href="{{ route('rentals.index') }}"
               class="block px-3 py-2 rounded-lg {{ request()->routeIs('rentals.*') ? 'bg-slate-900 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                Rental Alat
            </a>
            <a href="{{ route('members.index') }}"
               class="block px-3 py-2 rounded-lg {{ request()->routeIs('members.*') ? 'bg-slate-900 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                Member
            </a>
            <a href="{{ route('coaches.index') }}"
               class="block px-3 py-2 rounded-lg {{ request()->routeIs('coaches.*') ? 'bg-slate-900 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                Instruktur
            </a>
        </nav>
    </aside>

    <!-- Area Konten Kanan -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Header Atas: Judul + Status Profil & Logout di Kanan -->
        <header class="h-14 bg-white border-b border-slate-200 px-5 flex items-center justify-between gap-4">
            <div class="font-semibold text-slate-800 text-sm truncate">
                @yield('page_title', '')
            </div>

            @auth
                <div class="flex items-center gap-3 shrink-0">
                    <div class="flex items-center gap-2">
                        <div class="text-right leading-tight">
                            <div class="font-semibold text-slate-900">{{ auth()->user()->name }}</div>
                            <div class="text-[11px] text-slate-500">{{ auth()->user()->email }}</div>
                        </div>
                        <span class="px-2 py-0.5 rounded font-semibold text-[11px] {{ auth()->user()->role === 'admin' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                            {{ auth()->user()->role === 'admin' ? 'Admin' : 'User Biasa' }}
                        </span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-2.5 py-1 bg-rose-50 text-rose-600 border border-rose-200 rounded-lg hover:bg-rose-100 font-medium cursor-pointer">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </header>

        <!-- Konten Utama -->
        <main class="p-5 space-y-4">
            @if(session('success'))
                <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-lg">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>