let gallary_s_form = document.getElementById("gallary_s_form");
let gallary_picture_inp = document.getElementById("gallary_picture_inp");

//eventListener for Management Teams  form
gallary_s_form.addEventListener("submit", function (e1) {
    e1.preventDefault();
    add_image();
});

// add management team member function
function add_image() {
    let data = new FormData();
    data.append("picture", gallary_picture_inp.files[0]);
    data.append("add_image", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/gallary_crud.php", true);

    xhr.onload = function () {

        // show/hide modal
        var myModal = document.getElementById("gallary-s");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "invalid_image") {
            alert("error", "Only JPG and PNG images are allowed !!😢😢");
            gallary_picture_inp.value = "";
        } else if (this.responseText == "invalid_size") {
            alert("error", "Image should be less than 2MB !!😢😢");
            gallary_picture_inp.value = "";
        } else if (this.responseText == "upload_failed") {
            alert("error", "Image upload failed .. Server Down..!!😢😢");
            gallary_picture_inp.value = "";
        } else {
            alert("success", "New Image Added !!😄😄");
            gallary_picture_inp.value = "";
            get_gallaryImg();
        }
    };
    xhr.send(data);
}

//get team members function
function get_gallaryImg() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/gallary_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        document.getElementById("gallary-data").innerHTML = this.responseText;
    };
    xhr.send("get_gallaryImg");
}

//delete team member function
function delete_image(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/gallary_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert("success", "Image Removed !!😄😄");
            get_gallaryImg();
        } else {
            alert("error", "Sorry, Server Down !!😢😢");
        }
    };
    xhr.send("delete_image=" + val);
}

window.onload = function () {
    get_gallaryImg();
};
