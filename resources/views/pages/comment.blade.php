@include('layouts.header')

<main class="h-screen mb-5">
    <div class="flex items-center justify-around mt-10">

        <div id="comment_con" class=" max-w-fit min-w-[70%] pt-6 pl-4 flex flex-col items-center">

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
                        <input placeholder="saisir un commentaire..." value="{{old("input_comment")}}" type="text" name="input_comment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none">
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
            @error("comment_display_input")
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 w-full m-6" role="alert">
                <span class="font-medium">Alerte danger!</span> {{$message}}.
            </div>
            @enderror

            <div class="w-full max-h-[400px] min-h-fit overflow-auto">
                <!-- table con -->
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-md">
                        <tr>
                            <th scope="col" class="px-3 py-3 w-[5%] text-center">
                                ACTIVE
                            </th>
                            <th scope="col" class="px-6 py-3 text-center w-2/3">
                                COMMENTAIRE
                            </th>
                            <th scope="col" class="py-3 text-center">
                                ACTIONS
                            </th>
                            <th scope="col" class="py-3  flex justify-center">
                                <svg fill="none" class="w-[35px]" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                                </svg>
                            </th>
                            <th scope="col" class="py-3 px-2 text-center">
                                Group
                            </th>
                        </tr>
                    </thead>
                    <tbody>



                        @foreach ($comments as $comment)
                        <tr class="bg-white border-b ">
                            <form action="{{Route("updateController",["Comment"=>$data["commentOBJ"],"id"=>$comment->id])}}" method="get">
                                @csrf
                                <td class="font-medium text-gray-900 whitespace-nowrap">
                                    <div class="w-full h-full flex justify-center items-center">
                                        @if (isset($comment->origin_id))
                                        <input id="default-checkbox" disabled {{$comment->active==true?"checked":""}} type="checkbox" value="{{ $comment->active }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">
                                        @else
                                        <input id="default-checkbox" name="comment_check" {{$comment->active==true?"checked":""}} type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">
                                        @endif
                                    </div>

                                </td>
                                <td class="py-4 px-5 font-medium text-gray-900  ">
                                    @if (isset($comment->origin_id))

                                    <textarea disabled rows="1" class=" whitespace-nowrap block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 outline-none">{{$comment->value}}</textarea>

                                    @else
                                    <textarea rows="1" id="first_name" name="comment_display_input" class=" whitespace-nowrap block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 outline-none " required>{{$comment->value}}</textarea>

                                    @endif
                                </td>
                                <td class="h-full  py-4 font-medium text-gray-900  ">
                                    <div class="flex justify-center items-center gap-3 ">

                                        @if (isset($comment->formateur))
                                            <a class=" py-2.5 px-2.5 hover:shadow font-medium text-red-600 rounded-md shadow-md" href="{{Route("deleteController",["Comment"=>$data["commentOBJ"],"id"=>$comment->id])}}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                            </svg>
                                            </a>
                                         @else

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
                                        @endif
                                    </div>

                                    
                                </td>
                                <td class="px-2 text-center h-full min-w-fit max-w-[100px]">

                                    {{isset($comment->formateur)?$comment->formateur:"Vous"}}

                                </td>
                                <td class="">
                                    @if (isset($comment->formateur))
                                    <p>{{$comment->group}}</p>
                                    @else
                                    <div class="w-full flex justify-center">

                                        <svg class="w-[20px] jy" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </td>
                            </form>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class=" min-w-fit  max-w-[20%] h-fit  flex flex-col items-center pt-4 justify-between  ">
            <!-- info -->

            <ul class=" w-fit h-fit text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg mb-5">
                <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg flex flex-col items-center min-h-[100px] max-h-fit">
                    <!-- aspeet -->
                    <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">ASPEETS À TRAILER</label>
                    <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{$data["aspeetOBJ"]->value}}</p>


                </li>
                <li class="w-full px-4 py-2 border-b border-gray-200 flex flex-col items-center  min-h-[100px] max-h-fit">
                    <!-- element-->
                    <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">Eléments de traitement</label>
                    <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{$data["elementOBJ"]->name}}</p>

                </li>
                <li class="w-full px-4 py-2 border-b border-gray-200 flex flex-col items-center min-h-[100px] max-h-fit">
                    <!-- filiere -->
                    <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">Filiére</label>
                    <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{session("selected_filier")}}</p>
                </li>
                <li class="w-full px-4 py-2 rounded-b-lg flex flex-col items-center min-h-[100px] max-h-fit">
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

</script>
@include("layouts.footer")