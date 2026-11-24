<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Masukkan email Anda. Kami kirimkan tautan masuk satu klik, tanpa perlu mengetik kata sandi.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login.link.send') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                Masuk dengan kata sandi
            </a>
            <x-primary-button>Kirim Tautan Masuk</x-primary-button>
        </div>
    </form>
</x-guest-layout>