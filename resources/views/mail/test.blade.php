<h1>{{ Tenant::isMultitenancyEnabled() ? Tenant::current()->name : 'No tenant' }}</h1>
<a href="{{ route('welcome') }}">Go To Welcome</a>
<br>
<a href="{{ route('tenants.create') }}">Create Tenant</a>
<br>
<a href="{{ url('/hello/world') }}">Hello World</a>
