<div class="mt-8 mb-8 flex items-center justify-between">
    <div class="text-gray-600">
        Showing {{ ($page-1)*$perPage + 1 }} to
        {{ ($page-1)*$perPage + $totalResults }}
    </div>
    <div>
        @if($page > 1)
            <button wire:click="loadPage({{ $page-1 }})" class="px-3 py-1 border rounded">Previous</button>
        @endif
        @if($totalResults == $perPage)
            <button wire:click="loadPage({{ $page+1 }})" class="px-3 py-1 border rounded ml-2">Next</button>
        @endif
    </div>
</div>
