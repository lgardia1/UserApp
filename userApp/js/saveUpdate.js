const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const urlUpdate = document.querySelector('meta[name="app-url-update"]').getAttribute('content').slice(0, -1);

function sendUpdate(field) {
    const { name } = field.dataset;
    const value = field.tagName === "SELECT" ? field.value : field.textContent;
    const { userId } = field.closest('tr').dataset;
    const url = urlUpdate+userId;
    
   fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': `${csrf}`
            },
            credentials: "include", // Habilita el envío de cookies
            body: JSON.stringify({
                [name]: value
            })
        })
        .then(response => {
            return response.json();
        })
        .then((data) => {
            if (data.error) {
                const error = document.createElement('div');
                error.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                                    `${data.error}`
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
                                 '</div>';

                const errorContainer = document.getElementById('error-container');

                errorContainer.appendChild(error);
                setTimeout(error.remove(), 100000)
            }else if(field.tagName === 'BUTTON'){
                field.value = data.user.email_verified_at;
            }
        })
        .catch(error => {
            console.error(error)
        })
}

document.querySelectorAll('.editable').forEach(field => {
    field.addEventListener('focus', function () {
        this.contentEditable = true;
    });

    field.addEventListener('blur', function () {
        this.contentEditable = false;
        this.textContent = this.textContent.trim();
        sendUpdate(this);
    })

    field.addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            this.blur();
        }
    })
});

document.querySelectorAll('.role-select').forEach(field => {
    field.addEventListener('change', function (event) {
        sendUpdate(event.target);
    });
})

document.querySelectorAll('.verfy-button').forEach(button => {
    button.addEventListener('click', function (event) {
        sendUpdate(event.target);
    });
})