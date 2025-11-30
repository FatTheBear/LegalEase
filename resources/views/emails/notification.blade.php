@component('mail::message')
# You have a new notification from LegalEase

**{{ $notification->title }}**

{{ $notification->message }}

@component('mail::button', ['url' => route('notifications.index')])
View all notifications
@endcomponent

Thank you for using our service,<br>
{{ config('app.name') }}
@endcomponent