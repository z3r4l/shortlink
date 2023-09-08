@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Tombol "Sebelumnya" --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Sebelumnya</a></li>
        @endif

        {{-- Tautan halaman --}}
        @foreach ($elements as $element)
            {{-- "..." separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Halaman aktif --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Tombol "Berikutnya" --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">Berikutnya</span></li>
        @endif
    </ul>
@endif
