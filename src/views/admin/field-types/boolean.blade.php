<div class="control-group row-fluid">
    <div class="span3">
        <label class="control-label" for="{{$field->column_name}}">
            {{$field->name}}
            @if($field->tooltip_text)<a href="javascript:;" class="bootstrap-tooltip" data-placement="top" data-original-title="{{$field->tooltip_text}}"><i class="icon-photon info-circle"></i></a>@endif
        </label>
    </div>
    <div class="span9 span-inset">
        <div class="controls">
            <div data-on-label="ON" data-off-label="OFF" class="switch switch-small">
                <input id="{{$field->column_name}}" name="{{$field->column_name}}" value="1" type="checkbox" @if(isset($entry[$field->column_name]) AND $entry[$field->column_name]==1)checked="checked@endif">
            </div>
        </div>
    </div>
</div>
