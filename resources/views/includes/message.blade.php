@if(session('error'))
    <div id="error-message" class="fixed top-4 right-4 px-4 py-2 bg-white shadow-custom text-[#E51F1F] rounded-2xl flex items-center gap-1">
        <img src="{{ asset('img/error.svg') }}" alt="">{{ session('error') }}</div>
@endif
@if(session('message'))
    <div id="error-message" class="fixed top-4 right-4 px-4 py-2 bg-white shadow-custom text-[#32C352] rounded-2xl flex items-center gap-1">
        <img src="{{ asset('img/message.svg') }}" alt="">{{ session('message') }}</div>
@endif
<script>
    const errorMessage = document.getElementById('error-message');

    if (errorMessage) {
        setTimeout(() => {
            errorMessage.classList.add('invisible');
        }, 3000);
    }
</script>
