let createUpdateProfile = document.getElementById('createUpdateProfile')
let updateProfile = document.getElementById('updateProfile')
let close = document.getElementById('close');
if (createUpdateProfile) {
    createUpdateProfile.addEventListener('click', function () {
        updateProfile.classList.remove('hidden');
    });
}

if (close) {
    close.addEventListener('click', function () {
        updateProfile.classList.add('hidden');
    });
}
if (updateProfile) {
    updateProfile.addEventListener('click', function (event) {
        if (event.target === this) {
            this.classList.add('hidden');
        }
    });
}
