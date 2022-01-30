<x-app-layout>
    <div class="wrapper w-10/12 mx-auto md:w-11/12 lg:w-10/12">
        <header class="py-20 flex items-center justify-between">
            <h2 class="text-5xl font-bold text-slate-700">Добавить событие</h2>
            <a href="{{route('events.index')}}" class="ring-offset-2 ring-2 bg-cyan-500 text-white px-4 py-2 text-base font-medium rounded-md">
                Список событий
            </a>
        </header>
        <main class="pb-10">
            <div class="w-1/3 bg-white px-6 py-8 shadow-md">
                <form action="{{route('events.store')}}" method="post" autocomplete="off" id="add_event_form">

                    @csrf

                    <div class="field @error('title') error @enderror">
                        <label for="title">Title</label>
                        <div class="input">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </span>
                            <input type="text" name="title" id="title" value="{{old('title') ?? ''}}" placeholder="Tap your events'title here">
                        </div>
                    </div>
                    <div class="field @error('starts_at') error @enderror">
                        <label for="starts_at">Start At</label>
                        <div class="input">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input type="date" name="starts_at" id="starts_at" value="{{old('starts_at') ?? ''}}" placeholder="Tap your events'title here">
                        </div>
                    </div>
                    <div class="field @error('ends_at') error @enderror">
                        <label for="ends_at">Start At</label>
                        <div class="input">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input type="date" name="ends_at" id="ends_at" value="{{old('ends_at') ?? ''}}" placeholder="Tap your events'title here">
                        </div>
                    </div>
                    <div class="field @error('content') error @enderror">
                        <label for="title">content</label>
                        <textarea id="content" rows="4" name="content" id="content" class="" placeholder="Tell us a bit about a your event...">
                            {{old('content') ?? ''}}
                        </textarea>
                    </div>

                    <div class="field @error('tags') error @enderror">
                        <label for="tags">Tags (they should be separated by a comma (,))</label>
                        <div class="input">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input type="text" name="tags" id="tags" value="{{old('tags') ?? ''}}" placeholder="web,php,css...">
                        </div>
                    </div>

                    <div class="checkbox">
                        <input id="premium" aria-describedby="premium" name="premium" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"" checked>
                        <label for="premium" class="">Premium</label>
                    </div>

                    <input type="hidden" name="payment_method" id="payment_method">

                    {{-- Stripe Elements Placeholder --}}
                    <div id="card-element"></div>

                    <div class="mt-8">
                        <button class="submit" id="add_event_btn" type="submit">
                            Add Event
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    @section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const apiKey = "pk_test_51JVssJDdOHOiq4Pb9x2ziEd10tUiCNrO1V7wzcPipf8FX4ZtYBzM2ZjZxTRZePQnSXj4TLWu73aZglAIrGONSXJV005MSsmh5a";
        const stripe = Stripe(apiKey,{
            apiKey: apiKey
        });

        const elements = stripe.elements();
        const cardElement = elements.create('card',{
            classes: {
                base: 'StripeElement my-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5'
            }
        });

        cardElement.mount('#card-element');

        const payment_method = document.getElementById('payment_method');
        const addEventBtn = document.getElementById('add_event_btn');

        addEventBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const { paymentMethod, error } = await stripe.createPaymentMethod('card', cardElement);

            if (error) {
                // Display "error.message" to the user...
                alert(error.message);
            } else {
                // The card has been verified successfully...
                payment_method.value = paymentMethod.id

                document.getElementById("add_event_form").submit();
            }
        });

    </script>
@endsection
</x-app-layout>


