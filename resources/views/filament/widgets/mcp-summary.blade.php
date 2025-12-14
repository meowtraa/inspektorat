<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- BARIS 1 KIRI (KOSONG) --}}
    <div class="hidden lg:block"></div>

    {{-- BARIS 1 KANAN --}}
    <div class="lg:col-span-2 grid grid-cols-2 gap-6">
        @foreach ($areas->slice(0, 2) as $row)
            @include('filament.widgets.mcp-area-card', ['row' => $row])
        @endforeach
    </div>

    {{-- BARIS 2 KIRI (DONUT) --}}
    <div class="flex items-center justify-center">
        <div class="text-center">
            <div class="text-6xl font-bold text-green-600">
                {{ $total }}
            </div>
            <div class="text-sm text-gray-500 mt-1">
                Nilai MCP
            </div>
        </div>
    </div>

    {{-- BARIS 2 KANAN --}}
    <div class="lg:col-span-2 grid grid-cols-2 gap-6">
        @foreach ($areas->slice(2, 2) as $row)
            @include('filament.widgets.mcp-area-card', ['row' => $row])
        @endforeach
    </div>

    {{-- BARIS 3 KIRI (KOSONG) --}}
    <div class="hidden lg:block"></div>

    {{-- BARIS 3 KANAN --}}
    <div class="lg:col-span-2 grid grid-cols-2 gap-6">
        @foreach ($areas->slice(4) as $row)
            @include('filament.widgets.mcp-area-card', ['row' => $row])
        @endforeach
    </div>

</div>
