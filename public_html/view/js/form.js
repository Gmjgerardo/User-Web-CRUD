// Verificar si se intenta modificar un usuario
parameters = new URLSearchParams(location.search);
isModification = parameters.get('id') ?? false;

// Obtener campos para validar
const form = document.getElementById('userForm');
const inputs = document.querySelectorAll('#userForm input');

// Variables de control para validación final
const fields = {
    names: isModification ? true : false,
    lastNames: isModification ? true : false,
    email: isModification ? true : false,
    username: isModification ? true : false,
    password: isModification ? true : false,
    confirm: isModification ? true : false
};

// Expresiones regulares para cada campo
const expressions = {
    username: /^[a-zA-Z0-9\_\-]{4,80}$/, // Letras, numeros, guion y guion_bajo
    name: /^[a-zA-ZÀ-ÿ\s]{2,50}$/, // Letras y espacios, pueden llevar acentos.
    password: /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/, // 7 a 15 digitos, al menos un numero y un caracter especial.
    email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/
}

// Agregar eventos de "escritura" para cada campo
inputs.forEach((inputField) => {
    inputField.addEventListener('keyup', validateForm);
    inputField.addEventListener('blur', validateForm);
});

// Validación al hacer click en el bóton
form.addEventListener('submit', (e) => {
    if (fields.names && fields.lastNames && fields.email && fields.username && fields.password && fields.confirm) {
        document.getElementById('formConfirmation').setAttribute("hidden", true);
    } else {
        e.preventDefault();
        document.getElementById('formConfirmation').removeAttribute("hidden");
    }
});

// Ejecutar la validación y cambios especificos para cada campo
const validateField = (expression, input, nameField) => {
    if (expression.test(input.value)) {
        input.classList.add('border', 'border-2', 'border-success');
        input.classList.remove('border-danger');

        let errorField = document.querySelector(`#${nameField}Field .input-error`) ?? null;

        if (errorField) {
            errorField.setAttribute("hidden", true);
        }

        fields[nameField] = true;
    } else {
        input.classList.add('border', 'border-danger');
        input.classList.remove('border-success');
        let errorField = document.querySelector(`#${nameField}Field .input-error`) ?? null;

        if (errorField) {
            errorField.removeAttribute("hidden");
        }

        fields[nameField] = false;
    }
}

// Verificar que ambos campos de contraseña sean iguales
const validateSamePasswords = () => {
    password = document.getElementById('password');
    confirm = document.getElementById('confirm');

    if (password.value == confirm.value) {
        document.getElementById('confirm').classList.add('border', 'border-2', 'border-success');
        document.getElementById('confirm').classList.remove('border-danger');
        document.querySelector('#confirmField .input-error').setAttribute('hidden', true);

        fields.confirm = true;
    } else {
        document.getElementById('confirm').classList.add('border', 'border-danger');
        document.getElementById('confirm').classList.remove('border-success');
        document.querySelector('#confirmField .input-error').removeAttribute('hidden');

        fields.confirm = false;
    }
}

// Funcion de validación de campos general (relación entre campos, pruebas y elementos html)
function validateForm(e) {
    switch (e.target.name) {
        case 'name':
            validateField(expressions.name, e.target, 'names');
            break;
        case 'fullLastName':
            validateField(expressions.name, e.target, 'lastNames');
            break;
        case 'email':
            validateField(expressions.email, e.target, 'email');
            break;
        case 'username':
            validateField(expressions.username, e.target, 'username');
            break;
        case 'password':
            validateField(expressions.password, e.target, 'password');
            validateSamePasswords();
            break;
        case 'confirm':
            validateSamePasswords();
            break;
    }
}
