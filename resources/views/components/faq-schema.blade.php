<script type="application/ld+json">
{
"@context":"https://schema.org",
"@type":"FAQPage",
"mainEntity":[
@foreach($faqs as $faq)
{
"@type":"Question",
"name": @json($faq['question']),
"acceptedAnswer":{
"@type":"Answer",
"text": @json($faq['answer'])
}
}@if(!$loop->last),@endif
@endforeach
]
}
</script>