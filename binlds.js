var initialInput;
var studentLength;
var mydate; //="2020-01-25";
var old_l = 0;
var date;
var i = 0;
var old_step_count;
var mycounter = 0;
var database;
var last_data;

var allKeys = [];

var allObject;
//
function setup() {
    if (navigator.onLine) {
        // true|false
        console.log("connected");
    } else {
        document.getElementById("errordata").innerHTML = "No Network";
    }
    var today = new Date();
    date =
        today.getFullYear() +
        "-" +
        ("0" + (today.getMonth() + 1)).slice(-2) +
        "-" +
        ("0" + today.getDate()).slice(-2);
    // document.getElementById("mydate").innerHTML = "Today's Date : " + date;
    //document.getElementById("start").defaultValue = date;
    //mydate=date;

    var config = {
        //https://physiotherapy-1eedc.firebaseio.com/

        apiKey: "uENHOiY4nDfIpd1FZoR6LL9OQ7pziLI1Cb1zq8oi",
        authDomain: "smartbin-9d2b7.firebaseapp.com",
        // databaseURL: "https://physiotherapy-1eedc.firebaseio.com",
        databaseURL: "https://smartbin-9d2b7-default-rtdb.firebaseio.com/",
        projectId: "smartbin-9d2b7",
        storageBucket: "smartbin-9d2b7.appspot.com",
        messagingSenderId: "1036512543663",
        //appId: "1:980134619276:web:ceed589d3a9d37c932b3a9"
    };

    firebase.initializeApp(config);
    database = firebase.database();
    console.log(database);

    var ref = database.ref("BinIds");
    ref.on("value", gotData, errData);
}

function gotData(data) {
    console.log("gotData");
    console.log("mydate  : ", date);
    var datalog = data.val();
    console.log(datalog);
    console.log(data.val());
    var datalog = data.val();

    console.log("datalog", datalog);
    if (datalog) {
        alldatalog = datalog;
        var keys = Object.keys(data.val());

        console.log("keys", keys);
        var l = keys.length;
        console.log("lenght", l);
        console.log("key[0]", keys[0]);
        var bin = keys[0];
        var info = datalog[bin];
        console.log("info", info);
        var dry = Object(info).Dry;
        var wet = Object(info).Wet;
        var lati = Object(info).lat;
        var logi = Object(info).lon;
        //console.log('Branch',);
        //console.log('RollNo',RollNo);
        //console.log('lati',lati);
        //console.log('logi',logi);

        let dataJson = []
        for (var i = 0; i < keys.length; i++) {
            var bin = keys[i];
            var info = datalog[bin];
            var dry = Object(info).Dry;
            var wet = Object(info).Wet;
            var lati = Object(info).lat;
            var logi = Object(info).lon;
            dataJson.push({
                bin: bin,
                dry: dry,
                wet: wet,
                lati: lati,
                logi: logi
            })
            localStorage.setItem("data", JSON.stringify(dataJson));
        }
        window.stop();
    } else {
        document.getElementById("errordata").innerHTML =
            "No data fround on this date";
        console.log("else loop");
    }
}
//---------------file code-----------------
function exportTableToCSV() {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    for (var i = 0; i < rows.length; i++) {
        var row = [],
            cols = rows[i].querySelectorAll("td, th");
        for (var j = 0; j < cols.length; j++) row.push(cols[j].innerText);
        csv.push(row.join(","));
    }
    downloadCSV(csv.join("\n"));
}

function downloadCSV(csv) {
    var csvFile;
    var downloadLink;
    // CSV file
    csvFile = new Blob([csv], { type: "text/csv" });
    // Download link
    downloadLink = document.createElement("a");
    var fname = date + ".csv"; // File name
    downloadLink.download = fname;
    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);
    // Hide download link
    downloadLink.style.display = "none";
    // Add the link to DOM
    document.body.appendChild(downloadLink);
    // Click download link
    downloadLink.click();
}
//-----------------------------------------
function errData(err) {
    console.log("Error!");
    console.log(err);
}