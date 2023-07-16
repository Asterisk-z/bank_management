import userImg from "@/assets/images/all-img/user.png";
import user2Img from "@/assets/images/all-img/user2.png";
import user3Img from "@/assets/images/all-img/user3.png";
import user4Img from "@/assets/images/all-img/user4.png";

export const AdminMenuItem = [
  {
    isHeadr: true,
    title: "menu",
  },

  {
    title: "Dashboard",
    icon: "heroicons-outline:home",
    link: "dashboard",
  },
  {
    title: "Users",
    icon: "heroicons:users",
    link: "users",
  },
  {
    title: "Transfer Requests",
    icon: "heroicons:document",
    link: "transfer-requests",
  },
  {
    title: "Wire Transfers",
    icon: "heroicons:document",
    link: "wire-transfer-requests",
  },
  {
    title: "Deposits",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Make Deposits",
        childlink: "new-deposit",
      },
      {
        childtitle: "Deposit Requests",
        childlink: "deposit-request",
      },
      {
        childtitle: "Deposit History",
        childlink: "deposit-history",
      },
    ],
  },
  {
    title: "Withdraw",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Make Withdraw",
        childlink: "new-withdraw",
      },
      {
        childtitle: "Withdraw Requests",
        childlink: "withdraw-requests",
      },
      {
        childtitle: "Withdraw History",
        childlink: "withdraw-history",
      },
    ],
  },
  {
    title: "Transactions",
    icon: "heroicons:document",
    link: "transactions",
  },
  {
    title: "Loan Management",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Loans",
        childlink: "projects",
      },
      {
        childtitle: "Loan Calculator",
        childlink: "project-details",
      },
      {
        childtitle: "New Loan",
        childlink: "project-details",
      },
      {
        childtitle: "Loan Product",
        childlink: "project-details",
      },
      {
        childtitle: "Loan Repayment",
        childlink: "project-details",
      },
    ],
  },
  {
    title: "Fixed Deposits",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "New Fixed Deposit Request",
        childlink: "projects",
      },
      {
        childtitle: "All Fixed Deposit",
        childlink: "project-details",
      },
      {
        childtitle: "FDR Package",
        childlink: "project-details",
      },
    ],
  },
  {
    title: "Gift Card",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Gift Cards",
        childlink: "projects",
      },
      {
        childtitle: "Used Gift Card",
        childlink: "project-details",
      },
    ],
  },
  {
    title: "Support TIckets",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Active Ticket",
        childlink: "projects",
      },
      {
        childtitle: "Pending Tickets",
        childlink: "project-details",
      },
      {
        childtitle: "Closed Ticket",
        childlink: "project-details",
      },
    ],
  },
  {
    isHeadr: true,
    title: "System Setting",
  },

  {
    title: "Branches",
    icon: "heroicons-outline:clipboard-check",
    link: "todo",
  },
  {
    title: "Banks",
    icon: "heroicons-outline:clipboard-check",
    link: "todo",
  },
  {
    title: "Reports",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Transaction Report",
        childlink: "projects",
      },
      {
        childtitle: "Loan Reports",
        childlink: "project-details",
      },
      {
        childtitle: "FDR Reports",
        childlink: "project-details",
      },
      {
        childtitle: "Bank Reports",
        childlink: "project-details",
      },
    ],
  },
  {
    title: "Admin",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "All Admin",
        childlink: "projects",
      },
      {
        childtitle: "User Role",
        childlink: "project-details",
      },
      {
        childtitle: "Access Control",
        childlink: "project-details",
      },
      {
        childtitle: "Bank Reports",
        childlink: "project-details",
      },
    ],
  },
  {
    title: "Currency List",
    icon: "heroicons-outline:clipboard-check",
    link: "todo",
  },
  {
    title: "Transaction Settings",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Deposit Gateways",
        childlink: "projects",
      },
      {
        childtitle: "Deposit Method",
        childlink: "project-details",
      },
      {
        childtitle: "Withdraw Method",
        childlink: "project-details",
      },
      {
        childtitle: "Transaction Fee",
        childlink: "project-details",
      },
    ],
  },
  {
    title: "Website Management",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Services",
        childlink: "projects",
      },
      {
        childtitle: "FAQ",
        childlink: "project-details",
      },
      {
        childtitle: "Testimonial",
        childlink: "project-details",
      },
      {
        childtitle: "Teams",
        childlink: "project-details",
      },
      {
        childtitle: "Page",
        childlink: "project-details",
      },
      {
        childtitle: "Menu Management",
        childlink: "project-details",
      },
      {
        childtitle: "Team Option",
        childlink: "project-details",
      },
    ],
  },
  {
    title: "Administration",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "General Setting",
        childlink: "projects",
      },
      {
        childtitle: "Email Template",
        childlink: "project-details",
      },
      {
        childtitle: "SMS Template",
        childlink: "project-details",
      },
      {
        childtitle: "BackUp",
        childlink: "project-details",
      },
    ],
  },
  {
    title: "Languages",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "All Language",
        childlink: "projects",
      },
      {
        childtitle: "Add Lanuage",
        childlink: "project-details",
      },
    ],
  },


  {
    isHeadr: true,
    title: "apps",
  },
  {
    title: "Chat",
    icon: "heroicons-outline:chat",
    link: "chat",
  },

  {
    title: "Email",
    icon: "heroicons-outline:mail",
    link: "email",
  },

  {
    title: "Kanban",
    icon: "heroicons-outline:view-boards",
    link: "kanban",
  },
  {
    title: "Calender",
    icon: "heroicons-outline:calendar",
    link: "calender",
  },

  {
    title: "Todo",
    icon: "heroicons-outline:clipboard-check",
    link: "todo",
  },

  {
    title: "Projects",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Projects",
        childlink: "projects",
      },
      {
        childtitle: "Project Details",
        childlink: "project-details",
      },
    ],
  },
  {
    isHeadr: true,
    title: "Pages",
  },
  {
    title: "Authentication",
    icon: "heroicons-outline:lock-closed",
    link: "#",
    child: [
      {
        childtitle: "Signin One",
        childlink: "/",
      },
      {
        childtitle: "Signin Two",
        childlink: "/login2",
      },
      {
        childtitle: "Signin Three",
        childlink: "/login3",
      },
      {
        childtitle: "Signup One",
        childlink: "/register",
      },
      {
        childtitle: "Signup Two",
        childlink: "/register2",
      },
      {
        childtitle: "Signup Three",
        childlink: "/register3",
      },
      {
        childtitle: "Forget Password One",
        childlink: "/forgot-password",
      },
      {
        childtitle: "Forget Password Two",
        childlink: "/forgot-password2",
      },
      {
        childtitle: "Forget Password Three",
        childlink: "/forgot-password3",
      },
      {
        childtitle: "Lock Screen One",
        childlink: "/lock-screen",
      },
      {
        childtitle: "Lock Screen Two",
        childlink: "/lock-screen2",
      },
      {
        childtitle: "Lock Screen Three",
        childlink: "/lock-screen3",
      },
    ],
  },
  {
    title: "Utility",
    icon: "heroicons-outline:view-boards",
    link: "#",
    child: [
      {
        childtitle: "Invoice",
        childlink: "invoice",
      },
      {
        childtitle: "Pricing",
        childlink: "pricing",
      },
      {
        childtitle: "Testimonial",
        childlink: "testimonial",
      },
      {
        childtitle: "FAQ",
        childlink: "faq",
      },
      {
        childtitle: "Blog",
        childlink: "blog",
      },

      {
        childtitle: "Blank Page",
        childlink: "blank-page",
      },
      {
        childtitle: "Profile",
        childlink: "profile",
      },
      {
        childtitle: "Settings",
        childlink: "settings",
      },
      {
        childtitle: "404 page",
        childlink: "/404",
      },
      {
        childtitle: "Coming Soon",
        childlink: "/coming-soon",
      },
      {
        childtitle: "Under Maintanance page",
        childlink: "/under-construction",
      },
    ],
  },

  {
    isHeadr: true,
    title: "Elements",
  },
  {
    title: "Widgets",
    icon: "heroicons-outline:view-grid-add",
    link: "#",
    child: [
      {
        childtitle: "Basic",
        childlink: "basic",
      },
      {
        childtitle: "Statistic",
        childlink: "statistic",
      },
    ],
  },
  {
    title: "Components",
    icon: "heroicons-outline:collection",
    link: "#",
    child: [
      {
        childtitle: "Typography",
        childlink: "typography",
      },
      {
        childtitle: "Colors",
        childlink: "colors",
      },
      {
        childtitle: "Alert",
        childlink: "alert",
      },
      {
        childtitle: "Button",
        childlink: "button",
      },
      {
        childtitle: "Card",
        childlink: "/app/card",
      },
      {
        childtitle: "Carousel",
        childlink: "carousel",
      },
      {
        childtitle: "Dropdown",
        childlink: "dropdown",
      },
      {
        childtitle: "Image",
        childlink: "image",
      },
      {
        childtitle: "Modal",
        childlink: "modal",
      },
      {
        childtitle: "Progress bar",
        childlink: "progress-bar",
      },
      {
        childtitle: "Placeholder",
        childlink: "placeholder",
      },
      {
        childtitle: "Tab & Accordion",
        childlink: "tab-accordion",
      },
      {
        childtitle: "Badge",
        childlink: "badges",
      },
      {
        childtitle: "Pagination",
        childlink: "Pagination",
      },
      {
        childtitle: "Video",
        childlink: "video",
      },
      {
        childtitle: "Tooltip & Popover",
        childlink: "tooltip-popover",
      },
    ],
  },
  {
    title: "Forms",
    icon: "heroicons-outline:clipboard-list",
    link: "#",
    child: [
      {
        childtitle: "Input",
        childlink: "input",
      },
      {
        childtitle: "Input group",
        childlink: "input-group",
      },
      {
        childtitle: "Input layout",
        childlink: "input-layout",
      },
      {
        childtitle: "Form validation",
        childlink: "form-validation",
      },
      {
        childtitle: "Wizard",
        childlink: "form-wizard",
      },
      {
        childtitle: "Input mask",
        childlink: "input-mask",
      },
      {
        childtitle: "File input",
        childlink: "file-input",
      },
      {
        childtitle: "Form repeater",
        childlink: "form-repeater",
      },
      {
        childtitle: "Textarea",
        childlink: "textarea",
      },
      {
        childtitle: "Checkbox",
        childlink: "checkbox",
      },
      {
        childtitle: "Radio button",
        childlink: "radio-button",
      },
      {
        childtitle: "Switch",
        childlink: "switch",
      },
      {
        childtitle: "Select & Vue select",
        childlink: "select",
      },
      {
        childtitle: "Date time picker",
        childlink: "date-time-picker",
      },
    ],
  },
  {
    title: "Tables",
    icon: "heroicons-outline:table",
    link: "#",
    child: [
      {
        childtitle: "Basic Table",
        childlink: "table-basic",
      },
      {
        childtitle: "Advanced table",
        childlink: "table-advanced",
      },
    ],
  },
  {
    title: "Chart",
    icon: "heroicons-outline:chart-bar",
    link: "#",
    child: [
      {
        childtitle: "Apex chart",
        childlink: "appex-chart",
      },
      {
        childtitle: "Chart js",
        childlink: "chartjs",
      },
    ],
  },
  {
    title: "Map",
    icon: "heroicons-outline:map",
    link: "map",
  },

  {
    title: "Icons",
    icon: "heroicons-outline:emoji-happy",
    link: "icons",
  },
];

