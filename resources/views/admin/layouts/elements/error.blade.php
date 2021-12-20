<div class="alert alert-danger">
	<strong>Errors :</strong>
	<button type="button" class="close" data-dismiss="alert">×</button>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>