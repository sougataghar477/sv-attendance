const attendanceModalBtn = document.querySelector("#attendanceModalBtn");
function handleLogin(event) {
    event.preventDefault();

    const formData = new FormData(event.target);

    fetch("/login/handler.php", {
        method: "POST",
        credentials: "include",
        body: formData   // 👈 NO headers, NO JSON.stringify
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(data.status==="success"){
            if(data.role==="user"){
                window.location.href ="/attendance";
                return
            }
            else{
            window.location.href ="/admin";
                return
            }
        }
 
    })
    .catch(err => console.error(err));
}
function handleAttendance(event){
    event.preventDefault();
    fetch("/attendance/handler.php", {
        method: "POST",
        credentials: "include",
        body: new FormData(event.target)   // 👈 NO headers, NO JSON.stringify
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        event.target.lastElementChild.disabled=true;
        attendanceModalBtn.click();
    })
    .catch(err => console.error(err));
}