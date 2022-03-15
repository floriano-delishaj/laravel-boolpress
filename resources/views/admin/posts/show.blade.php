@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        Dettagli post {{$post->title}}
                    </div>

                    <div class="card-body">

                     {{ $post->content }}

                    </div>
                    <div class="d-flex class="ms-auto"">
                        <a class="btn btn-link" href="{{route('admin.posts.edit', $post->slug)}}">Edit</a>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-link" type="submit">Delete</button>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
