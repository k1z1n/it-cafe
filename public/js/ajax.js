document.getElementById('sendSmsForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем стандартное действие отправки формы

    let form = this;
    let formData = new FormData(form);

    $.ajax({
        url: form.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.success) {
                document.getElementById('createModal').classList.add('hidden');
                document.getElementById('createSms').classList.remove('hidden');
            } else {
                document.getElementById('errorMessage').innerText = data.error || 'Ошибка отправки смс.';
            }
        },
        error: function (xhr, status, error) {
            document.getElementById('errorMessage').innerText = 'Ошибка при отправке формы: ' + error;
        }
    });
});
