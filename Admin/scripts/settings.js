let general_data, contacts_data;

let site_title_inp = document.getElementById("site_title_inp");
let site_about_inp = document.getElementById("site_about_inp");

let general_s_form = document.getElementById("general_s_form");
let contacts_s_form = document.getElementById("contacts_s_form");

let team_s_form = document.getElementById("team_s_form");
let member_name_inp = document.getElementById("member_name_inp");
let member_picture_inp = document.getElementById("member_picture_inp");

// retrive site title and about us section data
function get_general() {
    let site_title = document.getElementById("site_title");
    let site_about = document.getElementById("site_about");

    let shutdown_toggle = document.getElementById("shutdown-toggle");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        general_data = JSON.parse(this.responseText);
        // console.log(general_data);

        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;

        site_title_inp.value = general_data.site_title;
        site_about_inp.value = general_data.site_about;

        if (general_data.shutdown == 0) {
            shutdown_toggle.checked = false;
            shutdown_toggle.value = 0;
        } else {
            shutdown_toggle.checked = true;
            shutdown_toggle.value = 1;
        }
    };
    xhr.send("get_general");
}

//eventListener for blank form not submit
general_s_form.addEventListener("submit", function (e) {
    e.preventDefault();
    upd_general(site_title_inp.value, site_about_inp.value);
});

// update site title and about us section data
function upd_general(site_title_val, site_about_val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        // show/hide modal
        var myModal = document.getElementById("general-s");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        // console.log(this.responseText);

        if (this.responseText == 1) {
            // console.log("data updated !!");
            alert("success", "Changes Saved !!😄😄");
            get_general();
        } else {
            // console.log("no changes made  !!");
            alert("error", "No Changes Made !!😢😢");
        }
    };
    xhr.send(
        "site_title=" +
        site_title_val +
        "&site_about=" +
        site_about_val +
        "&upd_general"
    );
}

// update shutdown value function
function upd_shutdown(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText == 1 && general_data.shutdown == 0) {
            alert("success", "Site has been shutdown !!😢😢");
        } else {
            alert("success", "shutdown mode off !!");
        }
        get_general();
    };
    xhr.send("upd_shutdown=" + val);
}

// retrive contact details section data
function get_contacts() {
    let contacts_p_id = [
        "address",
        "gmap",
        "pn1",
        "pn2",
        "email",
        "fb",
        "insta",
        "tw",
    ];
    let iframe = document.getElementById("iframe");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        contacts_data = JSON.parse(this.responseText);
        contacts_data = Object.values(contacts_data);
        // console.log(contacts_data);

        for (i = 0; i < contacts_p_id.length; i++) {
            document.getElementById(contacts_p_id[i]).innerText =
                contacts_data[i + 1];
        }
        iframe.src = contacts_data[9];
        contacts_inp(contacts_data);
    };
    xhr.send("get_contacts");
}

function contacts_inp(data) {
    let contacts_inp_id = [
        "address_inp",
        "gmap_inp",
        "pn1_inp",
        "pn2_inp",
        "email_inp",
        "fb_inp",
        "insta_inp",
        "tw_inp",
        "iframe_inp",
    ];

    for (i = 0; i < contacts_inp_id.length; i++) {
        document.getElementById(contacts_inp_id[i]).value = data[i + 1];
    }
}

//eventListener for Contact details form
contacts_s_form.addEventListener("submit", function (e1) {
    e1.preventDefault();
    upd_contacts();
});

// update contacts details value function
function upd_contacts() {
    let index = [
        "address",
        "gmap",
        "pn1",
        "pn2",
        "email",
        "fb",
        "insta",
        "tw",
        "iframe",
    ];
    let contacts_inp_id = [
        "address_inp",
        "gmap_inp",
        "pn1_inp",
        "pn2_inp",
        "email_inp",
        "fb_inp",
        "insta_inp",
        "tw_inp",
        "iframe_inp",
    ];

    let data_str = "";

    for (i = 0; i < index.length; i++) {
        data_str +=
            index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + "&";
    }
    // console.log(data_str);
    data_str += "upd_contacts";

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        // show/hide modal
        var myModal = document.getElementById("contacts-s");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success", "Changes Saved !!😄😄");
            get_contacts();
        } else {
            alert("error", "No Changes Made !!😢😢");
        }
    };
    xhr.send(data_str);
}

//eventListener for Management Teams  form
team_s_form.addEventListener("submit", function (e1) {
    e1.preventDefault();
    add_member();
});

// add management team member function
function add_member() {
    let data = new FormData();
    data.append("name", member_name_inp.value);
    data.append("picture", member_picture_inp.files[0]);
    data.append("add_member", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    xhr.onload = function () {
        // console.log(this.responseText);

        // show/hide modal
        var myModal = document.getElementById("team-s");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "invalid_image") {
            alert("error", "Only JPG and PNG images are allowed !!😢😢");
            member_name_inp.value = "";
            member_picture_inp.value = "";
        } else if (this.responseText == "invalid_size") {
            alert("error", "Image should be less than 2MB !!😢😢");
            member_name_inp.value = "";
            member_picture_inp.value = "";
        } else if (this.responseText == "upload_failed") {
            alert("error", "Image upload failed .. Server Down..!!😢😢");
            member_name_inp.value = "";
            member_picture_inp.value = "";
        } else {
            alert("success", "New Member Added !!😄😄");
            member_name_inp.value = "";
            member_picture_inp.value = "";
            get_members();
        }
    };
    xhr.send(data);
}

//get team members function
function get_members() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        document.getElementById("team-data").innerHTML = this.responseText;
    };
    xhr.send("get_members");
}

//delete team member function
function delete_member(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert("success", "Member Removed !!😄😄");
            get_members();
        } else {
            alert("error", "Sorry, Server Down !!😢😢");
        }
    };
    xhr.send("delete_member=" + val);
}

window.onload = function () {
    get_general();
    get_contacts();
    get_members();
};
