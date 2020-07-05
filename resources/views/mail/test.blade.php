<h1>{{ Tenant::isMultitenancyEnabled() ? Tenant::current()->name : 'No tenant' }}</h1>
<a href="{{ route('home') }}">Go To Home</a>
<br>
<a href="{{ route('landlord.tenants.create') }}">Create Tenant</a>
<br>
<a href="{{ url('/hello/world') }}">Hello World</a>
