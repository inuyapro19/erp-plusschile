{{-- En resources/views/components/menu-item.blade.php --}}

<div class="menu-item">
    <a class="menu-link" href="{{ route($item->route) }}">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
        <span class="menu-title">{{ $item->title }}</span>
    </a>
</div>
