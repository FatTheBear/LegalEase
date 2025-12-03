@foreach($messages as $msg)
    <div class="mb-3 {{ $msg->sender_id == auth()->id() ? 'text-end' : 'text-start' }}">
        <div class="d-inline-block p-3 rounded {{ $msg->sender_id == auth()->id() ? 'btn-primary text-white' : 'bg-white border' }}"
             style="max-width: 75%;">
            {!! nl2br(e($msg->message)) !!}
            <small class="d-block mt-1 opacity-75">
                {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}
            </small>
        </div>
    </div>
@endforeach

@if($messages->count() == 0)
    <p class="text-center text-muted my-5">
        <i class="bi bi-chat-square-text fs-1 d-block mb-3"></i>
        Start your conversation!
    </p>
@endif
