@include("layouts.header")

<main class="w-ful max-h-fit min-h-full flex p-4 mt-1 justify-around">
    <div class=" w-7/12 h-5/6  overflow-scroll">

        <table class="w-full h-fit text-sm text-left text-gray-500 border">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-md ">
                <tr>
                    <th scope="col" class="px-6 py-3 w-2/3 text-center border">
                        LA DATE
                    </th>

                    <th scope="col" class="py-3 w-1/3 text-center border">
                        ACTIONS
                    </th>
                </tr>
            </thead>
            <tbody class=" ">



            
                @foreach($data as $item)

                <tr class="bg-white border-b h-16">


                    <td class=" font-medium text-gray-900 whitespace-nowrap text-center h-full">

                        {{$item->export_date}}

                    </td>
                    <td class=" font-medium text-gray-900 h-full flex justify-center items-center gap-4">
                        <a href="{{Route("ExportData",["id"=>$item->id])}}"><button type="button" class="text-white h-fit bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2.5 py-2.5">Export</button></a>
                        <a href="{{Route("deleteExport",["id"=>$item->id])}}"><button type="button" class="py-2.5 px-2.5 h-fit  text-sm font-medium text-red-500 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-200 ">supprimer</button></a>
                    </td>

                </tr>
                @endforeach


            </tbody>
        </table>
    </div>
    <div class=" w-1/3 h-5/6  flex flex-col items-center py-5 gap-7">
        <a href="{{Route("home")}}" class="flex">
            <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 flex shadow-md">

                <svg class=" w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"></path>
                </svg>Retour à la page d'accueil</button>
        </a>
        <div class="w-5/6 h-fit flex justify-center items-center gap-2">
            <p class="underline underline-offset-3 decoration-8 decoration-blue-400 text-3xl font-bold text-center">total des exportations:</p>
            <mark class="px-2 text-white text-4xl bg-blue-600 rounded h-fit">{{count($data)}}</mark>
        </div>
    </div>
</main>
@include("layouts.footer")