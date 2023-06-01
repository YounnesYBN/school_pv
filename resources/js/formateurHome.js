import axios from "axios";

if (document.getElementById("selectFiliere").value == "default") {
    document.getElementById("group_con").style.display = "none";
}
document.getElementById("selectFiliere").addEventListener("change", (e) => {
    var select_filiere_ele = e.target;
    if (select_filiere_ele.value == "default") {
        document.getElementById("group_con").style.display = "none";
        document.getElementById("loading_con").style.display = "none";
    } else {
        document.getElementById("selectGroup").innerHTML = "";
        document.getElementById("group_con").style.display = "none";
        document.getElementById("loading_con").style.display = "inline";
        var value = JSON.parse(select_filiere_ele.value)
        console.log(value);
        axios
            .get(
                window.location.origin +
                    "/GetGroups/" +
                    value.filiere
            )
            .then((res) => {
                const { data } = res;
                var newHTML = "";
                data.data.map((group) => {
                    newHTML += `<option value=${group.id} >${group.name}</option>`;
                });
                document.getElementById("selectGroup").innerHTML = newHTML;
                document.getElementById("loading_con").style.display = "none";
                document.getElementById("group_con").style.display = "inline";
            });
    }
});
