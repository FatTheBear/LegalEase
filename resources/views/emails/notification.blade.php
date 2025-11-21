@component('mail::message')
# Bạn có thông báo mới từ LegalEase

**{{ $notification->title }}**

{{ $notification->message }}

@component('mail::button', ['url' => route('notifications.index')])
Xem tất cả thông báo
@endcomponent

Cảm ơn bạn đã sử dụng dịch vụ,<br>
{{ config('app.name') }}
@endcomponent