<!-- Search Bar -->
<form action="{{ route('search')}}" method="GET" class="form-inline my-2 my-lg-0">
    {{-- <i class="fa fa-search search-icon"></i> --}}
    <input class="form-control mr-sm-2" type="text" name="query" id="query" value="{{ request()->input('query')}}" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>