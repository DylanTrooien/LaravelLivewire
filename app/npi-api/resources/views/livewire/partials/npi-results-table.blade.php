@include('livewire.partials.npi-table-pages')
<table class="table-auto min-w-full bg-white border">
    <thead class="bg-gray-100">
    <tr>
        <th class="text-left p-2 border">NPI</th>
        <th class="text-left p-2 border">Name</th>
        <th class="text-left p-2 border">Taxonomy</th>
        <th class="text-left p-2 border">City</th>
        <th class="text-left p-2 border">State</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $provider)
        @php
            $basic = $provider['basic'] ?? [];
            $addresses = $provider['addresses'][0] ?? [];  // first address (mailing or practice)
            $taxonomy = $provider['taxonomies'][0] ?? [];  // primary taxonomy
        @endphp
        <tr class="hover:bg-gray-50 cursor-pointer" wire:click.prevent="showProvider('{{ $provider['number'] }}')">
            <td class="p-2 border">{{ $provider['number'] }}</td>
            <td class="p-2 border">
                {{ $basic['first_name'] ?? '' }} {{ $basic['last_name'] ?? $basic['organization_name'] ?? '' }}
            </td>
            <td class="p-2 border">{{ $taxonomy['desc'] ?? 'N/A' }}</td>
            <td class="p-2 border">{{ $addresses['city'] ?? '' }}</td>
            <td class="p-2 border">{{ $addresses['state'] ?? '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@include('livewire.partials.npi-table-pages')
