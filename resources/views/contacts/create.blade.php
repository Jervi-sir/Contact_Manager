 @extends('layouts.main')

 @section('content')
<div class="card">
  <div class="card-header">
    <strong>Add Contact</strong>
  </div>    
  {!! Form::open(['route' => 'contacts.store', 'files' => true]) !!}       
  

  @include("contacts.form")


  {!! Form::close() !!}
</div>





@endsection
