@if($term = request('term'))
    <div class="alert alert-info">
        <p>Search Result For :<strong>{{$term}}</strong></p>
    </div>
    @endif