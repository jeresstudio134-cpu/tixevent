"use client";

import Link from "next/link";
import Countdown from "./Countdown";

export default function Hero() {
  return (
    <section className="relative flex min-h-screen items-center justify-center overflow-hidden">

      {/* Background Video */}
      <video
        autoPlay
        muted
        loop
        playsInline
        className="absolute inset-0 h-full w-full object-cover"
      >
        <source src="/video/concert.mp4" type="video/mp4" />
      </video>

      {/* Overlay */}
      <div className="absolute inset-0 bg-black/70"></div>

      {/* Content */}
      <div className="relative z-10 mx-auto max-w-4xl px-6 text-center">

        <p className="mb-3 text-yellow-400 uppercase tracking-[4px]">
          Music Festival 2026
        </p>

        <h1 className="mb-6 text-5xl font-extrabold text-white md:text-7xl">
          Nusantara Music Festival
        </h1>

        <p className="mx-auto mb-8 max-w-2xl text-lg text-gray-300">
          Nikmati pengalaman konser terbaik bersama musisi pilihan
          dengan tata panggung spektakuler dan teknologi audio visual modern.
        </p>

        <div className="mb-10 flex flex-wrap justify-center gap-6 text-white">

          <div>
            <div className="text-sm text-gray-400">
              Tanggal
            </div>

            <div className="font-semibold">
              18 Juni 2026
            </div>
          </div>

          <div>
            <div className="text-sm text-gray-400">
              Lokasi
            </div>

            <div className="font-semibold">
              Gelora Bung Karno
            </div>
          </div>

        </div>

        <div className="flex flex-wrap justify-center gap-4">

          <Link
            href="#tickets"
            className="rounded-xl bg-yellow-500 px-8 py-4 font-bold text-black transition hover:bg-yellow-400"
          >
            🎫 Beli Tiket
          </Link>

          <Link
            href="#about"
            className="rounded-xl border border-white px-8 py-4 font-bold text-white hover:bg-white hover:text-black"
          >
            Pelajari Event
          </Link>

        </div>

      </div>
    <Countdown />
    </section>
    
  );
}