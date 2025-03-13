<?php

namespace App\Livewire;

use Exception;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class NpiSearch extends Component
{
    public string $firstName = '';
    public string $lastName = '';
    public string $number = '';
    public string $taxonomy = '';
    public string $city = '';
    public string $state = '';
    public string $zip = '';

    public array $results = [];
    public int $totalResults = 0;
    public int $perPage = 4;
    public int $page = 1;
    public ?string $errorMessage = null;

    public bool $showModal = false;
    public array $selectedProviderDetails = [];

    public function render()
    {
        return view('livewire.npi-search')
            ->layout('layouts.app');
    }

    public function search()
    {
        $this->page = 1; // Reset to first page on new search
        $this->fetchResults();
    }

    public function loadPage($page)
    {
        $this->page = $page;
        $this->fetchResults();
    }

    public function fetchResults()
    {
        $this->errorMessage = null;

        // Build query params
        $query = [
            'version' => '2.1',
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'number' => $this->number,
            'taxonomy_description' => $this->taxonomy,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->zip,
            'limit' => $this->perPage,
            'skip' => ($this->page - 1) * $this->perPage,
        ];

        // Filter out empty values to avoid unnecessary parameters
        $query = array_filter($query, fn($value) => $value !== '' && $value !== null);

        try {
            $response = Http::get('https://npiregistry.cms.hhs.gov/api/', $query);
        } catch (Exception $e) {
            // Handle network or unexpected errors
            $this->errorMessage = "Failed to connect to NPI Registry. Please try again.";
            $this->results = [];
            return;
        }

        if ($response->failed()) {
            // Non-200 HTTP status
            $this->errorMessage = "NPI Registry search failed (HTTP {$response->status()}).";
            $this->results = [];
            return;
        }

        $data = $response->json();
        $this->totalResults = $data['result_count'] ?? 0;
        $this->results = $data['results'] ?? [];

        if ($this->totalResults === 0) {
            $this->errorMessage = "No results found for the given criteria.";
        }
    }

    public function showProvider($npi)
    {
        // Fetch details for the single provider (if not already available in current results)
        $response = Http::get('https://npiregistry.cms.hhs.gov/api/', [
            'number' => $npi,
            'version' => '2.1'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->selectedProviderDetails = $data['results'][0] ?? [];
        } else {
            $this->selectedProviderDetails = [];
        }

        $this->showModal = true;
    }
}
