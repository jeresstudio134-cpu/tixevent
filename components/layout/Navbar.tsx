"use client";

import Link from "next/link";
import { Menu, X } from "lucide-react";
import { useState } from "react";

const menus = [
  { name: "Beranda", href: "/" },
  { name: "Tentang", href: "#about" },
  { name: "Tiket", href: "#tickets" },
  { name: "FAQ", href: "#faq" },
  { name: "Kontak", href: "#contact" },
];

export default function Navbar() {
  const [open, setOpen] = useState(false);

  return (
    <header className="fixed top-0 left-0 z-50 w-full bg-black/60 backdrop-blur-md border-b border-white/10">
      <div className="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        {/* Logo */}
        <Link href="/" className="text-2xl font-bold text-white">
          TIXEVENT
        </Link>

        {/* Desktop Menu */}
        <nav className="hidden gap-8 md:flex">
          {menus.map((menu) => (
            <Link
              key={menu.name}
              href={menu.href}
              className="text-gray-200 transition hover:text-yellow-400"
            >
              {menu.name}
            </Link>
          ))}
        </nav>

        {/* Button */}
        <Link
          href="#tickets"
          className="hidden rounded-lg bg-yellow-500 px-5 py-2 font-semibold text-black transition hover:bg-yellow-400 md:block"
        >
          Beli Tiket
        </Link>

        {/* Mobile Button */}
        <button
          onClick={() => setOpen(!open)}
          className="text-white md:hidden"
        >
          {open ? <X size={28} /> : <Menu size={28} />}
        </button>
      </div>

      {/* Mobile Menu */}
      {open && (
        <div className="border-t border-white/10 bg-black/95 md:hidden">
          <div className="flex flex-col p-6">
            {menus.map((menu) => (
              <Link
                key={menu.name}
                href={menu.href}
                onClick={() => setOpen(false)}
                className="py-3 text-gray-200 hover:text-yellow-400"
              >
                {menu.name}
              </Link>
            ))}

            <Link
              href="#tickets"
              className="mt-4 rounded-lg bg-yellow-500 py-3 text-center font-semibold text-black"
            >
              Beli Tiket
            </Link>
          </div>
        </div>
      )}
    </header>
  );
}