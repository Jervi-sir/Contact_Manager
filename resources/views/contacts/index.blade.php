 @extends('layouts.main')

 @section('content')
 <div class="card">
  <div class="card-header"><strong>All Contacts</strong></div>
  <table class="table">
    @foreach($contacts as $contact)
    <tr>
      <td class="middle">
        <div class="media">
          <div class="media-left">
            <a href="#">
              <?php $photo = ! is_null($contact->photo) ? $contact->photo : 'default.png' ?>
              {!! Html::image('/uploads/' . $photo, $contact->name, ['class' =>'media-object', 'width' => 100, 'height' => 100 ]) !!}
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading">{{ $contact->name }}</h4>
            <address>
              <strong>{{ $contact->company }}</strong><br>
              {{ $contact->email }}
            </address>
          </div>
        </div>
      </td>
      <td width="100" class="middle">
        <div>

          {!! Form::open(['method' => 'DELETE', 'route' => ['contacts.destroy', $contact->id]]) !!}
          <a href="{{ route('contacts.edit', ['contact' => $contact->id]) }}" class="btn btn-outline-secondary btn-circle btn-xs" title="Edit">
            <i class="fa fa-edit"></i>
          </a>
          <button onclick="return confim('Are you sure about that?');" type="submit" class="btn btn-outline-danger btn-circle btn-xs" title="Delete">
            <i class="fa fa-times"></i>
          </button>
          {!! Form::close() !!}
        </div>
      </td>
    </tr>
    @endforeach

  </table>    
  <div class="card-footer">
      <nav aria-label="Page Navigation">
            {!! $contacts->appends( Request::query())->render() !!}
        </nav>
  </div>
</div>

@endsection