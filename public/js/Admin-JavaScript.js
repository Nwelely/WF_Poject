function toggleMainMenu(menuId) {
    const submenus = document.querySelectorAll('.submenu');
    submenus.forEach(menu => {
        if (menu.id === menuId) {
            menu.classList.toggle('open');
        } else {
            menu.classList.remove('open');
        }
    });
}

function toggleVisibility(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        const isVisible = container.classList.contains('hidden');

       
        const allContainers = document.querySelectorAll('.action-container, .container');
        allContainers.forEach(cont => {
            if (cont.id !== containerId && cont.id !== 'admin_Panel') {
                cont.classList.add('hidden');
            }
        });

        
        container.classList.toggle('hidden');

        
        const submenuLinks = container.querySelectorAll('.submenu-link');
        submenuLinks.forEach(link => {
            link.addEventListener('mouseenter', () => {
                if (!isVisible) {
                    container.classList.add('open');
                }
            });
            link.addEventListener('mouseleave', () => {
                if (!isVisible) {
                    container.classList.remove('open');
                }
            });
            link.addEventListener('click', (event) => {
                event.preventDefault();
            });
        });
    }
}



let selectedProductId = null;
async function selectProduct(productId) {
    selectedProductId = productId;

    await fetch(`/auth/product/${productId}`)
        .then(response => response.json())
        .then(product => {
            sessionStorage.setItem('selectedProduct', JSON.stringify(product));
            populateProductForms(product);
        })
        .catch(error => {
            console.error('Error fetching product data:', error);
        });
}


// Product
function populateProductForms(product) {
    document.getElementById('editProductName').value = product.productname;
    document.getElementById('newProductName').value = product.productname;
    document.getElementById('editproductId').value = product.id;
    document.getElementById('editproductPrice').value = product.price;
    document.getElementById('editproductImage').src = product.img || 'default-image.png';

    document.getElementById('removeProductName').value = product.productname;
    document.getElementById('removeProductId').value = product.id;
}


function getUserData(userId) {
    // Fetch user data using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "show_user.php?view=" + userId, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Display the user data
            document.getElementById("user-details").innerHTML = xhr.responseText;
            document.getElementById("Userview").classList.remove("hidden"); // Show user details
        }
    };
    xhr.send();
}

// user
function viewUser(userId) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "show_user.php?view=" + userId, true); // Send GET request to fetch user data

    xhr.onload = function() {
        console.log("Response Text:", xhr.responseText); // Log the raw response text

        if (xhr.status === 200) {
            try {
                const userData = JSON.parse(xhr.responseText); // Parse the JSON response

                // Check if userData has valid properties
                if (userData && !userData.error) {
                    // Update the HTML elements with user data
                    document.getElementById('viewImage').src = userData.img || 'default_image.png'; // Fallback image
                    document.getElementById('viewUsername').innerText = userData.username || 'N/A';
                    document.getElementById('viewFullName').innerText = userData.fullname || 'N/A';
                    document.getElementById('viewEmail').innerText = userData.useremail || 'N/A';
                    document.getElementById('viewPhone').innerText = userData.userphone || 'N/A';
                    document.getElementById('viewRole').innerText = userData.role || 'N/A';
                    document.getElementById('viewGender').innerText = userData.gender || 'N/A';
                    document.getElementById('viewAge').innerText = userData.age || 'N/A';
                    document.getElementById('viewAddress').innerText = userData.address || 'N/A';
                    document.getElementById('viewSubscription').innerText = userData.subscription || 'N/A';

                    // Show the user details container
                    toggleVisibility('ViewUserContainer');
                } else {
                    console.error("User data not found:", userData.error || "Unknown error");
                }
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        } else {
            console.error("Error fetching user data: ", xhr.status, xhr.statusText);
        }
    };

    xhr.onerror = function() {
        console.error("Request failed"); // Log if the request fails
    };

    xhr.send(); // Send the request
}



