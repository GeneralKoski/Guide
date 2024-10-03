import AppFooter from "@/components/footer/Footer";
import Navbar from "@/components/navbar/Navbar";
import { ReactNode } from "react";

interface LayoutProps {
    children: ReactNode;
}

const Layout: React.FC<LayoutProps> = ({ children }) => {
    return (
        <>
        <Navbar/>
        {children}
        <AppFooter/>
        </>
    )
}

export default Layout;