<div class="mt-2 mb-2">
    @auth
        <form method="POST" action="{{ $route }}">
            @csrf
            <div class="form-group">
                <textarea type="text" id="content" name="content" class="form-control"></textarea>
            </div>
            <button class="btn btn-primary btn-block">Add comment</button>
        </form>
        @errors @enderrors
    @else
        <a href="{{ route('login') }}">Sign in</a> to post commemts!
    @endauth
</div>
<hr>