function editUser() {
    const user = JSON.parse(sessionStorage.getItem('selectedUser'));

    document.getElementById('editUsersName').value = user.username;
    document.getElementById('newUsersFullName').value = user.fullname;
    document.getElementById('UsersPassword').value = user.password; 
    document.getElementById('userphone').value = user.userphone;
    document.getElementById('edituseremail').value = user.useremail;
    document.getElementById('editUsersrole').value = user.role;
    document.getElementById('edit-gender').value = user.gender;
    document.getElementById('editUsersage').value = user.age;
    document.getElementById('editUsersaddress').value = user.address;
    console.log(user.Subscription)
    document.getElementById('edit-subscribtion').value = user.Subscription;

    document.getElementById('editUserContainer').classList.remove('hidden');
}

function removeUser() {
    // Retrieve selected user from sessionStorage
    const user = JSON.parse(sessionStorage.getItem('selectedUser'));

    // Check if user data is available
    if (user) {
        // Populate the form fields with the selected user's data
        document.getElementById('removeUsersName').value = user.username;
        document.getElementById('removeUsersId').value = user.id; // Assuming 'id' is the correct key

        // Show the remove user container
        document.getElementById('removeUserContainer').classList.remove('hidden');

        // Set the global selectedUserId variable
        window.selectedUserId = user.id; // Set the global variable for use in the delete request
    } else {
        console.error("No user selected.");
    }
}



// Event listener for editing user form
document.getElementById('editUsersForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    await fetch(`/auth/user/${selectedUserId}`, {
        method: 'PUT',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            alert(data.message);
            toggleVisibility('editUserContainer');
        }
    })
    .catch(error => {
        console.error('Error updating user:', error);
        alert('An error occurred while updating the user.');
    });
});

// Event listener for removing user form
document.getElementById('removeUsersForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    await fetch(`/auth/user/${selectedUserId}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            alert(data.message);
            toggleVisibility('removeUserContainer');
            // Optionally, you might want to refresh the user list or redirect
        }
    })
    .catch(error => {
        console.error('Error deleting user:', error);
    });
});



const notyf = new Notyf({
    position: {
        x: 'right', // 'left' or 'right' or 'center'
        y: 'top', // 'top' or 'bottom'
    },
});

// Edit Exercise
async function editExercise() {
    const editExerciseName = document.getElementById('editExerciseName').value;
    const newExerciseName = document.getElementById('newExerciseName').value;
    const exercisedescription = document.getElementById('exercisedescription').value;
    const exerciseimage = document.getElementById('exerciseimage').value;
    const Exercisetype = document.getElementById('Exercisetype').value;

    const exerciseData = {
        editExerciseName,
        newExerciseName,
        exercisedescription,
        exerciseimage,
        Exercisetype
    };

    await fetch('/auth/editexercise', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(exerciseData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                notyf.error(data.error);
            } else {
                notyf.success(data.message);
                toggleVisibility('editExerciseContainer');
            }
        })
        .catch(error => {
            console.error('Error updating exercise:', error);
            notyf.error('An error occurred while updating the exercise.');
        });
}

// Remove Exercise
async function removeExercise() {
    const exerciseName = document.getElementById('removeExerciseName').value;

    await fetch('/auth/removeexercise', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ removeExerciseName: exerciseName })
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                notyf.error(data.error);
            } else {
                notyf.success(data.message);
                toggleVisibility('removeExerciseContainer');
            }
        })
        .catch(error => {
            console.error('Error removing exercise:', error);
            notyf.error('An error occurred while removing the exercise.');
        });
}

// Edit Meal
async function editMeal() {
    const editMealName = document.getElementById('editMealName').value;
    const newMealName = document.getElementById('newMealName').value;
    const newMealdescription = document.getElementById('newMealDescription').value;
    const newIngredients = [];
    document.querySelectorAll('#newIngredientsContainer .ingredient-group').forEach((group, index) => {
        const name = group.querySelector(`input[name="newIngredients[${index}][name]"]`).value;
        const quantity = group.querySelector(`input[name="newIngredients[${index}][quantity]"]`).value;
        newIngredients.push({ name, quantity });
    });

    const mealData = {
        editMealName,
        newMealName,
        newMealdescription,
        newIngredients
    };

    await fetch('/auth/editmeal', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(mealData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                notyf.error(data.error);
            } else {
                notyf.success(data.message);
                toggleVisibility('editMealContainer');
            }
        })
        .catch(error => {
            console.error('Error updating meal:', error);
            notyf.error('An error occurred while updating the meal.');
        });
}

