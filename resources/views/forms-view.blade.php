<a class="small" href="{{ route('login') }}">Login!</a>
<h4>Forms</h4>
@foreach($forms as $form)
    <p><a class="small" href="{{ url('forms/view') }}/{{$form->id}}">{{$form->form_name}}</a></p>

@endforeach