export const UserMenuItem = [
  {
    isHeadr: true,
    title: "menu",
  },
  {
    title: "Dashboard",
    icon: "heroicons-outline:home",
    link: "user-dashboard",
  },
  {
    title: "Send Money",
    icon: "heroicons-outline:home",
    link: "send-money",
  },
  {
    title: "Exchange Money",
    icon: "heroicons-outline:home",
    link: "exchange-money",
  },
  {
    title: "Wire Transfer",
    icon: "heroicons-outline:home",
    link: "wire-transfer",
  },
  {
    title: "Payment Request",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "New Request",
        childlink: "new-request",
      },
      {
        childtitle: "All Requests",
        childlink: "all-requests",
      },
    ],
  },
  {
    title: "Deposit Money",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Automatic Deposit",
        childlink: "automatic-deposit",
      },
      {
        childtitle: "Manual deposit",
        childlink: "manual-deposit",
      },
      {
        childtitle: "Redeem Gift Card",
        childlink: "redeem-gift-card",
      },
    ],
  },
  {
    title: "Withdraw Money",
    icon: "heroicons:users",
    link: "withdraw-money",
  },
  {
    title: "Loan",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Apply New Loan",
        childlink: "new-loan",
      },
      {
        childtitle: "My Loan",
        childlink: "all-loan",
      },
      {
        childtitle: "Loan Calculate",
        childlink: "calculate-loan",
      },
    ],
  },
  {
    title: "Fixed Deposit",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Apply New FRD",
        childlink: "new-deposit",
      },
      {
        childtitle: "FDR History",
        childlink: "all-deposit",
      },
    ],
  },
  {
    title: "Support Ticket",
    icon: "heroicons-outline:document",
    link: "#",
    child: [
      {
        childtitle: "Create New Ticket",
        childlink: "new-deposit",
      },
      {
        childtitle: "Pending Tickets",
        childlink: "all-deposit",
      },
      {
        childtitle: "Active Tickets",
        childlink: "all-deposit",
      },
      {
        childtitle: "Close Tickets",
        childlink: "all-deposit",
      },
    ],
  },
  {
    title: "Transactions Report",
    icon: "heroicons:users",
    link: "users",
  },

];

