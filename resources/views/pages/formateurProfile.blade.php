@include("layouts.header")
<main class="w-full mt-10 px-10">

    <form class="w-[50%]" method="post" action="{{route("updateProfile")}}">
        @csrf
        @method("put")
        <div class="mb-6">
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 ">nom d'utilisateur</label>
            <input value="{{$user->username}}" id="username" name="username" class="shadow-sm outline-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
            @error("username")
            <div class="flex p-2 mb-4 text-sm text-red-800 rounded-lg bg-red-50 w-fit mt-2 h-fit" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    {{$message}}
                </div>
            </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">votre e-mail</label>
            <input value="{{$user->email}}" id="email" name="email" class="shadow-sm outline-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
            @error("email")
            <div class="flex p-2 mb-4 text-sm text-red-800 rounded-lg bg-red-50 w-fit mt-2 h-fit" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    {{$message}}
                </div>
            </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">votre mot de passe</label>
            <div class="w-full flex items-center justify-center">
                <input value="{{$user->password}}" type="password" id="password" name="password" class="shadow-sm outline-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                <button type="button" id="show_password" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none   hover:text-blue-700  w-fit">
                    <svg fill="none" id="hide" class="w-[20px]" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path>
                    </svg>
                    <svg fill="none" id="show" class="w-[20px] hidden" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg> 
                </button>

                
                    

            </div>
            @error("password")
            <div class="flex p-2 mb-4 text-sm text-red-800 rounded-lg bg-red-50 w-fit mt-2 h-fit" role="alert">
                <svg aria-hidden="true"  class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    {{$message}}
                </div>
            </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 ">Confirmez le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="shadow-sm outline-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
            @error("password_confirmation")
            <div class="flex p-2 mb-4 text-sm text-red-800 rounded-lg bg-red-50 w-fit mt-2 h-fit" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    {{$message}}
                </div>
            </div>
            @enderror
        </div>
        <div class="flex">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-fit">mettre à jour les informations</button>
            <a href="{{route("formateurHome")}}"><button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 ml-2 ">Annuler</button></a>

        </div>
        
        @if ($message = session("error"))
    
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50  mt-4" role="alert">
            <span class="font-medium">Danger alert!</span> {{$message}}
        </div>
        @endif
        @if ($message = session("success"))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 mt-4" role="alert">
            <span class="font-medium">Success alert!</span> {{$message}}
        </div>
    
        @endif
    </form>

</main>
<script>
document.getElementById("show_password").addEventListener("mousedown",()=>{
    document.getElementById("hide").style.display ="none"
    document.getElementById("password").type ="text"
    document.getElementById("show").style.display ="flex"

    
})

document.getElementById("show_password").addEventListener("mouseup",()=>{
    document.getElementById("hide").style.display ="flex"
    document.getElementById("password").type ="password"
    document.getElementById("show").style.display ="none"

    
})


</script>

@include("layouts.footer")