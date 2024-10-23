"use client";
import { useState } from 'react';
import { AiOutlineClose, AiOutlineMenu } from 'react-icons/ai';
import { Dropdown, Avatar } from 'flowbite-react';
import NavigationHandler from './router';


const UserAvatar = () => {
  return (
    <div className='hidden md:block  relative'>
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
        {/* Dropdown menu content */}
        <Dropdown.Header>
          <span className="block text-sm font-medium text-black">Bonnie Green</span>
          <span className="block truncate text-sm text-gray">name@flowbite.com</span>
        </Dropdown.Header>
        <Dropdown.Item className="block px-4 py-2 text-sm text-gray-700 bg-white hover:bg-gray-200">
          Dashboard
        </Dropdown.Item>
        <Dropdown.Item className="block px-4 py-2 text-sm text-gray-700 bg-white hover:bg-gray-200">
          Settings
        </Dropdown.Item>
        <Dropdown.Item className="block px-4 py-2 text-sm text-gray-700 bg-white hover:bg-gray-200">
          Earnings
        </Dropdown.Item>
        <Dropdown.Divider className="border-t border-gray-200 my-1" />
        <Dropdown.Item className="block px-4 py-2 text-sm text-gray-700 bg-white hover:bg-red-400">
          Sign out
        </Dropdown.Item>
      </Dropdown>
    </div>
  );
}

const UserAvatarMobile = () => {
  return (
    <div className='relative'>
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
        {/* Dropdown menu content */}
        <Dropdown.Header>
          <span className="block text-sm font-medium text-black">Bonnie Green</span>
          <span className="block truncate text-sm text-gray">name@flowbite.com</span>
        </Dropdown.Header>
        <Dropdown.Item className="block px-4 py-2 text-sm text-gray-700 bg-white hover:bg-gray-200">
          Dashboard
        </Dropdown.Item>
        <Dropdown.Item className="block px-4 py-2 text-sm text-gray-700 bg-white hover:bg-gray-200">
          Settings
        </Dropdown.Item>
        <Dropdown.Item className="block px-4 py-2 text-sm text-gray-700 bg-white hover:bg-gray-200">
          Earnings
        </Dropdown.Item>
        <Dropdown.Divider className="border-t border-gray-200 my-1" />
        <Dropdown.Item className="block px-4 py-2 text-sm text-gray-700 bg-white hover:bg-red-400">
          Sign out
        </Dropdown.Item>
      </Dropdown>
    </div>
  );
}

const Navbar = () => {
  // State to manage the navbar's visibility
  const [nav, setNav] = useState(false);

  // Toggle function to handle the navbar's display
  const handleNav = () => {
    setNav(!nav);
  };

  // Array containing navigation items
  const navItems = [
    { id: 1, text: 'Home' },
    { id: 2, text: 'Company' },
    { id: 3, text: 'Resources' },
    { id: 4, text: 'About' },
    { id: 5, text: 'Contact' },
  ];

  return (
    <div className='bg-black flex justify-between w-full items-center h-24 mx-auto px-4 text-white font-fredoka'>
      {/* Logo */}
      <h1 className=' text-3xl font-bold '><NavigationHandler>
              {(handleNavigation) => (
                <a
                onClick={() => handleNavigation(`/home`)}
                className="text-white cursor-pointer text-custom-green no-underline font-semibold hover:underline m-0"
              >
                UmoDJA
              </a>              
              )}
            </NavigationHandler></h1>

      {/* Desktop Navigation */}
      <ul className='hidden md:flex'>
        {navItems.map(item => (
          <li
            key={item.id}
            className='p-4 hover:bg-[#00df9a] rounded-xl m-2 cursor-pointer duration-300 hover:text-black'
          >
            <NavigationHandler>
              {(handleNavigation) => (
                <a
                  onClick={() => handleNavigation(`/${item.text.toLowerCase()}`)} // Assure-toi que ce chemin existe
                  className="text-white no-underline font-semibold hover:underline"
                >
                  {item.text}
                </a>
              )}
            </NavigationHandler>
          </li>
        ))}

      </ul>

      <UserAvatar />

      {/* Mobile Navigation Icon */}
      <div onClick={handleNav} className='block md:hidden z-[10000] relative'>
        {nav ? <AiOutlineClose size={20} /> : <AiOutlineMenu size={20} />}
      </div>

      {/* Mobile Navigation Menu */}
      <ul
        className={
          nav
            ? 'fixed md:hidden left-0 top-0 w-[60%] h-full border-r border-r-gray-900 bg-[#000300] z-[5000] ease-in-out duration-500'
            : 'ease-in-out w-[60%] duration-500 fixed top-0 bottom-0 left-[-100%] z-[5000]'
        }

      >

        {/* Mobile Logo */}
        <div className='flex m-4 '>
          <h1 className='w-full text-3xl font-bold text-[#00df9a]'>UmoDJA</h1>
          <UserAvatarMobile />
        </div>
        {/* Mobile Navigation Items */}
        {navItems.map(item => (
          <li
            key={item.id}
            className='p-4 border-b rounded-xl hover:bg-[#00df9a] duration-300 hover:text-black cursor-pointer border-gray-600'
          >
            {item.text}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Navbar;

