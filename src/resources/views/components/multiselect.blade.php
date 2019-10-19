<form id="multiselect-form" 
      method="POST" 
      action="{{ $route }}">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <label for="multiselect">
                {{ $left_label }}
            </label>
            <select name="from[]" 
                    id="multiselect" 
                    class="form-control" 
                    size="8" 
                    multiple="multiple">
                @foreach($leftItems as $itemId => $itemName)
                    <option value="{{ $itemId }}">
                        {{ $itemName }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" 
                    id="multiselect_rightAll" 
                    class="btn btn-sm btn-primary btn-block">
                <i class="fa fa-forward" aria-hidden="true"></i>
            </button>
            <button type="button" 
                    id="multiselect_rightSelected" 
                    class="btn btn-sm btn-primary btn-block">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </button>
            <button type="button" 
                    id="multiselect_leftSelected" 
                    class="btn btn-sm btn-primary btn-block">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </button>
            <button type="button" 
                    id="multiselect_leftAll" 
                    class="btn btn-sm btn-primary btn-block">
                <i class="fa fa-backward" aria-hidden="true"></i>
            </button>
            <button type="submit" 
                    class="btn btn-sm btn-block btn-success">
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
            </button>
        </div>
        <div class="col-md-5">
            <label for="multiselect_to">
                {{ $right_label }}
            </label>
            <select name="to[]" 
                    id="multiselect_to" 
                    class="form-control" 
                    size="8" 
                    multiple="multiple">
                @foreach($rightItems as $itemId => $itemName)
                    <option value="{{ $itemId }}">
                        {{ $itemName }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>