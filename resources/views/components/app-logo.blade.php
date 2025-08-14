@if($currentOrganization)
<div class="flex aspect-square size-8 items-center justify-center rounded-md text-accent-foreground">
{{--    <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />--}}
    @if($currentOrganization->logo_url)
        <img src="{{ $currentOrganization->logo_url }}" alt="Logo" class="size-8">
    @endif
</div>
@endif
<div class="ms-1 grid flex-1 text-start text-sm">
    <span class="mb-0.5 truncate leading-tight font-semibold">{{ $currentOrganization ? $currentOrganization->display_name : 'Baseball Org' }}</span>
</div>
