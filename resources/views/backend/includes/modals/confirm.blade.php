@php($action = isset($action) ? $action.'_' : '')
@php($form = $form ?? false)
<div class="modal fade border-0" id="confirm_{{$action}}{{ $model }}_{{ ${$model}->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center mt-2">{{ $message ?? 'Are you sure you want to perform this action ?' }}</p>
                <div class="float-right">
                    @if($form)
                        <form class="d-inline" action="{{ $route }}" method="post">
                            @csrf
                            @method('Delete')
                            <button type="submit" class="btn btn-sm btn-danger">Yes</button>
                        </form>
                    @else
                        <a href="{{ $route ?? '' }}" class="btn btn-sm btn-danger">Yes</a>
                    @endif
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
