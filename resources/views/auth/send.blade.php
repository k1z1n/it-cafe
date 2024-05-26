<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-80 justify-center items-center z-50">
    <div
        class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md transform translate-x-[-50%] translate-y-[-50%] relative left-1/2 top-1/2">
        <h1 class="text-3xl">Вход на сайт</h1>
        <button><img src="{{ asset('img/krest.svg') }}"
                                             class="absolute top-0 right-[-60px] z-[60] hover:scale-110 transition-all duration-150"
                                             alt=""></button>
        <form id="sendSmsForm" method="post" action="{{ route('auth.send') }}">
            @csrf
            <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Номер телефона:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required
                   class="tel mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <!-- Add a hidden input to store the formatted phone number -->
            <input type="hidden" id="telephone_edit" name="telephone_edit">
            <button id="sendSms" type="submit"
                    class="mt-4 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#E2E8F0FF] hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    disabled>Отправить код
            </button>
            <div id="errorMessage"></div>
        </form>
        <div>
            <div class="text-[10px] pt-2 text-center">Продолжая, вы соглашаетесь<a href="" class="ml-1 text-blue-600">со
                    сбором и обработкой персональных данных и пользовательским соглашением</a></div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", function () {
        [].forEach.call(document.querySelectorAll('.tel'), function (input) {
            var keyCode;

            function mask(event) {
                event.keyCode && (keyCode = event.keyCode);
                var pos = this.selectionStart;
                if (pos < 3) event.preventDefault();
                var matrix = "+7 (___) ___-__-__",
                    i = 0,
                    def = matrix.replace(/\D/g, ""),
                    val = this.value.replace(/\D/g, ""),
                    new_value = matrix.replace(/[_\d]/g, function (a) {
                        return i < val.length ? val.charAt(i++) || def.charAt(i) : a
                    });
                i = new_value.indexOf("_");
                if (i !== -1) {
                    i < 5 && (i = 3);
                    new_value = new_value.slice(0, i)
                }
                var reg = matrix.substr(0, this.value.length).replace(/_+/g,
                    function (a) {
                        return "\\d{1," + a.length + "}"
                    }).replace(/[+()]/g, "\\$&");
                reg = new RegExp("^" + reg + "$");
                if (!reg.test(this.value) || this.value.length < 5 || keyCode > 47 && keyCode < 58) this.value = new_value;
                if (event.type === "blur" && this.value.length < 5) this.value = "";

                // Check if the phone number is complete
                var isComplete = this.value.replace(/\D/g, '').length === 11;
                var sendSmsButton = document.getElementById('sendSms');

                // Update the button's disabled state and background color
                sendSmsButton.disabled = !isComplete;
                sendSmsButton.style.backgroundColor = isComplete ? 'rgb(59, 130, 246)' : 'rgb(226, 232, 240)'; // Original button color is 'rgb(59, 130, 246)'

                // Remove the country code and format the phone number
                if (isComplete) {
                    var formattedNumber = this.value.replace(/\D/g, '').slice(1);
                    // Set the value of the hidden input
                    document.getElementById('telephone_edit').value = formattedNumber;
                    console.log(formattedNumber)
                }
            }

            input.addEventListener("input", mask, false);
            input.addEventListener("focus", mask, false);
            input.addEventListener("blur", mask, false);
            input.addEventListener("keydown", mask, false);
        });
    });
</script>
