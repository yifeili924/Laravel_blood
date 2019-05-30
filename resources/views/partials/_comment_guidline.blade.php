@foreach($comments as $comment)
    <div class="comment_part">
        <div style="margin-top: 10px;margin-bottom: 10px">
            <lavel><strong>{{ $comment->user->last_name }}</strong></lavel>&nbsp;|&nbsp;
            <lavel>{{date('d/m/Y', strtotime($comment->created_at))}}</lavel>&nbsp;|&nbsp;
            <a title="Reply" onclick="addReply({{ $comment->id }})" style="cursor: pointer;">Reply </a>
        </div>

        <div style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 20px;"><?php echo($comment->body) ?></div>
        <div id="reply_{{ $comment->id }}" style="display: none;margin-left: 10px;">
            {!! Form::open(["url" => route("reply_guidline")] ) !!}

            <div class="form-group">
                <textarea  name="comment_body" class="form-control" style="height: 100px"></textarea>
                <input type="hidden" name="guidline_id" value="{{ $figure_id }}"/>
                <input type="hidden" name="comment_id" value="{{ $comment->id }}"/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Reply"/>
            </div>
            {!! Form::close() !!}
        </div>

        @include('partials._comment_guidline', ['comments' => $comment->replies])
    </div>

@endforeach