// Remove Meal
async function removeMeal() {
    const mealName = document.getElementById('removeMealName').value;

    await fetch('/auth/removemeal', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ removeMealName: mealName })
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                notyf.error(data.error);
            } else {
                notyf.success(data.message);
                toggleVisibility('removeMealContainer');
            }
        })
        .catch(error => {
            console.error('Error removing meal:', error);
            notyf.error('An error occurred while removing the meal.');
        });
}

// Edit Product
async function editProduct() {
    const editProductName = document.getElementById('editProductName').value;
    const newProductName = document.getElementById('newProductName').value;
    const productId = document.getElementById('productId').value;
    const productPrice = document.getElementById('productPrice').value;

    const productData = {
        editProductName,
        newProductName,
        productId,
        productPrice
    };

    await fetch('/auth/editProduct', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(productData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                notyf.error(data.error);
            } else {
                notyf.success(data.message);
                toggleVisibility('editProductsContainer');
            }
        })
        .catch(error => {
            console.error('Error updating product:', error);
            notyf.error('An error occurred while updating the product.');
        });
}

// Remove Product
async function removeProduct() {
    const productName = document.getElementById('removeProductName').value;
    const productId = document.getElementById('removeProductId').value;

    try {
        const response = await fetch('/auth/removeProduct', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ removeProductName: productName, removeProductId: productId })
        });

        const data = await response.json();
        if (data.error) {
            notyf.error(data.error);
        } else {
            notyf.success(data.message);
            toggleVisibility('removeProductsContainer');
        }
    } catch (error) {
        console.error('Error removing product:', error);
        notyf.error('An error occurred while removing the product.');
    }
}


// Edit Coach
async function editCoach() {
    const editCoachName = document.getElementById('editCoachName').value;
    const newCoachName = document.getElementById('newCoachName').value;
    const coachDescription = document.getElementById('newCoachDescription').value;

    const coachData = {
        editCoachName,
        newCoachName,
        coachDescription
    };

    try {
        const response = await fetch('/auth/editcoaches', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(coachData)
        });

        const data = await response.json();
        if (data.error) {
            notyf.error(data.error);
        } else {
            notyf.success(data.message);
            toggleVisibility('editCoachesContainer');
        }
    } catch (error) {
        console.error('Error updating coach:', error);
        notyf.error('An error occurred while updating the coach.');
    }
}


// Remove Coach
async function removeCoach() {
    const coachName = document.getElementById('removeCoachName').value;

    try {
        const response = await fetch('/auth/removecoach', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ removeCoachName: coachName })
        });

        const data = await response.json();
        if (data.error) {
            notyf.error(data.error);
        } else {
            notyf.success(data.message);
            toggleVisibility('removeCoachesContainer');
        }
    } catch (error) {
        console.error('Error removing coach:', error);
        notyf.error('An error occurred while removing the coach.');
    }
}


// Form Submission Event Listeners
document.getElementById('editExerciseForm').addEventListener('submit', function (event) {
    event.preventDefault();
    editExercise();
});

document.getElementById('removeExerciseForm').addEventListener('submit', function (event) {
    event.preventDefault();
    removeExercise();
});

document.getElementById('editMealForm').addEventListener('submit', function (event) {
    event.preventDefault();
    editMeal();
});

document.getElementById('removeMealForm').addEventListener('submit', function (event) {
    event.preventDefault();
    removeMeal();
});

document.getElementById('editProductForm').addEventListener('submit', function (event) {
    event.preventDefault();
    editProduct();
});

document.getElementById('removeProductForm').addEventListener('submit', function (event) {
    event.preventDefault();
    removeProduct();
});

document.getElementById('editCoachForm').addEventListener('submit', function (event) {
    event.preventDefault();
    editCoach();
});

document.getElementById('removeCoachForm').addEventListener('submit', function (event) {
    event.preventDefault();
    removeCoach();
});


