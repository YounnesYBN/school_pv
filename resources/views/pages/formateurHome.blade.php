@include("layouts.header")

<main class="w-full h-fit   flex flex-col items-center ">
    <div class=" w-full h-fit flex items-center justify-center flex-wrap ">
        <div id="cartProfileCon" class="flex flex-col items-center justify-center mb-6 gap-6 min-w-[450px] max-w-[40%]  p-4  ">
            <!-- cardinfo -->
            <div id="profil_card" class=" p-6 bg-white border border-gray-200 rounded-lg shadow w-fit flex flex-col justify-center ">

                <div class="flex">
                    <svg fill="none" class="w-[100px] text-gray-700" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div class="flex flex-col justify-center">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 min-w-fit max-w-[400px]">{{$user->username}}</h5>
                        <p class="mb-3 font-normal text-gray-700 ">{{$user->email}}</p>
                    </div>
                </div>
                <div class="border my-4">
                </div>
                <div class="flex gap-3 justify-center">
                    <div class="w-fit flex flex-col items-center">
                        <label for="moiyen" class=" text-center block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">nombre de groupes</label>
                        <h5 class="mb-2 text-6xl font-bold tracking-tight text-gray-900  ">{{$user->group()->count()}}</h5>
                    </div>
                    <div class=" text-center w-fit flex flex-col items-center">
                        <label for="moiyen" class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">nombre de filieres</label>
                        <h5 class="mb-2 text-6xl font-bold tracking-tight text-gray-900  ">{{count($filiers)}}</h5>
                    </div>

                </div>
                <a href="{{Route("FormateurProfile")}}" class="self-center">
                    <button type="button" class="w-fit mt-5 self-center flex  items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2.5 py-2.5">
                        gérer votre compte
                        <svg fill="none" class="w-[20px] ml-1" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0015 0m-15 0a7.5 7.5 0 1115 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.964m11.49-9.642l1.149-.964M7.501 19.795l.75-1.3m7.5-12.99l.75-1.3m-6.063 16.658l.26-1.477m2.605-14.772l.26-1.477m0 17.726l-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205L12 12m6.894 5.785l-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864l-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495"></path>
                        </svg>
                    </button>
                </a>


            </div>

        </div>

        <form id="formateurFiliereFormCon" action="{{Route("formateurHome")}}" class="min-w-[450px] max-w-[40%]  h-fit flex  items-end flex-wrap justify-center" method="get">
            @csrf
            @method("get")
            <div class="flex  w-full h-fit justify-start items-center flex-wrap gap-2 mb-5">


                <div id="filiere_con" class="w-full mx-4">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900">les filieres</label>
                    <select id="selectFiliere" name="selectFiliere" class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-green-500 focus:border-green-500 block w-full text-center py-2.5 px-5 outline-none">
                        <option value="default" class="min-w-fit">choisir une filière:</option>
                        @foreach ($filiers as $filiere)
                        <option value="{{json_encode(["filiere"=>$filiere->code_filiere,"year"=>$filiere->annee])}}">{{$filiere->name}}</option>
                        @endforeach
                    </select>

                </div>
                <div id="group_con" class="w-full mx-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Groupe :</label>
                    <select id="selectGroup" name="selectGroup" class=" bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-green-500 focus:border-green-500 block w-full py-2.5 px-5 outline-none text-center">

                    </select>
                </div>
                <!-- ------------- -->
                <div id="loading_con" class="hidden h-fit text-center w-full">
                    <svg aria-hidden="true" class="inline w-10 h-10 mr-2 text-gray-200 animate-spin  fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- -------------- -->
            <div id="submit_btn_con" class="flex items-end mx-2">
                <button class="py-2.5 px-5 mr-2  text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-green-700 focus:z-10 focus:ring-4 focus:ring-gray-200">Select</button>
            </div>
        </form>

    </div>
    @if ($shouldTbaleDisplay)
    <div class="w-full h-fit  flex justify-center mt-10">
        <div id="alert-border-3" class="flex items-center p-4  text-green-800 border-t-4 border-green-300 bg-green-50 w-fit rounded-md  " role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="ml-10 text-sm h-full w-fit font-medium flex flex-col items-center justify-center gap-3">
                <p class="text-xl uppercase">choix actuel:</p>
                <p class=" text-lg"> Filiere:<span class="font-light p-1 text-green-300 italic ml-1 mr-3">{{session("selectedFiliere")}}</span> Group: <span class="font-light p-1 text-green-300 italic ml-1">{{session("selectedGroupName")}}</span> </p>

            </div>

        </div>
    </div>
    <div class="w-fit h-fit mt-10">
        {{-- //table--------------- --}}
        <?php $x = false ?>
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-lg">
                <tr>
                    <th class="px-6 py-6 w-1/5 text-center">Aspeets à Trailer</th>
                    <th class=" px-6 py-6 w-4/12  text-center">Eléments de traitement</th>
                    <th class="px-6 py-6 text-center w-36">les données</th>

                    <th class="px-6 py-6 text-center">commentaires</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($data as $aspeet_element)
                <tr class="">
                    <td class="{{ $x ? "border-b bg-gray-50 text-lg px-6 py-6" : "text-lg px-6 py-6" }}" rowspan="
                    {{count($aspeet_element["elements"])+1}}
                    ">

                        {{$aspeet_element["aspeet"]->value}}
                    </td>
                </tr>
                <?php $endOfAspeet = 0; ?>

                @foreach ($aspeet_element["elements"] as $element)

                <?php $endOfAspeet++; ?>

                <tr class="{{count($aspeet_element["elements"]) == $endOfAspeet ? " border-b" : " " }}">
                    <td class=" px-6 py-4 text-md border-b">{{$element->name}}</td>
                    <td>
                        <div class="px-6 py-6 flex justify-center items-center">

                            @if ($element->type_comment != "select")

                            <input type="number" id="first_name" name="{{$element->id}}" disabled value="{{$element->donne? $element->donne->value: " "}}" class="w-full text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  p-2.5">
                            @endif

                        </div>

                    </td>


                    <td class="min-h-[132px] max-h-fit flex items-center justify-center gap-2 p-2  border-b">
                        <div class="min-h-full max-h-fit w-full" id="comment_COM">
                            <ol>

                                <?php $comments_json = $element->comment ? json_decode($element->comment->comments) : []; ?>

                                @foreach ( $comments_json as $valueCom)
                                @if ($valueCom->active)

                                <li class="italic text-slate-600/75 space break-words text-md font-medium m-2 flex">
                                    <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{$valueCom->value}}
                                </li>
                                @endif
                                @endforeach

                            </ol>

                        </div>
                        <button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 ">
                            <a href="{{route("FormateurComment",["group"=>$selectedGroup,"element"=>$element,"filiere"=>$selectedFiliere])}}">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"></path>
                                </svg>
                            </a>
                        </button>
                    </td>

                </tr>
                @endforeach
                <?php $x = !$x ?>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <blockquote class="text-xl italic font-semibold text-gray-900 h-[400px] flex flex-col justify-center">
        <svg aria-hidden="true" class="w-10 h-10 text-gray-400 dark:text-gray-600" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.017 18L14.017 10.609C14.017 4.905 17.748 1.039 23 0L23.995 2.151C21.563 3.068 20 5.789 20 8H24V18H14.017ZM0 18V10.609C0 4.905 3.748 1.038 9 0L9.996 2.151C7.563 3.068 6 5.789 6 8H9.983L9.983 18L0 18Z" fill="currentColor" />
        </svg>
        <p>"choisissez la filiere et le groupe ."</p>
    </blockquote>
    @endif
</main>

<script>


</script>
@include("layouts.footer")