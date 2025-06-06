function renumber(type) {
    const items = document.querySelectorAll(`.${type}-item`);

    items.forEach((item, index) => {
        const newId = index + 1;
        item.id = `${type}-${newId}`;

        const numberSpan = item.querySelector(`.${type}-number`);
        if (numberSpan) {
            numberSpan.textContent = newId;
        }
    });

    // Optional: log total count
    // console.log(`Total ${type}s:`, items.length);
}

// Call renumber for all list types you want
["visitor", "session", "speaker", "moderator"].forEach(renumber);

// Example: get total tickets
const totalTickets = document.querySelectorAll(".visitor-item").length;
console.log("Total tickets:", totalTickets);

function addSession() {
    const container = document.getElementById("sessions-list");

    const inputGroup = document.createElement("div");

    fetch("/committee/render-session")
        .then((response) => response.text())
        .then((html) => {
            inputGroup.innerHTML = html;
            container.appendChild(inputGroup); // append only after innerHTML is set
            renumber("session"); // renumber after DOM is updated
        })
        .catch((error) => console.error("Error:", error));
}

function removeSession(button) {
    const inputGroup = button.closest(".session-item");
    inputGroup.remove();
}

function addSpeaker() {
    const container = document.getElementById("speakers-list");

    const inputGroup = document.createElement("div");

    fetch("/committee/render-speaker")
        .then((response) => response.text())
        .then((html) => {
            inputGroup.innerHTML = html;
            container.appendChild(inputGroup);
            renumber("speaker"); // renumber after DOM is updated
        })
        .catch((error) => console.error("Error:", error));
}

function removeSpeaker(button) {
    const inputGroup = button.closest(".speaker-item");
    inputGroup.remove();
}

function addModerator() {
    const container = document.getElementById("moderators-list");

    const inputGroup = document.createElement("div");

    fetch("/committee/render-moderator")
        .then((response) => response.text())
        .then((html) => {
            inputGroup.innerHTML = html;
            container.appendChild(inputGroup);
            renumber("moderator"); // renumber after DOM is updated
        })
        .catch((error) => console.error("Error:", error));
}

function removeModerator(button) {
    const inputGroup = button.closest(".moderator-item");
    inputGroup.remove();
}
