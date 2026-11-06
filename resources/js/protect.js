// NexaConsult Client Protection & Auth Guard
document.addEventListener("DOMContentLoaded", () => {
    const token = localStorage.getItem("token");
    let user = null;
    try {
        user = JSON.parse(localStorage.getItem("user") || "null");
    } catch (e) {}

    const currentPath = window.location.pathname.toLowerCase();

    // Halaman yang WAJIB login
    const isProtected = 
        currentPath.startsWith("/chatbot") || 
        currentPath.startsWith("/project") || 
        currentPath.startsWith("/landing-page") || 
        currentPath.startsWith("/admin") || 
        currentPath.startsWith("/profile");

    // Halaman khusus tamu (login / register)
    const isGuestOnly = 
        currentPath === "/login" || 
        currentPath === "/register";

    if (isProtected && !token) {
        if (typeof Swal !== "undefined") {
            Swal.fire({
                icon: "warning",
                title: "Akses Dibatasi",
                text: "Silakan login terlebih dahulu untuk mengakses fitur ini.",
                confirmButtonText: "Login Sekarang",
                confirmButtonColor: "#7E3CA9"
            }).then(() => {
                window.location.href = "/login";
            });
        } else {
            alert("Silakan login terlebih dahulu untuk mengakses fitur ini.");
            window.location.href = "/login";
        }
        return;
    }

    // Proteksi khusus halaman /admin (Khusus Role Admin)
    if (currentPath.startsWith("/admin") && token) {
        let role = user?.role;
        if (!role) {
            try {
                const payload = JSON.parse(atob(token.split(".")[1]));
                role = payload.role;
            } catch (e) {}
        }

        if (role !== "admin") {
            if (typeof Swal !== "undefined") {
                Swal.fire({
                    icon: "error",
                    title: "Akses Ditolak",
                    text: "Halaman ini khusus untuk Administrator NexaConsult.",
                    confirmButtonText: "Kembali ke Beranda",
                    confirmButtonColor: "#7E3CA9"
                }).then(() => {
                    window.location.href = "/home";
                });
            } else {
                alert("Akses Ditolak: Khusus Administrator.");
                window.location.href = "/home";
            }
            return;
        }
    }

    if (isGuestOnly && token) {
        window.location.href = "/home";
    }
});
