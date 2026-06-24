<style>
    .faq-item {
        margin-bottom: 10px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #fff;
    }

    .faq-item summary {
        cursor: pointer;
        font-weight: bold;
        color: #000;
    }

    .faq-item p {
        margin-top: 10px;color: #000;
    }
</style>

@if (!empty($faqs))

    <div class="faq-section">
        <h2>Frequently Asked Questions</h2>

        @foreach ($faqs as $faq)
            <details class="faq-item">
                <summary>{{ $faq['question'] }}</summary>
                <p>{{ $faq['answer'] }}</p>
            </details>
        @endforeach
    </div>

    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($faqs)->map(function ($faq) {
        return [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer']
            ]
        ];
    })->values()
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
</script>

@endif
