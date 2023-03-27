@section('title')
    Login
@endsection

@include('layouts.header')
<main class="flex flex-col justify-center w-full items-center flex-1">

    <div class=" text-2xl subpixel-antialiased tracking-wide font-medium text-slate-400"><h1>authentification</h1></div>
    <form action="{{Route("Onlogin")}}" method="post" class="w-1/4 flex flex-col items-center shadow-md p-4 rounded-md">
        @csrf
        
            <div class="flex flex-col w-full mb-6">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 ">Nom</label>
                <input type="text" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block  p-2.5 outline-none " placeholder="nom..." value="{{old("email")}}">
                
                @error("email")
                
                <div class="p-3 mt-2  text-sm text-red-800 rounded-lg bg-red-50 dark:text-red-400 " role="alert">
                    <span class="font-medium">Error:</span> {{$message}}
                </div>
                
                @enderror 
                
            </div>

            <div class="flex flex-col w-full mb-6">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 ">mot de passe</label>
                <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block  p-2.5 outline-none " placeholder="mot de passe..." value="{{old("password")}}">
                
                @error("password")
                
                <div class="p-3 mt-2  text-sm text-red-800 rounded-lg bg-red-50 dark:text-red-400 " role="alert">
                    <span class="font-medium">Error:</span> {{$message}}
                </div>
                
                @enderror 
                
            </div>
            
         
        

        <button class="focus:outline-none text-white bg-green-700 hover:bg-green-800  focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">connexion</button>


    </form>
    @if ($m = session("error"))
    
       <p class="italic text-red-400/75 m-3 underline decoration-pink-500">{{$m}}</p> 
    
    @endif

</main>
@include('layouts.footer')
