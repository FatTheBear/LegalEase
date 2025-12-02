{{-- Nút chat nổi góc dưới --}}
<div class="position-fixed bottom-0 end-0 m-4" style="z-index: 1020;">
    @if(auth()->id() === 1)
        {{-- Admin: click thẳng vào trang chat --}}
        <a href="{{ route('chat.index') }}" class="btn btn-primary btn-lg rounded-circle shadow-lg p-4">
            <i class="bi bi-chat-dots-fill fs-3"></i>
        </a>
    @else
        {{-- User thường: hiện modal chọn --}}
        <button class="btn btn-primary btn-lg rounded-circle shadow-lg p-4" data-bs-toggle="modal" data-bs-target="#chatModal">
            <i class="bi bi-chat-dots-fill fs-3"></i>
        </button>
    @endif
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
<style>
    /* Tùy chỉnh nút chat nổi */
    .btn-lg.rounded-circle {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* tùy chỉnh khi hover */
    .btn-lg.rounded-circle:hover {
        background-color: #548e6c;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        /* to ra */
        transform: translateY(-2px);
        transition: all 0.2s ease-in-out;
    }
    
    /* icon to ra lòi ra khỏi chính xây dựng */
    .btn-lg.rounded-circle:hover i {
        transform: scale(1.6);
        transition: all 0.4s ease-in-out;
    }
    .btn-outline-primary {
        color: #1d3e2e;
        border-color: #2e6e35;
    }
    /* khi hover Live Chat with Admin */
    .btn-outline-primary:hover {
        background-color: #1d3e2e;
        border-color: #2e6e35;
        color: #ffffff;
    }
    /* khi active Live Chat with Admin */
    .btn-outline-primary:active {
        background-color: #19341f !important;
        border-color: #19341f;
        color: #ffffff;
    }
    /* khi hover Chat with AI xám kiểu bị khóa */
    .btn-light:hover {
        background-color: #e2e2e2;
        color: #6c757d;
    }
</style>
{{-- scrip nổi 1 đoạn chữ "Cần tư vấn trực tiếp bằng tiếng anh" lên khi hover --}}
<script>
    document.querySelector('.btn-lg.rounded-circle').addEventListener('mouseenter', function() {
        const tooltip = document.createElement('div');
        tooltip.id = 'chat-tooltip';
        tooltip.className = 'position-absolute bg-dark text-white rounded px-3 py-1';
        tooltip.style.bottom = '80px';
        tooltip.style.right = '0';
        tooltip.style.whiteSpace = 'nowrap';
        tooltip.style.zIndex = '1030';
        tooltip.innerText = 'Online Consultation & FAQs';
        this.appendChild(tooltip);
    });
    document.querySelector('.btn-lg.rounded-circle').addEventListener('mouseleave', function() {
        const tooltip = document.getElementById('chat-tooltip');
        if (tooltip) {
            this.removeChild(tooltip);
        }
    });
</script>
