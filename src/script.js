function previewFile() {
    const preview = document.getElementById('previewImage');
    const file = document.querySelector('input[type=file]').files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "../images/coffee-svgrepo-com.svg";
    }
}
function addErrorState(element, message) {
    element.classList.add('border-red-500');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'text-red-500 text-xs';
    errorDiv.textContent = message;
    
    element.parentNode.insertBefore(errorDiv, element.nextSibling);
}


function removeErrorState(element) {
    element.classList.remove('border-red-500');
    const errorDiv = element.parentNode.querySelector('.text-red-500');
    if (errorDiv) errorDiv.remove();
}
function showMessage(message, duration = 1500) {
    if (divMessage) {
        divMessage.classList.remove('hidden');
        messages.textContent = message;
        setTimeout(() => {
            divMessage.classList.add('hidden');
        }, duration);
    }
}
