@include('layouts.header')





<main class="flex flex-col items-center">
    <div class="w-full flex justify-center items-center h-72  rounded my-10">

        <div class=" w-4/5 h-5/6  flex items-center justify-around gap-4">


            <form action="{{Route("home")}}" class="w-1/2 flex items-end  space-x-4" method="get">
                @csrf
                <div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900">l'année :</label>
                    <select id="selectYear" class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-green-500 focus:border-green-500 block w-26 text-center py-2.5 px-5 outline-none" name="selectYear">
                        <option id="year12" value="12">1A & 2A</option>
                        <option id="year1" value="1">1A</option>
                        <option id="year2" value="2">2A</option>
                    </select>

                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">filière :</label>
                    <select id="filierSelect" class=" bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-green-500 focus:border-green-500 block w-full py-2.5 px-5 outline-none text-center" name="filierSelect">
                    </select>

                </div>
                <div>
                    <button class="py-2.5 px-5 mr-2  text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-green-700 focus:z-10 focus:ring-4 focus:ring-gray-200">Select</button>
                </div>


            </form>

            @if (session("type")=="directeur")

            <div class="h-full w-2/5 flex flex-col items-center justify-center gap-6 shadow-md rounded-md">
                <div class="p-4  text-sm text-yellow-800 rounded-lg bg-yellow-50 w-3/4 " role="alert">
                    <span class="font-medium">Alerte d'avertissement !</span> lors de l'importation d'un nouveau fichier, les anciennes données seront supprimées.
                </div>
                <button type="button" class="shadow-xl hover:shadow-md duration-100 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2  focus:outline-none flex-grow-0 w-1/2"><a href="{{Route("upload")}}">importer un nouveau fichier</a></button>

            </div>
            @endif
        </div>
    </div>


    <div id="alert-border-3" class="flex items-center p-4 mt-20 text-green-800 border-t-4 border-green-300 bg-green-50 w-1/4 rounded-md mb-24 md:w-1/3" role="alert">
        <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <div class="ml-3 text-sm h-full w-5/6 font-medium flex flex-col items-center justify-center gap-3">
            <p class="text-xl uppercase">choix actuel:</p>
            @if($year = session("selected_year"))
            @if ($year == 12)
            <p class=" text-lg"> Année<span class="font-light p-1 text-green-300 italic ml-1 mr-3">Toute</span> Filiere <span class="font-light p-1 text-green-300 italic ml-1">Toute</span> </p>
            @else
            <p class=" text-lg"> Année<span class="font-light p-1 text-green-300 italic ml-1 mr-3">{{session("selected_year")}}A</span> Filiere <span class="font-light p-1 text-green-300 italic ml-1">{{session("selected_filier") == "all_a1" || session("selected_filier") == "all_a2" ? "Toute" : session("selected_filier") }}</span> </p>
            @endif
            @else

            <p class=" text-lg"> Année<span class="font-light p-1 text-green-300 italic ml-1 mr-3">Toute</span> Filiere <span class="font-light p-1 text-green-300 italic ml-1">Toute</span> </p>

            @endif

        </div>

    </div>

    <!-- ////////////////////////// -->

    <?php $x = false ?>
    <form action="{{Route("saveHomeChanges")}}" class="relative overflow-x-auto shadow-lg sm:rounded-lg p-6 w-3/4 flex flex-col items-center" method="get">
        @csrf
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-lg">
                <tr>
                    <th class="px-6 py-6 w-1/5 text-center">Aspeets à Trailer</th>
                    <th class="{{$comment_display ? " px-6 py-6 w-4/12  text-center" : "px-6 py-6 w-3/5 text-center" }}">Eléments de traitement</th>
                    <th class="px-6 py-6 text-center w-36">les données</th>

                    @if ($comment_display)
                    <th class="px-6 py-6 text-center">commentaires</th>
                    @endif

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
                            
                            <input type="number" id="first_name" name="{{$element->id}}" value="{{$element->donne? $element->donne->value: " "}}" class="w-full text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  p-2.5">
                            @endif
                            
                        </div>

                    </td>

                    @if ($comment_display)
                    <td class=" h-32 flex items-center justify-center gap-2 p-2  border-b">
                        <div class="h-4/5 w-4/5 pl-2 pt-2 pr-2 overflow-y-auto" id="comment_COM">
                            <ol>

                                <?php $comments_json =$element->comment ? json_decode($element->comment->value) : [];?> 

                                @foreach ( $comments_json as $valueCom)
                                    @if ($valueCom->active)
                                        
                                    <li class="italic text-slate-600/75 space break-words text-md font-medium m-2 flex">
                                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        {{$valueCom->value}}
                                    </li>
                                    @endif
                                @endforeach 
                                
                            </ol>
                            
                        </div>
                        <button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 ">
                                <a href="{{Route("show",$element)}}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"></path>
                                      </svg>
                                </a>
                        </button>
                    </td>
                    @endif
                </tr>
                @endforeach
                <?php $x = !$x ?>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-center items-center gap-10 mt-8" >
            <button type="submit" id="save-button" class= " text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 ">Sauvegarder les modifications</button>
            <button type="button"  class="py-2.5 px-5  text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200"><a href="{{Route("OnExport")}}" id="download_file_button">Télécharger le fichier excel de Toute les filiéres</a></button>
        </div>

    </form>
    

</main>
<script>
    document.getElementById('save-button').addEventListener("click", (e) => {

        var ele = e.target;
        
        ele.innerHTML = `
        
        Chargement... <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
    </svg>
    
        `;
        
    })

    document.getElementById('download_file_button').addEventListener("click", (e) => {

var ele = e.target;
ele.innerHTML = `

S'il vous plaît, attendez... <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-900 hover:text-blue-700 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
</svg>

`;

setTimeout(() => {
            console.log("hii");
            ele.innerHTML = "Télécharger le fichier excel de Toute les filiéres"
        }, 17*1000);
})

    
</script>
