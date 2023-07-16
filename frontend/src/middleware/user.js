import { useAuthStore } from "@/store/authUser";
export default function auth ({ next, store }){
  const auth = useAuthStore();
  
  if (auth.user.user.user_type == 'customer') {
    return next();
  } 
  return next({ name: "Login" });
}