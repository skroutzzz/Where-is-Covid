//Upload JSON File in php

const myForm = document.getElementById("myForm");
const inpFile = document.getElementById("inpFile");

myForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const endpoint = "upload.php";
  const formData = new FormData();

  console.log(inpFile.files);

  formData.append("inpFile", inpFile.files[0]);

  fetch(endpoint, {
    method: "post",
    headers: {
      "Content-Type": "application/json;charset=utf-8",
    },
    body: (formData) => new FormData(), //(data) => new data(formData),
  }).catch(console.error);
});

//
// PREVIOUS

//Parse JSON and print in html

/*

var btn = document.getElementById("load");
btn.addEventListener("click", function () {
  var ourRequest = new XMLHttpRequest();
  //ourRequest.onload = reqListener;
  ourRequest.open("GET", data(formData), "true");
  ourRequest.onload = function () {
    var ourData = JSON.parse(ourRequest.responseText);
    //console.log(ourData);
    renderHTML(ourData);
  };
  ourRequest.send();
});

function renderHTML(data) {
  var htmlString = "";

  for (i = 0; i < data.length; i++) {
    htmlString += "<p>" + data[i].name + " is " + data[i].address + "</p>";
  }

  document
    .getElementById("content")
    .insertAdjacentHTML("beforeend", htmlString);
}

*/