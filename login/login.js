const loginForm = document.getElementById("login-form");
const loginButton = document.getElementById("login-form-submit");
const loginErrorMsg = document.getElementById("login-error-msg");

loginButton.addEventListener("click", (e) => {
    e.preventDefault();
    const username = loginForm.username.value;
    const password = loginForm.password.value;
    
    if (username === "admin" && password === "admin") {
        alert("登录成功");
        location.assign("file:///C:\\Users\\samqu\\Desktop\\project-1\\main\\list.html")
    } else {
        alert("用户名或密码错误");
    }
})