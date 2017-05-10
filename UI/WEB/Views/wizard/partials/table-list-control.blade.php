<div class="input-group">
    <input list="tables" name="table_name" class="form-control input-lg" placeholder="{{ isset($placeholder) ? $placeholder : 'Change table...' }}" form="update-table-form">
    <datalist id="tables">
        @foreach($tables as $table)
        <option value="{{ $table }}">
        @endforeach
      </datalist>
    <span class="input-group-btn">
        <button class="btn btn-lg btn-default" type="submit" form="update-table-form">Go!</button>
    </span>
</div>
