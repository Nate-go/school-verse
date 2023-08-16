<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Row extends Component
{
    private $item;
    private $header;

    public function mount($item, $header)
    {
        $this->item = $item;
        $this->header = $header;
    }

    public function render()
    {
        return view('livewire.row', [
            'item' => $this->item,
            'header' => $this->header
        ]);
    }
}
