<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bildverwaltung</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>


<div>

    <body class="bg-gray-100 p-6">

        <div class="bg-white border border-gray-400 rounded-lg p-6 min-h-[90vh]">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-bold">Projekt</h1>

                <button class="bg-gray-200 border px-4 py-2 rounded">
                    Admin
                </button>
            </div>

            <!-- Hauptbereich -->
            <div class="flex gap-6">

                <!--Bilderlistre -->
                <div class="w-1/4 border-r pr-4">
                    <h2 class="font-bold mb-4">Alle Bilder</h2>

                    <ul class="space-y-2">
                        <li>
                            <button class="w-full text-left border rounded p-2 hover:bg-gray-100">
                                Bild 1
                            </button>
                        </li>
                        <li>
                            <button class="w-full text-left border rounded p-2 hover:bg-gray-100">
                                Bild 2
                            </button>
                        </li>
                        <li>
                            <button class="w-full text-left border rounded p-2 hover:bg-gray-100">
                                Bild 3
                            </button>
                        </li>
                    </ul>

                    <p class="mt-6 mb-2">Bilder hinzufügen:</p>
                    <input type="file" accept="image/*" multiple>
                </div>


                <div class="grid grid-cols-3 gap-3 w-full max-w-3xl mx-auto flex-1 place-items-center">

                    <input type="text" placeholder="Bild-weiter"
                        class="col-start-2 row-start-1 w-40 min-w-0 p-2 border border-gray-300 rounded-md text-center">

                    <div id="picture_id" wire:model="picture_id"
                        class="col-start-2 row-start-2 border-2 border-gray-400 rounded-lg h-80 w-80 flex items-center justify-center bg-gray-50">
                        <p class="text-gray-500">Aktuelles Bild</p>
                    </div>

                    <input id="left_id" type="text" placeholder="Bild-links" wire:model="left_id"
                        class="col-start-1 row-start-2 w-40 min-w-0 p-2 border border-gray-300 rounded-md text-center">

                    <input id="right_id" type="text" placeholder="Bild-rechts" wire:model="right_id"
                        class="col-start-3 row-start-2 w-40 min-w-0 p-2 border border-gray-300 rounded-md text-center">

                    <input id="back_id" type="text" placeholder="Bild-unten" wire:model="back_id"
                        class="col-start-2 row-start-3 w-40 min-w-0 p-2 border border-gray-300 rounded-md text-center">

                </div>

            </div>

            <!-- Unten rechts -->
            <div class="flex justify-end gap-3 mt-8">
                <button wire:click="save" class="bg-gray-200 border rounded px-5 py-2 hover:bg-gray-300">
                    Speichern
                </button>

                <button class="bg-blue-600 text-white rounded px-5 py-2 hover:bg-blue-700">
                    Next →
                </button>
            </div>

        </div>

    </body>
</div>
