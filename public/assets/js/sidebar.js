const sidebarToggler = document.querySelector(".sidebar-toggle")
const sidebar = document.querySelector(".sidebar-menu")

sidebarToggler.addEventListener("click", ()=>{
    if (document.body.classList.contains("collapsed")) {
        document.body.classList.remove("collapsed")
    } else {
        document.body.classList.add("collapsed")
    }
})

const sidebarItemsList = [
    {
        icon : "fa fa-chart-line",
        text : "Dashboard",
        link : "/dashboard"
    },
    {
        icon : "fa fa-graduation-cap",
        text : "Students",
        link : "/students"
    },
    {
        icon : "fa fa-users",
        text : "Staff",
        link : "/staff"
    },
    {
        icon : "fa fa-bus",
        text : "Transport",
        link : "/transport"
    },
    {
        icon : "fa fa-book",
        text : "Courses",
        link : "/courses"
    },
    {
        icon : "fa-solid fa-chalkboard-user",
        text : "Classes",
        link : "/classes"
    },
    {
        icon : "fa-solid fa-hands-praying",
        text : "Religions",
        link : "/religions"
    },
    {
        icon : "fa fa-square-poll-vertical",
        text : "Exams",
        link : "/exams"
    },
    {
        icon : "fa fa-money-bills",
        text : "Fee",
        link : "/fee"
    },
    {
        icon : "fa fa-file-invoice-dollar",
        text : "Accounts",
        link : "/accounts"
    },
    {
        icon : "fa fa-phone",
        text : "Support",
        link : "/support"
    },
    {
        icon : "fa fa-user",
        text : "Profile",
        link : "/profile"
    },
]

function sidebarItem(icon, text, link) {
    return `<li class="" data-item="${text}">
    <a class="sidebar-item ${window.location.href.includes(link)? "active" : ""} btn py-2 rounded-0 btn-dark w-100 mb-2" href="${link}">
    <i class="${icon} me-1"></i>
    <span>${text}</span></a></li>`
}

sidebarItemsList.forEach(item => {
  sidebar.innerHTML += sidebarItem(item.icon, item.text, item.link)  
})