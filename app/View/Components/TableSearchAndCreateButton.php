<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableSearchAndCreateButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $search,
        public string $create,
        public string $label = 'Tambah Data',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-search-and-create-button');
    }
}
