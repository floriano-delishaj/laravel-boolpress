@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        <a class="mx-2" href="{{route('admin.posts.index')}}"><b> < </b></a> Dettagli post {{$post->title}}
                    </div>

                    <div class="card-body">
                        {{ $post->content }}
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p>Creato il <i>{{$post->created_at->format('d/m/Y H:i')}}</i></p>
                                @if($post->updated_at->diffInHours(date(0)) <= 12)
                                    <p>Modificato <i>{{$post->updated_at->diffForHumans(date(0)) }}</i></p>
                                    @else <p>Modificato <i>{{$post->updated_at->format('d/m/Y H:i')}}</i></p>
                                @endif
                            </li>
                            @if($post->path_img)
                            <li class="list-group-item">
                                <img class="img-fluid" src="{{asset("storage/" . $post->path_img)}}" alt="">
                            </li>
                            @endif
                            @if ($post->category !== null)
                            <li class="list-group-item">
                                Categoria: <span class="badge bg-danger text-white mx-1 mb-3">{{$post->category->name}}</span>
                            </li>
                            @endif
                            <li class="list-group-item">
                                Tags:
                            @forelse ($post->tags as $tag)

                                 <span class="badge bg-success text-white mx-1 mb-3">{{$tag->name}}</span>

                            @empty
                                <span></span>
                            @endforelse
                            </li>
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
