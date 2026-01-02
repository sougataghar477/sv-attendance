function handleLogin(event) {
    event.preventDefault();

    const formData = new FormData(event.target);

    fetch("/login/handler.php", {
        method: "POST",
        body: formData   // 👈 NO headers, NO JSON.stringify
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(data.status==="success"){
            window.location.href ="/attendance"
        }
    })
    .catch(err => console.error(err));
}
function handleAttendance(event){
    event.preventDefault();
    fetch("/attendance/handler.php", {
        method: "POST",
        body: new FormData(event.target)   // 👈 NO headers, NO JSON.stringify
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        event.target.lastElementChild.disabled=true;
    })
    .catch(err => console.error(err));
}