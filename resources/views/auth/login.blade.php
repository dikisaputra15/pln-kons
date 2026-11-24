<x-stisla.layout title="Masuk">
    <x-stisla.card title="Masuk">
        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <x-stisla.form-input name="email" label="Email" type="email" :value="old('email')"
                autocomplete="username" required autofocus />

            <x-stisla.form-input name="password" label="Kata sandi" type="password"
                autocomplete="current-password" required />

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input id="remember" name="remember" value="1" type="checkbox"
                        class="custom-control-input" @checked(old('remember'))>
                    <label for="remember" class="custom-control-label text-dark">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Masuk</button>
        </form>
    </x-stisla.card>
</x-stisla.layout>
