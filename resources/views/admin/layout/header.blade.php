<div class="container-fluid mb-3">
    <div class="row align-items-center">
        <div class="col-sm-6 mb-2 mb-sm-0">
            <h4 class="m-0 font-weight-bold text-dark d-flex align-items-center" style="letter-spacing: -0.02em;">
                <span>@yield('title')</span>
            </h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0 align-items-center small">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-primary font-weight-bold">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                @for ($i = 2; $i <= count(Request::segments()); $i++)
                    @php
                        $segment = Request::segment($i);
                        $formattedSegment = ucwords(str_replace(['-', '_'], ' ', $segment));
                    @endphp
                    @if ($i == count(Request::segments()))
                        <li class="breadcrumb-item active text-muted font-weight-semibold">{{ $formattedSegment }}</li>
                    @else
                        <li class="breadcrumb-item text-secondary">{{ $formattedSegment }}</li>
                    @endif
                @endfor
            </ol>
        </div>
    </div>
</div>
