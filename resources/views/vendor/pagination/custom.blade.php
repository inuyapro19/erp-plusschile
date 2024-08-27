@if ($paginator->hasPages())
<div class="paginating-container pagination-solid">
    <ul class="pagination">
        @if ($paginator->onFirstPage())
        <li class="prev disabled">
            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </a>

            </li>
        @else
            <li class="prev"><a href="{{ $paginator->previousPageUrl() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-chevron-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </a></li>
        @endif
            {{-- Pagination Elements --}}
        @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled">{{$element}}</li>
                @endif
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active"><a href="javascript:void(0);">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="next"><a href="{{ $paginator->nextPageUrl() }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </a></li>
         @else
                <li class="next disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                </li>
         @endif
    </ul>
</div>
@endif
@push('styles')
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{asset('assets/css/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
@endpush
