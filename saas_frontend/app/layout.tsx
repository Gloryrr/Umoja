"use client";

// import localFont from "next/font/local";
import { Fredoka, Nunito } from "next/font/google";
import NavbarApp from "../app/components/Navbar";
import Footer from "../app/components/Footer";
import React from "react";
// import Head from "next/head";

import "./globals.css";

// const geistSans = localFont({
//   src: "./fonts/GeistVF.woff",
//   variable: "--font-geist-sans",
//   weight: "100 900",
// });
// const geistMono = localFont({
//   src: "./fonts/GeistMonoVF.woff",
//   variable: "--font-geist-mono",
//   weight: "100 900",
// });

const fredoka = Fredoka({
  weight: ["300", "400", "500", "600", "700"],
  variable: "--font-fredoka",
  display: "swap",
  subsets: ["latin"], // Specify the subsets here
});

const nunito = Nunito({
  weight: ["200", "300", "400", "500", "600", "700", "800", "900", "1000"],
  variable: "--font-nunito",
  display: "swap",
  subsets: ["latin"], // Specify the subsets here
});

export default function RootLayout({children,}: Readonly<{children: React.ReactNode;}>) {
  const [isMenuConnection, setIsMenuConnection] = React.useState(false);

  React.useEffect(() => {
    if (typeof window !== 'undefined') {
      setIsMenuConnection(window.location.pathname === '' || window.location.pathname === '/');
    }
  }, []);

  return (
    <html lang="fr">
      <body className={`${fredoka.variable} ${nunito.variable} antialiased flex flex-col`}>
        {isMenuConnection ? null : <NavbarApp/> }
          {children}
        {isMenuConnection ? null : <Footer/>}
      </body>
    </html>
  );
}
