@props(['job' => null])
<x-panel class="flex flex-col text-center">
    <div class="self-start text-sm">{{$job->employer->name}}</div>
    <div class="py-8 font-bold">
        <h3 class="text-xl group-hover:text-blue-900 transition-colors duration-300">{{$job->title}}</h3>
        <p class="text-sm mt-4">{{$job->location}} - From {{$job->salary}}</p>
    </div>
    <!-- img and Tags -->
    <div class="flex justify-between items-center mt-auto">
        <div>
             @foreach($job->tags as $tag)
                <x-tag :$tag/>
             @endforeach
        </div>
{{--        <x-employer-logo/>--}}
    </div>
</x-panel>
