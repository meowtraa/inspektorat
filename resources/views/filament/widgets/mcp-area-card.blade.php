<div class="flex items-center justify-between p-4 rounded-xl bg-gray-50">
    <div>
        <div class="font-semibold">
            {{ $row->area->name }}
        </div>
        <div class="text-xs text-gray-500">
            Bobot {{ $row->bobot }}%
        </div>
    </div>

    <div
        class="text-2xl font-bold
        {{ $row->persentase >= 80 ? 'text-green-600' : ($row->persentase >= 60 ? 'text-yellow-500' : 'text-red-600') }}">
        {{ number_format($row->persentase, 1) }}
    </div>
</div>
