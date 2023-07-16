import { useAuthStore } from "@/store/authUser";
export default function auth ({ next, store }){
  const auth = useAuthStore();
  if (auth.user.user.status == 1) {
    return next();
  } 
  return next({ name: "Login" });
}