import { useAuthStore } from "@/store/authUser";
export default function auth ({ next, store }){
  const auth = useAuthStore();
  console.log("here")
  if (auth.user) {
    return next();
  } 
  return next({ name: "Login" });
}