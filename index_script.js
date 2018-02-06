function control(){
    var msg = "";
    if(document.form_sign_in.user.value == "") msg += "Write your first name please!";
    if(document.form_sign_in.pswd.value == "") msg += "\nWrite your password please!";
    if(msg != "") alert(msg);
    else document.form_sign_in.submit();
    }

function control_sign_up(){
    var msg = "";
    if(document.form_sign_up.new_nickname.value == "") msg += "Write your user nickname please!";
    if(document.form_sign_up.new_user.value == "") msg += "Write your user name please!";
    if(document.form_sign_up.new_pswd.value == "") msg += "\nWrite your password please!";
    if(document.form_sign_up.new_pswd.value != document.form_sign_up.new_pswd_confirm.value) msg += "\nThe Two Passwords don't match!";
    if(msg != "") alert(msg);
    else document.form_sign_up.submit();
    }

function main()
{
    
}
$(document).ready(main); 