// menuseetins

export const ProfileMenu = [
  {
    label: "Profile",
    icon: "heroicons-outline:user",
    link: "#",
  },
  {
    label: "Chat",
    icon: "heroicons-outline:chat",
    link: "chat",
  },
  {
    label: "Email",
    icon: "heroicons-outline:mail",
    link: "email",
  },
  {
    label: "Todo",
    icon: "heroicons-outline:chip",
    link: "todo",
  },
  {
    label: "Settings",
    icon: "heroicons-outline:cog",
    link: "#",
  },
  {
    label: "Price",
    icon: "heroicons-outline:credit-card",
    link: "pricing",
  },
  {
    label: "Faq",
    icon: "heroicons-outline:information-circle",
    link: "faq",
  },
  {
    label: "Logout",
    icon: "heroicons-outline:login",
    link: "/",
  },
];

export const notifications = [
  {
    title: "Your order is placed",
    desc: "Amet minim mollit non deser unt ullamco est sit aliqua.",
    image: userImg,
    link: "#",
  },
  {
    title: "Congratulations Darlene  🎉",
    desc: "Won the monthly best seller badge",
    unread: true,
    image: user2Img,
    link: "#",
  },
  {
    title: "Revised Order 👋",
    desc: "Won the monthly best seller badge",
    image: user3Img,
    link: "#",
  },
  {
    title: "Brooklyn Simmons",
    desc: "Added you to Top Secret Project group...",
    image: user4Img,
    link: "#",
  },
];

