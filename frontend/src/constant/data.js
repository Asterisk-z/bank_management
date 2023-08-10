
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
    title: "Payment Requests",
    icon: "mdi:bank-transfer",
    link: "transfer-requests",
  },
  {
    title: "Wire Transfer Requests",
    icon: "ic:outline-request-page",
    link: "wire-transfer requests",
  },
  {
    title: "Deposits",
    icon: "vaadin:money-deposit",
    link: "#",
    child: [
      {
        childtitle: "Make Deposits",
        childlink: "admin-new-deposit",
      },
      {
        childtitle: "Deposit Requests",
        childlink: "admin-deposit-request",
      },
      {
        childtitle: "Deposit History",
        childlink: "admin-deposit-history",
      },
    ],
  },
  {
    title: "Withdraw",
    icon: "vaadin:money-withdraw",
    link: "#",
    child: [
      {
        childtitle: "Make Withdraw",
        childlink: "admin-new-withdraw",
      },
      {
        childtitle: "Withdraw Requests",
        childlink: "admin-withdraw-requests",
      },
      {
        childtitle: "Withdraw History",
        childlink: "admin-withdraw-history",
      },
    ],
  },
  {
    title: "Transactions",
    icon: "icon-park-outline:transaction-order",
    link: "admin-transactions",
  },
  {
    title: "Loan Management",
    icon: "lucide:helping-hand",
    link: "#",
    child: [
      {
        childtitle: "New Loan",
        childlink: "admin-create-loan",
      },
      {
        childtitle: "Loans",
        childlink: "admin-loans",
      },
      // {
      //   childtitle: "Loan Calculator",
      //   childlink: "admin-loan-calculator",
      // },
      {
        childtitle: "Loan Products",
        childlink: "admin-loan-products",
      },
      {
        childtitle: "Loan Repayment",
        childlink: "admin-loan-payment",
      },
    ],
  },
  {
    title: "Fixed Deposits",
    icon: "ri:luggage-deposit-line",
    link: "#",
    child: [
      {
        childtitle: "New Fixed Deposit Request",
        childlink: "admin-fixed-deposit-request",
      },
      {
        childtitle: "All Fixed Deposit",
        childlink: "admin-all-fixed-deposit-request",
      },
      {
        childtitle: "FDR Package",
        childlink: "admin-fixed-deposit-request-package",
      },
    ],
  },
  {
    title: "Gift Card",
    icon: "fluent:gift-card-money-20-regular",
    link: "#",
    child: [
      {
        childtitle: "Gift Cards",
        childlink: "admin-gift-card",
      },
      {
        childtitle: "All Gift Card",
        childlink: "admin-all-gift-card",
      },
    ],
  },
  {
    title: "Currency",
    icon: "grommet-icons:currency",
    link: "#",
    child: [
      {
        childtitle: "New Currency",
        childlink: "admin-new-currency",
      },
      {
        childtitle: "All Currency",
        childlink: "admin-all-currency",
      },
    ],
  },
  {
    title: "Support TIckets",
    icon: "fa:ticket",
    link: "#",
    child: [
      {
        childtitle: "Create Ticket",
        childlink: "admin-create-ticket",
      },
      {
        childtitle: "All Tickets",
        childlink: "admin-all-tickets",
      },
    ],
  },
  {
    title: "Banks",
    icon: "ant-design:bank-outlined",
    link: "#",
    child: [
      {
        childtitle: "Create Bank",
        childlink: "admin-create-bank",
      },
      {
        childtitle: "All Banks",
        childlink: "admin-all-banks",
      },
    ],
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
    icon: "tabler:cube-send",
    link: "send-money",
  },
  {
    title: "Exchange Money",
    icon: "bi:currency-exchange",
    link: "exchange-money",
  },
  {
    title: "Wire Transfer",
    icon: "mdi:bank-transfer",
    link: "wire-transfer",
  },
  {
    title: "Payment Request",
    icon: "ic:outline-request-page",
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
    icon: "vaadin:money-deposit",
    link: "#",
    child: [
      {
        childtitle: "Deposit History",
        childlink: "deposithistory",
      },
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
    icon: "vaadin:money-withdraw",
    link: "withdraw-money",
  },
  {
    title: "Loan",
    icon: "heroicons-outline:collection",
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
      // {
      //   childtitle: "Loan Calculate",
      //   childlink: "calculate-loan",
      // },
    ],
  },
  {
    title: "Fixed Deposit",
    icon: "uil:moneybag-alt",
    link: "#",
    child: [
      {
        childtitle: "Apply New FRD",
        childlink: "fixed-deposit",
      },
      {
        childtitle: "FDR History",
        childlink: "fixed-deposit-history",
      },
    ],
  },
  {
    title: "Support Ticket",
    icon: "healthicons:contact-support-outline",
    link: "#",
    child: [
      {
        childtitle: "Create New Ticket",
        childlink: "create-ticket",
      },
      {
        childtitle: "All Tickets",
        childlink: "support-tickets",
      },
      {
        childtitle: "Pending Tickets",
        childlink: "support-tickets",
      },
      {
        childtitle: "Active Tickets",
        childlink: "support-tickets",
      },
      {
        childtitle: "Close Tickets",
        childlink: "support-tickets",
      },
    ],
  },
  {
    title: "Transactions Report",
    icon: "icon-park-outline:transaction",
    link: "transaction",
  },

];

export const basicArea = {
  series: [
    {
      data: [90, 70, 85, 60, 80, 70, 90, 75, 60, 80],
    },
  ],
  chartOptions: {
    chart: {
      toolbar: {
        show: false,
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: "smooth",
      width: 2,
    },
    colors: ["#4669FA"],
    tooltip: {
      theme: "dark",
    },
    grid: {
      show: true,
    },
    fill: {
      type: "gradient",
      colors: "#4669FA",
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        opacityTo: 0.5,
        stops: [0, 100, 0],
      },
    },
    yaxis: {
      labels: {
        style: {
          colors: "#475569",
          fontFamily: "Inter",
        },
      },
    },
    xaxis: {
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      labels: {
        style: {
          colors: "#475569",
          fontFamily: "Inter",
        },
      },
    },
    padding: {
      top: 0,
      right: 0,
      bottom: 0,
      left: 0,
    },
  },
};

export const basicAreaDark = {
  series: [
    {
      data: [90, 70, 85, 60, 80, 70, 90, 75, 60, 80],
    },
  ],
  chartOptions: {
    chart: {
      toolbar: {
        show: false,
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: "smooth",
      width: 4,
    },
    colors: ["#4669FA"],
    tooltip: {
      theme: "dark",
    },
    grid: {
      show: true,
      borderColor: "#334155",
      strokeDashArray: 10,
      position: "back",
    },
    fill: {
      type: "gradient",
      colors: "#4669FA",
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        opacityTo: 0.5,
        stops: [50, 100, 0],
      },
    },
    yaxis: {
      labels: {
        style: {
          colors: "#CBD5E1",
          fontFamily: "Inter",
        },
      },
    },
    xaxis: {
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      labels: {
        style: {
          colors: "#CBD5E1",
          fontFamily: "Inter",
        },
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    padding: {
      top: 0,
      right: 0,
      bottom: 0,
      left: 0,
    },
  },
};
