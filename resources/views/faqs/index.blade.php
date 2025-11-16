@extends('layouts.app')
@section('title', 'Câu hỏi thường gặp')

@section('content')
<h2>FAQ - Câu hỏi thường gặp</h2>
<div class="accordion" id="faqAccordion">
    @foreach($faqs as $faq)
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}">
                {{ $faq->question }}
            </button>
        </h2>
        <div id="faq{{ $faq->id }}" class="accordion-collapse collapse">
            <div class="accordion-body">{{ $faq->answer }}</div>
        </div>
    </div>
    @endforeach
</div>
@endsection