export const message = [
  {
    title: "Wade Warren",
    desc: "Hi! How are you doing?.....",
    active: true,
    hasnotifaction: true,
    notification_count: 1,
    image: userImg,
    link: "#",
  },
  {
    title: "Savannah Nguyen",
    desc: "Hi! How are you doing?.....",
    active: false,
    hasnotifaction: false,
    image: user2Img,
    link: "#",
  },
  {
    title: "Ralph Edwards",
    desc: "Hi! How are you doing?.....",
    active: false,
    hasnotifaction: true,
    notification_count: 8,
    image: user3Img,
    link: "#",
  },
  {
    title: "Cody Fisher",
    desc: "Hi! How are you doing?.....",
    active: true,
    hasnotifaction: false,
    image: user4Img,
    link: "#",
  },
  {
    title: "Savannah Nguyen",
    desc: "Hi! How are you doing?.....",
    active: false,
    hasnotifaction: false,
    image: user2Img,
    link: "#",
  },
  {
    title: "Ralph Edwards",
    desc: "Hi! How are you doing?.....",
    active: false,
    hasnotifaction: true,
    notification_count: 8,
    image: user3Img,
    link: "#",
  },
  {
    title: "Cody Fisher",
    desc: "Hi! How are you doing?.....",
    active: true,
    hasnotifaction: false,
    image: user4Img,
    link: "#",
  },
];

