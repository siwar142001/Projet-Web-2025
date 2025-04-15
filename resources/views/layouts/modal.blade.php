<div class="fixed inset-0 z-50 hidden items-center justify-center" data-modal="true" id="@yield('modal-id')">
    <div class="relative top-[10%] w-full max-w-[600px] rounded-lg bg-white shadow-lg border border-gray-300">
        <div class="flex items-center justify-between border-b border-gray-200 p-4">
            <h3 class="text-lg font-medium text-gray-900">
                @yield('modal-title')
            </h3>
            <button class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500" data-modal-dismiss="true">
                <i class="ki-outline ki-cross"></i>
            </button>
        </div>
        <div class="p-4">
            @yield('modal-content')
        </div>
    </div>
</div>