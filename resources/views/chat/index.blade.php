<!-- resources/views/chat/index.blade.php -->
@extends('layouts.app')
@section('title', 'Live Chat')

@section('content')
<div class="container py-4">
    @if(auth()->id() === 1)
        <!-- ADMIN VIEW -->
        <div class="row g-4">
            <div class="col-lg-4">
                <h4>Conversations</h4>
                <div class="list-group">
                    @forelse($conversations as $user)
                        <a href="#" class="list-group-item list-group-item-action chat-user" data-id="{{ $user->id }}">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $user->name }}</strong>
                                @if($user->unread_messages_count > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $user->unread_messages_count }}</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="p-3 text-muted">No messages yet</div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-8">
                <div id="chat-area" class="border rounded bg-light p-4" style="height: 70vh; overflow-y: auto;">
                    <p class="text-center text-muted">Select a user to view conversation</p>
                </div>

                <!-- ⭐ ADDED: QUICK REPLIES FOR ADMIN -->
                <div id="quick-admin" class="p-3 border rounded bg-white mt-3">
                    <h6 class="text-muted mb-2">Quick Replies</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary quick-btn" data-text="Hello! How can I assist you today?">
                            Greeting
                        </button>
                        <button class="btn btn-outline-primary quick-btn" data-text="Could you please provide more details?">
                            Need details
                        </button>
                        <button class="btn btn-outline-primary quick-btn" data-text="I am checking this issue for you.">
                            Checking issue
                        </button>
                        <button class="btn btn-outline-primary quick-btn" data-text="Thank you for your patience.">
                            Thanks
                        </button>
                        <button class="btn btn-outline-primary quick-btn" data-text="Let me guide you through the steps.">
                            Steps guide
                        </button>
                        <button class="btn btn-outline-primary quick-btn" data-text="Your request has been completed. Let me know if you need more help.">
                            Completed
                        </button>
                    </div>
                </div>
                <!-- END ADDED -->

                <form id="chat-form" class="mt-3" style="display:none;">
                    <input type="hidden" id="selected-user">
                    <div class="input-group">
                        <input type="text" id="message-input" class="form-control" placeholder="Type a message...">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>

    @else
        <!-- USER VIEW -->
        <div>
            <div class="card-header btn-primary text-white d-flex justify-content-between"
                style ="border-top-left-radius: .375rem; border-top-right-radius: .375rem; padding: 1rem;">
                <h5>Live Support Chat</h5>
                <span>Online</span>
            </div>

            <div id="chat-messages" class="card-body" style="height: 70vh; overflow-y: auto; background:#f8f9fa; padding: 1rem"></div>

            <!-- ⭐ ADDED: QUICK QUESTIONS FOR USER -->
            <div id="quick-user" class="p-3 border-top bg-white">
                <h6 class="text-muted mb-2">Quick Questions</h6>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-secondary quick-btn" data-text="Hello, I need assistance.">
                        Need assistance
                    </button>
                    <button class="btn btn-outline-secondary quick-btn" data-text="How long is the response time?">
                        Response time?
                    </button>
                    <button class="btn btn-outline-secondary quick-btn" data-text="Is this online consultation free?">
                        Is it free?
                    </button>
                    <button class="btn btn-outline-secondary quick-btn" data-text="I would like to schedule a consultation.">
                        Schedule consultation
                    </button>
                </div>
            </div>
            <!-- END ADDED -->

            <div class="card-footer bg-light">
                <form id="chat-form">
                    <div class="input-group">
                        <input type="text" id="message-input" class="form-control" placeholder="Type your message here...">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // === ORIGINAL JS (GIỮ NGUYÊN 100%) ===
    @if(auth()->id() === 1)
        document.querySelectorAll('.chat-user').forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                
                const userId = this.dataset.id;
                document.getElementById('selected-user').value = userId;
                document.getElementById('chat-form').style.display = 'block';

                document.querySelectorAll('.chat-user').forEach(item => item.classList.remove('active'));
                this.classList.add('active');

                loadConversation(userId);
            });
        });

        function loadConversation(userId) {
            fetch(`/chat/conversation/${userId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('chat-area').innerHTML = data.html;
                    document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
                })
                .catch(err => {
                    console.error('Load conversation error:', err);
                    document.getElementById('chat-area').innerHTML = '<p class="text-danger text-center">Error loading messages</p>';
                });
        }
    @endif

    @if(auth()->id() !== 1)
        function loadMessages() {
            fetch('/chat/messages')
                .then(r => r.text())
                .then(html => {
                    document.getElementById('chat-messages').innerHTML = html;
                    document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
                })
                .catch(err => console.error(err));
        }
        setInterval(loadMessages, 3000);
        loadMessages();
    @endif

    document.getElementById('chat-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        if (!message) return;

        let receiverId = 1;
        @if(auth()->id() === 1)
            receiverId = document.getElementById('selected-user').value || 1;
        @endif

        await fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message: message,
                user_id: receiverId
            })
        });

        input.value = '';

        @if(auth()->id() === 1)
            if (receiverId) loadConversation(receiverId);
        @else
            loadMessages();
        @endif
    });

    // ===== ⭐ ADDED: HIDE QUICK BUTTONS WHEN USER TYPE =====
    const msgInput = document.getElementById('message-input');
    msgInput?.addEventListener('input', () => {
        document.getElementById('quick-user')?.classList.add('d-none');
        document.getElementById('quick-admin')?.classList.add('d-none');
    });

    // ===== ⭐ ADDED: CLICK QUICK BUTTON → AUTO SEND =====
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('quick-btn')){
            const text = e.target.dataset.text;
            const input = document.getElementById('message-input');
            input.value = text;

            // ẩn quick
            document.getElementById('quick-user')?.classList.add('d-none');
            document.getElementById('quick-admin')?.classList.add('d-none');

            document.getElementById('chat-form').dispatchEvent(new Event('submit'));
        }
    });
</script>

<style>
    .chat-user.active {
        background-color: #1d3e2e !important;
        border-left: 4px solid #2e6e35;
    }
    .chat-user:hover {
        background-color: #f5f5f5;
    }
</style>
@endsection