export const topMenu = [
  {
    isHeadr: true,
    title: "DASHBOARD",
  },
  {
    title: "Dashboard",
    icon: "heroicons-outline:home",
    link: "/app/home",
    child: [
      {
        childtitle: "Analytics Dashboard",
        childlink: "home",
        childicon: "heroicons:presentation-chart-line",
      },
      {
        childtitle: "Ecommerce Dashboard",
        childlink: "ecommerce",
        childicon: "heroicons:shopping-cart",
      },
      {
        childtitle: "Project  Dashboard",
        childlink: "project",
        childicon: "heroicons:briefcase",
      },
      {
        childtitle: "CRM Dashboard",
        childlink: "crm",
        childicon: "ri:customer-service-2-fill",
      },
      {
        childtitle: "Banking Dashboard",
        childlink: "banking",
        childicon: "heroicons:wrench-screwdriver",
      },
    ],
  },
  {
    title: "App",
    icon: "heroicons-outline:chip",
    link: "/app/home",
    child: [
      {
        childtitle: "Calendar",
        childlink: "calender",
        childicon: "heroicons-outline:calendar",
      },
      {
        childtitle: "Kanban",
        childlink: "kanban",
        childicon: "heroicons-outline:view-boards",
      },
      {
        childtitle: "Todo",
        childlink: "todo",
        childicon: "heroicons-outline:clipboard-check",
      },
      {
        childtitle: "Projects",
        childlink: "projects",
        childicon: "heroicons-outline:document",
      },
    ],
  },
  {
    title: "Pages",
    icon: "heroicons-outline:view-boards",
    link: "/app/home",
    megamenu: [
      {
        megamenutitle: "Authentication",
        megamenuicon: "heroicons-outline:user",
        singleMegamenu: [
          {
            m_childtitle: "Signin One",
            m_childlink: "/",
          },
          {
            m_childtitle: "Signin Two",
            m_childlink: "/login2",
          },
          {
            m_childtitle: "Signin Three",
            m_childlink: "/login3",
          },
          {
            m_childtitle: "Signup One",
            m_childlink: "/register",
          },
          {
            m_childtitle: "Signup Two",
            m_childlink: "/register/register2",
          },
          {
            m_childtitle: "Signup Three",
            m_childlink: "/register/register3",
          },
          {
            m_childtitle: "Forget Password One",
            m_childlink: "/forgot-password",
          },
          {
            m_childtitle: "Forget Password Two",
            m_childlink: "/forgot-password2",
          },
          {
            m_childtitle: "Forget Password Three",
            m_childlink: "/forgot-password3",
          },
          {
            m_childtitle: "Lock Screen One",
            m_childlink: "/lock-screen",
          },
          {
            m_childtitle: "Lock Screen Two",
            m_childlink: "/lock-screen2",
          },
          {
            m_childtitle: "Lock Screen Three",
            m_childlink: "/lock-screen3",
          },
        ],
      },

      {
        megamenutitle: "Components",
        megamenuicon: "heroicons-outline:user",
        singleMegamenu: [
          {
            m_childtitle: "typography",
            m_childlink: "typography",
          },
          {
            m_childtitle: "colors",
            m_childlink: "colors",
          },
          {
            m_childtitle: "alert",
            m_childlink: "alert",
          },
          {
            m_childtitle: "button",
            m_childlink: "button",
          },
          {
            m_childtitle: "card",
            m_childlink: "card",
          },
          {
            m_childtitle: "carousel",
            m_childlink: "carousel",
          },
          {
            m_childtitle: "dropdown",
            m_childlink: "dropdown",
          },
          {
            m_childtitle: "image",
            m_childlink: "image",
          },
          {
            m_childtitle: "modal",
            m_childlink: "modal",
          },
          {
            m_childtitle: "Progress bar",
            m_childlink: "progress-bar",
          },
          {
            m_childtitle: "Placeholder",
            m_childlink: "placeholder",
          },

          {
            m_childtitle: "Tab & Accordion",
            m_childlink: "tab-accordion",
          },
        ],
      },
      {
        megamenutitle: "Forms",
        megamenuicon: "heroicons-outline:user",
        singleMegamenu: [
          {
            m_childtitle: "Input",
            m_childlink: "input",
          },
          {
            m_childtitle: "Input group",
            m_childlink: "input-group",
          },
          {
            m_childtitle: "Input layout",
            m_childlink: "input-layout",
          },
          {
            m_childtitle: "Form validation",
            m_childlink: "form-validation",
          },
          {
            m_childtitle: "Wizard",
            m_childlink: "form-wizard",
          },
          {
            m_childtitle: "Input mask",
            m_childlink: "input-mask",
          },
          {
            m_childtitle: "File input",
            m_childlink: "file-input",
          },
          {
            m_childtitle: "Form repeater",
            m_childlink: "form-repeater",
          },
          {
            m_childtitle: "Textarea",
            m_childlink: "textarea",
          },
          {
            m_childtitle: "Checkbox",
            m_childlink: "checkbox",
          },
          {
            m_childtitle: "Radio button",
            m_childlink: "radio-button",
          },
          {
            m_childtitle: "Switch",
            m_childlink: "switch",
          },
        ],
      },
      {
        megamenutitle: "Utility",
        megamenuicon: "heroicons-outline:user",
        singleMegamenu: [
          {
            m_childtitle: "Invoice",
            m_childlink: "invoice",
          },
          {
            m_childtitle: "Pricing",
            m_childlink: "pricing",
          },
          {
            m_childtitle: "Testimonial",
            m_childlink: "testimonial",
          },
          {
            m_childtitle: "FAQ",
            m_childlink: "faq",
          },
          {
            m_childtitle: "Blog",
            m_childlink: "blog",
          },
          {
            m_childtitle: "404 page",
            m_childlink: "/404",
          },
          {
            m_childtitle: "Coming Soon",
            m_childlink: "/coming-soon",
          },
          {
            m_childtitle: "Under Maintanance page",
            m_childlink: "/under-construction",
          },
        ],
      },
    ],
  },

  {
    isHeadr: true,
    title: "PAGES",
  },
  {
    title: "Widgets",
    icon: "heroicons-outline:view-grid-add",
    link: "form-elements",
    child: [
      {
        childtitle: "Basic",
        childlink: "basic",
        childicon: "heroicons-outline:document-text",
      },
      {
        childtitle: "Statistic",
        childlink: "statistic",
        childicon: "heroicons-outline:document-text",
      },
    ],
  },

  {
    title: "Extra",
    icon: "heroicons-outline:template",

    child: [
      {
        childtitle: "Basic Table",
        childlink: "table-basic",
        childicon: "heroicons-outline:table",
      },
      {
        childtitle: "Advanced table",
        childlink: "table-advanced",
        childicon: "heroicons-outline:table",
      },
      {
        childtitle: "Apex chart",
        childlink: "appex-chart",
        childicon: "heroicons-outline:chart-bar",
      },
      {
        childtitle: "Chart js",
        childlink: "chartjs",
        childicon: "heroicons-outline:chart-bar",
      },
      {
        childtitle: "Map",
        childlink: "map",
        childicon: "heroicons-outline:map",
      },
    ],
  },
];

