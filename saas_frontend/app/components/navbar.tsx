"use client";
import { Navbar, NavbarBrand, NavbarContent, NavbarItem, Link, Button } from "@nextui-org/react";

export default function NavbarApp() {
  return (
    <Navbar className="py-2px px-5 bg-white shadow-md">
      <NavbarContent className="flex justify-center items-center text-xl font-semibold text-black">
        <NavbarBrand className="flex items-center">
          <img src="/logo.png" alt="logo" className="w-[200px] mr-[20px]" />
        </NavbarBrand>
        
        <NavbarItem className="mr-5 hover:text-blue-600">
          <Link href="#">
            ?????
          </Link>
        </NavbarItem>
        
        <NavbarItem className="mr-5 text-blue-600">
          <Link href="#" aria-current="page">
            ?????
          </Link>
        </NavbarItem>

        <NavbarItem className="mr-5 hover:text-blue-600">
          <Link href="#">
            ?????
          </Link>
        </NavbarItem>

        <NavbarItem className="mr-5">
          <Button as={Link} href="#" className="bg-blue-600 text-white py-2 px-4 rounded transition duration-300 hover:bg-blue-700">
            Login
          </Button>
        </NavbarItem>

        <NavbarItem className="mr-5">
          <Button as={Link} href="#" className="bg-blue-600 text-white py-2 px-4 rounded transition duration-300 hover:bg-blue-700">
            Sign Up
          </Button>
        </NavbarItem>
      </NavbarContent>
    </Navbar>
  );
}
