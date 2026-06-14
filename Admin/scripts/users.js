// getAll users function
function get_users() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        document.getElementById("users-data").innerHTML = this.responseText;
    };
    xhr.send("get_users");
}

// user status change function
function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert("success", "Status Toggled !!");
            get_users();
        } else {
            alert("error", "Server Down !!");
        }
    };
    xhr.send("toggle_status=" + id + "&value=" + val);
}


// remove user
function remove_user(user_id) {

    if(confirm("Are you Sure, you want to delete this user ?? ")){

        let data = new FormData();
        data.append('user_id',user_id);
        data.append('remove_user','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users_crud.php", true);
        // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    
        xhr.onload = function () {
            if (this.responseText == 1) {
                alert("success", "User Removed !!😄😄");
                get_users();
            } 
            else {
                alert('error','User removal failed !! 😢😢');
            }
        };
        xhr.send(data);
    }
}


//search user
function search_user(username){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        document.getElementById("users-data").innerHTML = this.responseText;
    };
    xhr.send("search_user&name="+username);
}

window.onload = function () {
    get_users();
};
