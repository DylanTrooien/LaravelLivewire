<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">NPI Registry Search</h1>
    <form wire:submit.prevent="search" class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded">
        <input type="text" wire:model.defer="firstName" placeholder="First Name" class="border p-2" />
        <input type="text" wire:model.defer="lastName" placeholder="Last Name" class="border p-2" />
        <input type="text" wire:model.defer="number" placeholder="NPI Number" class="border p-2" />
        <input type="text" wire:model.defer="taxonomy" placeholder="Taxonomy (Description)" class="border p-2" />
        <input type="text" wire:model.defer="city" placeholder="City" class="border p-2" />
        <input type="text" wire:model.defer="state" placeholder="State (2-letter)" class="border p-2" />
        <input type="text" wire:model.defer="zip" placeholder="Zip Code" class="border p-2" />
        <div class="col-span-2 text-right">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
        </div>
    </form>
    <div wire:loading class="mt-4">Searching NPI Registry...</div>
    <!-- Results will be displayed below -->
    @if($errorMessage)
        <div class="text-red-600 mt-4">{{ $errorMessage }}</div>
    @endif

    @if(!empty($results))
        <div class="mt-6">
            @include('livewire.partials.npi-results-table')
        </div>
    @endif

    <div x-data="{ open: @entangle('showModal') }" x-show="open"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
         x-cloak x-transition>
        <div class="bg-white rounded-lg shadow-lg w-3/4 max-w-2xl p-6 relative">
            <!-- Close button -->
            <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
                    @click="open = false">&times;</button>
            <h2 class="text-xl font-semibold mb-4">Provider Details</h2>
            @if($selectedProviderDetails)
                @php
                    $basic = $selectedProviderDetails['basic'] ?? [];
                @endphp
                <p><strong>Name:</strong>
                    {{ $basic['first_name'] ?? '' }} {{ $basic['last_name'] ?? $selectedProviderDetails['enumeration_type'] == 'NPI-2' ? $basic['organization_name'] ?? '' : '' }}</p>
                <p><strong>NPI:</strong> {{ $selectedProviderDetails['number'] ?? '' }}</p>
                <p><strong>Status:</strong> {{ $basic['status'] ?? '' }}</p>
                <p><strong>Enumeration Date:</strong> {{ $basic['enumeration_date'] ?? '' }}</p>
                <p><strong>Gender:</strong> {{ $basic['gender'] ?? 'N/A' }}</p>
                <p class="mt-3"><strong>Taxonomies:</strong></p>
                <ul class="list-disc list-inside">
                    @foreach($selectedProviderDetails['taxonomies'] ?? [] as $tax)
                        <li>{{ $tax['desc'] ?? '' }} ({{ $tax['code'] ?? '' }}) {{ $tax['primary'] ? '[Primary]' : '' }}</li>
                    @endforeach
                </ul>
                <p class="mt-3"><strong>Addresses:</strong></p>
                <ul class="list-disc list-inside">
                    @foreach($selectedProviderDetails['addresses'] ?? [] as $addr)
                        <li>{{ $addr['address_purpose'] ?? '' }} – {{ $addr['address_1'] ?? '' }}, {{ $addr['city'] ?? '' }}, {{ $addr['state'] ?? '' }} {{ $addr['postal_code'] ?? '' }}</li>
                    @endforeach
                </ul>
                <!-- Add more fields as needed, e.g., identifiers, licenses -->
            @endif
        </div>
    </div>
</div>
