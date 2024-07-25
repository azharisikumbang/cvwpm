<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableFooterNavigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        int $total,
        int $prev_page_url,
        int $next_page_url
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-footer-navigation');
    }
}
