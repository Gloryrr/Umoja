import Image from 'next/image'
import Link from 'next/link'
import { Facebook, Linkedin, Twitter, Instagram, Youtube } from 'lucide-react'

export default function Footer() {
  return (
    <footer className="bg-gray-900 text-white w-full pt-[5em] md:p-[5em]">
      <div className="mx-auto px-4">
        {/* Header */}
        <div className="flex flex-col md:flex-row justify-between bg-gray-800 rounded-3xl p-[3em] items-center mb-8">
          <div className="flex items-center mb-4 md:mb-0">
            <div className="ml-4">
              <h2 className="text-xl font-bold">UmoDJA</h2>
              <p className="text-sm text-gray-400">????????????????????????</p>
              <p className="text-sm text-gray-400">????????????????????????</p>
            </div>
          </div>
          <div className="flex space-x-4">
            <Link href="#" className="hover:text-[#3b5998] rounded-full p-[10px] bg-gray-900 md:p-[20px]"><Facebook className="w-10 h-10 md:w-12 md:h-12" /></Link>
            <Link href="#" className="hover:text-[#0077B5] rounded-full p-[10px] bg-gray-900 md:p-[20px]"><Linkedin className="w-10 h-10 md:w-12 md:h-12" /></Link>
            <Link href="#" className="hover:text-[#00ACEE] rounded-full p-[10px] bg-gray-900 md:p-[20px]"><Twitter className="w-10 h-10 md:w-12 md:h-12" /></Link>
            <Link href="#" className="hover:text-[#1DA1F2] rounded-full p-[10px] bg-gray-900 md:p-[20px]"><Instagram className="w-10 h-10 md:w-12 md:h-12" /></Link>            
            <Link href="#" className="hover:text-[#FF0000] rounded-full p-[10px] bg-gray-900 md:p-[20px]"><Youtube className="w-10 h-10 md:w-12 md:h-12" /></Link>
          </div>
        </div>

        {/* Main Links */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
          <div>
            <h3 className="text-lg font-semibold mb-4">Fund a project</h3>
            <hr className="border-solid border-4 border-gray-300 mb-10 w-[50px]" />
            <ul className="space-y-2">
              <li><Link href="#" className="text-gray-400 hover:text-white">How to run a successful campaign</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Our features</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Selection criterias</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Crowdfunding</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Campaign</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Pre-order</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Subscription</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Branding guidelines</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">The blog</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Studio</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">FAQ</Link></li>
            </ul>
          </div>
          <div>
            <h3 className="text-lg font-semibold mb-4">Partnerships</h3>
            <hr className="border-solid border-4 border-gray-300 mb-10 w-[50px]" />
            <ul className="space-y-2">
              <li><Link href="#" className="text-gray-400 hover:text-white">Become partners</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Partners deals</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Local authorities</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Mentors</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Maison de Crowdfunding</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">La Banque Postale</Link></li>
            </ul>
          </div>
          <div>
            <h3 className="text-lg font-semibold mb-4">About</h3>
            <hr className="border-solid border-4 border-gray-300 mb-10 w-[50px]" />
            <ul className="space-y-2">
              <li><Link href="#" className="text-gray-400 hover:text-white">Our manifesto</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Our values</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">StatKisstics</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Our record projects</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Our Team</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Recruitment</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Press</Link></li>
            </ul>
          </div>
          <div>
            <h3 className="text-lg font-semibold mb-4">Our commitments</h3>
            <hr className="border-solid border-4 border-gray-300 mb-10 w-[50px]" />
            <ul className="space-y-2">
              <li><Link href="#" className="text-gray-400 hover:text-white">Health and Handicap</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Indie</Link></li>
              <li><Link href="#" className="text-gray-400 hover:text-white">Organic</Link></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  )
}