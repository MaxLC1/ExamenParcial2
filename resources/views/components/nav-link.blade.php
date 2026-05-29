@props(['active'])

@php
$classes = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold leading-5 focus:outline-none transition duration-150 ease-in-out';
$activeStyle = ($active ?? false) ? 'border-color: #D52B1E; color: white;' : 'border-color: transparent; color: #d1d5db;';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'style' => $activeStyle]) }} onmouseover="this.style.color='white'" onmouseout="if(!{{ $active ?? 'false' }}){ this.style.color='#d1d5db'; }">
    {{ $slot }}
</a>
