@include("layouts.header")

<main class=" lg:bg-white h-screen   w-full gap-10 flex flex-col justify-between items-center mt-5">
    <button type="button" class=" self-start text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ml-2">
        <a href="{{Route("home")}}" class="flex">
            <svg class=" w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"></path>
            </svg>
            <p class=" text-md ">Retourner</p>
        </a>
    </button>
    <form class=" mb-7 md:w-11/12 h-full max-h-fit  flex flex-col flex-wrap items-center" action="{{Route("Onupload")}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="w-full flex-wrap mb-10 flex items-start">
            <div class="w-1/2 pl-[6%]">
                <label for="moiyen" class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">moyenne</label>
                <input type="number" name="moiyen" id="moiyen" value="{{old("moiyen")}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-100 focus:border-blue-100 block w-2/3 p-2.5  " placeholder="moyenne...">

                @error('moiyen')
                <div class="md:w-2/3 mt-4 flex p-4  text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Alerte danger !</span> {{$message}}
                    </div>
                </div>

                @enderror
            </div>
            <div class="w-1/2 pl-[6%]">
                <label for="convenable" class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">convenable</label>

                <input type="number" id="convenable" name="convenable" value="{{old("convenable")}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-2/3 p-2.5" placeholder="convenable...">

                @error('convenable')
                <div class="md:md:w-2/3  mt-4 flex p-4  text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Alerte danger !</span> {{$message}}
                    </div>
                </div>

                @enderror
            </div>

        </div>
        <div class="  w-full flex flex-col justify-center items-center">
            <div class="flex items-center justify-center w-1/2">
                <label for="dropzone-file" class=" max-h-fit h-[200px] flex flex-col items-center justify-center w-full  border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 ">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Cliquez pour télécharger le fichier</span></p>
                        <p class="text-xs text-gray-500 ">xlsx , xls</p>
                        <p id="file_name" class="text-blue-800 text-center px-5"></p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" name="file_import" />
                </label>
            </div>

            @error('file_import')
            <div class="md:full mt-4 flex p-4  text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Alerte danger !</span> {{$message}}
                </div>
            </div>
            @enderror
            @error('extension')
            {{$message}}
            @enderror
        </div>
        <div class=" w-1/4 mt-8">

            <button type="submit" id="submit_but" class="w-full shadow-lg text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">submit</button>

        </div>
        @if ($error = session("error"))

        <div class="mt-3  flex p-4  text-sm text-red-800 rounded-lg bg-red-50 max-w-[65%]" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Alerte danger !</span> {{$error}}
            </div>
        </div>
        @endif
    </form>
</main>

<script>
    document.getElementById('submit_but').addEventListener("click", (e) => {

        var ele = e.target;
        ele.innerHTML = `
        
        Chargement... <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
    </svg>
    
        `;
    })

    document.getElementById("dropzone-file").addEventListener("change", (e) => {
        document.getElementById("file_name").innerText = e.target.files[0].name;
    })
</script>