<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Live Code Editor</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Live Code Editor</h1>
            <div class="add-collaborator">
                <input type="text" id="collaboratorUser" placeholder="Agregar usuario del colaborador">
                <button id="addCollaboratorButton">Agregar</button>
            </div>
        </div>
        <h2>Tu grupo de trabajo:</h2>

        <div class="collaborators" id="collaboratorsContainer">
        </div>

        <div class="code-editor">
            <div class="code">
                <div class="html-code">
                    <h1><img src="images/html.png" alt="">HTML</h1>
                    <textarea id="htmlCode"></textarea>
                </div>
                <div class="css-code">
                    <h1><img src="images/CSS.png" alt="">CSS</h1>
                    <textarea id="cssCode"></textarea>
                </div>
                <div class="js-code">
                    <h1><img src="images/js.png" alt="">JS</h1>
                    <textarea id="jsCode" spellcheck="false"></textarea>
                </div>
                <button onclick="guardarCodigo()" class="boton-guardar">Guardar Código</button>
                </div>
            <iframe id="result"></iframe>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>
