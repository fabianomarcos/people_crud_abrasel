<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;

            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100vw;

            @media(max-width: 700px) {
                li {
                    flex-direction: column;
                }

                li input,
                .name,
                .cpf,
                .age {
                    width: 100%;
                    max-width: 100% !important;
                }
            }

            h1 {
                text-align: center;
            }

            form,
            ul {
                margin: 10px 0 20px;
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
                width: 80%;
            }

            input {
                padding: 8px;
                margin: 5px 0;
                width: 100%;
                box-sizing: border-box;
            }

            button {
                padding: 10px 15px;
                margin: 5px;
                border: none;
                background: #28a745;
                color: white;
                border-radius: 4px;
                cursor: pointer;
            }

            button.delete {
                background: #dc3545;
            }

            li {
                display: flex;
                justify-content: space-between;
                padding: 8px 0;
                border-bottom: 1px solid #ddd;
            }

            li input {
                width: auto;
                flex: 1;
                margin-right: 5px;
            }

            .name {
                max-width: 160px;
            }

            .cpf {
                max-width: 120px;
            }

            .age {
                max-width: 40px;
            }
    </style>
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

    <script>
        const API_URL = 'http://localhost:8000/api/people';
        const form = document.getElementById('personForm');
        const list = document.getElementById('peopleList');
        const submitButton = form.querySelector('button[type="submit"]');

        const disableButton = (button) => {
            button.disabled = true;
            button.innerHTML = "Carregando...";
        }




        async function fetchPeople() {
            list.innerHTML = 'Carregando';
            disableButton(submitButton)

            try {
                const res = await fetch(API_URL);
                const people = await res.json();

                list.innerHTML = "";
                people.data.forEach(person => {
                    const li = document.createElement('li');
                    li.dataset.id = person.id;
                    li.innerHTML = `
                        <input type="text" value="${person.name}" class="name">
                        <input type="text" value="${person.cpf}" class="cpf">
                        <input type="date" value="${person.birth_date || ''}" class="birth_date">
                        <input type="age" value="${person.age || ''}" class="age">
                        <button class="update">Salvar</button>
                        <button class="delete">Excluir</button>
                    `;
                    list.appendChild(li);
                });
            } catch (err) {
                console.error(err);
                alert('Erro ao buscar pessoas.');
            } finally {
                submitButton.textContent = 'Adicionar Pessoa';
                submitButton.disabled = false;
            }
        }

        form.addEventListener('submit', async e => {
            e.preventDefault();
            list.innerHTML = 'Carregando';

            const submitButton = form.querySelector('button[type="submit"]');
            disableButton(submitButton)

            const name = document.getElementById('name').value;
            const cpf = document.getElementById('cpf').value;
            const birth_date = document.getElementById('birth_date').value;
            try {
                const res = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name,
                        cpf,
                        birth_date
                    })
                });
                if (res.ok) {
                    form.reset();
                    fetchPeople();
                } else {
                    const error = await res.json();
                    alert(error.message || 'Erro ao adicionar pessoa.');
                }
            } catch (err) {
                console.error(err);
            }
        });

        list.addEventListener('click', async e => {
            const li = e.target.closest('li');
            const id = li.dataset.id;
            list.innerHTML = 'Carregando';

            if (e.target.classList.contains('delete')) {
                if (confirm('Deseja realmente excluir?')) {
                    await fetch(`${API_URL}/${id}`, {
                        method: 'DELETE'
                    });
                    fetchPeople();
                }
            }

            if (e.target.classList.contains('update')) {
                const updatedData = {
                    name: li.querySelector('.name').value,
                    cpf: li.querySelector('.cpf').value,
                    birth_date: li.querySelector('.birth_date').value
                };
                try {
                    const res = await fetch(`${API_URL}/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(updatedData)
                    });
                    if (res.ok) {
                        fetchPeople();
                    } else {
                        const error = await res.json();
                        alert(error.message || 'Erro ao atualizar pessoa.');
                    }
                } catch (err) {
                    console.error(err);
                }
            }
        });

        fetchPeople();
    </script>

</body>

</html>