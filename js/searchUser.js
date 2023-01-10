document.querySelector("#findUserBar").addEventListener("keyup", findUser);

function findUser(){
    let search = document.querySelector("#findUserBar").value.toLowerCase();
    let users = document.querySelectorAll(".username");
    users.forEach((user) => {
        // console.log(user.textContent.toLowerCase().includes(search));
        if(user.textContent.toLowerCase().includes(search)){
            user.parentElement.parentElement.style.display = "block";
        } else {
            user.parentElement.parentElement.style.display = "none";
            console.log(user.parentElement.parentElement);
        }
    })
}