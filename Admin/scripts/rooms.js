let add_room_form = document.getElementById("add_room_form");

add_room_form.addEventListener("submit", function (e) {
    e.preventDefault();
    add_rooms();
});

// add room function
function add_rooms() {
    let data = new FormData();
    data.append("add_room", "");
    data.append("name", add_room_form.elements["name"].value);
    data.append("area", add_room_form.elements["area"].value);
    data.append("price", add_room_form.elements["price"].value);
    data.append("quantity", add_room_form.elements["quantity"].value);
    data.append("adult", add_room_form.elements["adult"].value);
    data.append("children", add_room_form.elements["children"].value);
    data.append("desc", add_room_form.elements["desc"].value);

    let features = [];
    add_room_form.elements["features"].forEach((el) => {
        if (el.checked) {
            features.push(el.value);
        }
    });

    let facilities = [];
    add_room_form.elements["facilities"].forEach((el) => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });


    data.append("features", JSON.stringify(features)); //convert whole array into string types
    data.append("facilities", JSON.stringify(facilities));
    // data.append('categories',JSON.stringify(categories));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        // show/hide modal
        var myModal = document.getElementById("add-room");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success", "New Room Added !!😄😄");
            add_room_form.reset();
            get_all_rooms();
        } else {
            alert("error", "Server Down..!!😢😢");
            add_room_form.reset();
        }
    };
    xhr.send(data);
}

// getAll rooms function
function get_all_rooms() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        document.getElementById("room-data").innerHTML = this.responseText;
    };
    xhr.send("get_all_rooms");
}



let edit_room_form = document.getElementById("edit_room_form");

// room details fetch function
function edit_details(id) {
    // console.log(id);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        // console.log(JSON.parse(this.responseText));
        let data = JSON.parse(this.responseText);
        edit_room_form.elements["name"].value = data.roomdata.name;
        edit_room_form.elements["area"].value = data.roomdata.area;
        edit_room_form.elements["price"].value = data.roomdata.price;
        edit_room_form.elements["quantity"].value = data.roomdata.quantity;
        edit_room_form.elements["adult"].value = data.roomdata.adult;
        edit_room_form.elements["children"].value = data.roomdata.children;
        edit_room_form.elements["desc"].value = data.roomdata.description;
        edit_room_form.elements["room_id"].value = data.roomdata.id;

        edit_room_form.elements["features"].forEach((el) => {
            if (data.features.includes(Number(el.value))) {
                // facilities.push(el.value);
                el.checked = true;
            }
        });

        edit_room_form.elements["facilities"].forEach((el) => {
            if (data.facilities.includes(Number(el.value))) {
                // facilities.push(el.value);
                el.checked = true;
            }
        });
    };
    xhr.send("get_room=" + id);
}

// room details edit form
edit_room_form.addEventListener("submit", function (e) {
    e.preventDefault();
    submit_edit_room();
});

function submit_edit_room() {
    let data = new FormData();
    data.append("edit_room", "");
    data.append("room_id", edit_room_form.elements["room_id"].value);
    data.append("name", edit_room_form.elements["name"].value);
    data.append("area", edit_room_form.elements["area"].value);
    data.append("price", edit_room_form.elements["price"].value);
    data.append("quantity", edit_room_form.elements["quantity"].value);
    data.append("adult", edit_room_form.elements["adult"].value);
    data.append("children", edit_room_form.elements["children"].value);
    data.append("desc", edit_room_form.elements["desc"].value);

    let features = [];
    edit_room_form.elements["features"].forEach((el) => {
        if (el.checked) {
            features.push(el.value);
        }
    });

    let facilities = [];
    edit_room_form.elements["facilities"].forEach((el) => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });

    // let categories = [];
    // edit_room_form.elements['categories'].forEach(el =>{
    //     if(el.checked){
    //         categories.push(el.value);
    //     }
    // });

    data.append("features", JSON.stringify(features)); //convert whole array into string types
    data.append("facilities", JSON.stringify(facilities));
    // data.append('categories',JSON.stringify(categories));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        // show/hide modal
        var myModal = document.getElementById("edit-room");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success", "Room data edited !!😄😄");
            edit_room_form.reset();
            get_all_rooms();
        } else {
            alert("error", "Server Down..!!😢😢");
            add_room_form.reset();
        }
    };
    xhr.send(data);
}

// room status change function
function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert("success", "Status Toggled !!");
            get_all_rooms();
        } else {
            alert("error", "Status Toggled !!");
        }
    };
    xhr.send("toggle_status=" + id + "&value=" + val);
}


// remove room
function remove_room(room_id) {

    if(confirm("Are you Sure, you want to delete this Room ?? ")){

        let data = new FormData();
        data.append('room_id',room_id);
        data.append('remove_room','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms_crud.php", true);
        // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    
        xhr.onload = function () {
            if (this.responseText == 1) {
                alert("success", "Room Removed !!😄😄");
                get_all_rooms();
            } 
            else {
                alert('error','Room removal failed !! 😢😢');
            }
        };
        xhr.send(data);
    }

}








let add_image_form = document.getElementById("add_image_form");

add_image_form.addEventListener("submit", function (e) {
    e.preventDefault();
    add_image();
});

// add room image function
function add_image() {
    let data = new FormData();
    data.append('image', add_image_form.elements['image'].files[0]);
    data.append('room_id', add_image_form.elements['room_id'].value);
    data.append("add_image", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    xhr.onload = function () {
        if (this.responseText == "invalid_image") {
            alert("error", "Only JPG,WEBP and PNG images are allowed !!😢😢",'image-alert');
        } else if (this.responseText == "invalid_size") {
            alert("error", "Image should be less than 3MB !!😢😢",'image-alert');
        } else if (this.responseText == "upload_failed") {
            alert("error", "Image upload failed .. Server Down..!!😢😢",'image-alert');
        } else {
            alert("success", "New Image Added !!😄😄","image-alert");
            room_images(add_image_form.elements['room_id'].value,document.querySelector("#room-images .modal-title").innerText);
            add_image_form.reset();
        }
    };
    xhr.send(data);
}

// fetch room images and name with modal
function room_images(id,rname){
    document.querySelector("#room-images .modal-title").innerText = rname;
    add_image_form.elements['room_id'].value = id;

    add_image_form.elements['image'].value = '';

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        document.getElementById('room-image-data').innerHTML = this.responseText;
    };
    xhr.send('get_room_images='+id);

}

// delete image from room
function delete_room_image(img_id,room_id) {
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id',room_id);
    data.append('delete_room_image','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert("success", "Image Removed !!😄😄","image-alert");
            room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
        } 
        else {
            alert('error','Image removal failed !! 😢😢','image-alert');
            add_image_form.reset();
        }
    };
    xhr.send(data);
}

//set thumb image for room
function thumb_image(img_id,room_id) {
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id',room_id);
    data.append('thumb_image','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert("success", "Image Thumbnail Changed !! !!😄😄","image-alert");
            room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
        } 
        else {
            alert('error','Image Thumbnail Update failed !! 😢😢','image-alert');
            add_image_form.reset();
        }
    };
    xhr.send(data);
}



window.onload = function () {
    get_all_rooms();
};
