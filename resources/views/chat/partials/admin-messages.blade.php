@foreach($messages as $msg)
    <div class="mb-3  {{ $msg->sender_id == auth()->id() ? 'text-end' : 'text-start' }}">
        <div class="d-inline-block p-3  rounded {{ $msg->sender_id == auth()->id() ? 'btn-primary text-white' : 'bg-light border' }}"
             style="max-width: 80%;">
            @if($msg->sender_id != auth()->id())
                <small class="d-block fw-bold mb-1" style ="color: #19341f;">{{ $msg->sender->name }}</small>
            @endif
            {!! nl2br(e($msg->message)) !!}
            <small class="d-block mt-1 opacity-75 ">
                {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}
            </small>
        </div>
    </div>
@endforeach

@if($messages->count() == 0)
    <p class="text-center text-muted">No messages yet</p>
@endif
<style>
    
</style>