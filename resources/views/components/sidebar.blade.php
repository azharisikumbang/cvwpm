<aside x-show="sites.show_sidebar"
    class="fixed transition-all top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-14 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 pt-0 border-r border-gray-200">
        <div class="flex flex-col flex-1 pt-4 pb-4 overflow-y-auto">
            @include( auth()->user()->role->getSidebarMenuView() )
        </div>
        <div class="absolute bottom-0 left-0 text-sm w-full p-4 space-x-4 bg-white" sidebar-bottom-menu="">
            <p class="text-gray-600">&copy; 2024 {{ env('APP_NAME') }}</p>
        </div>
    </div>
</aside>