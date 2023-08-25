 @extends('layouts.main')

 @section('content')
<div class="card">
  <div class="card-header">
    <strong>Add Contact</strong>
  </div>    
  {!! Form::model(
  	$contact, ['files' => true, 'route' => ['contacts.update', $contact->id], 'method' => 'PATCH']
  	) !!}       

  @include("contacts.form")

  {!! Form::close() !!}
</div>

@endsection
