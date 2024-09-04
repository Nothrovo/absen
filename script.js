document.addEventListener('DOMContentLoaded', function() {
    const absenTable = document.getElementById('absenTable').getElementsByTagName('tbody')[0];

    // Function to load attendance data
    function loadabsenData() {
        fetch('fetch_absen.php')
            .then(response => response.json())
            .then(data => {
                absenTable.innerHTML = ''; // Clear existing data

                data.forEach((row, index) => {
                    let newRow = absenTable.insertRow();
                    newRow.insertCell().textContent = index + 1;
                    newRow.insertCell().textContent = row.name;
                    newRow.insertCell().textContent = row.nim;
                    newRow.insertCell().textContent = row.status;

                    // Add a button for changing status
                    let statusCell = newRow.insertCell();
                    let statusButton = document.createElement('button');
                    statusButton.textContent = row.status === 'HADIR' ? 'ABSEN' : 'HADIR';
                    statusButton.dataset.id = row.id; // Store ID in data attribute
                    statusButton.addEventListener('click', updateStatus);
                    statusCell.appendChild(statusButton);
                });
            })
            .catch(error => console.error('Error loading data:', error));
    }

    // Function to update attendance status
    function updateStatus(event) {
        const id = event.target.dataset.id;
        const newStatus = event.target.textContent === 'HADIR' ? 'ABSEN' : 'HADIR';

        fetch('update_status.php', {
            method: 'POST',
            body: JSON.stringify({ id: id, status: newStatus })
        })
        .then(response => {
            // Refresh the data after update
            loadabsenData();
        })
        .catch(error => console.error('Error updating status:', error));
    }

    // Load initial data on page load
    loadabsenData();
});