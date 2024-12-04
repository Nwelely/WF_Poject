
let selectedUserId = null;
function selectUser(userId) {
    selectedUserId = userId;

    console.log(userId)
    fetch(`/auth/user/${userId}`)
        .then(response => response.json())
        .then(user => {
            sessionStorage.setItem('selectedUser', JSON.stringify(user));
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
}

function showVisaDetails() {
    document.querySelectorAll('.visa-details').forEach(function(visaDetail) {
        visaDetail.classList.add('hidden');
    });
    const visaSelect = document.getElementById('visaSelect');
    const selectedVisaIndex = visaSelect.value;
    if (selectedVisaIndex !== "") {
        document.getElementById('visaDetails' + selectedVisaIndex).classList.remove('hidden');
    }
}

function toggleEditFields(enable) {
    document.querySelectorAll('.profile-details input, .profile-details select').forEach(function(input) {
        input.classList.toggle('hidden', !enable);
    });


}

document.addEventListener("DOMContentLoaded", function () {
    const userId = document.querySelector('.profile-container').getAttribute('data-user-id');
    selectUser(userId);

    const workoutsButton = document.getElementById("workoutsButton");
    const mealsButton = document.getElementById("mealsButton");
    const subscriptionButton = document.getElementById("subscriptionButton");

    workoutsButton.addEventListener("click", function () {
        window.location.href = "/user/front-workout";
    });

    mealsButton.addEventListener("click", function () {
        window.location.href = "/user/meal";
    });

    subscriptionButton.addEventListener("click", function () {
        window.location.href = "/plans";
    });

    const editProfiletoDelete = document.getElementById('editProfiletoDelete');
    const deleteAccountButton = document.getElementById('deleteAccountButton');
    const editUserImage = document.getElementById('editUserImage');

    editProfiletoDelete.addEventListener('click', function () {
        toggleEditFields(true);
        editProfiletoDelete.classList.add('hidden');
        deleteAccountButton.classList.remove('hidden');
    });

    deleteAccountButton.addEventListener('click', function () {
        const confirmation = confirm('Are you sure you want to delete your account? This action cannot be undone.');
    
        if (confirmation) {
            console.log(selectedUserId);
            fetch(`/auth/user/${selectedUserId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '/auth/logout';
                } else {
                    console.error('Error deleting user data');
                }
            })
            .catch(error => {
                console.error('Error deleting user data:', error);
            });
        } else {
            
        }
    });

});
