const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const urlUpdate = document.querySelector('meta[name="app-url-update"]').getAttribute('content').slice(0, -1);

function sendUpdate(field) {
    const { name } = field.dataset;
    const value = field.tagName === "SELECT" ? field.value : field.textContent;
    const { userId } = field.closest('tr').dataset;
    const showError = field.closest('td');
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
            if (!response.ok) {
                throw new Error(response.status);
            }
            return response.json();
        })
        .then(({error}) => {
            if (error) {
                const error = document.createElement('p');
                styles = {
                    color: 'red',
                    margin: '0',
                    marginTop: '.5rem',
                    fontSize: '.9rem'
                }
                Object.assign(error.style, styles);
                showError.appendChild(error);

                setTimeout(error.remove(), 10000)
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
    field.addEventListener('change', (event) => {
        sendUpdate(event.target);
    });
})