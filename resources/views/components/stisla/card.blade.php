@props(['title'])

<div {{ $attributes->class(['card', 'card-primary']) }}>
    <div class="card-header">
        <h1 class="h5 mb-0">{{ $title }}</h1>
    </div>

    <div class="card-body">
        {{ $slot }}
    </div>
</div>
