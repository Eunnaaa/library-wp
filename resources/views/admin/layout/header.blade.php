<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('title')</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                @for ($i = 1; $i <= count(Request::segments()); $i++)
                    @php
                        $segment = Request::segment($i);
                        $formattedSegment = ucwords(str_replace('-', ' ', $segment));
                    @endphp
                    @if ($i == count(Request::segments()))
                        <li class="breadcrumb-item active">{{ $formattedSegment }}</li>
                    @else
                        <li class="breadcrumb-item">{{ $formattedSegment }}</li>
                    @endif
                @endfor
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
<hr>
