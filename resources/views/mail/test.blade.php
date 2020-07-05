<h1>{{ Tenant::isMultitenancyEnabled() ? Tenant::current()->name : 'No tenant' }}</h1>
<ul>
    <li><a href="{{ route('home') }}">Home</a></li>
    <li><a href="{{ route('landlord.tenants.index') }}">Tenants</a></li>
    <li><a href="{{ url('/hello/world') }}">Hello World (404)</a></li>
</ul>
