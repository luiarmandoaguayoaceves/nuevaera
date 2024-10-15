@extends('layouts.head')
@extends('layouts.app')
@extends('layouts.footer')
@extends('layouts.navegacion')



@section('contenido')
    <section class="w-full mx-auto bg-nordic-gray-light flex pt-12 md:pt-0 md:items-center bg-cover bg-right" style="max-width:1600px; height: 32rem; background-image: url('img/principal.jpg');">

        <div class="container mx-auto">
    
        <div class="flex flex-col w-full lg:w-1/2 justify-center items-start  px-6 tracking-wide">
            <h1 class="text-white text-2xl my-4">Calzado NuevaEra: Fabricamos el Éxito en Cada Paso</h1>
            <a class="text-xl inline-block no-underline border-b border-white leading-relaxed hover:text-white hover:border-white " href="#">Galeria</a>
    
        </div>
    
        </div>
  
  </section>
    <section class="bg-white py-8">

        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

            <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                    <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                        Store
                    </a>

                    <div class="flex items-center" id="store-nav-content">

                        <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                            <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                            </svg>
                        </a>

                        <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                            <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                            </svg>
                        </a>

                    </div>
            </div>
            </nav>

            
            <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col " id="fotos">
        
                    <img class="hover:grow hover:shadow-lg" src="img/galeria/1.jpeg">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">Mod:
                        <span class="pt-1 text-gray-900"> 1872 </span></p>
                    </div>
        
            </div>
            <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" id="fotos">
        
                    <img class="hover:grow hover:shadow-lg" src="img/galeria/2.jpeg">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">Mod:
                        <span class="pt-1 text-gray-900"> 330 </span></p>
                    </div>
        
            </div>
            <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" id="fotos">
            
                    <img class="hover:grow hover:shadow-lg" src="img/galeria/3.jpeg">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">Mod:
                        <span class="pt-1 text-gray-900"> 673 </span></p>
                    </div>
            
            </div>
            <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" id="fotos">
            
                    <img class="hover:grow hover:shadow-lg" src="img/galeria/4.jpeg">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">Mod:
                        <span class="pt-1 text-gray-900"> 1822 </span></p>
                    </div>
            
            </div>
            <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" id="fotos">
            
                    <img class="hover:grow hover:shadow-lg" src="img/galeria/5.jpeg">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">Mod:
                        <span class="pt-1 text-gray-900"> 1822 </span></p>
                    </div>
            
            </div>
            <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" id="fotos">
            
                    <img class="hover:grow hover:shadow-lg" src="img/galeria/6.jpeg">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">Mod:
                        <span class="pt-1 text-gray-900"> 1822 </span></p>
                    </div>
                
            </div>
            <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" id="fotos">
                    <img class="hover:grow hover:shadow-lg" src="img/galeria/7.jpeg">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">Mod:
                        <span class="pt-1 text-gray-900"> 1872 </span></p>
                    </div>
            </div>
            <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" id="fotos">
                    <img class="hover:grow hover:shadow-lg" src="img/galeria/8.jpeg">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">Mod:
                        <span class="pt-1 text-gray-900"> 920 </span></p>
                    </div>
            </div>


    </section>
@endsection

@section('script')
    <script src="{{ asset('js/galeria/fotos.js') }}?v={{ time() }}"></script>
@endsection