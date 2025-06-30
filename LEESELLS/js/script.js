function validateForm(){
    //Getting the values
let username=document.getElementById("username").value.trim();
let email=document.getElementById("email").value.trim();
let password=document.getElementById("password").value.trim();
 
//Get error messages
let userNameError =document.getElementById("userNameError");
let emailError =document.getElementById("emailError");
let passwordError =document.getElementById("passwordError");
 
//clear Errors
userNameError.innerHTML="";
emailError.innerHTML="";
passwordError.innerHTML="";
let isValid=true;
if(username===""){
    userNameError.innerHTML="Username is required";
    isValid=false;
}
let emailPattern=/^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
if(email===""){
    emailError.innerHTML="Email is required";
    isValid=false;
}else if(!email.match(emailPattern)){
    emailError.innerHTML="invalid email format";
    isValid=false;
}
 
if(password===""){
    passwordError.innerHTML="Password is required";
    isValid=false;
}else if(password.length<6){
    passwordError.innerHTML="Password must be at least 6 characters long";
    isValid=false;
}
 
return isValid;
}



function validateLoginForm(){
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    let userNameError = document.getElementById("emailError");
    let passwordError = document.getElementById("passwordError");

    emailError.innerHTML = "";
    passwordError.innerHTML = "";
    let isValid = true;

    if(email === ""){
        emailError.innerHTML = "email is required";
    }

    if (password === ""){
        passwordError.innerHTML = "Password if required";
        isValid = false;
    }

    return isValid;
}

window.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  if (params.get('registered') === '1') {
    const notification = document.createElement('div');
    notification.textContent = 'Account created successfully! Please log in.';
    notification.classList.add('notification-success'); // Use your CSS class

    // Optional inline styles if you don't have CSS class
    notification.style.backgroundColor = '#d4edda';
    notification.style.color = '#155724';
    notification.style.padding = '10px';
    notification.style.marginBottom = '15px';
    notification.style.border = '1px solid #c3e6cb';
    notification.style.borderRadius = '5px';
    notification.style.textAlign = 'center';

    const form = document.querySelector('.modern-form');
    if (form) {
      form.prepend(notification);
    }
  }
});

//Show password
document.addEventListener('DOMContentLoaded', function() {
  // Use closest so it works even if you have more than one password field in the future
  document.querySelectorAll('.password-toggle').forEach(function(toggleBtn) {
    toggleBtn.addEventListener('click', function(e) {
      e.preventDefault();
      // Find the input just before the button
      const passwordInput = toggleBtn.parentElement.querySelector('input[type="password"], input[type="text"]');
      if (passwordInput) {
        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          // Optionally: toggle an 'active' class or swap the SVG for an "eye-off" icon
        } else {
          passwordInput.type = "password";
        }
      }
    });
  });
});



//LOGED IN SUCCESSFULY NOTIFICATION
window.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  if (params.get('login') === 'success') {
    const notification = document.createElement('div');
    notification.textContent = 'Login successful! Welcome back.';
    notification.classList.add('notification-success'); // Define this class in CSS

    // Optional inline styles
    notification.style.backgroundColor = '#d4edda';
    notification.style.color = '#155724';
    notification.style.padding = '10px';
    notification.style.marginBottom = '15px';
    notification.style.border = '1px solid #c3e6cb';
    notification.style.borderRadius = '5px';
    notification.style.textAlign = 'center';

    // Insert notification somewhere visible, e.g., top of the page
    document.body.prepend(notification);

    // Optionally remove notification after a few seconds
    setTimeout(() => notification.remove(), 5000);
  }
});
