@include('layouts.header')
<main class="h-fit w-full mt-5 flex">


    <div id="comment_con" class=" w-2/3 pt-6 pl-4 flex flex-col items-center">

        <form action="{{Route("FormateurCommentAdd",["group"=>$group,"element"=>$element,"filiere"=>$filiere])}}" method="post" class="w-full mb-4">
            <!-- insert input-->
            @csrf
            @method("post")
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

        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 w-full" role="alert">
            <span class="font-medium">Alerte danger!</span> {{$message}}.
        </div>
        @enderror
        @if ($error = session("error"))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 w-full" role="alert">
            <span class="font-medium">Alerte danger!</span> {{$error}}.
        </div>
        @endif
        @if ($success = session("success"))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 w-full" role="alert">
            <span class="font-medium">Success alert!</span> {{$success}}
          </div>
        @endif

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
                


                @foreach ($comments as $comment)
                <tr class="bg-white border-b ">
                    <form action="{{Route("FormateurCommentUpdate",["comment"=>$commentOBJ,"id"=>$comment->origin_id])}}" method="post">
                        @csrf
                        @method("post")
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap flex justify-center items-center">
                            <input id="default-checkbox" name="comment_checked" {{$comment->active==true?"checked":""}}  type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">

              
                        <td class="py-4 font-medium text-gray-900 whitespace-nowrap ">
                            <input type="text" name="comment_display_input" id="first_name" class="h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none " value="{{$comment->value}}" required>


                        </td>
                        <td class=" py-4 font-medium text-gray-900 whitespace-nowrap flex  justify-center gap-3 ">
                            <button type="submit" class="py-2.5 px-2.5  hover:shadow  text-sm font-medium text-gray-900 focus:outline-none  hover:text-blue-700 focus:z-10   rounded-md shadow-md">
                                <svg fill="none" class="w-6 h-6" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
                                </svg>
                            </button>


                            <a class=" py-2.5 px-2.5 hover:shadow font-medium text-red-600 rounded-md shadow-md" href="{{route("FormateurCommentDelete",["comment"=>$commentOBJ,"id"=>$comment->origin_id])}}">
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
        
    </div>
    <div class=" w-4/12  flex flex-col items-center pt-4 justify-between mt-4 ">
        <!-- info -->

        <ul class=" w-4/5 h-fit text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
            <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg flex flex-col items-center h-fit py-5">
                <!-- aspeet -->
                <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">ASPEETS À TRAILER</label>
                <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{$aspeet->value}}</p>


            </li>
            <li class="w-full px-4 py-2 border-b border-gray-200 flex flex-col items-center h-fit py-5">
                <!-- element-->
                <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">Eléments de traitement</label>
                <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{$element->name}}</p>

            </li>
            <li class="w-full px-4 py-2 border-b border-gray-200 flex flex-col items-center h-fit py-5">
                <!-- filiere -->
                <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">Filiére</label>
                <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{$filiere->code_filiere}}</p>
            </li>
            <li class="w-full px-4 py-2 rounded-b-lg flex flex-col items-center h-fit py-5">
                <!-- yeare -->

                <label class="block bg-blue-100 text-blue-800  font-semibold mb-1.5 px-2.5 py-0.5 rounded w-fit">Group</label>
                <p class="tracking-tighter text-gray-500 text-center italic dark:text-gray-400">{{$group->name}}</p>


            </li>
        </ul>
        <a href="{{Route("formateurHome")}}" class="flex">
            <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 flex shadow-md">

                <svg class=" w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"></path>
                </svg>Retour à la page d'accueil</button>
        </a>

    </div>



</main>



@include("layouts.footer")