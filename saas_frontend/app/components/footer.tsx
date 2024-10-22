import Image from 'next/image'
import Link from 'next/link'
import { Facebook, Linkedin, Twitter, Instagram, Youtube } from 'lucide-react'

export default function Footer() {
  return (
    <footer className="bg-gray-900 text-white w-full p-[12em]">
      <div className="mx-auto px-4">
        {/* Header */}
        <div className="flex flex-col md:flex-row justify-between bg-gray-800 rounded-3xl p-[3em] items-center mb-8">
          <div className="flex items-center mb-4 md:mb-0">
            <Image src="/logo.svg" alt="KissKiss BankBank" width={40} height={40} />
            <div className="ml-4">
              <h2 className="text-xl font-bold">UmoDJA</h2>
              <p className="text-sm text-gray-400">????????????????????????</p>
              <p className="text-sm text-gray-400">????????????????????????</p>
            </div>
          </div>
          <div className="flex space-x-4">
            <Link href="#" className="hover:text-[#3b5998] rounded-full p-[20px] bg-gray-900"><Facebook size={45} /></Link>
            <Link href="#" className="hover:text-[#0077B5] rounded-full p-[20px] bg-gray-900"><Linkedin size={45} /></Link>
            <Link href="#" className="hover:text-[#00ACEE] rounded-full p-[20px] bg-gray-900"><Twitter size={45} /></Link>
            <Link href="#" className="hover:text-[#1DA1F2] rounded-full p-[20px] bg-gray-900"><Instagram size={45} /></Link>            
            <Link href="#" className="hover:text-[#FF0000] rounded-full p-[20px] bg-gray-900"><Youtube size={45} /></Link>
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

        {/* Ecosystem */}
        <div className="mb-12">
          <h3 className="text-lg font-semibold mb-4">Our committed ecosystem</h3>
          <hr className="border-solid border-4 border-gray-300 mb-10 w-[50px]" />
          <div className="flex flex-wrap justify-between items-center">
            <Image src="/lendopolis.svg" alt="Lendopolis" width={120} height={40} className="mb-4" />
            <Image src="/goodeed.svg" alt="Goodeed" width={120} height={40} className="mb-4" />
            <Image src="/la-maison.svg" alt="La Maison" width={120} height={40} className="mb-4" />
            <Image src="/youmatter.svg" alt="You Matter" width={120} height={40} className="mb-4" />
            <Image src="/microdon.svg" alt="Microdon" width={120} height={40} className="mb-4" />
          </div>
        </div>

        {/* Legal */}
        <div className="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
          <div className="flex items-center mb-4 md:mb-0">
            <Image src="/legal-badge1.svg" alt="Legal Badge 1" width={60} height={60} className="mr-4" />
            <Image src="/legal-badge2.svg" alt="Legal Badge 2" width={60} height={60} className="mr-4" />
            <p className="max-w-md">
              KissKissBankBank is a crowdfunding platform regulated by french authorities.
              Registration number as a Crowdfunding Intermediary with ORIAS: 14007218. Head
              office address: 34, Rue de Paradis 75010 PARIS. Contact email address:
              contact@kisskissbankbank.com
            </p>
          </div>
          <div className="flex items-center">
            <Image src="/mangopay.svg" alt="Mangopay" width={120} height={40} className="mr-4" />
            <p className="max-w-xs">
              KissKissBankBank & Co is an agent of the financial institution MANGOPAY SA. Secure
              payments with MANGOPAY Payment Services
            </p>
          </div>
        </div>
      </div>
    </footer>
  )
}