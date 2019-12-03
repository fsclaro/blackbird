@if (count($breadcrumbs))

    <ol class="breadcrumb float-sm-right">
        @foreach ($breadcrumbs as $breadcrumb)

            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item">
                    @if (config('breadcrumbs.show_icon'))
                    <i class="{{ config('breadcrumbs.icon') }} {{ config('breadcrumbs.icon_color') }}"></i>
                    @endif
                    <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                </li>
            @else
                <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ol>

@endif
