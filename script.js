function filterjob() {
    let title = document.getElementById('title').value;
    let company = document.getElementById('company').value;
    let location = document.getElementById('location').value;
    let results = document.getElementById("results");

    let data = { title: title };
    if (company.trim() !== '') {
        data = { company: company };
    }
    if (location.trim() !== '') {
        data = { location: location };
    }

    $.ajax({
        method: "POST",
        url: "search.php",
        data: data,
        success: function (response) {
            results.innerHTML = response;
        },
        error: function () {
            alert("La recherche n'a pas fonctionné.");
        },
    });

    return false;
}



  (function () {
    $.ajax({
      method: "GET",
      url: "search.php",
      data: {},
      success: function (response) {
       console.log("the response is :", response);
      
      },
      error: function () {
        alert("it doesn't work");
      },
    });
  })();