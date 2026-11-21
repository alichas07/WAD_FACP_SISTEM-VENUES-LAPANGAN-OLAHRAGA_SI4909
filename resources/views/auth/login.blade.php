<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Sistem - Venue Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
<div class="min-h-screen flex flex-col justify-center items-center p-4">
    <div class="w-full max-w-md space-y-4">
        <div class="text-center space-y-1">
            <h1 class="text-xl font-bold text-slate-900">Sistem Manajemen Venue</h1>
            <p class="text-xs text-slate-500">Login untuk mengakses Sistem Manajemen Venue</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm space-y-4">
            @if ($errors->any())
                <div class="p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-lg">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus
                           class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" placeholder="••••••••" required
                           class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-slate-900">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-lg shadow-sm transition cursor-pointer">
                    Masuk ke Sistem
                </button>
            </form>

            <!-- Opsi Buat Akun Baru -->
            <div class="text-center text-xs text-slate-600">
                Belum punya akun?
                <a href="{{ route('users.create') }}" class="font-semibold text-slate-900 hover:underline">
                    Buat Akun Baru
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>