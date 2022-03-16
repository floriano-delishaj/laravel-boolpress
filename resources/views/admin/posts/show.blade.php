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
                    <div class="card-footer d-flex justify-content-between">
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p>Creato il <i>{{$post->created_at}}</i></p>
                                <p>Modificato il <i>{{$post->updated_at}}</i></p>
                            </li>
                            @if ($post->category !== null)
                            <li class="list-group-item">
                                Categoria: <b>{{$post->category->name}}</b>
                            </li>
                                @endif
                            @if ($post->tags !== null)
                            <li class="list-group-item">
                                Tags:
                                @foreach($post->tags as $tag)
                                    <span class="fw-bold">{{$tag->name}}, </span>
                                @endforeach
                            </li>
                            @endif
                        </ul>
                    </div>
                        <div class="d-flex">
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
    </div>
@endsection
