const API_URL = "http://localhost:8000/api/people";
const form = document.getElementById("personForm");
const list = document.getElementById("peopleList");
const submitButton = form.querySelector('button[type="submit"]');

const disableButton = (button) => {
    button.disabled = true;
    button.innerHTML = "Carregando...";
};

const getPeople = async () => {
    const res = await fetch(API_URL);
    const people = await res.json();

    list.innerHTML = "";
    people.data.forEach((person) => {
        const li = document.createElement("li");
        li.dataset.id = person.id;
        li.innerHTML = `
            <input type="text" value="${person.name}" class="name">
            <input type="text" value="${person.cpf}" class="cpf">
            <input type="date" value="${
                person.birth_date || ""
            }" class="birth_date">
            <input type="age" value="${person.age || ""}" class="age">
            <button class="update">Salvar</button>
            <button class="delete">Excluir</button>
        `;
        list.appendChild(li);
    });
};

const addPeople = async () => {
    const name = document.getElementById("name").value;
    const cpf = document.getElementById("cpf").value;
    const birth_date = document.getElementById("birth_date").value;

    const res = await fetch(API_URL, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ name, cpf, birth_date }),
    });

    if (res.ok) {
        form.reset();
        fetchPeople();
    } else {
        const error = await res.json();
        alert(error.message || error.error || "Erro ao adicionar pessoa.");
        fetchPeople();
    }
};

async function fetchPeople() {
    list.innerHTML = "Carregando";
    disableButton(submitButton);

    try {
        getPeople();
    } catch (err) {
        console.error(err);
        alert("Erro ao buscar pessoas.");
    } finally {
        submitButton.textContent = "Adicionar Pessoa";
        submitButton.disabled = false;
    }
}

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    list.innerHTML = "Carregando";
    disableButton(submitButton);

    try {
        addPeople();
    } catch (err) {
        alert(err.message || "Erro ao adicionar pessoa.");
        fetchPeople();
    }
});

const updatePeople = async (li) => {
    list.innerHTML = "Carregando";
    const id = li.dataset.id;
    const updatedData = {
        name: li.querySelector(".name").value,
        cpf: li.querySelector(".cpf").value,
        birth_date: li.querySelector(".birth_date").value,
    };

    const res = await fetch(`${API_URL}/${id}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(updatedData),
    });

    if (res.ok) {
        fetchPeople();
    } else {
        const error = await res.json();
        alert(error.message || "Erro ao atualizar pessoa.");
    }
};

const deletePeople = async (id) => {
    if (confirm("Deseja realmente excluir?")) {
        list.innerHTML = "Carregando";
        await fetch(`${API_URL}/${id}`, { method: "DELETE" });
        fetchPeople();
    }
};

list.addEventListener("click", async (e) => {
    const li = e.target.closest("li");
    const id = li.dataset.id;

    if (e.target.classList.contains("delete")) {
        deletePeople(id);
    }

    if (e.target.classList.contains("update")) {
        try {
            updatePeople(li);
        } catch (err) {
            console.error(err);
            fetchPeople();
        }
    }
});

fetchPeople();
