<div class="d-flex align-items-center gap-1">
    <button
        wire:click="toggleLike"
        class="btn btn-sm shadow-none p-0"
        type="button"
    >
        @if ($liked)
            <i class="fa-solid fa-heart text-danger fs-4"></i>
        @else
            <i class="fa-regular fa-heart"></i>
        @endif
    </button>

    <span>{{ $likesCount }}</span>
</div>