document.getElementById('addProductForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    await fetch('/auth/addProduct', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                notyf.error(data.error);
            } else {
                notyf.success('Product added successfully');
                document.getElementById('addProductForm').reset();
            }
        })
        .catch(error => {
            console.error('Error adding product:', error);
            notyf.error('An error occurred while adding the product.');
        });
});
document.getElementById('addCoachForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    await fetch('/auth/addcoaches', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                notyf.error(data.error);
            } else {
                notyf.success('Coach added successfully');
                document.getElementById('addCoachForm').reset();
            }
        })
        .catch(error => {
            console.error('Error adding coach:', error);
            notyf.error('An error occurred while adding the coach.');
        });
});


document.getElementById('addMealForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    try {
        const response = await fetch('/auth/addmeal', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();
        if (response.ok) {
            notyf.success(result.message);  // Show success notification
        } else {
            notyf.error(result.error);  // Show error notification
        }
    } catch (error) {
        console.error('Error:', error);
        notyf.error('An error occurred while adding the meal.');  // Show error notification
    }
});

document.getElementById('addExerciseForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);

    try {
        const response = await fetch('/auth/addexercise', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();
        if (response.ok) {
            notyf.success(result.message);  // Show success notification
        } else {
            notyf.error(result.error);  // Show error notification
        }
    } catch (error) {
        console.error('Error:', error);
        notyf.error('An error occurred while adding the exercise.');  // Show error notification
    }
});























// Product Form Validation
function validateForm() {
    const productNameInput = document.getElementById('productName');
    const productPriceInput = document.getElementById('productPrice');
    const productName = productNameInput.value.trim();
    const productPrice = productPriceInput.value.trim();
    let isValid = true;

    document.getElementById('productNameError').textContent = '';
    document.getElementById('productPriceError').textContent = '';

    if (productName === '') {
        document.getElementById('productNameError').textContent = 'Product name is required';
        isValid = false;
    } else if (!/^[a-zA-Z]+$/.test(productName)) {
        document.getElementById('productNameError').textContent = 'Product name must contain only letters';
        isValid = false;
    }

    if (productPrice === '') {
        document.getElementById('productPriceError').textContent = 'Product price is required';
        isValid = false;
    } else if (isNaN(productPrice) || parseFloat(productPrice) <= 0) {
        document.getElementById('productPriceError').textContent = 'Product price must be a valid positive number';
        isValid = false;
    }

    if (isValid) {
        productNameInput.value = '';
        productPriceInput.value = '';
        document.getElementById('successMessage').textContent = 'Product Added';
    }

    return isValid;
}

// Coach Form Validation
function validateCoachForm() {
    const coachNameInput = document.getElementById('coachName');
    const coachSpecialtyInput = document.getElementById('coachSpecialty');
    const coachName = coachNameInput.value.trim();
    const coachSpecialty = coachSpecialtyInput.value.trim();
    let isValid = true;

    document.getElementById('coachNameError').textContent = '';
    document.getElementById('coachSpecialtyError').textContent = '';

    if (coachName === '') {
        document.getElementById('coachNameError').textContent = 'Coach name is required';
        isValid = false;
    } else if (!/^[a-zA-Z\s]+$/.test(coachName)) {
        document.getElementById('coachNameError').textContent = 'Coach name must contain only letters';
        isValid = false;
    }

    if (coachSpecialty === '') {
        document.getElementById('coachSpecialtyError').textContent = 'Coach specialty is required';
        isValid = false;
    } else if (!/^[a-zA-Z\s]+$/.test(coachSpecialty)) {
        document.getElementById('coachSpecialtyError').textContent = 'Coach specialty must contain only letters';
        isValid = false;
    }

    if (isValid) {
        coachNameInput.value = '';
        coachSpecialtyInput.value = '';
        document.getElementById('coachSuccessMessage').textContent = 'Coach Added';
    }

    return isValid;
}

