<x-stisla.dashboard.layout title="Dashboard">
    <div class="hero bg-primary text-white mb-4">
        <div class="hero-inner">
            <h2>Selamat datang, {{ auth()->user()->name }}.</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">
            <x-stisla.card title="Informasi Akun">
                <dl class="row text-dark mb-0">
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8">{{ auth()->user()->name }}</dd>
                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8 mb-0 text-break">{{ auth()->user()->email }}</dd>
                </dl>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
