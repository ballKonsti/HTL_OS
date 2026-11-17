<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="h-[100vh] w-[100vw]">

    <img id="tour-image" alt="virtueller rundgang" class="mx-auto h-[100vh] w-[100vw]">


    <button type="button" data-tour-direction="left" aria-label="Nach links abbiegen" hidden>

        <-links </button>


            <button type="button" , data-tour-direction="right" aria-label="nach recht abbiegen" hidden>

                recht->
            </button>



</body>

</html>
