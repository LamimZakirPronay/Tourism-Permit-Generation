<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            @if(isset($siteSettings['site_logo']))
                <img src="{{ $siteSettings['site_logo'] }}" alt="Logo" style="height: 50px;">
            @else
                <strong>{{ $siteSettings['site_name'] ?? 'Default Brand' }}</strong>
            @endif
        </a>

        <span class="navbar-text d-none d-md-block">
            {{ $siteSettings['site_name'] ?? '' }}
        </span>

        <div class="ms-auto">
            @if(isset($siteSettings['emergency_contacts']))
                <small class="text-danger">
                    <i class="fa fa-phone"></i> Emergency: {{ $siteSettings['emergency_contacts'] }}
                </small>
            @endif
        </div>
    </div>
</nav>