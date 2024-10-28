<div>
    <a href="javascript:void(0);" wire:click="like" class="text-primary">
        <i class="mdi mdi-thumb-up {{ $data->likes()->where('user_id', auth()->id())->exists() ? 'text-primary' : 'text-muted' }} text-primary"></i> 
        {{ $likesCount }} Like{{ $likesCount === 1 ? '' : 's' }}
    </a>
</div>
