<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo List Reverb</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])

</head>

<body>
    <!-- Toast Notification -->
    <div id="toast" class="fixed top-5 right-5 max-w-sm w-full bg-white border border-gray-200 rounded-lg shadow-lg p-4 flex items-start space-x-4 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="flex-shrink-0">
            <!-- Ikon ceklis -->
            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="flex-1">
            <p id="toast-message" class="text-sm font-semibold text-gray-900" id="message">Successfully saved!</p>
            <p class="mt-1 text-sm text-gray-500">Anyone with a link can now view this file.</p>
        </div>
        <button class="text-gray-400 hover:text-gray-600">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div class="font-sans text-gray-900 antialiased">
        <div id="card" class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8f4f3]">
            <div>
                <a href="/">
                    <h2 class="font-bold text-3xl">Todo <span class="bg-[#f84525] text-white px-2 rounded-md">List</span>
                    </h2>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form id="form">
                    @csrf
                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="task" value="task" />
                        <input type='task' name='message' placeholder='Task' class="w-full rounded-md py-2.5 px-4 border text-sm outline-[#f84525]" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button id="submit" type="button" onclick="submitForm()" class="ms-4 inline-flex items-center px-4 py-2 bg-[#f84525] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Add Task
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        // menampilkan toast notifikasi
        function showToast(data) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').textContent = data.message;

            // Menampilkan toast dengan mengubah opacity
            toast.classList.remove('opacity-0');
            toast.classList.add('opacity-100');
            toast.classList.remove('pointer-events-none');

            // Menghilangkan toast setelah 3 detik
            setTimeout(() => {
                toast.classList.remove('opacity-100');
                toast.classList.add('opacity-0');
                toast.classList.add('pointer-events-none');
            }, 3000);
        }

        function submitForm() {
            const form = document.getElementById("form")
            var formData = new FormData(form);

            fetch("{{ route('sendMessage') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Terjadi kesalahan saat melakukan request.');
                    }
                    return response.text();

                })
                .then(result => {
                    const data = JSON.parse(result)
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // memanggil event SendMessage
        window.onload = function() {

            var channel = Echo.channel('channel-reverb');
            channel.listen("SendMessageEvent", function(data) {

                const card = document.getElementById("card")
                showToast(data);
                card.innerHTML += `<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <h1>${data.message}</h1>
                </div>`
            })


        }
    </script>
</body>

</html>
