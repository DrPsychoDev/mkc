<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex gap-8 justify-center p-0">
            <a href="/">
                <x-dynamic-component :component="'heroicon-o-home'" class="w-8 h-8" />
            </a>
            @if(auth()->user()->is_reception)
                <a href="/attendance">
                    <x-dynamic-component :component="'heroicon-o-clipboard-document-check'" class="w-8 h-8" />
                </a>
            @endif
            @if(auth()->user()->is_judge)
                <a href="/evaluation">
                    <x-dynamic-component :component="'heroicon-o-pencil-square'" class="w-8 h-8" />
                </a>
            @endif
            @if(auth()->user()->is_dashboard)
                <a href="/dashboard">
                    <x-dynamic-component :component="'heroicon-o-presentation-chart-line'" class="w-8 h-8" />
                </a>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
