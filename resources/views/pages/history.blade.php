@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="date/date.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="date/date.js"></script>
<script>
    var siteUrl = '{{URL::to('/')}}';
    var search = '';
    $(document).ready(function()
    {
        $('#search').keyup(function () {
            search = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (search.length>0)
            {
                $.ajax({
                    type: "GET",
                    url: siteUrl + "/searchResult",
                    data:{
                        search: search,
                    },
                    success: function (data)
                    {
                        $('#allDataSearch').html(data)
                    },error: function (xhr, status, error) {
                        console.log(error);
                    }
                })
            }
        });
        $('#searchFilter').click(function () {
            var from_date = $('#from_date').val();
            if(from_date !== '' )
            {
                $.ajax({
                    type: "GET",
                    url: siteUrl + "/searchResult",
                    data:{from_date:from_date},
                    success: function (data)
                    {
                        //console.log(data);
                        $('#searchResult').html(data)
                    },error: function (xhr, status, error) {
                        console.log(error);
                    }
                })
            }
            else
            {
                alert('Both Date is required');
            }
        });
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href').split('page=')[1];
            $.ajax({
                url: siteUrl + "/searchResult?search="+search+"&page="+url,
                success: function (data) {
                    //console.log(search);
                    $('#allDataSearch').html(data)
                }
            });
        });
        $('#selectAll').change(function()
        {
            search = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: siteUrl + "/searchResult",
                    data: {
                        dataFilter: search,
                    },
                    success: function (data)
                    {
                        $('#allDataSearch').html(data);
                        // alert(data.fa);
                    }
                });
        });
    });
</script>
@section('content')
    <div class="container-fluid app-body settings-page">
        <div class="row" style="margin-bottom: 1%">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="search"></label>
                                <input type="text" id="search" class="form-control" placeholder="Search">
                            </div>
                            <div class="col-md-3">
                                <label for="search"></label>
                                <div class="input-group input-daterange">
                                    <input placeholder="date" type="text" name="from_date" id="from_date" readonly class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="selectAll">
                                    <option value="all">All</option>
                                    <option value="upload">Upload</option>
                                    <option value="curation">curation</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="row">
            <div class="col-md-12">
                <div id="newData"></div>
                <table class="table table-hover social-accounts" id="allDataSearch">
                    <thead>
                    <tr>
                        <th>Group Name</th>
                        <th>Group Type</th>
                        <th>Account Name</th>
                        <th>Post Text</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{$post->groupInfo->name}}</td>
                            <td>{{$post->groupInfo->type}}</td>
                            <td>{{$post->groupInfo->user->name}}</td>
                            <td>{{$post->post_text}}</td>
                            <td>{{$post->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
