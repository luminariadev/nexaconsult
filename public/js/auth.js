// NexaConsult Authentication Script
document.addEventListener("DOMContentLoaded", () => {
    // If already logged in, redirect away from login/register
    const token = localStorage.getItem("token");
    const currentPath = window.location.pathname.toLowerCase();
    if (token && (currentPath === "/login" || currentPath === "/register")) {
        window.location.href = "/home";
        return;
    }

    // ===========================================================
    //  LOGIN FORM HANDLER
    // ===========================================================
    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const btn = document.getElementById("loginButton");
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;
            const errorDiv = document.getElementById("login-error");

            if (errorDiv) {
                errorDiv.style.display = "none";
                errorDiv.textContent = "";
            }

            btn.disabled = true;
            btn.textContent = "Sedang Masuk...";

            try {
                const res = await fetch("/api/auth/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await res.json();

                if (!res.ok) {
                    const msg = data.message || "Email atau password yang Anda masukkan salah.";
                    if (typeof Swal !== "undefined") {
                        Swal.fire({
                            icon: "error",
                            title: "Login Gagal",
                            text: msg,
                            confirmButtonColor: "#7E3CA9"
                        });
                    } else {
                        alert(msg);
                    }
                    btn.disabled = false;
                    btn.textContent = "Sign In";
                    return;
                }

                if (data.token) {
                    localStorage.setItem("token", data.token);

                    let redirectUrl = "/home";
                    // Fetch profile to cache user data
                    try {
                        const meRes = await fetch("/api/auth/me", {
                            headers: { "Authorization": "Bearer " + data.token, "Accept": "application/json" }
                        });
                        if (meRes.ok) {
                            const meData = await meRes.json();
                            if (meData.user) {
                                localStorage.setItem("user", JSON.stringify(meData.user));
                                if (meData.user.role === "admin") {
                                    redirectUrl = "/admin";
                                }
                            }
                        }
                    } catch (err) {}

                    if (redirectUrl === "/home") {
                        try {
                            const payload = JSON.parse(atob(data.token.split(".")[1]));
                            if (payload.role === "admin") redirectUrl = "/admin";
                        } catch (e) {}
                    }

                    if (typeof Swal !== "undefined") {
                        Swal.fire({
                            icon: "success",
                            title: "Login Berhasil",
                            text: redirectUrl === "/admin" ? "Selamat datang, Administrator!" : "Selamat datang kembali!",
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = redirectUrl;
                        });
                    } else {
                        window.location.href = redirectUrl;
                    }
                }
            } catch (err) {
                console.error("Login fetch error:", err);
                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        icon: "error",
                        title: "Koneksi Bermasalah",
                        text: "Gagal menghubungi server. Pastikan koneksi internet atau server berjalan.",
                        confirmButtonColor: "#7E3CA9"
                    });
                } else {
                    alert("Gagal menghubungi server.");
                }
                btn.disabled = false;
                btn.textContent = "Sign In";
            }
        });
    }

    // ===========================================================
    //  REGISTER FORM HANDLER
    // ===========================================================
    const registerForm = document.getElementById("registerForm");
    if (registerForm) {
        registerForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const btn = document.getElementById("registerButton");
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;

            btn.disabled = true;
            btn.textContent = "Sedang Mendaftar...";

            try {
                const res = await fetch("/api/auth/register", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ name, email, password })
                });

                const data = await res.json();

                if (!res.ok) {
                    const msg = data.message || "Pendaftaran gagal. Periksa kembali data Anda.";
                    if (typeof Swal !== "undefined") {
                        Swal.fire({
                            icon: "error",
                            title: "Registrasi Gagal",
                            text: msg,
                            confirmButtonColor: "#7E3CA9"
                        });
                    } else {
                        alert(msg);
                    }
                    btn.disabled = false;
                    btn.textContent = "Create Account";
                    return;
                }

                if (data.token) {
                    localStorage.setItem("token", data.token);

                    try {
                        const meRes = await fetch("/api/auth/me", {
                            headers: { "Authorization": "Bearer " + data.token, "Accept": "application/json" }
                        });
                        if (meRes.ok) {
                            const meData = await meRes.json();
                            if (meData.user) {
                                localStorage.setItem("user", JSON.stringify(meData.user));
                            }
                        }
                    } catch (err) {}

                    if (typeof Swal !== "undefined") {
                        Swal.fire({
                            icon: "success",
                            title: "Registrasi Berhasil!",
                            text: "Akun Anda telah aktif.",
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "/home";
                        });
                    } else {
                        window.location.href = "/home";
                    }
                }
            } catch (err) {
                console.error("Register fetch error:", err);
                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        icon: "error",
                        title: "Koneksi Bermasalah",
                        text: "Gagal menghubungi server register.",
                        confirmButtonColor: "#7E3CA9"
                    });
                } else {
                    alert("Gagal menghubungi server.");
                }
                btn.disabled = false;
                btn.textContent = "Create Account";
            }
        });
    }
});
