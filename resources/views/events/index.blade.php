<x-app-layout>
    <div class="wrapper w-10/12 mx-auto md:w-11/12 lg:w-10/12">
        <header class="py-20 flex items-center justify-between">
            <h2 class="text-5xl font-bold text-slate-700">Список событий</h2>
            <a href="{{route('events.create')}}" class="ring-offset-2 ring-2 bg-cyan-500 text-white px-4 py-2 text-base font-medium rounded-md">
                Добавить событие
            </a>
        </header>
        <main>
            <section class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start gap-5">
                @foreach ($events as $event)
                    <article class="bg-white py-5 px-4 grid grid-cols-7 gap-3  divide-x {{$event->premium ? "border border-cyan-400":''}}">
                        <div class="col-span-2 flex items-center justify-center">
                            <ul class="grid grid-cols-2 gap-1">
                                <li class="p-1 text-center font-medium text-lg capitalize">{{$event->starts_at->translatedFormat('M')}}</li>
                                <li class="p-1 text-center font-medium text-lg capitalize">{{$event->ends_at->translatedFormat('M')}}</li>
                                <li class="p-1 text-center font-semibold text-lg border-t-2">{{$event->starts_at->translatedFormat('d')}}</li>
                                <li class="p-1 text-center font-semibold text-lg border-t-2">{{$event->ends_at->translatedFormat('d')}}</li>
                            </ul>
                        </div>
                        <div class="pl-3 col-span-5">
                            <header class="">
                                <div class="mb-1.5 flex items-center flex-wrap gap-1.5">
                                    @foreach ($event->tags as $tag)
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900 mb-1">
                                        {{$tag->name}}
                                    </span>
                                    @endforeach
                                </div>
                                <h4 class="font-semibold cursor-pointer text-[18.5px] capitalize leading-6 text-slate-800 tracking-tight">
                                    <a href="{{route('events.show',['event'=>$event])}}">{{Str::limit($event->title,60)}}</a>
                                </h4>
                            </header>
                            <div class="flex items-center gap-4 pt-4">
                                <div class="bg-slate-200 h-10 w-10 rounded-full">
                                    {{-- <img src="" alt=""> --}}
                                </div>
                                <div class="leading-3">
                                    <div class="text-base font-semibold text-slate-800 capitalize">{{explode(' ',$event->user->name)[0]}}</div>
                                    <div class="text-sm font-semibold text-slate-500 capitalize">{{explode(' ',$event->user->name)[1]}}</div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>
        </main>
    </div>
</x-app-layout>
