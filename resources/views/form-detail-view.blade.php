
@if(isset($formData))
    <h3>{{$formData['form_name']}}</h3>
    @if(isset($formData['form_controls']))
        @foreach($formData['form_controls'] as $form_control)
            <label>{{ $form_control['label'] }}</label></br>
            @if($form_control['type'] == 1)
                <input type="text" name="{{$form_control['label']}}">
            @elseif($form_control['type'] == 2)
                <input type="number" name="{{$form_control['label']}}">
            @else
                <select name="{{$form_control['label']}}">
                    @if(isset($form_control['options']))
                        @foreach($form_control['options'] as $option)
                            <option>{{$option->option}}</option>
                        @endforeach
                    @endif
                    
            @endif
            </br>
        @endforeach
    
    @endif
    <button>Save</button>
@endif