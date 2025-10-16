
function fetch_select_userEmail(userID){
    $.ajax({
        type:'post', url:'../include/reg__ajax.php',
        data:{get_userEmail:userID},
        success:function(response){
            document.getElementById("email").value=response;
        }
    });
}
 
function fetch_select_projectContact(projectID, contactID){
    $.ajax({
        type:'post', url:'../include/reg__ajax.php',
        data:{get_projectContacts:projectID, contactPerson: contactID},
        success:function(response){
            document.getElementById("contact_person").innerHTML=response;
        }
    });
}