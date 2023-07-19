import { useAuthStore } from "@/store/authUser";
export default function auth ({ next, store }){
  const auth = useAuthStore();
  console.log(auth.user.user)
  if (auth.user?.user?.status == 'active') {
    return next();
  } 
  return next({ name: "Login" });
}