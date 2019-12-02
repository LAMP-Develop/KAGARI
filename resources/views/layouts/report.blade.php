@section('content')
<section>
<div class="container">
<div class="card">
<div class="card-body">
<div class="row mx-0">
<div class="col">
<h2 class="font-weight-bold h5 text-dark">{{ $add_site->site_name}}</h2>
<p class="m-0">{{ $add_site->url}}</p>
</div>
</div>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="#">Active</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="#">Active</a>
  </li>
</ul>

</div>
</div>
</div>
</section>
@endsection