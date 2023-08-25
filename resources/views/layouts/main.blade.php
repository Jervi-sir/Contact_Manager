<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>My Contact</title>

    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container">
        <a class="navbar-brand text-uppercase" href="index.html">            
            My contact
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
            
        <!-- /.navbar-header -->
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="{{ route('contacts.create')}}" class="btn btn-outline-primary">Add Contact</a></li>
          </ul>
        </div>
        <form action="{{ route('contacts.index')}}" class="navbar-form navbar-right" role="search">
            <div class="input-group">
              <input type="text" name="term" value="{{ Request::get('term') }}" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
      </div>
    </nav>

    <!-- content -->
    <main class="pt-5">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
	            <div class="list-group">
                <?php $selected_group = Request::get('group_id') ?>
                <a href="{{ route('contacts.index')}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ empty($selected_group) ? 'active' : ''}}">All Contacts<span class="badge badge-warning badge-pill">{{ App\Contact::count()}} </span></a>
                

                @foreach(App\Group::all() as $group)
                <a href="{{ route('contacts.index', ['group_id' => $group->id])}} " 
                  class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $selected_group == $group->id ? 'active' : ''}}">{{ $group->name}} <span class="badge badge-pill badge-warning">{{ $group->contacts->count() }}</span></a>
                @endforeach
	            
	            </div>
          </div><!-- /.col-md-3 -->
  
          <div class="col-md-9">
              @if(session('message'))
              <div class="alert alert-success">
                  {{session('message')}}
              </div>
              @endif
              
           		@yield('content')
          </div>
        </div>
      </div>
    </main>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jasny-bootstrap.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
      //autocomplete
      $(function() {
        $("input[name=term]").autocomplete({
          source: "{{ route("contacts.autocomplete") }}",
          minlenght: 3,
          select: function(event, ui) {
            $(this).val(ui.item.value);
          }
        });
      });

    
</script>

@yield('extra-script')


  </body>
</html>