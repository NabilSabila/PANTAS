<div class="card-grid">
    @forelse($items as $row)
        <div class="card"><span class="icon-box"><i data-lucide="calendar-days"></i></span> <x-badge :status="$row->status" />
            <h2>{{ $row->wilayah->nama }}</h2>
            <p>{{ implode(', ', $row->hari) }}</p>
            <p>{{ str_replace(':', '.', substr($row->jam_mulai, 0, 5)) }}–{{ str_replace(':', '.', substr($row->jam_selesai, 0, 5)) }}
            </p>
            <p>{{ $row->jenis_sampah }}</p>
            <div class="actions"><a class="outline small" href="{{ route('admin.jadwal.edit', $row->id) }}"><i
                        data-lucide="pencil"></i>Ubah</a>
                <form method="post" action="{{ route('admin.jadwal.destroy', $row->id) }}" data-confirm="Hapus Jadwal?"
                    data-summary="{{ $row->nama ?? ($row->judul ?? ($row->kode ?? $row->wilayah?->nama)) }}">@csrf
                    @method('DELETE')<button class="danger small"><i data-lucide="trash-2"></i>Hapus</button></form>
            </div>
    </div>@empty<div class="card span-2"><x-empty-state title="Belum ada data terdaftar." /></div>
    @endforelse
</div>{{ $items->links() }}
