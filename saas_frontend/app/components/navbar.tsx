"use client";
import { Avatar, Dropdown, Navbar, NavbarBrand, NavbarCollapse, NavbarLink, NavbarToggle } from "flowbite-react";

export default function NavbarApp() {
  return (
    <Navbar fluid rounded className="bg-white shadow-lg">
      <div className="container mx-auto flex items-center justify-between py-4 px-6">
        {/* Brand / Logo */}
        <NavbarBrand className="flex items-center">
          <img src="/logo.png" alt="logo" className="w-56 h-auto mr-6" />
        </NavbarBrand>

        {/* Middle Navigation Links */}
        <div className="hidden md:flex space-x-6">
          <NavbarLink href="#" active className="text-lg font-semibold text-gray-900 hover:text-blue-600">
            Home
          </NavbarLink>
          <NavbarLink href="#" className="text-lg text-gray-700 hover:text-blue-600">
            About
          </NavbarLink>
          <NavbarLink href="#" className="text-lg text-gray-700 hover:text-blue-600">
            Services
          </NavbarLink>
          <NavbarLink href="#" className="text-lg text-gray-700 hover:text-blue-600">
            Pricing
          </NavbarLink>
          <NavbarLink href="#" className="text-lg text-gray-700 hover:text-blue-600 ">
            Contact
          </NavbarLink>
        </div>

        {/* Right Section (Dropdown / Toggle for Mobile) */}
        <div className="flex items-center ml-[20px] space-x-4">
          <Dropdown
            arrowIcon={false}
            inline
            label={
              <Avatar
                alt="User settings"
                img="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                rounded
                className="h-10 w-10"
              />
            }
          >
            <Dropdown.Header>
              <span className="block text-sm font-medium text-gray-900">Bonnie Green</span>
              <span className="block truncate text-sm text-gray-500">name@flowbite.com</span>
            </Dropdown.Header>
            <Dropdown.Item className="hover:bg-gray-100">Dashboard</Dropdown.Item>
            <Dropdown.Item className="hover:bg-gray-100">Settings</Dropdown.Item>
            <Dropdown.Item className="hover:bg-gray-100">Earnings</Dropdown.Item>
            <Dropdown.Divider />
            <Dropdown.Item className="hover:bg-gray-100">Sign out</Dropdown.Item>
          </Dropdown>
          <NavbarToggle />
        </div>
      </div>

      {/* Mobile Menu */}
      <NavbarCollapse className="md:hidden flex flex-col space-y-4 bg-white px-6 py-4">
        <NavbarLink href="#" active className="text-lg font-semibold text-gray-900 hover:text-blue-600">
          Home
        </NavbarLink>
        <NavbarLink href="#" className="text-lg text-gray-700 hover:text-blue-600">
          About
        </NavbarLink>
        <NavbarLink href="#" className="text-lg text-gray-700 hover:text-blue-600">
          Services
        </NavbarLink>
        <NavbarLink href="#" className="text-lg text-gray-700 hover:text-blue-600">
          Pricing
        </NavbarLink>
        <NavbarLink href="#" className="text-lg text-gray-700 hover:text-blue-600">
          Contact
        </NavbarLink>
      </NavbarCollapse>
    </Navbar>
  );
}