// Edit Coach Form Validation
function validateEditCoachForm() {
    const editCoachNameInput = document.getElementById('editCoachName');
    const editCoachSpecialtyInput = document.getElementId('editCoachSpecialty');
    const newCoachNameInput = document.getElementId('newCoachName');
    const newCoachSpecialtyInput = document.getElementId('newCoachSpecialty');
    const editCoachName = editCoachNameInput.value.trim();
    const editCoachSpecialty = editCoachSpecialtyInput.value.trim();
    const newCoachName = newCoachNameInput.value.trim();
    const newCoachSpecialty = newCoachSpecialtyInput.value.trim();
    let isValid = true;

    document.getElementById('editCoachNameError').textContent = '';
    document.getElementById('editCoachSpecialtyError').textContent = '';
    document.getElementById('newCoachNameError').textContent = '';
    document.getElementById('newCoachSpecialtyError').textContent = '';
    document.getElementById('editCoachSuccessMessage').textContent = '';

    if (editCoachName === '') {
        document.getElementById('editCoachNameError').textContent = 'Coach name is required';
        isValid = false;
    } else if (!/^[a-zA-Z\s]+$/.test(editCoachName)) {
        document.getElementById('editCoachNameError').textContent = 'Coach name must contain only letters';
        isValid = false;
    }

    if (editCoachSpecialty === '') {
        document.getElementById('editCoachSpecialtyError').textContent = 'Coach specialty is required';
        isValid = false;
    } else if (!/^[a-zA-Z\s]+$/.test(editCoachSpecialty)) {
        document.getElementById('editCoachSpecialtyError').textContent = 'Coach specialty must contain only letters';
        isValid = false;
    }

    if (newCoachName === '') {
        document.getElementById('newCoachNameError').textContent = 'New name is required';
        isValid = false;
    } else if (!/^[a-zA-Z\s]+$/.test(newCoachName)) {
        document.getElementById('newCoachNameError').textContent = 'New name must contain only letters';
        isValid = false;
    } else if (newCoachName.toLowerCase() === editCoachName.toLowerCase()) {
        document.getElementById('newCoachNameError').textContent = 'New name must be different from the coach name';
        isValid = false;
    }

    if (newCoachSpecialty === '') {
        document.getElementById('newCoachSpecialtyError').textContent = 'New specialty is required';
        isValid = false;
    } else if (!/^[a-zA-Z\s]+$/.test(newCoachSpecialty)) {
        document.getElementById('newCoachSpecialtyError').textContent = 'New specialty must contain only letters';
        isValid = false;
    } else if (newCoachSpecialty.toLowerCase() === editCoachSpecialty.toLowerCase()) {
        document.getElementById('newCoachSpecialtyError').textContent = 'New specialty must be different from the current one';
        isValid = false;
    }

    if (isValid) {
        editCoachNameInput.value = '';
        editCoachSpecialtyInput.value = '';
        newCoachNameInput.value = '';
        newCoachSpecialtyInput.value = '';
        document.getElementById('editCoachSuccessMessage').textContent = 'Edited Successfully';
    }

    return isValid;
}

// Remove Coach Form Validation
async function validateremoveCoachForm() {
    const coachNameInput = document.getElementById('removeCoachName');
    const coachName = coachNameInput.value.trim();
    let isValid = true;

    document.getElementById('removeCoachNameError').textContent = '';

    if (coachName === '') {
        document.getElementById('removeCoachNameError').textContent = 'Coach name is required';
        isValid = false;
    } else if (!/^[a-zA-Z\s]+$/.test(coachName)) {
        document.getElementById('removeCoachNameError').textContent = 'Coach name must contain only letters';
        isValid = false;
    }

    if (isValid) {
        // Send the form data to the server using fetch
        await fetch('/auth/removecoach', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ removeCoachName: coachName })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                console.log('Server response:', data);
                document.getElementById('removeCoachSuccessMessage').textContent = 'Coach Removed';
                coachNameInput.value = '';
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }

    return isValid;
}

// Remove Product Form Validation
function validateremoveProductForm() {
    const productNameInput = document.getElementById('removeProductName');
    const productName = productNameInput.value.trim();
    let isValid = true;

    document.getElementById('removeProductNameError').textContent = '';

    if (productName === '') {
        document.getElementById('removeProductNameError').textContent = 'Product name is required';
        isValid = false;
    } else if (!/^[a-zA-Z\s]+$/.test(productName)) {
        document.getElementById('removeProductNameError').textContent = 'Product name must contain only letters';
        isValid = false;
    }

    if (isValid) {
        productNameInput.value = '';
        document.getElementById('removeProductSuccessMessage').textContent = 'Product Removed';
    }

    return isValid;
}

