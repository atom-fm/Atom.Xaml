(function () {
    const url = window.APP_BASE_URL + "/hotreload/hotreload.php";

    const source = new EventSource(url);
    const guid = "294f372e-874d-443e-82eb-99385889196e";
    source.onmessage = function (event) {
        const data = JSON.parse(event.data);
        const lastHash = localStorage.getItem("lastHash");

        if (data.hash !== lastHash) {
            localStorage.setItem("lastHash", data.hash);
            fetch(document.location.href)
                .then(e => e.text())
                .then(t => {
                    if (t.indexOf(guid) > -1) {
                        document.location.reload(true);
                    } else {
                        console.error(t);
                        var e = document.getElementById("errorMessage");
                        var ec = document.getElementById("errorMessageContent");
                        ec.innerHTML = t;
                        e.style = "display:block";
                    }
                })
        }
    };
})();