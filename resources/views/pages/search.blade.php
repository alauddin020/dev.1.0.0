<table class="table table-striped table-inverse table-bordered">
    @if(count($posts))
        <thead class="thead-inverse">
        <tr>
            <th>Group Name</th>
            <th>Group Type</th>
            <th>Account Name</th>
            <th>Post Text</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody >
        @foreach($posts as $post)
            <tr>
                <td>{{$post->groupInfo->name}}</td>
                <td>{{$post->groupInfo->type}}</td>
                <td>{{$post->groupInfo->user->name}}</td>
                <td>{{$post->post_text}}</td>
                <td>{{$post->created_at}}</td>
            </tr>
        @endforeach
        </tbody>
    @else
        <tr><td colspan="3">No Data Found</td></tr>
    @endif
</table>
<div class="paginate">
    {{$posts->links() }}
</div>