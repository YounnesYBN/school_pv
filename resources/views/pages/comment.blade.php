@include('layouts.header')

<main class="h-screen mb-5">
    <div class="flex">

        <div id="comment_con" class=" w-2/3 pt-6 pl-4 flex flex-col items-center">

            <form action="{{Route("store")}}" method="post" class="w-full mb-4">
                <!-- insert input-->
                @csrf
                <div class="flex items-center gap-4">
                    <div class="flex h-1/2 gap-2">
                        <span class="ml-3 text-sm font-medium text-gray-90">Active</span>

                        <label class="relative flex-col items-center cursor-pointer">
                            <input type="checkbox" value="true" name="checkbox_active" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4   rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class=" w-4/5">
                        <label for="first_name" class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">commentaire</label>
                        <input placeholder="créez votre commentaire..." value="{{old("input_comment")}}" type="text" name="input_comment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none">
                    </div>

                    <div class="w-fit">
                        <button type="submit" class="mt-8 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-blue-600">Ajouter</button>
                    </div>
                </div>



            </form>
            @error('input_comment')

            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 w-full m-6" role="alert">
                <span class="font-medium">Alerte danger!</span> {{$message}}.
            </div>
            @enderror

            <div class="w-full h-[350px] overflow-auto">
                <!-- table con -->
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-md">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-1/12 text-center">
                                ACTIVE
                            </th>
                            <th scope="col" class="px-6 py-3 text-center w-2/3">
                                COMMENTAIRE
                            </th>
                            <th scope="col" class="py-3 text-center">
                                ACTIONS
                            </th>
                        </tr>
                    </thead>
                    <tbody>



                        @foreach ($comments as $comment)
                        <tr class="bg-white border-b ">
                            <form action="{{Route("updateController",["Comment"=>$data["commentOBJ"],"id"=>$comment->id])}}" method="get">
                                @csrf
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap flex justify-center items-center">
                                    <input id="default-checkbox" name="comment" {{$comment->active==true?"checked":""}} type="checkbox" value="{{ $comment->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">

                                    {{-- <input type="checkbox" name="comment" {{$comment->active==true?"checked":""}} value="{{ $comment->id }}"> --}}
                                </td>
                                <td class="py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    <input type="text" name="comment_display_input" id="first_name" class="h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none " value="{{$comment->value}}" required>


                                </td>
                                <td class=" py-4 font-medium text-gray-900 whitespace-nowrap flex  justify-center gap-3 ">
                                    <button type="submit" class="py-2.5 px-2.5  hover:shadow  text-sm font-medium text-gray-900 focus:outline-none  hover:text-blue-700 focus:z-10   rounded-md shadow-md">
                                        <svg fill="none" class="w-6 h-6" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
                                        </svg>
                                    </button>


                                    <a class=" py-2.5 px-2.5 hover:shadow font-medium text-red-600 rounded-md shadow-md" href="{{Route("deleteController",["Comment"=>$data["commentOBJ"],"id"=>$comment->id])}}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                        </svg>
                                    </a>


                                </td>
                            </form>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-5">
                @if (count($comments) > 0)
                <button id="save_changes" type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 ">Enregistrer Les Changements</button>
                @endif
            </div>
        </div>
        <div class=" w-4/12  flex flex-col items-center pt-4 justify-between mt-4 ">
            <!-- info -->

            <ul class=" w-4/5 h-5/6 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg flex flex-col items-center h-1/4">
                    <!-- aspeet -->
                    <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">ASPEETS À TRAILER</label>
                    <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{$data["aspeetOBJ"]->value}}</p>


                </li>
                <li class="w-full px-4 py-2 border-b border-gray-200 flex flex-col items-center h-2/5">
                    <!-- element-->
                    <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">Eléments de traitement</label>
                    <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{$data["elementOBJ"]->name}}</p>

                </li>
                <li class="w-full px-4 py-2 border-b border-gray-200 flex flex-col items-center h-[18%]">
                    <!-- filiere -->
                    <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">Filiére</label>
                    <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{session("selected_filier")}}</p>
                </li>
                <li class="w-full px-4 py-2 rounded-b-lg flex flex-col items-center h-[18%]">
                    <!-- yeare -->

                    <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">Année</label>
                    <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{session("selected_year")."A"}}</p>


                </li>
            </ul>
            <a href="{{Route("home")}}" class="flex">
                <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 flex shadow-md">

                    <svg class=" w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"></path>
                    </svg>Retour à la page d'accueil</button>
            </a>

        </div>
    </div>

</main>
<script>
    var element_save_btn = document.getElementById("save_changes");
    var all_checkbox = document.querySelectorAll("input[name='comment']")
    document.getElementById('save_changes').addEventListener("click", (e) => {

        var ele = e.target;
        ele.innerHTML = `

S'il vous plaît, attendez... <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-900 hover:text-blue-700 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
</svg>

`;
    })
    element_save_btn.addEventListener("click", function() {
        var data = [];

        for (let index = 0; index < all_checkbox.length; index++) {
            const element = all_checkbox[index];
            data.push({
                id: element.value,
                active: element.checked
            })
        }

        fetch(window.location.origin + "/api/saveChanges", {
            method: "post",
            headers: {

                'Content-Type': 'application/json',


            },
            body: JSON.stringify({
                id_comment: {{session("selected_comment")}},
                data: data
            })
        }).then((res) => {
            if (res.ok) {
                location.reload()
            }

        })
    })
</script>
@include("layouts.footer")