{{-- Each row: name, quota, ratio. Ratio is the readable value; fill colour on the map only restates it. --}}
@php
$rows = [
    ['id' => 'cilacap',      'nama' => 'Kab. Cilacap',      'kuota' => '12.000', 'rasio' => '0,43'],
    ['id' => 'banyumas',     'nama' => 'Kab. Banyumas',     'kuota' => '30.000', 'rasio' => '1,00'],
    ['id' => 'purbalingga',  'nama' => 'Kab. Purbalingga',  'kuota' => '45.000', 'rasio' => '2,22'],
    ['id' => 'banjarnegara', 'nama' => 'Kab. Banjarnegara', 'kuota' => '20.500', 'rasio' => '1,01'],
    ['id' => 'kebumen',      'nama' => 'Kab. Kebumen',      'kuota' => '29.000', 'rasio' => '0,99'],
];
@endphp
@foreach ($rows as $row)
    <li>
        <button type="button"
                @mouseenter="hovered = '{{ $row['id'] }}'" @mouseleave="hovered = null"
                @focus="hovered = '{{ $row['id'] }}'" @blur="hovered = null"
                :class="hovered === '{{ $row['id'] }}' ? 'bg-white' : ''"
                class="w-full grid grid-cols-[1fr_auto_auto] items-center gap-3 min-h-11 py-1.5 px-1 text-left rounded hover:bg-white focus-ring">
            <span class="text-[13px] truncate">{{ $row['nama'] }}</span>
            <span class="font-mono text-[11px] tabular-nums text-slate-600 text-right">{{ $row['kuota'] }}</span>
            <span class="font-mono text-[11px] tabular-nums font-semibold text-right">{{ $row['rasio'] }}x</span>
        </button>
    </li>
@endforeach
