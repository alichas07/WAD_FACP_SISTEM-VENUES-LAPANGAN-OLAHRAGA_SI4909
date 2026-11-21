<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru - Venue Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
<div class="min-h-screen flex flex-col justify-center items-center p-4">
    <div class="w-full max-w-md space-y-4">
        <div class="text-center space-y-1">
            <h1 class="text-xl font-bold text-slate-900">Buat Akun Pengguna</h1>
            <p class="text-xs text-slate-500">Daftar akun baru untuk masuk ke Sistem Manajemen Venue</p>
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

            <form method="POST" action="{{ route('users.store') }}" class="space-y-3.5 text-xs">
                @csrf

                <div>
                    <label class="block font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-slate-900">
                </div>

                <div>
                    <label class="block font-medium text-slate-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="budi@venue.com" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-slate-900">
                </div>

                <div>
                    <label class="block font-medium text-slate-700 mb-1">Role</label>
                    <input type="text" value="User Biasa" disabled
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg bg-slate-100 text-slate-500 cursor-not-allowed">
                </div>

                <div>
                    <label class="block font-medium text-slate-700 mb-1">Kata Sandi (Min. 8 karakter)</label>
                    <input type="password" name="password" placeholder="••••••••" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-slate-900">
                </div>

                <div>
                    <label class="block font-medium text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-slate-900">
                </div>

                <button type="submit" class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg shadow-sm transition cursor-pointer">
                    Daftar Akun
                </button>
            </form>

            <div class="text-center text-xs text-slate-600 pt-2 border-t border-slate-100">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-slate-900 hover:underline">
                    Login di sini
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>