function validateEditProductForm() {
    const editProductNameInput = document.getElementById('editProductName');
    const newProductNameInput = document.getElementById('newProductName');
    const editProductName = editProductNameInput.value.trim();
    const newProductName = newProductNameInput.value.trim();
    let isValid = true;

    document.getElementById('editProductNameError').textContent = '';
    document.getElementById('newProductNameError').textContent = '';
    document.getElementById('editProductSuccessMessage').textContent = '';

    if (editProductName === '') {
        document.getElementById('editProductNameError').textContent = 'Product name is required';
        isValid = false;
    } else if (!/^[a-zA-Z]+$/.test(editProductName)) {
        document.getElementById('editProductNameError').textContent = 'Product name must contain only letters';
        isValid = false;
    }

    if (newProductName === '') {
        document.getElementById('newProductNameError').textContent = 'New name is required';
        isValid = false;
    } else if (!/^[a-zA-Z]+$/.test(newProductName)) {
        document.getElementById('newProductNameError').textContent = 'New name must contain only letters';
        isValid = false;
    } else if (newProductName.toLowerCase() === editProductName.toLowerCase()) {
        document.getElementById('newProductNameError').textContent = 'New name must be different from the product name';
        isValid = false;
    }

    if (isValid) {
        editProductNameInput.value = '';
        newProductNameInput.value = '';
        document.getElementById('editProductSuccessMessage').textContent = 'Edited Successfully';
    }

    return isValid;
}


let ingredientIndex = 1;
function addIngredient() {
    const container = document.getElementById('ingredientsContainer');
    const newIngredientGroup = document.createElement('div');
    newIngredientGroup.className = 'ingredient-group';
    newIngredientGroup.innerHTML = `
        <input type="text" name="ingredients[${ingredientIndex}][name]" placeholder="Ingredient Name" required>
        <input type="text" name="ingredients[${ingredientIndex}][quantity]" placeholder="Quantity" required>
        <button type="button"   class="remove-button" onclick="removeIngredient(this)">-</button>
    `;
    container.appendChild(newIngredientGroup);
    ingredientIndex++;
}

function removeIngredient(button) {
    const container = document.getElementById('ingredientsContainer');
    container.removeChild(button.parentElement);
}

let newIngredientIndex = 1;
function addNewIngredient() {
    const container = document.getElementById('newIngredientsContainer');
    const newIngredientGroup = document.createElement('div');
    newIngredientGroup.className = 'ingredient-group';
    newIngredientGroup.innerHTML = `
        <input type="text" name="newIngredients[${newIngredientIndex}][name]" placeholder="Ingredient Name" required>
        <input type="text" name="newIngredients[${newIngredientIndex}][quantity]" placeholder="Quantity" required>
        <button type="button"   class="remove-button" onclick="removeNewIngredient(this)">-</button>
    `;
    container.appendChild(newIngredientGroup);
    newIngredientIndex++;
}

function removeNewIngredient(button) {
    const container = document.getElementById('newIngredientsContainer');
    container.removeChild(button.parentElement);
}




function toggleStatsContainer() {
    const statsContainer = document.getElementById('stats_Container');

    if (isStatsContainerMiddle) {
        statsContainer.classList.remove('middle');
        isStatsContainerMiddle = false;
        isStatsContainerRight = false;
    } else if (isStatsContainerRight) {
        statsContainer.classList.remove('right');
        statsContainer.classList.add('middle');
        isStatsContainerMiddle = true;
    } else {
        statsContainer.classList.add('right');
        isStatsContainerRight = true;
    }
}



document.addEventListener('DOMContentLoaded', function () {
    const isDarkMode = localStorage.getItem('darkModeEnabled') === 'true';
    const darkModeButton = document.querySelector('.darkmode-button');

    if (isDarkMode) {
        document.body.classList.add('dark-mode');
        darkModeButton.textContent = 'Light Mode';
    } else {
        document.body.classList.remove('dark-mode');
        darkModeButton.textContent = 'Dark Mode';
    }
});