<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css','resources/css/formateurHome.css', 'resources/js/app.js','resources/js/formateurHome.js'])

</head>

<body style="font-family: 'Montserrat', sans-serif;" class="flex flex-col h-screen">
    <header class="flex justify-between bg-emerald-700 h-24 px-2 items-center shadow-lg shadow-gray-500/50">

        <div class="h-full flex w-fit items-center  text-white">
            <img class="h-24" src="{{url('ofppt_logo.png')}}" alt="ofppt_Logo">
            <div class="text-md">
                <h2 class="font-bold  " id="ofppt_onwan">المعهد المتخصص للتدبير والاعلاميات مراكش</h2>
                <h2 class="font-bold " id="ofppt_onwan">ISGI MARRAKECH</h2>
            </div>
        </div>



        @if (
        session("type")

        )
        <div class="">

            <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4  font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"><a href="{{Route("Onlogout")}}">déconnecter</a></button>
        </div>


        @endif
    </header>