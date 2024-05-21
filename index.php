<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encriptar y Enviar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .hidden {
            display: none;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Encriptar mensaje</h2>
        <form id="encryptForm">
            <label for="key">Clave:</label>
            <input type="text" id="key" name="key" required autocomplete="off">
            <div id="keyError" class="error"></div>

            <label for="message">Mensaje:</label>
            <textarea id="message" name="message" required autocomplete="off"></textarea>
            <div id="messageError" class="error"></div>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required autocomplete="off">
            <div id="emailError" class="error"></div>

            <input type="submit" value="ENCRIPTAR Y ENVIAR">
        </form>

        <h2>Desencriptar Mensaje</h2>
        <form id="decryptForm" class="hidden">
            <label for="decryptKey">Clave:</label>
            <input type="text" id="decryptKey" name="key" required autocomplete="off">
            <div id="decryptKeyError" class="error"></div>

            <label for="encryptedMessage">Mensaje Encriptado:</label>
            <textarea id="encryptedMessage" name="encryptedMessage" required autocomplete="off"></textarea>
            <div id="encryptedMessageError" class="error"></div>

            <label for="decryptEmail">Correo Electrónico:</label>
            <input type="email" id="decryptEmail" name="email" required autocomplete="off">
            <div id="decryptEmailError" class="error"></div>

            <input type="submit" value="DESENCRIPTAR Y ENVIAR">
        </form>
    </div>

    <script>
        function validateForm(formId, keyId, messageId, emailId, keyErrorId, messageErrorId, emailErrorId) {
            const key = document.getElementById(keyId).value;
            const message = document.getElementById(messageId).value;
            const email = document.getElementById(emailId).value;

            const keyError = document.getElementById(keyErrorId);
            const messageError = document.getElementById(messageErrorId);
            const emailError = document.getElementById(emailErrorId);

            let isValid = true;

            // Reset errors
            keyError.textContent = '';
            messageError.textContent = '';
            emailError.textContent = '';

            // Validate key (only numbers)
            if (!/^\d+$/.test(key)) {
                keyError.textContent = 'La clave solo debe contener números.';
                isValid = false;
            }

            // Validate message (letters and spaces only)
            if (formId === 'encryptForm' && !/^[a-zA-Z\s]+$/.test(message)) {
                messageError.textContent = 'El mensaje solo debe contener letras y espacios.';
                isValid = false;
            }

            // Validate email (simple email format)
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                emailError.textContent = 'Ingrese un correo electrónico válido.';
                isValid = false;
            }

            return isValid;
        }

        document.getElementById('encryptForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (validateForm('encryptForm', 'key', 'message', 'email', 'keyError', 'messageError', 'emailError')) {
                const formData = new FormData(this);

                fetch('encrypt.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert('El mensaje ha sido enviado.');
                    document.getElementById('decryptForm').classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
            }
        });

        document.getElementById('decryptForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (validateForm('decryptForm', 'decryptKey', 'encryptedMessage', 'decryptEmail', 'decryptKeyError', 'encryptedMessageError', 'decryptEmailError')) {
                const formData = new FormData(this);

                fetch('decrypt.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>
</body>
</html>
