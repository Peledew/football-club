// game-management.js

// Utility to format Date object to ISO (YYYY-MM-DD)
const formatDateToISO = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
};

// Utility to populate a select element and reinitialize MaterializeCSS
const populateSelect = (select, items) => {
    select.innerHTML = '<option value="" disabled selected>Select an option</option>';
    items.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name;
        select.appendChild(option);
    });
    M.FormSelect.init(select);
};

// Utility to fetch data from API and populate a select element
const fetchAndPopulateSelect = (url, select) => {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                populateSelect(select, data);
            } else {
                console.error(`Unexpected data format from ${url}:`, data);
            }
        })
        .catch(error => console.error(`Error fetching data from ${url}:`, error));
};

// Initialize selects with data fetched from API
const initializeSelects = () => {
    const homeClubSelect = document.getElementById('home_club_id');
    const guestClubSelect = document.getElementById('guest_club_id');
    const competitionSelect = document.getElementById('competition_id');

    fetchAndPopulateSelect('/api/clubs', homeClubSelect);
    fetchAndPopulateSelect('/api/clubs', guestClubSelect);
    fetchAndPopulateSelect('/api/competitions', competitionSelect);
};

// Utility to handle API POST requests
const postData = (url, data, headers = {}) => {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            ...headers
        },
        body: JSON.stringify(data),
    });
};

// Attach event listener to the "Create" button
const initializeCreateGameButton = () => {
    const createButton = document.getElementById('create-game-button');

    createButton.addEventListener('click', () => {
        const dateOfEvent = document.getElementById('date_of_event').value;
        const competitionId = document.getElementById('competition_id').value;
        const homeClubId = document.getElementById('home_club_id').value;
        const guestClubId = document.getElementById('guest_club_id').value;

        const requestData = {
            date_of_event: dateOfEvent,
            competition_id: competitionId,
            home_club_id: homeClubId,
            guest_club_id: guestClubId,
        };

        postData(window.appRoutes.gamesStore, requestData, {
            'X-CSRF-TOKEN': window.appCsrfToken,
        })
            .then(response => {
                if (response.ok) {
                    window.location.href = window.appRoutes.gamesIndex;
                } else {
                    console.error('Error creating game:', response);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the game.');
            });
    });
};

// Initialize everything
document.addEventListener('DOMContentLoaded', () => {
    initializeSelects();

    const dateInput = document.getElementById('date_of_event');
    dateInput.addEventListener('change', (e) => {
        const selectedDate = new Date(e.target.value);
        e.target.value = formatDateToISO(selectedDate);
    });

    initializeCreateGameButton();
});
