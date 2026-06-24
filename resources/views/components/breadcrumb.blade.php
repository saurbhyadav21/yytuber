<nav class="breadcrumb mb-3">
@foreach($breadcrumbs as $breadcrumb)

@if(!$loop->last)
<a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a> >
@else
<span>{{ $breadcrumb['name'] }}</span>
@endif

@endforeach
</nav>

<script type="application/ld+json">
{!! json_encode([
'@context'=>'https://schema.org',
'@type'=>'BreadcrumbList',
'itemListElement'=>collect($breadcrumbs)->map(function($item,$index){
return[
'@type'=>'ListItem',
'position'=>$index+1,
'name'=>$item['name'],
'item'=>$item['url']
];
})->values()
],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
</script>