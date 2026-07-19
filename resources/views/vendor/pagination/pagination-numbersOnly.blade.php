@if ($paginator->hasPages())
    <div class="flex justify-center gap-2 mt-6">
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 rounded bg-blue-600 text-white">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
@endif