export const alertType = [
  {
    type: "dark",
  },
  {
    type: "primary",
  },

  {
    type: "secondary",
  },
  {
    type: "success",
  },
  {
    type: "info",
  },
  {
    type: "danger",
  },
  {
    type: "warning",
  },
];

export const alertType2 = [
  {
    type: "dark-light",
  },
  {
    type: "primary-light",
  },

  {
    type: "secondary-light",
  },
  {
    type: "success-light",
  },
  {
    type: "info-light",
  },
  {
    type: "danger-light",
  },
  {
    type: "warning-light",
  },
];

export const alertType3 = [
  {
    type: "dark",
    icon: "fluent:target-20-regular",
  },
  {
    type: "primary",
    icon: "fluent:target-20-regular",
  },

  {
    type: "secondary",
    icon: "heroicons-outline:support",
  },
  {
    type: "success",
    icon: "akar-icons:double-check",
  },
  {
    type: "t-info",
    icon: "heroicons-outline:information-circle",
  },
  {
    type: "danger",
    icon: "heroicons-outline:exclamation",
  },
  {
    type: "warning",
    icon: "heroicons-outline:ban",
  },
];
export const alertType4 = [
  {
    type: "dark-light",
    icon: "fluent:target-20-regular",
  },
  {
    type: "primary-light",
    icon: "fluent:target-20-regular",
  },

  {
    type: "secondary-light",
    icon: "heroicons-outline:support",
  },
  {
    type: "success-light",
    icon: "akar-icons:double-check",
  },
  {
    type: "info-light",
    icon: "heroicons-outline:information-circle",
  },
  {
    type: "danger-light",
    icon: "heroicons-outline:exclamation",
  },
  {
    type: "warning-light",
    icon: "heroicons-outline:ban",
  },
];
export const alertType5 = [
  {
    type: "dark-outline",
  },
  {
    type: "primary-outline",
  },

  {
    type: "secondary-outline",
  },
  {
    type: "success-outline",
  },
  {
    type: "info-outline",
  },
  {
    type: "danger-outline",
  },
  {
    type: "warning-outline",
  },
];
export const alertType6 = [
  {
    type: "dark-outline",
    icon: "fluent:target-20-regular",
  },
  {
    type: "primary-outline",
    icon: "fluent:target-20-regular",
  },

  {
    type: "secondary-outline",
    icon: "heroicons-outline:support",
  },
  {
    type: "success-outline",
    icon: "akar-icons:double-check",
  },
  {
    type: "info-outline",
    icon: "heroicons-outline:information-circle",
  },
  {
    type: "danger-outline",
    icon: "heroicons-outline:exclamation",
  },
  {
    type: "warning-outline",
    icon: "heroicons-outline:ban",
  },
];

