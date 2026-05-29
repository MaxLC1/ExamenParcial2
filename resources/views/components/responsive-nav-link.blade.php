@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-bold text-white focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-300 hover:text-white focus:outline-none transition duration-150 ease-in-out';
$activeStyle = ($active ?? false) ? 'border-color: #D52B1E; background-color: #051c2e;' : '';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'style' => $activeStyle]) }} onmouseover="if(!{{ $active ?? 'false' }}){ this.style.backgroundColor='#072440'; }" onmouseout="if(!{{ $active ?? 'false' }}){ this.style.backgroundColor='transparent'; }">
    {{ $slot }}
</a>
