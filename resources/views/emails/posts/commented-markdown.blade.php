@component('mail::message')
# Comment was posted on your blog post

Hi {{ $comment->commentable->user->name }}

Someone posted a comment on your blog post 
    
@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id])])
    View the blog post
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id])])
    Visit {{ $comment->user->name }}'s profile
@endcomponent

@component('mail::panel')
    {{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
