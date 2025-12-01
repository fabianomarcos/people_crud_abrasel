<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoas</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <h1>Cadastro de Pessoas</h1>



    <form id="personForm">
        <input type="text" id="name" placeholder="Nome" required>
        <input type="text" id="cpf" placeholder="CPF" required>
        <input type="date" id="birth_date" placeholder="Data de Nascimento" required>
        <button type="submit">Adicionar Pessoa</button>
    </form>


    <ul id="peopleList"></ul>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>