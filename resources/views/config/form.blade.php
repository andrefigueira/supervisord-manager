<form method="{{ $method }}" action="{{ $action }}">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="program-name">Program name</label>
        <input type="text" class="form-control" id="program-name" name="name" placeholder="Enter a program name...">
    </div><!-- End form group -->

    <div class="form-group">
        <label for="program-command">Command</label>
        <input type="text" class="form-control" id="program-command" name="command" placeholder="Enter a program command...">
    </div><!-- End form group -->

    <button class="btn btn-success">{{ $button }}</button>
</form>