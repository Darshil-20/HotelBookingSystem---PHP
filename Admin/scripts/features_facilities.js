let feature_s_form = document.getElementById("feature_s_form");
let facility_s_form = document.getElementById("facility_s_form");

//eventListener for features section
feature_s_form.addEventListener("submit", function (e1) {
    e1.preventDefault();
    add_feature();
});

// add_feature function
function add_feature() {
    let data = new FormData();
    data.append("name", feature_s_form.elements['feature_name'].value);
    data.append("add_feature", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    xhr.onload = function () {
        // console.log(this.responseText);

        // show/hide modal
        var myModal = document.getElementById("features-s");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success", "New Feature Added !!😄😄");
            feature_s_form.elements['feature_name'].value = '';
            get_feature();
        } else {
            alert("error", "Server Down..!!😢😢");
            feature_s_form.elements['feature_name'].value = '';
        }
    };
    xhr.send(data);
}

//get feature function
function get_feature() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        document.getElementById("features-data").innerHTML = this.responseText;
    };
    xhr.send("get_feature");
}

//delete feature function
function delete_feature(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert("success", "Featured Removed !!😄😄");
            get_feature();
        } else if (this.responseText == 'room_added') {
            alert("error", "Feature is added in room !!😢😢");
        } else {
            alert("error", "Sorry, Server Down !!😢😢");
        }
    };
    xhr.send("delete_feature=" + val);
}





// eventListener for Facility section
facility_s_form.addEventListener('submit', function (e1) {
    e1.preventDefault();
    add_facility();
});

// add_Facility function
function add_facility() {
    let data = new FormData();
    data.append('name', facility_s_form.elements['facility_name'].value);
    data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
    data.append('desc', facility_s_form.elements['facility_desc'].value);
    data.append('add_facility', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/features_facilities_crud.php', true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    xhr.onload = function () {
        // console.log(this.responseText);

        // show/hide modal
        var myModal = document.getElementById('facility-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "invalid_image") {
            alert("error", "Only SVG images are allowed !!😢😢");
            facility_s_form.reset();
        } else if (this.responseText == "invalid_size") {
            alert("error", "Image should be less than 1MB !!😢😢");
            facility_s_form.reset();
        } else if (this.responseText == "upload_failed") {
            alert("error", "Image upload failed .. Server Down..!!😢😢");
            facility_s_form.reset();
        } else {
            alert("success", "New facility Added !!😄😄");
            facility_s_form.reset();
            get_facility();
        }
    };
    xhr.send(data);
}

// get Facility function
function get_facility() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        document.getElementById("facilities-data").innerHTML = this.responseText;
    };
    xhr.send("get_facility");
}

// //delete Facility function
function delete_facility(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert("success", "Facility Removed !!😄😄");
            get_facility();
        } else if (this.responseText == 'room_added') {
            alert("error", "Facility is added in room !!😢😢");
        } else {
            alert("error", "Sorry, Server Down !!😢😢");
        }
    };
    xhr.send("delete_facility=" + val);
}


window.onload = function () {
    get_feature();
    get_facility();
}