<?php

namespace App\Livewire;

use App\Models\Division;
use Livewire\Component;

class Dashboard extends Component
{
    public $divisions;

    public function mount()
    {
        // Carregar as divisões e os participantes associados
        $this->loadDivisions();
    }

    public function loadDivisions()
    {
        $this->divisions = Division::with(['participants'])
            ->get()
            ->map(function ($division) {
                $division->participants = $division->participants
                    ->sortByDesc('total_evaluation')
                    ->take(8);
                return $division;
            });

    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}
