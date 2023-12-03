function verif(){
    var email=document.getElementById("email").value;
    var errorText = document.getElementById('errorText');
    if (email === '') {
        errorText.textContent = 'Email cannot be empty.';
        return false;
    } else if (!email.includes('@')) {
        errorText.textContent = 'Invalid email format. Please include the "@" symbol.';
        return false;
    } else {
        errorText.textContent = '';
        return true;

    }
};