export const trackingParcel = [
  {
    title: "Project start date",
    desc: "This parcel is paid for by the customer. Please contact the customer for any further information.",
    date: "Sep 20, 2021 ",
    time: "12:32 AM",
    status: "ok",
  },
  {
    title: "Project start date",
    date: "Sep 20, 2021 ",
    desc: "This parcel is paid for by the customer. Please contact the customer for any further information.",
    time: "12:32 AM",
    status: "ok",
  },
  {
    title: "Project start date",
    date: "Sep 20, 2021 ",
    desc: "This parcel is paid for by the customer. Please contact the customer for any further information.",
    time: "12:32 AM",
    status: "ok",
  },
  {
    title: "Project start date",
    date: "Sep 20, 2021 ",
    desc: "This parcel is paid for by the customer. Please contact the customer for any further information.",
    time: "12:32 AM",
  },
  {
    title: "Project start date",
    date: "Sep 20, 2021 ",
    desc: "This parcel is paid for by the customer. Please contact the customer for any further information.",
    time: "12:32 AM",
  },
  {
    title: "Project start date",
    date: "Sep 20, 2021 ",
    desc: "This parcel is paid for by the customer. Please contact the customer for any further information.",
    time: "12:32 AM",
  },
  {
    title: "Project start date",
    date: "Sep 20, 2021 ",
    desc: "This parcel is paid for by the customer. Please contact the customer for any further information.",
    time: "12:32 AM",
  },
];

