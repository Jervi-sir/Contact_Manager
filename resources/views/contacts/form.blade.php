<div class="card-body">
  <div class="row">
    <div class="col-md-9">
    	@if(count($errors))
    		<div class="alert alert-danger">
    			<ul>
    				@foreach($errors->all() as $error)
    					<li>{{$error}}</li>
    				@endforeach
    			</ul>
    		</div>
    	@endif
      <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">Name</label>
        <div class="col-md-8">
        	{!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
      </div>

      <div class="form-group row">
        <label for="company" class="col-md-3 col-form-label">Company</label>
        <div class="col-md-8">
        	{!! Form::text('company', null, ['class' => 'form-control']) !!}
        </div>
      </div>

      <div class="form-group row">
        <label for="email" class="col-md-3 col-form-label">Email</label>
        <div class="col-md-8">
        	{!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>
      </div>

      <div class="form-group row">
        <label for="phone" class="col-md-3 col-form-label">Phone</label>
        <div class="col-md-8">
        	{!! Form::text('phone', null, ['class' => 'form-control']) !!}
        </div>
      </div>

      <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">Address</label>
        <div class="col-md-8">
        	{!! Form::textarea('address', null, ['class' => 'form-control', 'rows' =>2]) !!}
        </div>
      </div>
      <div class="form-group row">
        <label for="group" class="col-md-3 col-form-label">Group</label>
        <div class="col-md-5">
        	{!! Form::select('group_id', App\Group::pluck('name','id'), null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-3">
          <a href="#" id="add-group-btn" class="btn btn-outline-secondary btn-block">Add Group</a>
        </div>
      </div>
      <div class="form-group row" id="add-new-group">
        <div class="offset-md-3 col-md-8">
          <div class="input-group mb-3">
            <input id="new_group" type="text" class="form-control" name="name" placeholder="Enter group name" aria-label="Enter group name" aria-describedby="button-addon2">
            <div class="input-group-append">
              <a id="add-new-btn" class="btn btn-outline-secondary" href="#" >
                <i class="fa fa-check"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new img-thumbnail" style="width: 150px; height: 150px;">
           <?php $photo = ! empty($contact->photo) ? $contact->photo : 'default.png' ?>
           @if(! empty($contact->photo))
              {!! Html::image('/uploads/' . $photo, $contact->name, ['width' => 150, 'height' => 150 ]) !!}
           @endif
        </div>
        <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 150px; max-height: 150px;"></div>
        <div class="mt-2">
          <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>

          {!! Form::file('photo') !!}

          <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-offset-3 col-md-6">
          <button type="submit" class="btn btn-primary">{{ !empty($contact->id) ? "Update" : "Save"}}</button>
          <a href="#" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</div>



@section('extra-script')
<script>
    //add group input  
    $("#add-new-group").hide();
    $('#add-group-btn').click(function () {      
      $("#add-new-group").slideToggle(function() {
        $('#new_group').focus();
      });
      return false;
    });

    $("#add-new-btn").click(function() {
      var newGroup = $("#new_group");

      $.ajax({
        url: "/groups/store",
        method: 'POST',
        data: {
          name: $("#new_group").val(),
          _token: $("input[name=_token]").val(),
        },

        success: function(group) {
          if(group.id != null) {
            inputGroup.removerClass('has-error');
            inputGroup.next('.text-danger').remove();

            var newOption = $('<option></option>').attr('value', group.id)
                                                    .attr('selected', true)
                                                    .text(group.name);

            $("select[name=group_id]")
                    .append( newOption );  
            mewGroup.val("");

          }
        },
        error: function(xhr, status, error) {
            var errorMessage = xhr.responseJSON;
            var inputGroup = newGroup.closest('.input-group');
            inputGroup.next('.text-danger').remove();
            inputGroup.addClass('has-error').after('<p class="text-danger">' + error + '</p>');
        },
      });
    });

</script>

@endsection