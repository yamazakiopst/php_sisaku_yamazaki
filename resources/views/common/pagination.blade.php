<div class="d-flex justify-content-center align-items-center">
    @if ($paginator->hasPages())
    <!-- 開始ページ -->
    <a class="page-link" href="{{$paginator->url(1)}}">&laquo;</a>
    <!-- 前ページ -->
    @if($paginator->currentPage() === 1 )
    <a class="page-link" href="{{$paginator->url(1)}}">&lsaquo;</a>
    @else
    <a class="page-link" href="{{$paginator->previousPageUrl()}}">&lsaquo;</a>
    @endif

    <!-- 現ページ/総ページ -->
    {{$paginator->currentPage()}}&nbsp;/&nbsp;{{$paginator->lastPage()}}&nbsp;


    <!-- 次ページ -->
    @if($paginator->currentPage() === $paginator->lastPage())
    <a class="page-link" href="{{$paginator->url($paginator->lastPage())}}">&rsaquo;</a>
    @else
    <a class="page-link" href="{{$paginator->nextPageUrl()}}">&rsaquo;</a>
    @endif
    <!-- 最終ページ -->
    <a class="page-link" href="{{$paginator->url($paginator->lastPage())}}">&raquo;</a>
    @endif
</div>