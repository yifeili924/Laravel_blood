@foreach($comments as $comment)

    <div class="comment_part">
        <div style="margin-top: 10px;margin-bottom: 10px">
            <lavel><strong>{{ $comment->user->last_name }}</strong></lavel>&nbsp;|&nbsp;
            <lavel>{{date('d/m/Y', strtotime($comment->created_at))}}</lavel>
        </div>

        <div style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 20px;"><?= $comment->body?></div>



        @include('partials._comment', ['comments' => $comment->replies])
    </div>

@endforeach