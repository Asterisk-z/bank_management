import admin from "@/middleware/admin";
import user from "@/middleware/user";

const routes = [
  {
    path: "/",
    name: "Login",
    component: () => import("@/views/auth/login/index.vue"),
  },
  {
    path: "/login-otp",
    name: "login-otp",
    component: () => import("@/views/auth/login/otp.vue"),
  },
  {
    path: "/register",
    name: "reg",
    component: () => import("@/views/auth/register"),
  },
  {
    path: "/forgot-password",
    name: "forgot-password",
    component: () => import("@/views/auth/forgot-password.vue"),
  },
  {
    path: "/password_reset/:token",
    name: "password_reset",
    component: () => import("@/views/auth/password_reset.vue"),
  },
  {
    path: "/app",
    name: "Layout",
    component: () => import("@/Layout/index.vue"),
    children: [
      //USER DASHBOARD
      {
        path: "user-dashboard",
        name: "user-dashboard",
        component: () => import("@/views/user-dashboard/index.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "send-money",
        name: "send-money",
        component: () => import("@/views/user-dashboard/send-money/index.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "exchange-money",
        name: "exchange-money",
        component: () => import("@/views/user-dashboard/exchange-money/index.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "wire-transfer",
        name: "wire-transfer",
        component: () => import("@/views/user-dashboard/wire-transfer/index.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "new-request",
        name: "new-request",
        component: () => import("@/views/user-dashboard/payment-request/create.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "all-requests",
        name: "all-requests",
        component: () => import("@/views/user-dashboard/payment-request/index.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "automatic-deposit",
        name: "automatic-deposit",
        component: () => import("@/views/user-dashboard/deposit-money/automatic.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "automatic-deposit-blockchain",
        name: "automatic-deposit Blockchain",
        component: () => import("@/views/user-dashboard/deposit-money/blockchain.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "automatic-deposit-paypal",
        name: "automatic-deposit Paypal",
        component: () => import("@/views/user-dashboard/deposit-money/paypal.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "redeem-gift-card",
        name: "redeem-gift-card",
        component: () => import("@/views/user-dashboard/deposit-money/gift-card.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "manual-deposit",
        name: "manual-deposit",
        component: () => import("@/views/user-dashboard/deposit-money/manual.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "manual-deposit-payoneer",
        name: "manual-deposit payoneer",
        component: () => import("@/views/user-dashboard/deposit-money/payoneer.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "withdraw-money",
        name: "withdraw-money",
        component: () => import("@/views/user-dashboard/withdraw-money/index.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "new-loan",
        name: "new-loan",
        component: () => import("@/views/user-dashboard/loan/create.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "all-loan",
        name: "all-loan",
        component: () => import("@/views/user-dashboard/loan/all-loan.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "calculate-loan",
        name: "calculate-loan",
        component: () => import("@/views/user-dashboard/loan/calculate.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      
      {
        path: "otp",
        name: "otp",
        component: () => import("@/views/user-dashboard/checkotp.vue"),
        meta: {
            hide: true,
            middleware: [user],
        },
      },
      {
        path: "transaction",
        name: "transaction",
        component: () => import("@/views/user-dashboard/transaction/index.vue"),
        meta: {
            hide: true,
            middleware: [user],
        },
      },
      {
        path: "deposithistory",
        name: "deposithistory",
        component: () => import("@/views/user-dashboard/deposit-money/history.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "support-tickets",
        name: "support-tickets",
        component: () => import("@/views/user-dashboard/support-ticket/index.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "create-ticket",
        name: "create-ticket",
        component: () => import("@/views/user-dashboard/support-ticket/create.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "ticket-chat/:ticket_id",
        name: "ticket-chat",
        component: () => import("@/views/user-dashboard/support-ticket/chat.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "manual-deposit-check",
        name: "manual-deposit check",
        component: () => import("@/views/user-dashboard/deposit-money/check.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "fixed-deposit",
        name: "fixed-deposit",
        component: () => import("@/views/user-dashboard/fixed-deposit/create.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "fixed-deposit-history",
        name: "fixed-deposit-history",
        component: () => import("@/views/user-dashboard/fixed-deposit/history.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      
      {
        path: "user-profile",
        name: "user-profile",
        component: () => import("@/views/user-dashboard/profile.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "withdraw",
        name: "withdraw",
        component: () => import("@/views/user-dashboard/withdraw-money/create.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "withdraw-requests",
        name: "withdraw-requests",
        component: () => import("@/views/user-dashboard/withdraw-money/list.vue"),
        meta: {
          hide: true,
          middleware: [user],
        },
      },
      {
        path: "dashboard",
        name: "dashboard",
        component: () => import("@/views/dashboard.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "users",
        name: "users",
        component: () => import("@/views/dashboard/users/index.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "create-user",
        name: "create-user",
        component: () => import("@/views/dashboard/users/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "user/:user_id/edit",
        name: "user-edit",
        component: () => import("@/views/dashboard/users/edit.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "user/:user_id",
        name: "user",
        component: () => import("@/views/dashboard/users/view.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "transfer-requests",
        name: "transfer-requests",
        component: () => import("@/views/dashboard/transfer-request/index.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "wire-transfer-requests",
        name: "wire-transfer requests",
        component: () => import("@/views/dashboard/wire-transfer-request/index.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "new-deposit",
        name: "admin-new-deposit",
        component: () => import("@/views/dashboard/deposit/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-deposit-request",
        name: "admin-deposit-request",
        component: () => import("@/views/dashboard/deposit/request.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-deposit-history",
        name: "admin-deposit-history",
        component: () => import("@/views/dashboard/deposit/history.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-new-withdraw",
        name: "admin-new-withdraw",
        component: () => import("@/views/dashboard/withdraw/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-withdraw-history",
        name: "admin-withdraw-history",
        component: () => import("@/views/dashboard/withdraw/history.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-withdraw-requests",
        name: "admin-withdraw-requests",
        component: () => import("@/views/dashboard/withdraw/request.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-transactions",
        name: "admin-transactions",
        component: () => import("@/views/dashboard/transactions/index.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      
      {
        path: "admin-fixed-deposit-request",
        name: "admin-fixed-deposit-request",
        component: () => import("@/views/dashboard/fdr/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-all-fixed-deposit-request",
        name: "admin-all-fixed-deposit-request",
        component: () => import("@/views/dashboard/fdr/history.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-fixed-deposit-request-package",
        name: "admin-fixed-deposit-request-package",
        component: () => import("@/views/dashboard/fdr/request.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-fixed-deposit-create",
        name: "admin-fixed-deposit-create",
        component: () => import("@/views/dashboard/fdr/plancreate.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-fixed-deposit-edit/:plan_id",
        name: "admin-fixed-deposit-edit",
        component: () => import("@/views/dashboard/fdr/planedit.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-gift-card",
        name: "admin-gift-card",
        component: () => import("@/views/dashboard/giftcard/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-all-gift-card",
        name: "admin-all-gift-card",
        component: () => import("@/views/dashboard/giftcard/history.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-new-currency",
        name: "admin-new-currency",
        component: () => import("@/views/dashboard/currency/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-edit-currency/:currency_id",
        name: "admin-edit-currency",
        component: () => import("@/views/dashboard/currency/edit.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-all-currency",
        name: "admin-all-currency",
        component: () => import("@/views/dashboard/currency/history.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },

      {
        path: "admin-create-ticket",
        name: "admin-create-ticket",
        component: () => import("@/views/dashboard/ticket/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-edit-ticket/:ticket_id",
        name: "admin-edit-ticket",
        component: () => import("@/views/dashboard/ticket/edit.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-chat-ticket/:ticket_id",
        name: "admin-chat-ticket",
        component: () => import("@/views/dashboard/ticket/chat.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-all-tickets",
        name: "admin-all-tickets",
        component: () => import("@/views/dashboard/ticket/history.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-all-banks",
        name: "admin-all-banks",
        component: () => import("@/views/dashboard/banks/index.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-create-bank",
        name: "admin-create-bank",
        component: () => import("@/views/dashboard/banks/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-edit-bank/:bank_id",
        name: "admin-edit-bank",
        component: () => import("@/views/dashboard/banks/edit.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-loan-products",
        name: "admin-loan-products",
        component: () => import("@/views/dashboard/loans/lp_index.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-create-loan-product",
        name: "admin-create-loan-product",
        component: () => import("@/views/dashboard/loans/lp_create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-edit-loan-product/:loan_product_id",
        name: "admin-edit-loan-product",
        component: () => import("@/views/dashboard/loans/lp_edit.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      
      {
        path: "admin-loans",
        name: "admin-loans",
        component: () => import("@/views/dashboard/loans/index.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-create-loan",
        name: "admin-create-loan",
        component: () => import("@/views/dashboard/loans/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-edit-loan/:loan_id",
        name: "admin-edit-loan",
        component: () => import("@/views/dashboard/loans/edit.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-view-loan/:loan_id",
        name: "admin-view-loan",
        component: () => import("@/views/dashboard/loans/view.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-loan-payment",
        name: "admin-loan-payment",
        component: () => import("@/views/dashboard/loans/payment_index.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-create-loan-payment",
        name: "admin-create-loan-payment",
        component: () => import("@/views/dashboard/loans/payment_create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "admin-loan-create",
        name: "admin-loan-create",
        component: () => import("@/views/dashboard/loans/create.vue"),
        meta: {
          hide: true,
          middleware: [admin],
        },
      },
      {
        path: "notifications",
        name: "notifications",
        component: () => import("@/views/notifications.vue"),
        meta: {
          hide: true,
        },
      },
      {
        path: "home",
        name: "home",
        redirect: "/app/dashboard",
        component: () => import("@/views/dashboard.vue"),
        meta: {
          hide: true,
        },
      },
    ],
  },
];

export default routes;
