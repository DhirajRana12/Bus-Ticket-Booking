// script.js

// document.addEventListener('DOMContentLoaded', function () {
//     const accountBtn = document.getElementById('accountBtn');
//     const accountModal = document.getElementById('accountModal');
//     const closeModal = document.querySelector('.close');
//     const loginForm = document.getElementById('loginForm');
//     const registerForm = document.getElementById('registerForm');
//     const showRegisterForm = document.getElementById('showRegisterForm');

//     // Open modal on account button click
//     accountBtn.addEventListener('click', () => {
//         accountModal.style.display = 'block';
//     });

//     // Close modal on close button click
//     closeModal.addEventListener('click', () => {
//         accountModal.style.display = 'none';
//     });

//     // Toggle to show registration form
//     showRegisterForm.addEventListener('click', (e) => {
//         e.preventDefault();
//         loginForm.style.display = 'none';
//         registerForm.style.display = 'block';
//     });

//     // Close modal if clicked outside
//     window.addEventListener('click', (event) => {
//         if (event.target === accountModal) {
//             accountModal.style.display = 'none';
//         }
//     });
// });


// Account dropdown and modal handling
document.getElementById('accountBtn').addEventListener('click', function () {
    const dropdown = document.querySelector('.dropdown-content');
    dropdown.classList.toggle('hidden');
});

// Login and Register modal toggling
document.getElementById('loginBtn').addEventListener('click', function () {
    document.getElementById('accountModal').classList.remove('hidden');
    document.getElementById('loginForm').classList.remove('hidden');
    document.getElementById('registerForm').classList.add('hidden');
});

document.getElementById('registerBtn').addEventListener('click', function () {
    document.getElementById('accountModal').classList.remove('hidden');
    document.getElementById('registerForm').classList.remove('hidden');
    document.getElementById('loginForm').classList.add('hidden');
});

document.querySelector('.close').addEventListener('click', function () {
    document.getElementById('accountModal').classList.add('hidden');
});

document.getElementById('showRegisterForm').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('loginForm').classList.add('hidden');
    document.getElementById('registerForm').classList.remove('hidden');
});