export const TodoList = [
  {
    id: 1,
    image: userImg,
    title: "Amet minim mollit non deserunt ullam.",
    isDone: false,
  },
  {
    id: 2,
    image: user2Img,
    title: "Amet minim mollit non deserunt ullam.",
    isDone: false,
  },
  {
    id: 3,
    image: user3Img,
    title: "Amet minim mollit non deserunt ullam.",
    isDone: false,
  },
  {
    id: 4,
    image: user4Img,
    title: "Amet minim mollit non deserunt ullam.",
    isDone: false,
  },
  {
    id: 5,
    image: user2Img,
    title: "Amet minim mollit non deserunt ullam.",
    isDone: false,
  },
  {
    id: 6,
    image: user3Img,
    title: "Amet minim mollit non deserunt ullam.",
    isDone: false,
  },
];

//  todo fillter
export const fillters = [
  {
    value: "all",
    name: "My Task",
    icon: "uil:image-v",
  },
  {
    value: "fav",
    name: "Starred",
    icon: "heroicons:star",
  },
  {
    value: "done",
    name: "Completed",
    icon: "heroicons:document-check",
  },
  {
    value: "trash",
    name: "Trash",
    icon: "heroicons:trash",
  },
  {
    name: "Team",
    icon: "heroicons:users",
    value: "team",
  },
  {
    name: "low",
    icon: "heroicons:flag",
    value: "low",
  },
  {
    name: "medium",
    icon: "heroicons:flag",
    value: "medium",
  },
  {
    name: "high",
    icon: "heroicons:flag",
    value: "high",
  },
  {
    name: "update",
    icon: "heroicons:refresh",
    value: "update",
  },
];

export const editCatagory = [
  {
    value: "team",
    label: "team",
  },
  {
    value: "low",
    label: "low",
  },
  {
    value: "medium",
    label: "medium",
  },
  {
    value: "high",
    label: "high",
  },
];

export const projectCatagory = [
  {
    value: "team",
    label: "team",
  },
  {
    value: "low",
    label: "low",
  },
  {
    value: "medium",
    label: "medium",
  },
  {
    value: "high",
    label: "high",
  },
];

import avatar1 from "@/assets/images/avatar/av-1.svg";
import avatar2 from "@/assets/images/avatar/av-2.svg";
import avatar3 from "@/assets/images/avatar/av-3.svg";
import avatar4 from "@/assets/images/avatar/av-4.svg";
import avatar5 from "@/assets/images/avatar/av-5.svg";
import avatar6 from "@/assets/images/avatar/av-6.svg";
export const assignOption = [
  {
    title: "Mahedi Amin",
    image: avatar1,
  },
  {
    title: "Sovo Haldar",
    image: avatar2,
  },
  {
    title: "Rakibul Islam",
    image: avatar3,
  },
  {
    title: "Moni Haldar",
    image: avatar4,
  },
  {
    title: "Pritom Miha",
    image: avatar5,
  },
  {
    title: "Simanta Kika",
    image: avatar6,
  },
];