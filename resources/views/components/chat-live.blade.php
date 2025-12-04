{{-- Nút chat nổi góc dưới + Badge tin nhắn chưa đọc --}}
<div class="position-fixed bottom-0 end-0 m-4" style="z-index: 1020;">
    <div class="position-relative d-inline-block">
        @if(auth()->id() === 1)
            {{-- Admin: click thẳng vào trang chat --}}
            <a href="{{ route('chat.index') }}" 
               id="chat-float-btn" 
               class="btn btn-primary btn-lg rounded-circle shadow-lg p-4 position-relative">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                {{-- Badge cho Admin --}}
                <span id="unread-badge" 
                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                      style="font-size: 0.75rem; display: none;">
                    0
                    <span class="visually-hidden">unread messages</span>
                </span>
            </a>
        @else
            {{-- User thường: hiện modal chọn --}}
            <button id="chat-float-btn"
                    class="btn btn-primary btn-lg rounded-circle shadow-lg p-4 position-relative"
                    data-bs-toggle="modal" 
                    data-bs-target="#chatModal">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                {{-- Badge cho User --}}
                <span id="unread-badge" 
                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                      style="font-size: 0.75rem; display: none;">
                    0
                    <span class="visually-hidden">unread messages</span>
                </span>
            </button>
        @endif
    </div>
</div>

{{-- Modal chỉ hiện cho user thường --}}
@if(auth()->id() !== 1)
<div class="modal fade" id="chatModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header btn-primary text-white">
                <h5 class="modal-title">Customer Support</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-5">
                <div class="row g-4">
                    <div class="col-6">
                        <a href="{{ route('chat.index') }}" class="btn btn-outline-primary w-100 py-5 rounded-3 border-2">
                            <i class="bi bi-headset fs-1 d-block mb-3"></i>
                            <strong>Live Chat with Admin</strong>
                            <br><small class="text-success">Online now</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-light w-100 py-5 rounded-3 border" 
                                onclick="Swal.fire({icon:'info', title:'Coming Soon', text:'AI Chat is under development'})">
                            <i class="bi bi-robot fs-1 d-block mb-3"></i>
                            <strong>Chat with AI</strong>
                            <br><small class="text-muted">Coming soon</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- CSS giữ nguyên của bạn + thêm hiệu ứng badge đẹp --}}
<style>
    /* Tùy chỉnh nút chat nổi */
    .btn-lg.rounded-circle {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* Hover effect */
    .btn-lg.rounded-circle:hover {
        background-color: #548e6c;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
        transition: all 0.2s ease-in-out;
    }
    .btn-lg.rounded-circle:hover i {
        transform: scale(1.6);
        transition: all 0.4s ease-in-out;
    }

    /* Badge nhảy nhẹ khi có tin mới */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }
    #unread-badge {
        animation: pulse 2s infinite;
    }

    /* Các style cũ của bạn */
    .btn-outline-primary {
        color: #1d3e2e;
        border-color: #2e6e35;
    }
    .btn-outline-primary:hover {
        background-color: #1d3e2e;
        border-color: #2e6e35;
        color: #ffffff;
    }
    .btn-outline-primary:active {
        background-color: #19341f !important;
        border-color: #19341f;
        color: #ffffff;
    }
    .btn-light:hover {
        background-color: #e2e2e2;
        color: #6c757d;
    }
</style>

{{-- Tooltip khi hover + Realtime Badge --}}
<script>
    // Tooltip khi hover
    const chatBtn = document.querySelector('.btn-lg.rounded-circle');
    chatBtn.addEventListener('mouseenter', function() {
        if (document.getElementById('chat-tooltip')) return;
        const tooltip = document.createElement('div');
        tooltip.id = 'chat-tooltip';
        tooltip.className = 'position-absolute bg-dark text-white rounded px-3 py-1 small';
        tooltip.style.bottom = '80px';
        tooltip.style.right = '0';
        tooltip.style.whiteSpace = 'nowrap';
        tooltip.style.zIndex = '1030';
        tooltip.innerText = 'Online Consultation & FAQs';
        this.appendChild(tooltip);
    });
    chatBtn.addEventListener('mouseleave', function() {
        const tooltip = document.getElementById('chat-tooltip');
        if (tooltip) tooltip.remove();
    });

    // Cập nhật badge realtime
    function updateUnreadBadge() {
        fetch('/chat/unread-count', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('unread-badge');
            if (data.count > 0) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(() => {});
    }

    // Load ngay khi vào trang
    updateUnreadBadge();
    // Cập nhật mỗi 5 giây
    setInterval(updateUnreadBadge, 5000);

    // Cập nhật lại khi mở modal (user)
    const modalElement = document.getElementById('chatModal');
    if (modalElement) {
        modalElement.addEventListener('shown.bs.modal', updateUnreadBadge);
    }
</script>