@props(['width' => 'md'])

@php
// I like the simple 'width' prop when using this x-card component. The obvious
// approach here would simply be to build the max width class dynamically, for
// example: {{ 'max-w-' . $width }}. This works perfectly in development, but
// not for production. When running `npm run prod`, Tailwind CSS's 'purge' tree
// shaking will not recognize these classes and therefore strips them out of
// the final css, breaking the site. See doc:
//
//  https://tailwindcss.com/docs/optimizing-for-production#writing-purgeable-html 
//
// This switch statement is verbose, but by listing the classes in full, it
// prevents them being purged. Note, that I've only listed a few of the
// possible max-w-* classes, which may cause headaches in the future. I need
// a better system.

$maxWidth = 'md:max-w-full';
switch ($width) {
    case '0':
        $maxWidth = 'md:max-w-0';
        break;
    case 'sm':
        $maxWidth = 'md:max-w-sm';
        break;
    case 'md':
        $maxWidth = 'md:max-w-md';
        break;
    case 'lg':
        $maxWidth = 'md:max-w-lg';
        break;
    case 'lg':
        $maxWidth = 'md:max-w-full';
        break;
}
@endphp


<div {{ $attributes->merge(['class' => 'min-h-full flex flex-col sm:justify-center items-center pt-6 sm:pt-0']) }}>
    <div class="w-full {{ $maxWidth }} px-6 py-4 bg-primary-200 shadow-md overflow-hidden sm:rounded-lg">
        @if (!empty($title))
            <div class="text-2xl text-gray-500 mb-6">
                {{ $title }}
            </div>
        @endif

        {{ $slot }}
    </div>
</div>


