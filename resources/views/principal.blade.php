@extends('layouts.head')
@extends('layouts.app')
@extends('layouts.footer')
@extends('layouts.navegacion')
@extends('galeria')



@section('contenido')
    <!--
      Heads up! 👋

      This component comes with some `rtl` classes. Please remove them if they are not needed in your project.
    -->

    <section
        class="relative bg-[url(https://images.unsplash.com/photo-1604014237800-1c9102c219da?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80)] bg-cover bg-center bg-no-repeat">
        <div
            class="absolute inset-0 bg-gray-900/75 sm:bg-transparent sm:from-gray-900/95 sm:to-gray-900/25 ltr:sm:bg-gradient-to-r rtl:sm:bg-gradient-to-l">
        </div>

        <div class="relative mx-auto max-w-screen-xl px-4 py-32 sm:px-6 lg:flex lg:h-screen lg:items-center lg:px-8">
            <div class="max-w-xl text-center ltr:sm:text-left rtl:sm:text-right">
                <h1 class="text-3xl font-extrabold text-white sm:text-5xl">
                    Calzado Nueva Era

                    <strong class="block font-extrabold text-rose-500"> Calzado para ti. </strong>
                </h1>

                <p class="mt-4 max-w-lg text-white sm:text-xl/relaxed">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nesciunt illo tenetur fuga ducimus
                    numquam ea!
                </p>

            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="{{ asset('js/galeria/fotos.js') }}?v={{ time() }}"></script>
@endsection
