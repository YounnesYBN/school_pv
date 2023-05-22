@include("layouts.header")
<main class="w-full max-h-fit min-h-full mt-7 flex flex-col items-center  ">
    <button type="button" class=" self-start text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ml-2">
        <a href="{{Route("home")}}" class="flex">
            <svg class=" w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"></path>
            </svg>
            <p class=" text-md ">Retourner</p>
        </a>
    </button>
    <div class="w-full flex h-fit mt-10">

        <form class=" w-[45%] px-10 h-fit flex flex-col items-center gap-3" method="post" action='{{Route("uploadAccount&filiere")}}' enctype="multipart/form-data">

            @csrf
            <!-- //import con -->
            <div class="w-full"><label for="moiyen" class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">télécharger le fichier</label></div>
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50  hover:bg-gray-100 ">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Cliquez pour télécharger</span>
                        <p class="text-xs text-gray-500 ">XLSX,XLS</p>
                        <p id="displayFileName" class="text-blue-800"></p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" name="uploadFile" value="{{old("uploadFile")}}" />
                </label>
            </div>
            @error("uploadFile")
            <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">{{$message}}
                </div>
            </div>
            @enderror
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-9/12">submit</button>
            @if ($error = session("error"))
            <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">{{$error}}
                </div>
            </div>
            @endif

            @if ($seccess = session("seccess"))
            <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 " role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <span class="font-medium"></span> {{$seccess}}
                </div>
            </div>
            @endif
        </form>
        <div class=" w-[55%] flex flex-col h-fit px-5">

            <div class=" h-fit flex justify-center items-center gap-2 mb-5">
                <p class="underline underline-offset-3 decoration-8 decoration-blue-400 text-3xl font-bold text-center">total des Formateurs:</p>
                <mark class="px-2 text-white text-4xl bg-blue-600 rounded h-fit">5</mark>
            </div>
            <!-- /--------------------- -->
            <div class="w-full flex justify-end pr-4 gap-3 mb-2">
                <form class="self-start w-[71%] flex ">
                    <div class="relative z-0 w-2/3 group">
                        <input type="email" name="floating_email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">recherche</label>
                    </div>
                    <button type="button" class=" text-sm font-medium text-gray-900 focus:outline-none bg-white   hover:text-blue-700  ">
                        <svg class="w-[20px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                            </path>
                        </svg></button>
                </form>
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-1.5 py-1.5 h-fit w-fit ">actif Tous</button>
                <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-1.5 py-1.5 h-fit w-fit">désactiver tout</button>

            </div>
            <!-- /----------------- -->
            <table class="w-full h-fit text-sm text-left text-gray-500 border">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-md ">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-1/3 text-center border">
                            nom et prenom
                        </th>

                        <th scope="col" class="py-3 w-2/3 text-center border">
                            actions
                        </th>
                    </tr>
                </thead>
                <tbody class=" ">






                    <tr class="bg-white border-b h-16">


                        <td class=" font-medium text-gray-900 whitespace-nowrap text-center h-full">

                            dazdaz

                        </td>
                        <td class=" font-medium text-gray-900 h-full flex justify-center items-center gap-4">
                            dazdazdaz
                        </td>

                    </tr>



                </tbody>
            </table>

        </div>
    </div>
</main>


<script>
    document.getElementById("dropzone-file").addEventListener("change", (e) => {
        document.getElementById("displayFileName").innerText = e.target.files[0].name;
    })
</script>